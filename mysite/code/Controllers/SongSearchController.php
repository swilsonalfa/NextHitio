<?php
class SongSearchController extends Controller {
	private static $allowed_actions = array(
		'index',
		'artist'
	);
	
	public function index() {
		// respond to search query
		if(!$this->request->isAjax()) {
			return;
		}
		
		// get the query
		$query = $this->request->getVar("query");
		$search = $this->searchLastFMTracks($query);
		
		$this->response->addHeader("Content-Type", "application/json");
		
		return json_encode($search);
	}
	
	public function artist() {
		// respond to search query
		if(!$this->request->isAjax()) {
			return;
		}
	
		// get the query
	
	}
	
	private function searchLastFMTracks($query) {
		// Get the API key
		$apikeyConfig = Config::inst()->get('LastFM', 'Keys');
		$apiKey = $apikeyConfig['consumer'];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "http://ws.audioscrobbler.com/2.0/?method=track.search&track=$query&api_key=$apiKey&format=json");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_USERAGENT, "NextHit.io");
		
		//curl_setopt($curl, CONNECTTIMEOUT, 1);
		$content = curl_exec($curl);
		curl_close($curl);
		$lastFMreturn = json_decode($content, true);
		
		$responses = array();
		
		foreach($lastFMreturn["results"]["trackmatches"]["track"] as $track) {
			$image = $track["image"][1]["#text"];
			$responses[] = array("title" => $track["name"], "artist" => $track["artist"], "image" => $image,
				"html" => "<span class=\"img\"><img src=\"$image\"></span><span class=\"title\">$track[name]</span><span class=\"artist\">$track[artist]</span>"
			);
		}
		
		return $responses;
	}
}