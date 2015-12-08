<?php
class RssClass{
	private $url;
	private $title;
	private $user_id;
	private $id;

	private function __construct($url, $user_id, $id){
		$this->url = $url;
		$this->user_id = $user_id;
		$this->id = $id;
	}


	public static function addRss($arFields){
		DataBaseController::insertRss($arFields);
	}
	
	public static function deleteRss($arFields){
		DataBaseController::deleteRss($arFields);
	}

	public static function getByUserId($user_id){
		$arParams = array("user_id" => $user_id);
		$fields = DataBaseController::getRss($arParams);
		if(!empty($fields)){
			$rss = new RssClass($fields['rss_url'], $user_id, $fields['id']);
		}else $rss = false;
		return $rss;
	}

	public function getAllRssItems($offset = NULL, $limit = NULL){
		$arParams = array("user_id" => $this->user_id);
		$items = DataBaseController::getRssItems($arParams, $offset, $limit);
		return $items;		
	}

	public function setTitle($title){
		$this->title = $title;
		$arFieldsSet = array("title" => $this->title);
		$arFieldsWhere = array("url" => $this->url);
		DataBaseController::updateRss($arFieldsSet, $arFieldsWhere);
	}

	public function getProperty($property_name){
		return $this->$property_name;
	}

	public function clearItems(){
		DataBaseController::deleteRssItems($this);
	}

	public function insertItem($arFields){
		DataBaseController::insertRssItem($this, $arFields);
	}

}
?>