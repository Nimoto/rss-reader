<?php
class DataBaseController{
	private static $connection;
	private static $mysqli;
	private static $user_fields = array(
			"id" => "ID",
			"login" => "login",
			"email" => "email",
			"pass" => "pass",
			"full_name" => "full_name",
			"active" => "active",
			"code" => "code"
		); 
	private static $rss_fields = array(
			"id" => "ID",
			"user_id" => "user_id",
			"rss_url" => "rss_url",
		); 
	private static $rss_items_fields = array(
			"id" => "ID",
			"rss_id" => "ID_rss",
			"description" => "description",
			"title" => "title",
			"link" => "link",
			"user_id" => "user_id",
			"date" => "date",
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

	private static function select($table_name, $arFields, $offset = NULL, $limit = NULL){
		$sql = "SELECT * FROM `".$table_name."` WHERE ";
		$where = "";
		foreach ($arFields as $field => $value) {
			$where .= "`".$field."` = '".$value."' AND ";
		}		
		$where = substr($where, 0, -5);
		if($offset !== false){
			$offset .= ",";
		}
		if($limit){
			$where .= " LIMIT ".$offset.$limit.";";
		}
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
				"active" => $user->getProperty("active"),
				"code" => $user->getProperty("code")
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
		$fields = array();
		if($result[0]){
			foreach ($result[0] as $key => $value) {
				if($key_uf = array_search($key, self::$user_fields)){
					$fields[$key_uf] = $value;
				}
			
			}
		}
		return $fields;
	}

	public static function getRss($arParams){
		$arFields = array();
		$field_db = "";
		foreach ($arParams as $field_name => $value) {
			try {
				if(array_key_exists($field_name, self::$rss_fields)){
					$field_db = self::$rss_fields[$field_name];
				}else{
					throw new Exception('Некорректное значение поля для выборки.');					
				}
				$arFields[$field_db] = $value;	

			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}	
		$result = DataBaseController::select("rss", $arFields);
		$fields = array();
		foreach ($result as $key => $one_res) {
			foreach ($one_res as $key => $value) {
				if($key_uf = array_search($key, self::$rss_fields)){
					$fields[$key_uf][] = $value;
				}
			
			}
		}
		return $fields;
	}

	public static function insertRss($arParams){
		$arFields = array(
				"user_id" => $arParams["user_id"],
				"rss_url" => $arParams["rss_url"]
			);
		DataBaseController::insert("rss", $arFields);
	}

	public static function activateUser($email, $code){
		$arParams = array("code" => $code, "email" => $email);
		$fields = DataBaseController::getUser($arParams);
		if(!empty($fields)){
			DataBaseController::update("user", array("code" => "", "active" => true), array("id" => $fields["id"]));
			return true;
		}else return false;
	}

	private static function delete($table_name, $arFields){
		$sql = "DELETE FROM `".$table_name."` WHERE ";
		$where = "";
		foreach ($arFields as $field => $value) {
			$where .= "`".$field."` = '".$value."' AND ";
		}		
		$where = substr($where, 0, -5);
		$sql .= $where;
		self::$mysqli->query($sql);	
	}

	public static function deleteRss($arParams){
		$arFields = array(
				"user_id" => $arParams["user_id"],
				"rss_url" => $arParams["url"]
			);
		self::delete("rss", $arFields);
	}

	public static function deleteRssItems($rss){
		$arFields = array(
				"user_id" => $rss->getProperty("user_id"),
			);
		self::delete("rss_items", $arFields);
	}

	public static function insertRssItem($rss, $arFields){
		$arFields = array(
				"ID_rss" => $rss->getProperty("id"),
				"description" => $arFields["description"],
				"title" => $arFields["title"],
				"link" => $arFields["link"],
				"user_id" => $rss->getProperty("user_id"),
				"date" => $arFields["date"],
			);
		DataBaseController::insert("rss_items", $arFields);
	}

	public static function updateRss($set, $where){
		DataBaseController::update("rss_items", $set, $where);		
	}

	public static function getRssItems($arParams, $offset, $limit){
		$arFields = array();
		$field_db = "";
		foreach ($arParams as $field_name => $value) {
			try {
				if(array_key_exists($field_name, self::$rss_items_fields)){
					$field_db = self::$rss_fields[$field_name];
				}else{
					throw new Exception('Некорректное значение поля для выборки.');					
				}
				$arFields[$field_db] = $value;	

			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}	
		$result = DataBaseController::select("rss_items", $arFields, $offset, $limit);
		$fields = array();
		foreach ($result as $key => $one_res) {
			$fields_tmp = array();
			foreach ($one_res as $key => $value) {
				if($key_uf = array_search($key, self::$rss_items_fields)){
					$fields_tmp[$key_uf] = htmlspecialchars_decode($value);
				}			
			}
			$fields["items"][] = $fields_tmp;
		}
		if(empty($fields)) $fields = false;
		return $fields;
	} 
}
?>
