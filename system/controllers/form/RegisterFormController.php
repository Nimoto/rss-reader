<?php
class RegisterFormController extends MainFormController{

	private $_FORMDATA;

	function __construct($arParams = null, $form){
		$this->init($arParams, $form);
		$this->_FORMDATA = parent::getProperty("_FORMDATA");
		$this->afterInit($arParams["template"]);	
	}

	function handler(){
		$messages = parent::handler();
		if($messages["status"] == "success" && !empty($this->_FORMDATA)){
			foreach ($this->_FORMDATA as $name => $value) {
				if ($name == "email") {
					$user = UserClass::getByEmail($value);
					if($user !== false) $error_message[] = "Пользователь с таким email уже зарегистрирован";
				}else if ($name == "login") {
					$user = UserClass::getByLogin($value);
					if($user !== false) $error_message[] = "Пользователь с таким логином уже зарегистрирован";
				}
			}
			if($error_message){
				$messages["status"] = "error";
				$messages["error"][] = $error_message;
				unset($messages["success"]);			
			}else{
				$arFields = array(
						"login" => $this->_FORMDATA["login"],
						"email" => $this->_FORMDATA["email"],
						"full_name" => $this->_FORMDATA["full_name"],
						"pass" => $this->_FORMDATA["pass"]
					);
				UserClass::createUser($arFields);
				$messages["success"] = "Спасибо за регистрацию. На Ваш email выслано письмо для активации аккаунта.";		
				MailController::RegisterMail($this->_FORMDATA["email"]);	
			}
		}
		return $messages;
	}
}
?>