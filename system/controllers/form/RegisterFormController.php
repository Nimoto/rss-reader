<?php
class RegisterFormController extends MainFormController{

	function __construct($arParams = null, $form){
		parent::__construct($arParams, $form);
	}

	function handler(){
		$messages = parent::handler();
		return $messages;
	}
}
?>