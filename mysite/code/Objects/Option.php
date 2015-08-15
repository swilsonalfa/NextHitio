<?php
class Option extends DataObject {
	private static $db = array(
		"IPAddress"		=> "Varchar(250)"
	);
	
	private static $has_one = array(
		"Parent"		=> "Room"
	);
	
	public function onBeforeWrite() {
		// Capture the users IP Address
		$this->IPAddress = $_SERVER['REMOTE_ADDR'];
		parent::onBeforeWrite();
	}
}