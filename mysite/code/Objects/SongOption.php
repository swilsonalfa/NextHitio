<?php
class SongOption extends Option {
	private static $db = array(
		"Song"		=> "Varchar(250)",
		"Artist"	=> "Varchar(250)"
	);
}