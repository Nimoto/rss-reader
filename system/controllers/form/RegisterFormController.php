<?php
class RegisterFormController extends MainFormController{

	private $_DB;
	private $_FORMDATA;

	function __construct($arParams = null, $form){
		//$this->_DB = $GLOBALS["_DB"];
		$this->init($arParams, $form);
		$this->_FORMDATA = parent::getProperty("_FORMDATA");
		$this->afterInit($arParams["template"]);	
	}

	function handler(){
		$messages = parent::handler();
		if($messages["status"] == "success" && !empty($this->_FORMDATA)){
			//продумать класс USER так, чтобы вставка нового пользователя проходила через его поля
			$arFields = array(
					"login" => $this->_FORMDATA["login"],
					"email" => $this->_FORMDATA["email"],
					"full_name" => $this->_FORMDATA["full_name"],
					"pass" => md5(str)
				);
			DataBaseController::insert(DB_USER_TBL, $arFields); 
			$messages["success"] = "Спасибо за регистрацию. На Ваш email выслано письмо для активации аккаунта.";		
			MailController::RegisterMail($this->_FORMDATA["email"]);	
		}
		return $messages;
	}
}
?>