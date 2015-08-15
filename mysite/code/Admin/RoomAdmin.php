<?php
class RoomAdmin extends ModelAdmin {
	private static $managed_models = array('Room');
	
	private static $url_segment = 'room';
	
	private static $menu_title = 'Room Amdin';
}