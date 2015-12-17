<?php
class DataBaseController{
	private static $connection;
	private $mysqli;
	private $user_fields = array(
			"id" => "ID",
			"login" => "login",
			"email" => "email",
			"pass" => "pass",
			"full_name" => "full_name",
			"active" => "active",
			"code" => "code"
		); 
	private $rss_fields = array(
			"id" => "ID",
			"user_id" => "user_id",
			"rss_url" => "rss_url",
			"title" => "title",
			"date" => "refresh_date"
		); 
	private $rss_items_fields = array(
			"id" => "ID",
			"rss_id" => "ID_rss",
			"description" => "description",
			"title" => "title",
			"link" => "link",
			"user_id" => "user_id",
			"date" => "date",
			"audio" => "audio",
			"read" => "is_readen",
		); 
 
    private function __clone() {
    }

    private function __wakeup() {
    }     

	private function __construct(){
		$this->mysqli = new mysqli(HOST, USER, PASS, DB_NAME);
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

	private function select($table_name, $arFields, $offset = NULL, $limit = NULL, $only_count = false, $arSort = NULL){
		$sql = "SELECT ";
		if($only_count){
			$sql .= "COUNT(*)";
		}else{
			$sql .= "*";
		}
		$sql .= " FROM `".$table_name."` WHERE ";
		$where = "";
		if(is_array($arFields)){
			foreach ($arFields as $field => $value) {
				if(is_array($value)){
					foreach ($value as $val) {
						$value_sel .= "'".$val."',";
					}

					$value = "(".substr($value_sel, 0, -1).")";
					$operand_not = "NOT IN";
					$operand = "IN";
				}else{
					$value = "'".$value."'";
					$operand_not = "!=";
					$operand = "=";
				}
				if(strpos($field, "!") !== false){
					$where .= "`".substr($field, 1, strlen($field)-1)."` ".$operand_not." ".$value." AND ";
				} else {
					$where .= "`".$field."` ".$operand." ".$value." AND ";
				}
			}	
		}	
		$where = substr($where, 0, -5);
		/*if($order_field){
			$where .= " ORDER BY `".$order_field."` ".$order." ";
		}*/
		$order = "";
		if(is_array($arSort)){
			foreach ($arSort as $field => $sort) {
				$order .= "`".$field."` ".$sort.", ";
			}
		}
		if($order){
			$order = " ORDER BY ".substr($order, 0, -2);
		}
		if($offset !== false){
			$offset .= ",";
		}
		if($limit){
			$where .= $order." LIMIT ".$offset.$limit.";";
		}
		$sql .= $where;
		$result = $this->mysqli->query($sql);
		if($result){
			while ($row = $result->fetch_assoc()) {
			    $return[] = $row;
			}
		}
		return $return;
	}

	private function insert($table_name, $arFields){
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
		$this->mysqli->query($sql);
	}

	private function update($table_name, $arFieldsSet, $arFieldsWhere){
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
		$this->mysqli->query($sql);		
	}

	private function delete($table_name, $arFields){
		$sql = "DELETE FROM `".$table_name."` WHERE ";
		$where = "";
		foreach ($arFields as $field => $value) {
			$where .= "`".$field."` = '".$value."' AND ";
		}		
		$where = substr($where, 0, -5);
		$sql .= $where;
		$this->mysqli->query($sql);	
	}

	public function insertUser($user){
		$arFields = array(
				"login" => $user->getProperty("login"),
				"email" => $user->getProperty("email"),
				"full_name" => $user->getProperty("full_name"),
				"pass" => md5($user->getProperty("pass")),
				"active" => $user->getProperty("active"),
				"code" => $user->getProperty("code")
			);
		$this->insert("user", $arFields);
	}

	public function updateUser($fields){
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
		$this->update("user", $arFieldsSet, $arFieldsWhere);
	}

	public function getUser($arParams){
		$arFields = array();
		$field_db = "";
		foreach ($arParams as $field_name => $value) {
			try {
				if(array_key_exists($field_name, $this->user_fields)){
					$field_db = $this->user_fields[$field_name];
				}else{
					throw new Exception('Некорректное значение поля для выборки.');					
				}
				$arFields[$field_db] = $value;	

			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}	
		$result = $this->select("user", $arFields);
		$fields = array();
		if($result[0]){
			foreach ($result[0] as $key => $value) {
				if($key_uf = array_search($key, $this->user_fields)){
					$fields[$key_uf] = $value;
				}
			
			}
		}
		return $fields;
	}

	public function getRss($arParams){
		$arFields = array();
		$field_db = "";
		foreach ($arParams as $field_name => $value) {
			try {
				if(array_key_exists($field_name, $this->rss_fields)){
					$field_db = $this->rss_fields[$field_name];
				}else{
					throw new Exception('Некорректное значение поля для выборки.'.$field_name);					
				}
				$arFields[$field_db] = $value;	

			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}	
		$result = $this->select("rss", $arFields);
		$fields = array();
		foreach ($result as $key => $one_res) {
			$fields_tmp = array();
			foreach ($one_res as $key => $value) {
				if($key_uf = array_search($key, $this->rss_fields)){
					$fields_tmp[$key_uf] = htmlspecialchars_decode($value);
				}			
			}
			$fields[] = $fields_tmp;
		}
		if(empty($fields)) $fields = false;
		return $fields;
	}

	public function insertRss($arParams){
		$arFields = array(
				"user_id" => $arParams["user_id"],
				"rss_url" => $arParams["rss_url"]
			);
		$this->insert("rss", $arFields);
		$fields = $this->select("rss", $arFields);
		if(!empty($fields)){
			$rss = RssClass::getById($fields[0]["ID"]);
		}else $rss = false;
		return $rss;
	}

	public function activateUser($email, $code){
		$arParams = array("code" => $code, "email" => $email);
		$fields = $this->getUser($arParams);
		if(!empty($fields)){
			$this->update("user", array("code" => "", "active" => true), array("id" => $fields["id"]));
			return true;
		}else return false;
	}

	public function deleteRss($arParams){
		$arFields = array(
				"user_id" => $arParams["user_id"],
				"rss_url" => $arParams["url"]
			);
		$fields = $this->select("rss", $arFields);
		if($fields){
			$arFields = array(
					"user_id" => $arParams["user_id"],
					"ID_rss" => $fields[0]["ID"],
				);
			$this->delete("rss_items", $arFields);
		}
		$this->delete("rss", $arFields);
	}

	public function deleteRssItems($rss){
		$arFields = array(
				"user_id" => $rss->getProperty("user_id"),
				"ID_rss" => $rss->getProperty("id"),
			);
		$this->delete("rss_items", $arFields);
	}

	public function insertRssItem($rss, $arFields){
		$arFields = array(
				"ID_rss" => $rss->getProperty("id"),
				"description" => $arFields["description"],
				"title" => $arFields["title"],
				"link" => $arFields["link"],
				"user_id" => $rss->getProperty("user_id"),
				"date" => $arFields["date"],
				"audio" => $arFields["audio"],
			);
		$this->insert("rss_items", $arFields);
	}

	public function updateRssItem($set, $where){
		foreach ($set as $key => $value) {
			$arSet[$this->rss_items_fields[$key]] = $value;
		}
		foreach ($where as $key => $value) {
			$arWhere[$this->rss_items_fields[$key]] = $value;
		}
		$this->update("rss_items", $arSet, $arWhere);		
	}

	public function updateRss($set, $where){
		foreach ($set as $key => $value) {
			$arSet[$this->rss_fields[$key]] = $value;
		}
		foreach ($where as $key => $value) {
			$arWhere[$this->rss_fields[$key]] = $value;
		}
		$this->update("rss", $arSet, $arWhere);		
	}

	public function getRssItems($arParams, $offset, $limit, $only_count = false, $arSort = NULL){
		$arFields = array();
		$field_db = "";
		foreach ($arParams as $field_name => $value) {			
			try {
				$prefix = "";
				if(strpos($field_name, "!") !== false){
					$prefix = "!";
					$field_name = substr($field_name, 1, strlen($field_name)-1);
				}
				if(array_key_exists($field_name, $this->rss_items_fields)){
					$field_db = $this->rss_items_fields[$field_name];
				}else{
					throw new Exception('Некорректное значение поля для выборки.');					
				}
				$arFields[$prefix.$field_db] = $value;	
			} catch (Exception $e) {
				var_dump($e->getMessage());
			}
		}	
		$result = $this->select("rss_items", $arFields, $offset, $limit, $only_count, $arSort);
		if($only_count){
			return $result[0]["COUNT(*)"];
		}else{
			$fields = array();
			foreach ($result as $key => $one_res) {
				$fields_tmp = array();
				foreach ($one_res as $key => $value) {
					if($key_uf = array_search($key, $this->rss_items_fields)){
						$fields_tmp[$key_uf] = htmlspecialchars_decode($value);
					}			
				}
				$fields["items"][] = $fields_tmp;
			}
			if(empty($fields)) $fields = false;
			return $fields;
		}
	}
}
?>
