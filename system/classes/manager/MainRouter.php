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
		if(file_exists($_SERVER["DOCUMENT_ROOT"].TEMPLATE_PATH."pages/".$this->pages[$address]) && $this->pages[$address])
			include(TEMPLATE_PATH."pages/".$this->pages[$address]);
		else
			include(TEMPLATE_PATH."pages/404.php");
	}
}
?>