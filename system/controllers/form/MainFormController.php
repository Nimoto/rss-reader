<?php
class MainFormController{

	private $form;
	private $view;
	private $_FORMDATA;
	private $status;
	private $redirect_uri;

	function __construct($arParams = null){
		$this->view = new View();
		if($arParams) $this->form = new MainForm($arParams['class'], $arParams['method'], $arParams['action'], $arParams['fields'], $arParams['buttons']);
		else $this->form = new MainForm();
		if($arParams["method"] == "get"){
			$this->_FORMDATA = $_GET;
		}else $this->_FORMDATA = $_POST;
		$this->handler($this->form, $this->_FORMDATA);
		$this->include_tpl($arParams['template'], $this->form->getBones());
	}

	function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);
	}	

	function handler($form, $_FORMDATA = null){
		$fields = $form->getFields();
		$buttons = $form->getButtons();
		$class = $form->getClass();
		$error_message = array();
		if(is_array($_FORMDATA)){
			if($_FORMDATA["submit_".$class]){
				foreach ($_FORMDATA as $name => $value) {
					if($fields[$name]["validator"]){
						$err = $this->validator($value, $fields[$name]);
						if($err !== true) $error_message[] = $err;
					}
				}
			}
		}

		if(empty($error_message)){
			return true;
		}else return $error_message;
	}

	function validator($value, $rule){
		return true;
	}
}
?>