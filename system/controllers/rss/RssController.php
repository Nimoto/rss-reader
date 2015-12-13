<?php
class RssController{
	private $url;
	private $view;
	private $template;
	private $rss_list;

	function __construct($user_id, $template = NULL){
		$this->template = $template;
		$this->user_id = $user_id;
		$this->view = new View();
		$this->rss_list = $this->getAllRssByUserId($this->user_id);
	}

	private function parseXml($url){
		$rxml = new XMLReader();
		$rxml->xml(file_get_contents($url));
		while($rxml->read() && $rxml->name !== 'title');
		while($rxml->read() && $rxml->name !== 'item'){
			$name = $rxml->name;
			if($name == "#text" && strlen($rxml->value) > 2) 
				$value = $rxml->value;
			else if($name != "#text") $result[$name] = $value;
		}
		while($rxml->name === 'item'){      
			$note = new SimpleXMLElement($rxml->readOuterXML());
		    if($note->pubDate) $result["items"][$note->pubDate.""] = $note;
		    else $result["items"][] = $note;
		    $rxml->next('item');
		}
		return $result;
	}

	private function updateOneRss($rss){
		$one_url = $rss->getProperty("url");
		$lenta = $this->parseXml($one_url);
		$rss->setTitle($lenta["title"]);
		$rss->clearItems();
		foreach ($lenta["items"] as $date_nf => $item) {
			$timestamp = strtotime($date_nf);
			$date = date("Y-m-d H:i:s", $timestamp);
			$arFields = array(
					"title" => htmlspecialchars($item->title.""),
					"link" => htmlentities($item->link.""),
					"date" => $date."",
					"description" => htmlspecialchars($item->description.""),
					"audio" => $item->enclosure["url"].""
				);
			$rss->insertItem($arFields);
		}
	}

	public function updateRss(){
		if(!empty($this->rss_list)){
			foreach ($this->rss_list as $rss) {
				$this->updateOneRss($rss);
			}
		}
	}


	public function getAllRssByUserId($user_id){
		$arParams = array("user_id" => $user_id);
		$fields = DataBaseController::init()->getRss($arParams);
		$rss_list = array();
		if($fields){
			foreach ($fields as $rss_fields) {
				$rss_list[] = new RssClass($rss_fields['rss_url'], $user_id, $rss_fields['id'], $rss_fields['title']);
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