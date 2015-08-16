<?php
class Room extends DataObject {
	private static $db = array(
		"Segment"		=> "Varchar(250)",
		"Title"			=> "Varchar(250)",
		"Singular"		=> "Varchar(250)",
		"Plural"		=> "Varchar(250)",
		"Description"	=> "Text",
		"Views"			=> "Int",
		"Type"			=> "Enum('Music,Pizza','Music')"
	);
	
	private static $defaults = array(
		"Views"			=> "0"
	);
	
	private static $has_one = array(
		"Owner"			=> "Member"
	);
	
	private static $has_many = array(
		"Options"		=> "Option"
	);
	
	public function sortedOptions() {
		$options = $this->Options();
		$newList = new ArrayList();
		
		// Add to new list
		foreach($options as $option) {
			//$option->Position = $option->getPos();
			$newList->add($option);
			$newList->byID($option->ID)->Position = $option->getPos();
		}
		
		return $newList->sort('Position DESC');
	}
}