<?php
class MainFormController{

	private $form;
	private $view;
	private $_FORMDATA;
	private $status;
	private $redirect_uri;
	private $validator;

	function __construct($arParams, $form){
		$this->init($arParams, $form);
		$this->afterInit($arParams["template"]);
	}

	protected function init($arParams, $form){
		$this->view = new View();
		$this->validator = new MainValidatorController;
		$this->form = $form;

		if($this->form->getProperty("method") == "get"){
			$this->_FORMDATA = $_GET;
		}else $this->_FORMDATA = $_POST;
		$_SESSION["form_".$this->form->getProperty("class")] = $this->_FORMDATA;
	}

	protected function afterInit($template){
		$result["error"] = $this->handler();
		$bones = $this->formParts();
		$data = array_merge($result, $bones);
		$this->include_tpl($template, $data);
	}

	function include_tpl($tpl, $data){
		$this->view->generate($tpl, $data);
	}	

	function handler(){
		$form = $this->form;
		$_FORMDATA = $this->_FORMDATA;
		$fields = $form->getProperty("fields");
		$buttons = $form->getProperty("buttons");
		$class = $form->getProperty("class");
		$error_message = array();
		if(is_array($_FORMDATA)){
			if($_FORMDATA["submit_".$class]){
				foreach ($_FORMDATA as $name => $value) {
					if($fields[$name]){
						$valid = $fields[$name]->getProperty("validator");
						if($valid){
							$err = $this->validator->validator($value, $valid, $fields[$name]->getProperty("pass_field"), $this->_FORMDATA);
							if($err !== true) $error_message[] = str_replace("{field}", $fields[$name]->getProperty("label"), $err);
						}
					}
				}
			}
		}

		if(empty($error_message)){
			return true;
		}else return $error_message;
	}


	private function formParts(){
		$form = $this->form;
		$return = array();
		$return["form_header"] = $this->formHeaderGener($form->getProperty("class"), $form->getProperty("action"), $form->getProperty("method"));
		$return["fields"] = $this->fieldsGener($form->getProperty("fields"));
		$return["buttons"] = $this->buttonsGener($form->getProperty("buttons"), $form->getProperty("class"));
		$return["form_footer"] = "</form>";
		return $return;
	}

	private function formHeaderGener($class, $action, $method){
		return "<form role='form' action='".$action."' method='".$method."' class='form-signin ".$class."'>";
	}

	private function fieldsGener($arFields){
		$return = array();
		foreach ($arFields as $name => $arProp) {
			$label = $arProp->getProperty("label");
			if(!empty($arProp->getProperty("validator"))){
				$label .= "*";
			}
			$return[] = "<label>".$label."</label><input type='".$arProp->getProperty("type")."' name='".$name."' class='form-control ".$name."' value='".$_SESSION["form_".$this->form->getProperty("class")][$name]."'/>";
		}
		return $return;
	}

	private function buttonsGener($arButtons, $form_class){
		$return = array();
		foreach ($arButtons as $class => $arProp) {
			$return[] = "<input type='".$arProp->getProperty("type")."' name='".$arProp->getProperty("type")."_".$form_class."' class='btn btn-primary ".$class."' value='".$arProp->getProperty("label")."'/>";
		}
		return $return;
	}

	public function getProperty($property_name){
		return $this->$property_name;
	}
}
?>