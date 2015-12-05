<?php
class UpdateFormController extends MainFormController{

	private $_FORMDATA;

	function __construct($arParams = null, $form){
		$this->init($arParams, $form);
		$this->_FORMDATA = parent::getProperty("_FORMDATA");
		$this->afterInit($arParams["template"]);	
	}

	function handler(){
		$messages = parent::handler();
		if($messages["status"] == "success" && !empty($this->_FORMDATA)){
			$arFields = array(
					"id" => $this->_FORMDATA["id"],
					"login" => $this->_FORMDATA["login"],
					"email" => $this->_FORMDATA["email"],
					"full_name" => $this->_FORMDATA["full_name"],
					"pass" => $this->_FORMDATA["pass"]
				);
			UserClass::updateUser($arFields);
			$messages["success"] = "Информация обновлена.";		
		}
		return $messages;
	}
}
?>