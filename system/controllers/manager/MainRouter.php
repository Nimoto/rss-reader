<?php
class MainRouter{
	private $pages;
	public static $router;

	private function __construct($pages){
		$this->pages = $pages;
	}

	public static function createRouter($pages){
		if(!self::$router)
			self::$router = new MainRouter($pages);
		return self::$router;
	}

	public function route($address = null){
		$address = explode("?", $address);
		$address = $address[0];
		if(!$address || $address == "/") $address = "index";
		if(file_exists(PAGES_PATH.$this->pages[$address]) && $this->pages[$address])
			include(PAGES_PATH.$this->pages[$address]);
		else if(file_exists(PAGES_PATH.str_replace("/", "", $address).".php")){
			include(PAGES_PATH.str_replace("/", "", $address).".php");
		}else{
			include(PAGES_PATH."404.php");
		}
	}
}
?>