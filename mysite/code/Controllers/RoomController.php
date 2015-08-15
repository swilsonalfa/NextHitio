<?php
class RoomController extends MainController {
	private static $allowed_actions = array(
			'index'
	);
	
	public function index($request) {
		return $this->customise(array("Content" => $this->renderWith("room_index")));
	}
}