<?php
class MainController extends Controller {
	private static $allowed_actions = array(
			'index'
	);
	
	public function init() {
		// Style and Javascript requirements
		Requirements::css($this->ThemeDir()."/bootstrap/css/bootstrap.min.css");
		Requirements::css($this->ThemeDir()."/css/nexthit.css");
		Requirements::javascript($this->ThemeDir()."/js/jquery-1.11.3.min.js");
		Requirements::javascript($this->ThemeDir()."/bootstrap/js/bootstrap.min.js");
		Requirements::javascript($this->ThemeDir()."/js/typeahead.js");
		Requirements::javascript($this->ThemeDir()."/js/code.js");
		
		parent::init();
	}
	
	public function index($request) {
		$roomAction = $this->request->param("Action");
		
		if(!empty($roomAction)) {
			$this->redirect("/room/".$roomAction);
		}
		
		$sessionError = "";
		
		if(Session::get("SessionError")) {
			$sessionError = Session::get("SessionError");
			Session::clear("SessionError");
		}
		
		return $this->customise(array("Content" => $this->renderWith("index", array($this, "SessionError" => $sessionError))));
	}
}