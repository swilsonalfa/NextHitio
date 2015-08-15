<?php
class Room extends DataObject {
	private static $db = array(
		"Title"		=> "Varchar(250)",
		"Singular"	=> "Varchar(250)",
		"Plural"	=> "Varchar(250)"
	);
	
	private static $has_one = array(
		"Owner"		=> "Member"
	);
}