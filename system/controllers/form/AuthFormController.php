<?php
class AuthFormController extends MainFormController{

	private $_FORMDATA;
	private $redirect_url;

	function __construct($arParams = null, $form, $redirect_url = null){
		$this->init($arParams, $form);
		$this->redirect_url = $redirect_url;
		$this->_FORMDATA = parent::getProperty("_FORMDATA");
		$this->afterInit($arParams["template"]);	
	}

	function handler(){
		$messages = parent::handler();
		if($messages["status"] == "success" && !empty($this->_FORMDATA)){
			$user = UserClass::auth($this->_FORMDATA["login"], md5($this->_FORMDATA["pass"]));
			if(!$user && $messages["status"] == "success"){
				$messages["status"] = "error";
				$messages["error"][] = "Неправильный логин или пароль";
				unset($messages["success"]);
			}else{
				$messages["success"] = "Вы авторизованы.";
				$this->redirect();
			}
		}
		return $messages;
	}

	private function redirect(){
		if($this->redirect_url) echo '<meta http-equiv="refresh" content="0;URL='.$this->redirect_url.'">';
	}
}
?>