<?php
class RoomController extends MainController {
	private static $allowed_actions = array(
			'createajax',
			'viewRoom',
			'addOption',
			'registervote'
	);
	
	private static $url_handlers = array(
			'' 				=> 'index',
			'createajax' 	=> 'createajax',
			'addOption'		=> 'addOption',
			'registervote'	=> 'registervote',
			'$Room'			=> 'viewRoom'
	);
	
	public function index($request) {
		//return $this->customise(array("Content" => $this->renderWith("room_index")));
		$this->redirect("/");
	}
	
	public function viewRoom($request) {
		$roomName = $this->request->param("Room");
		
		if(empty($roomName)) {
			$this->redirect("/");
		}
		
		// Check if the room exists
		$room = Room::get_one("Room", "Segment = '$roomName'");
		
		if(!$room) {
			Session::set("SessionError", "No room exists with that name");
			$this->redirect("/");
		} else {
			// Room exists, Increase the view count
			$room->Views++;
			$room->write();
			
			// render the template
			return $this->customise(array("Content" => $this->renderWith("room_view", array($this, "Room" => $room))));
		}
	}
	
	public function createajax($request) {
		// Only accept if it's an ajax request
		if($this->request->isAjax()) {
			// all we need is the event title to create a room. other options can be set later
			$roomname = Convert::raw2sql($_POST['eventname']);
			$errors = array();
			
			if(empty($roomname)) {
				$errors[] = "You must have an event name";
			}
			
			$roomNameSegment = $this->generateSegment($roomname);
			
			if(empty($roomNameSegment) && !empty($roomname)) {
				$errors[] = "Room name is not valid.";
			}
			
			// check to ensure something doesn't already exist
			$rooms = Room::get_one("Room", "Segment = '$roomNameSegment'");
			
			if($rooms && !empty($roomname)) {
				$errors[] = "A Room with that name exists. Try again.";
			}
			
			if($errors) {
				$returnArray = array();
			
				$returnArray["success"] = false;
				$returnArray["errorstring"] = "<div class=\"alert alert-info\">".implode(", ", $errors)."</div>";
			
				return json_encode($returnArray);
			} else {
				// No errors. Let's make the room
				$room = new Room();
				$room->Segment = $roomNameSegment;
				$room->Title = $roomname;
				$room->Type = "Music"; // only do music right now
				$roomID = $room->write();
				
				if($roomID) {
					// All good.
					Session::set("RoomAdmin", $roomID);
					
					$returnArray = array();
						
					$returnArray["success"] = true;
					$returnArray["nextstep"] = "/room/".$roomNameSegment;
						
					return json_encode($returnArray);
					
				}
			}
		}
	}
	
	public function addOption() {
		if($this->request->isAjax()) {
			$songname = Convert::raw2sql($_POST['song']);
			$roomID = Convert::raw2sql($_POST['roomid']);
			$errors = array();
			
			if(empty($songname)) {
				$errors[] = "You must enter a song name";
			}
			
			if(empty($roomID)) {
				$errors[] = "No Room ID sent. Try refreshing the page.";
			}
			
			$room = Room::get_by_id("Room", (is_numeric($roomID) ? $roomID : null));
			
			if(!$room) {
				$errors[] = "No room found. Try refreshing.";
			}
			
			if($errors) {
				$returnArray = array();
					
				$returnArray["success"] = false;
				$returnArray["errorstring"] = "<div class=\"alert alert-info\">".implode(", ", $errors)."</div>";
					
				return json_encode($returnArray);
			} else {
				$jsonResponse = json_decode($_POST['lastFMResponse'], true);
				
				// Register a new option
				$songOption = new SongOption();
				$songOption->Song = $jsonResponse["title"];
				$songOption->Artist = $jsonResponse["artist"];
				$songOption->Image = $jsonResponse["img"];
				$songOption->ParentID = $room->ID;
				$songOption->write();
				
				$returnArray = array();
					
				$returnArray["success"] = true;
				$returnArray["nextstep"] = "/room/".$room->Segment;
					
				return json_encode($returnArray);
			}
		}
	}
	
	public function registervote() {
		$pos = ($_GET['pos'] == "true" ? true : false);
		$roomid = Convert::raw2sql($_GET['roomid']);
		$optionid = Convert::raw2sql($_GET['optionid']);
		
		$option = Option::get_by_id("Option", $optionid);
		
		if($option) {
			$vote = new Vote();
			$vote->Positive = $pos;
			$vote->ParentID = $option->ID;
			$voteID = $vote->write();
		}
		
	}
	
	public function generateSegment($name) {
		$filter = URLSegmentFilter::create();
		$t = $filter->filter($name);
		
		return $t;
	}
}