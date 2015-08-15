<?php
class MemberExtension extends DataExtension {
	private static $db = array(
		"MobileNumber"		=> "Varchar(10)",
		"TwitterHandle"		=> "Varchar(250)",
		"MobileConfirm"		=> "Varchar(250)"
	);
}