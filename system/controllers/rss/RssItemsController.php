<?php
class RssItemsController{
	private $user_id;
	private $page;
	private $limit;
	private $template;
	private $view;
	private $rss_list;
	private $count;
	private $paginator;

	public function __construct($user_id, $tpl, $limit = 5){
		$this->user_id = $user_id;
		$this->limit = $limit;
		$this->template = $tpl;
		$this->view = new View();
		$this->paginator = new PaginatorClass();
		$this->page = $this->paginator->getProperty("page_num");
		$arParams = array("user_id" => $this->user_id);
		$this->paginator->setProperty("page_count", round(DataBaseController::init()->getRssItems($arParams, NULL, NULL, true)/$limit));
	}

	private function getAllRssItems(){
		$offset = $this->limit * $this->page;
		$arParams = array("user_id" => $this->user_id);
		$items = DataBaseController::init()->getRssItems($arParams, $offset, $this->limit);
		return $items;		
	}

	private function createRss(){
		$items = array();
		$lenta = $this->getAllRssItems();
		if(!empty($lenta["items"])){
			foreach ($lenta["items"] as $item) {
				if(!$this->rss_list[$item["rss_id"]]){
					$this->rss_list[$item["rss_id"]] = RssClass::getById($item["rss_id"]);
				}
				$date_nf = $item["date"];
				$timestamp = strtotime($date_nf);
				$date = date("Y-m-d H:i:s", $timestamp);
				while(!empty($items[$date])){
					$date .= "*";
				}
				$items[$date]["title"] = $item["title"];
				$items[$date]["link"] = $item["link"];
				$items[$date]["date"] = $date_nf;
				$items[$date]["description"] = $item["description"];
				if($this->rss_list[$item["rss_id"]]){
					$items[$date]["main_title"] = $this->rss_list[$item["rss_id"]]->getProperty("title");
					$items[$date]["main_link"] = $this->rss_list[$item["rss_id"]]->getProperty("url");			
				}
			}
			krsort($items);
			$result["items"] = $items;
		}else{
			$result["message"] = "Вы не подписаны ни на одну ленту. Перейти в <a href='/personal/'>Личный кабинет</a>";
		}
		return $result;
	}

	public function printRssItems(){
		$data = $this->createRss();
		$this->include_tpl($this->template, $data);
	}

	private function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);		
	}

	public function getProperty($property_name){
		return $this->$property_name;
	}

} 
?>