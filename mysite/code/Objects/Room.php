<?php
class Room extends DataObject {
	private static $db = array(
		"Segment"		=> "Varchar(250)",
		"Title"			=> "Varchar(250)",
		"Singular"		=> "Varchar(250)",
		"Plural"		=> "Varchar(250)",
		"Description"	=> "Text"
	);
	
	private static $has_one = array(
		"Owner"		=> "Member"
	);
}