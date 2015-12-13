<?php
class RssClass{
	private $url;
	private $title;
	private $user_id;
	private $id;

	public function __construct($url, $user_id, $id, $title = NULL){
		$this->url = $url;
		$this->user_id = $user_id;
		$this->id = $id;
		$this->title = $title;
	}

	public static function getById($id){
		$arParams = array("id" => $id);
		$fields = DataBaseController::init()->getRss($arParams);
		if(!empty($fields)){
			$rss = new RssClass($fields[0]['rss_url'], $fields[0]['user_id'], $id, $fields[0]["title"]);
		}else $rss = false;
		return $rss;
	}

	public function setTitle($title){
		$this->title = $title;
		$arFieldsSet = array("title" => $this->title);
		$arFieldsWhere = array("url" => $this->url);
		DataBaseController::init()->updateRss($arFieldsSet, $arFieldsWhere);
	}

	public function getProperty($property_name){
		return $this->$property_name;
	}

	public function clearItems(){
		DataBaseController::init()->deleteRssItems($this);
	}

	public function insertItem($arFields){
		DataBaseController::init()->insertRssItem($this, $arFields);
	}
}
?>