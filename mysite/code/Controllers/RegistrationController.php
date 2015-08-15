<?php
class RegistrationController extends MainController {
	private static $allowed_actions = array(
			'index',
			'go'
	);
	
	public function init() {
		parent::init();
	}
	
	public function index($request) {
		return $this->customise(array("Content" => $this->renderWith("register_index", $this)));
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
			$member = Member::get()->filter(array("MobileNumber" => $mobilenumber));
			
			if($member->count() && !empty($mobilenumber)) {
				$errors[] = "A user already exists with that mobile number.";
			}
			
			if($errors) {
				$returnArray = array();
				
				$returnArray["success"] = false;
				$returnArray["errors"] = $errors;
				
				return json_encode($returnArray);
			} else {
				// Create the member
				$member = new Member();
				$member->MobileNumber = $mobilenumber;
				$member->MobileConfirm = mt_rand(100000, 999999);
				$memberID = $member->write();
				
				// Now send a text message to confirm the account
				if($memberID) {
					$config = Config::inst()->get('TelstraAPI', 'Keys');
					$sms = new TelstraSMS($config['consumer'], $config['secret'], $mobilenumber, "Your NextHit verification code is: ".$member->MobileConfirm);
					$sms->send();
					
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