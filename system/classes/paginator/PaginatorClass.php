<?php

class PaginatorClass {
    private $page_num;
    private $page_count;
    private $page_modif;

    public function __construct($page_modif = "nav", $page_count = NULL) {
        $this->page_count = $page_count;
        $this->page_modif = $page_modif;
        if ($_GET[$this->page_modif])
            $this->page_num = $_GET[$this->page_modif] - 1;
        else
            $this->page_num = 0;
    }

    public function setProperty($property_name, $property_value) {
        $this->$property_name = $property_value;
    }

    public function getProperty($property_name) {
        return $this->$property_name;
    }
}

?>