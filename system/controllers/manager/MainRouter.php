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
		if(!$address) $address = "index";
		$code = explode("?", $address);
		$code = $code[0];
		if(file_exists(PAGES_PATH.$this->pages[$address]) && $this->pages[$address])
			include(PAGES_PATH.$this->pages[$address]);
		else if(file_exists(PAGES_PATH.str_replace("/", "", $code).".php")){
			include(PAGES_PATH.str_replace("/", "", $code).".php");
		}else{
			include(PAGES_PATH."404.php");
		}
	}
}
?>