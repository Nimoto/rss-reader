<?php
class RegisterFormController extends MainFormController{

	function __construct($arParams = null){
		parent::__construct($arParams);
	}

	function handler(){
		$messages = parent::handler();
		return $messages;
	}
}
?>