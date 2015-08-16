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
	
	private static $has_many = array(
		"Votes"			=> "Vote"
	);
	
	public function getTotalPositive() {
		$votes = $this->Votes();
		$votes = $votes->Filter(array("Positive" => true));
		
		return $votes->Count();
	}
	
	public function getTotalNegative() {
		$votes = $this->Votes();
		$votes = $votes->Filter(array("Positive" => false));
	
		return $votes->Count();
	}
	
	public function getPos() {
		$pos = $this->getTotalPositive();
		$neg = $this->getTotalNegative();
		
		return $pos - $neg;
	}
}