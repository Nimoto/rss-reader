<?php
class DataBaseController{
	private static $obj;
	private $mysqli;

	private function __construct($host, $login, $pass, $db_name){
		$this->mysqli = new mysqli($host, $login, $pass, $db_name);
		if (mysqli_connect_errno()) {
			echo "Подключение невозможно: ".mysqli_connect_error();
		}
	}

	static function connectDB($host=null, $login=null, $pass=null, $db_name=null){
		if(!self::$obj){
			self::$obj = new DataBaseController($host, $login, $pass, $db_name);			
		}
		return self::$obj;
	}

	public function select(){

	}

	public function insert($table_name, $arFields){
		$sql = "INSERT INTO `".$table_name."`";
		$fields = "";
		$values = "";
		foreach ($arFields as $field => $value) {
			$fields .= "`".$field."`, ";
			$values .= "'".$value."', ";
		}
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -2);
		$sql .= "(".$fields.") VALUES (".$values.");";
		echo $sql;
		$this->mysqli->query($sql);
	}

	public function update(){

	}
}
?>