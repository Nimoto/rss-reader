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
		$result["error"] = $this->handler();
		$bones = $this->form->getBones();
		$data = array_merge($result, $bones);
		$this->include_tpl($arParams['template'], $data);
	}

	function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);
	}	

	function handler(){
		$form = $this->form;
		$_FORMDATA = $this->_FORMDATA;
		$fields = $form->getFields();
		$buttons = $form->getButtons();
		$class = $form->getClass();
		$error_message = array();
		if(is_array($_FORMDATA)){
			if($_FORMDATA["submit_".$class]){
				foreach ($_FORMDATA as $name => $value) {
					if($fields[$name]["validator"]){
						$err = $this->validator($value, $fields[$name]["validator"], $fields[$name]["pass_field"]);
						if($err !== true) $error_message[] = str_replace("{field}", $fields[$name]["label"], $err);
					}
				}
			}
		}

		if(empty($error_message)){
			return true;
		}else return $error_message;
	}

	private function validator($value, $rule, $pass_field = null){
		$func_name = "validator_".$rule;
		return $this->$func_name($value, $pass_field);
	}

	private function validator_text($value){
		$return = $this->validator_not_empty($value);
		if ($return === true && preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $value)) {
	        $return = "В поле {field} должны быть только буквы, пробелы или цифры";
		}
		return $return;
	}
	
	private function validator_email($value){
		$return = $this->validator_not_empty($value);
		if ($return === true && preg_match("/[^(\w)|(\@)|(\.)|(\-)]/", $value)) {
	        $return = "В поле {field} должен быть корректный email";
		}
		return $return;
	}
	
	private function validator_not_empty($value){
		$return = true;
		if (empty($value)) {
	        $return = "Поле {field} обязательно для заполнения";
		}
		return $return;
	}

	private function validator_confirm_pass($value, $pass_field){
		$return = $this->validator_not_empty($value);
		if ($return === true && $value != $this->_FORMDATA[$pass_field]) {
	        $return = "Введенные пароли не совпадают";
		}
		return $return;
	}
}
?>