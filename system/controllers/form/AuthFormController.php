<?php
class AuthFormController extends MainFormController{

	private $_FORMDATA;

	function __construct($arParams = null, $form){
		$this->init($arParams, $form);
		$this->_FORMDATA = parent::getProperty("_FORMDATA");
		$this->afterInit($arParams["template"]);	
	}

	function handler(){
		$messages = parent::handler();
		if($messages["status"] == "success" && !empty($this->_FORMDATA)){
			$user = UserClass::auth($this->_FORMDATA["login"], md5($this->_FORMDATA["pass"]));
			if(!$user){
				$messages["status"] = "error";
				$messages["error"][] = "Неправильный логин или пароль";
				unset($messages["success"]);
			}else{
				$messages["success"] = "Вы авторизованы.";	
			}	
		}
		return $messages;
	}
}
?>