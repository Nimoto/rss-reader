<?php
class DataBaseController{
	private static $obj;
	private static $mysqli;

	private function __construct($host, $login, $pass, $db_name){
		self::$mysqli = new mysqli($host, $login, $pass, $db_name);
		if (mysqli_connect_errno()) {
			echo "Подключение невозможно: ".mysqli_connect_error();
		}
	}

	static function init($host=null, $login=null, $pass=null, $db_name=null){
		if(!self::$obj){
			self::$obj = new DataBaseController($host, $login, $pass, $db_name);			
		}
		return self::$obj;
	}

	private static function select($table_name, $arFields){
		$sql = "SELECT * FROM `".$table_name."` WHERE ";
		$where = "";
		foreach ($arFields as $field => $value) {
			$where .= "`".$field."` = '".$value."' AND ";
		}		
		$where = substr($where, 0, -5);
		$sql .= $where;
		$result = self::$mysqli->query($sql);
		while ($row = $result->fetch_assoc()) {
		    $return[] = $row;
		}
		return $return;
	}

	private static function insert($table_name, $arFields){
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
		self::$mysqli->query($sql);
	}

	public static function insertUser($user){
		$arFields = array(
				"login" => $user->getProperty("login"),
				"email" => $user->getProperty("email"),
				"full_name" => $user->getProperty("full_name"),
				"pass" => md5($user->getProperty("pass")),
				"active" => $user->getProperty("active")
			);
		DataBaseController::insert("user", $arFields);
	}

	public static function getUser($arParams){
		$arFields = array();
		$field_db = "";
		foreach ($arParams as $field_name => $value) {
			try {
				switch ($field_name) {
					case 'id':
						$field_db = "id";
						break;
					case 'login':
						$field_db = "login";
						break;
					case 'pass':
						$field_db = "pass";
						break;
					default:
						throw new MyException('Некорректное значение поля для выборки.');
						break;
				}
				$arFields[$field_db] = $value;	

			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}	
		$result = DataBaseController::select("user", $arFields);
		return $result[0];
	}

	public function update(){

	}
}
?>