<?php
class RssClass{
	private $url;
	private $user_id;

	private function __construct($url, $items){
		$this->url = $url;
		$this->user_id = $user_id;
	}


	public static function addRss($arFields){
		DataBaseController::insertRss($arFields);
	}

	public static function getByUserId($user_id){
		$arParams = array("user_id" => $user_id);
		$fields = DataBaseController::getRss($arParams);
		if(!empty($fields)){
			$rss = new RssClass($fields['rss_url'], $fields['user_id']);
		}else $rss = false;
		return $rss;
	}

	public function getProperty($property_name){
		return $this->$property_name;
	}
}
?>