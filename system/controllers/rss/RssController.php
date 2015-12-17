<?php
class RssController{
	private $url;
	private $view;
	private $template;
	private $rss_list;

	function __construct($user_id, $template=NULL, $arFilter = NULL){
		$this->template = $template;
		$this->user_id = $user_id;
		$this->view = new View();
		$this->rss_list = $this->getAllRssByUserId($this->user_id, $arFilter);
	}

	private function parseXml($url, $rss = NULL){
		$xml = simplexml_load_file($url);;

		foreach ($xml->channel as $fields) {
			if(!empty($fields)){
				foreach ($fields as $key => $value) {		
					if($key != "item"){
						$result[$key] = $value."";
					}else if($key == "item"){
						$result["items"][$value->pubDate.""] = $value;
					}
				}
			}
		}
		foreach ($xml as $fields) {
			foreach ($fields as $key => $value) {
				$result["items"][] = array();
				$result["items"][count($result["items"])-1][$key] = $value;
			}
		}
		/*if($url == "http://feeds.feedburner.com/Eao197?format=xml"){
			echo "<pre>";
			print_r($xml);
			echo "</pre>";
		}*/
		return $result;
	}

	public function updateOneRss($rss){
		$one_url = $rss->getProperty("url");
		$lenta = $this->parseXml($one_url, $rss);
		$rss->setTitle($lenta["title"]);
		$last_update = $rss->getProperty("date");

		$rss->setRefreshDate(date("Y-m-d H:i:s"));
		//$rss->clearItems();

		foreach ($lenta["items"] as $date_nf => $item) {
			$timestamp = strtotime($date_nf);
			$date = date("Y-m-d H:i:s", $timestamp);
			//echo "=============>".$date_nf." ".$date." ".$last_update."<br />";
			if($date > $last_update){
				$arFields = array(
						"title" => htmlspecialchars($item->title.""),
						"link" => htmlentities($item->link.""),
						"date" => $date."",
						"description" => htmlspecialchars($item->description.""),
						"audio" => $item->enclosure["url"].""
					);
				if($arFields["title"] && $arFields["link"] && $arFields["description"]) $rss->insertItem($arFields);
			}
		}
	}

	public function updateRss($rss = NULL){
		if(!empty($this->rss_list)){
			foreach ($this->rss_list as $rss) {
				$this->updateOneRss($rss);
			}
		}
	}


	public function getAllRssByUserId($user_id, $arFilter = NULL){
		$arParams = $arFilter;
		$arParams["user_id"] = $user_id;
		$fields = DataBaseController::init()->getRss($arParams);
		$rss_list = array();
		if($fields){
			foreach ($fields as $rss_fields) {
				$rss_list[] = new RssClass($rss_fields['rss_url'], $user_id, $rss_fields['id'], $rss_fields['title'], $rss_fields['date']);
			}
		}
		return $rss_list;
	}



	function printRssList(){
		if(!empty($this->rss_list)){
			foreach ($this->rss_list as $rss) {
				if($rss->getProperty("title")){
					$text = $rss->getProperty("title");
				}else{
					$text = $rss->getProperty("url");
				}
				$data["urls"][$rss->getProperty("id")] = $rss->getProperty("url");
			}
			$this->include_tpl($this->template, $data);		
		}
	}


	private function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);		
	}
}
?>