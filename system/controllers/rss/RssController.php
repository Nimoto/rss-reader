<?php
class RssController{
	private $url;
	private $view;
	private $template;

	function __construct($url, $template){
		$this->url = $url;
		$this->template = $template;
		$this->view = new View();
	}

	function printRss(){
		if(is_array($this->url)){
			foreach ($this->url as $one_url) {
				$lenta[] = $this->parseXml($one_url);
			}
		}else $lenta[] = $this->parseXml($url);
		$data = $this->createRss($lenta);
		$this->include_tpl($this->template, $data);
	}

	function printRssList(){
		$data["urls"] = $this->url;
		$this->include_tpl($this->template, $data);		
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

	private function createRss($lenta){
		$items = array();
		foreach ($lenta as $key => $value) {
			foreach ($value["items"] as $date_nf => $item) {
				$timestamp = strtotime($date_nf);
				$date = date("Y-m-d H:i:s", $timestamp);
				$items[$date]["title"] = $item->title."";
				$items[$date]["link"] = $item->link."";
				$items[$date]["date"] = $date_nf;
				$items[$date]["description"] = $item->description."";
				$items[$date]["main_title"] = $value["title"];
				$items[$date]["main_link"] = $value["link"];
			}
		}
		krsort($items);
		$result["items"] = $items;
		return $result;
	}

	private function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);		
	}

}
?>