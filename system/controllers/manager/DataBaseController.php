<?php
class DataBaseController{
	private static $connection;
	private static $mysqli;
	private static $user_fields = array(
			"id" => "id",
			"login" => "login",
			"email" => "email",
			"pass" => "pass",
			"full_name" => "full_name"
		); 

	private function __construct(){
		self::$mysqli = new mysqli(HOST, USER, PASS, DB_NAME);
		if (mysqli_connect_errno()) {
			echo "Подключение невозможно: ".mysqli_connect_error();
		}
	}

	static function init(){
		if(!self::$connection){
			self::$connection = new self();			
		}
		return self::$connection;
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

	private static function update($table_name, $arFieldsSet, $arFieldsWhere){
		$sql = "UPDATE `".$table_name."` SET ";
		foreach ($arFieldsSet as $field => $value) {
			$sql .= "`".$field."` = '".$value."', ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= " WHERE ";
		foreach ($arFieldsWhere as $field => $value) {
			$sql .= "`".$field."` = '".$value."' AND ";
		}	
		$sql = substr($sql, 0, -4);
		echo $sql;
		self::$mysqli->query($sql);		
	}

	public static function updateUser($fields){
		$arFieldsSet = array(
				"login" => $fields["login"],
				"email" => $fields["email"],
				"full_name" => $fields["full_name"],
				"pass" => md5($fields["pass"]),
				"active" => $fields["active"]
			);
		$arFieldsWhere = array(
				"id" => $fields["id"],
			);
		DataBaseController::update("user", $arFieldsSet, $arFieldsWhere);
	}

	public static function getUser($arParams){
		$arFields = array();
		$field_db = "";
		foreach ($arParams as $field_name => $value) {
			try {
				if(array_key_exists($field_name, self::$user_fields)){
					$field_db = self::$user_fields[$field_name];
				}else{
					throw new Exception('Некорректное значение поля для выборки.');					
				}
				$arFields[$field_db] = $value;	

			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}	
		$result = DataBaseController::select("user", $arFields);
		return $result[0];
	}
}
?>