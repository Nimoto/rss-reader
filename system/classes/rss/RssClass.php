<?php
class RssClass{
	private $url;
	private $title;
	private $user_id;
	private $id;
	private $date;

	public function __construct($url, $user_id, $id, $title = NULL, $date = NULL){
		$this->url = $url;
		$this->user_id = $user_id;
		$this->id = $id;
		$this->title = $title;
		$this->date = $date;
	}

	public static function getById($id){
		$arParams = array("id" => $id);
		$fields = DataBaseController::init()->getRss($arParams);
		if(!empty($fields)){
			$rss = new RssClass($fields[0]['rss_url'], $fields[0]['user_id'], $id, $fields[0]["title"], $fields[0]["date"]);
		}else $rss = false;
		return $rss;
	}

	public function setTitle($title){
		$this->title = $title;
		$arFieldsSet = array("title" => $this->title);
		$arFieldsWhere = array("rss_url" => $this->url);
		DataBaseController::init()->updateRss($arFieldsSet, $arFieldsWhere);
	}

	public function setRefreshDate($date){
		$this->date = $date;
		$arFieldsSet = array("date" => $date);
		$arFieldsWhere = array("rss_url" => $this->url, "user_id" => $this->user_id);
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