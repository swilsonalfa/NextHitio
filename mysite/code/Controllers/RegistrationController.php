<?php
class RegistrationController extends MainController {
	private static $allowed_actions = array(
			'index',
			'go', // ajax call for inital register page
			'step2'
	);
	
	public function init() {
		parent::init();
	}
	
	public function index($request) {
		return $this->customise(array("Content" => $this->renderWith("register_index", $this)));
	}
	
	public function step2($request) {
		// Check if the sessions exist first
		if(Session::get("RegisterMember") && Session::get("RegisterMemberID")) {
			
			
			return $this->customise(array("Content" => $this->renderWith("register_step2", $this)));
		} else {
			$this->redirect($this->Link(), 403);
		}
	}
	
	public function go($request) {
		// Only accept if it's an ajax request
		if($this->request->isAjax()) {
			$mobilenumber = Convert::raw2sql($_POST['mobilenumber']);
			$errors = array();
			
			// DO some checking
			if(empty($mobilenumber)) {
				$errors[] = "Please enter a mobile number";
			}
			
			// check to see if there is already a member with this mobile number
			$member = Member::get_one("Member", "MobileNumber = $mobilenumber");
			
			if(($member && empty($member->MobileConfirm)) && !empty($mobilenumber)) {
				$errors[] = "A user already exists with that mobile number.";
			}
			
			if($errors) {
				$returnArray = array();
				
				$returnArray["success"] = false;
				$returnArray["errorstring"] = "<div class=\"alert alert-info\">".implode(", ", $errors)."</div>";
				
				return json_encode($returnArray);
			} else {
				// Create the member
				if(!$member) $member = new Member();
				$member->MobileNumber = $mobilenumber;
				$member->MobileConfirm = mt_rand(100000, 999999);
				$memberID = $member->write();
				
				// Now send a text message to confirm the account
				if($memberID) {
					$config = Config::inst()->get('TelstraAPI', 'Keys');
					$sms = new TelstraSMS($config['consumer'], $config['secret'], $mobilenumber, "Your NextHit verification code is: ".$member->MobileConfirm);
					$sms->send();
					
					// register a session with the mobile number
					Session::set("RegisterNumber", $mobilenumber);
					Session::set("RegisterMemberID", $memberID);
					
					$returnArray = array();
					
					$returnArray["success"] = true;
					$returnArray["nextstep"] = "step2";
					
					return json_encode($returnArray);
				}
			}
			
		} else {
			$this->redirect($this->Link(), 404);
		}
	}
	
	public function Link() {
		return Director::absoluteBaseURL();
	}
}