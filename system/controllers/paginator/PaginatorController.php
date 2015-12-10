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