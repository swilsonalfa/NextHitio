<?php
class MainController extends Controller {
	private static $allowed_actions = array(
			'index'
	);
	
	public function init() {
		// Style and Javascript requirements
		Requirements::css($this->ThemeDir()."/bootstrap/css/bootstrap.min.css");
		Requirements::javascript($this->ThemeDir()."/js/jquery-1.11.3.min.js");
		Requirements::javascript($this->ThemeDir()."/bootstrap/js/bootstrap.min.js");
		Requirements::javascript($this->ThemeDir()."/js/code.js");
		
		parent::init();
	}
	
	public function index($request) {
		return $this->customise(array("Content" => $this->renderWith("index")));
	}
}