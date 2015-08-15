<?php
class Vote extends DataObject {
	private static $db = array(
		"Weight"		=> "Int",
		"Positive"		=> "Boolean(1)",
		"Boosted"		=> "Boolean(0)"
	);
	
	private static $defaults = array(
		"Weight"		=> "1"
	);
	
	private static $has_one = array(
		"Parent"		=> "Option"
	);
}