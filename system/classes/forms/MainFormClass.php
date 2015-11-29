<?php
/*
* Класс - генератор форм
*/
class MainForm{
	private $fields;
	private $buttons;
	private $class;
	private $action;
	private $method;
	private $bones;
	private static $arDefault = array(
								"fields" => array(
											"login" => array(
														"label" => "Ваш логин",
														"type" => "text",
														"validator" => "text"
													),
											"pass" => array(
														"label" => "Ваш пароль",
														"type" => "password",
														"validator" => "not_empty"
													),
											),
								"buttons" => array(
											"send" => array(
														"label" => "Отправить",
														"action" => "submit"
													),
											),
								);

	function __construct($class="auth", $method="post", $action="", $fields = null, $buttons = null){
		if(!$fields){
			$this->fields = self::$arDefault["fields"];
		}else{
			$this->fields = $fields;
		}

		if(!$buttons){
			$this->buttons = self::$arDefault["buttons"];
		}else{
			$this->buttons = $buttons;
		}

		$this->action = $action;
		$this->method = $method;
		$this->class = $class;

		$this->bones = $this->init();

	}

	private function init(){
		$return = array();
		$return["form_header"] = $this->formHeaderGener($this->class, $this->action, $this->method);
		$return["fields"] = $this->fieldsGener($this->fields);
		$return["buttons"] = $this->buttonsGener($this->buttons, $this->class);
		$return["form_footer"] = "</form>";
		return $return;
	}

	private function formHeaderGener($class, $action, $method){
		return "<form role='form' action='".$action."' method='".$method."' class='form-signin ".$class."'>";
	}

	private function fieldsGener($arFields){
		$return = array();
		foreach ($arFields as $name => $arProp) {
			if(!empty($arProp["validator"])) $arProp["label"] .= "*";
			$return[] = "<label>".$arProp["label"]."</label><input type='".$arProp["type"]."' name='".$name."' class='form-control ".$name."' value=''/>";
		}
		return $return;
	}

	private function buttonsGener($arButtons, $form_class){
		$return = array();
		foreach ($arButtons as $class => $arProp) {
			$return[] = "<input type='".$arProp["action"]."' name='".$arProp["action"]."_".$form_class."' class='btn btn-primary ".$class."' value='".$arProp["label"]."'/>";
		}
		return $return;
	}

	public function getBones(){
		return $this->bones;
	}

	public function getFields(){
		return $this->fields;
	}

	public function getButtons(){
		return $this->buttons;
	}

	public function getClass(){
		return $this->class;
	}
}
?>