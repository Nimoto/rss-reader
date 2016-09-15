<?php

/*
* Класс - генератор форм
*/

class MainForm {
    private $fields;
    private $buttons;
    private $class;
    private $action;
    private $method;

    function __construct($class = "auth", $method = "post", $action = "") {
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
    }

    public function addField($arField) {
        $this->fields[$arField->getProperty("name")] = $arField;
    }

    public function addButton($arButton) {
        $this->buttons[$arButton->getProperty("name")] = $arButton;
    }

    public function getProperty($property_name) {
        return $this->$property_name;
    }
}

?>