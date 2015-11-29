<?php
class RegisterFormController extends MainFormController{

	private $_DB;
	private $_FORMDATA;

	function __construct($arParams = null, $form){
		$this->_DB = $GLOBALS["_DB"];
		$this->init($arParams, $form);
		$this->_FORMDATA = parent::getProperty("_FORMDATA");
		$this->afterInit($arParams["template"]);	
	}

	function handler(){
		$messages = parent::handler();
		if($messages === true && !empty($this->_FORMDATA)){
			print_r($this->_DB);
			$arFields = array(
					"login" => $this->_FORMDATA["login"],
					"email" => $this->_FORMDATA["email"],
					"full_name" => $this->_FORMDATA["full_name"],
					"pass" => md5(str)
				);
			$this->_DB->insert("user", $arFields); 
		}
		return $messages;
	}
}
?>