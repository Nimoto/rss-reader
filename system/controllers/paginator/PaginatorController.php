<?php
class PaginatorController{
	private $paginator;
	private $template;
	private $view;

	public function __construct($paginator, $template){
		$this->paginator = $paginator;
		$this->template = $template;
		$this->view = new View();
	}

	public function printPaginator(){
		//вырезать из гет параметров пагинацию
		//показывать левую стрелку
		//ссылка на левой стрелке
		//показывать правую стрелку
		//ссылка на правой стрелке
		//показывать 3 первых числа
		//показывать 3 последних числа
		if($this->paginator->getProperty("page_count") > 1){
			$url_get = explode("?", $_SERVER["REQUEST_URI"]);
			$url = $url_get[0]."?";
			$url_get = preg_replace("/nav=([0-9]*)/", "", $url_get[1]);
			$url_get = str_replace("&&", "&", $url_get);
			if($url_get[0] == "&"){
				$url_get = substr($url_get, 1, strlen($url_get)-1);
			}
			if($url_get){
				$url .= $url_get."&";
			}else	
				$url;

			$data["base_url"] = $url;
			if($this->paginator->getProperty("page_num") > 0){
				$data["left_arrow"] = substr($url, 0, -1);
			}

			if($this->paginator->getProperty("page_num") < ($this->paginator->getProperty("page_count") - 1)){
				$data["right_arrow"] = $url.$this->paginator->getProperty("page_modif")."=".($this->paginator->getProperty("page_count") - 1);				
			}

			$data["nums"][0] = 1;

			if($this->paginator->getProperty("page_num") > 0) $data["nums"][$this->paginator->getProperty("page_num")-1] = 1;
			else $data["nums"][$this->paginator->getProperty("page_num")+2] = 1;
			$data["nums"][$this->paginator->getProperty("page_num")] = 1;
			if($this->paginator->getProperty("page_num") < ($this->paginator->getProperty("page_count") - 1))  $data["nums"][$this->paginator->getProperty("page_num")+1] = 1;
			else $data["nums"][$this->paginator->getProperty("page_num")-2] = 1;

			$data["nums"][$this->paginator->getProperty("page_count")-1] = 1;

			ksort($data["nums"]);
		}

		$data["page_count"] = $this->paginator->getProperty("page_count");
		$data["page_num"] = $this->paginator->getProperty("page_num");
		$data["page_modif"] = $this->paginator->getProperty("page_modif");
		$this->include_tpl($this->template, $data);
	}

	private function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);		
	}
}
?>