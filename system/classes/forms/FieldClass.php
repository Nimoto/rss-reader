<?php
class Field{
	private $name;
	private $label;
	private $type;
	private $pass_field;
	private $validator;

	public function __construct($name, $label, $type, $validator = null, $pass_field = null){
		$this->name = $name;
		$this->label = $label;
		$this->type = $type;
		$this->pass_field = $pass_field;
		$this->validator = $validator;
	}

	public function getProperty($property_name){
		return $this->$property_name;
	}
}
?>