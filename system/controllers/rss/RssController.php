<?php
class RssController{
	private $url;
	private $view;
	private $template;
	private $page;
	private $rss;

	function __construct($rss, $template){
		$this->rss = $rss;
		$this->url = $rss->getProperty("url");
		$this->template = $template;
		$this->view = new View();
		if($_GET["nav"])
			$this->page = $_GET["nav"] - 1;
		else
			$this->page = 0;

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

	function updateRss(){
		foreach ($this->url as $one_url) {
			$lenta = $this->parseXml($one_url);
			$this->rss->setTitle($lenta["title"]);
			$this->rss->clearItems();
			foreach ($lenta["items"] as $date_nf => $item) {
				$timestamp = strtotime($date_nf);
				$date = date("Y-m-d H:i:s", $timestamp);
				$arFields = array(
						"title" => htmlspecialchars($item->title.""),
						"link" => htmlentities($item->link.""),
						"date" => $date_nf."",
						"description" => htmlspecialchars($item->description.""),
					);
				$this->rss->insertItem($arFields);
			}		
		}		
	}

	function printRss(){
		$data = $this->rss->getAllRssItems($this->page*5, 5);
		$this->include_tpl($this->template, $data);
	}

	function printRssList(){
		$data["urls"] = $this->url;
		$this->include_tpl($this->template, $data);		
	}


	private function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);		
	}
}
?>