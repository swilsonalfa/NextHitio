<?php
class RoomController extends MainController {
	private static $allowed_actions = array(
			'index',
			'createajax'
	);
	
	public function index($request) {
		return $this->customise(array("Content" => $this->renderWith("room_index")));
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
	
	public function generateSegment($name) {
		$filter = URLSegmentFilter::create();
		$t = $filter->filter($name);
		
		return $t;
	}
}