<?php
class UserClass{
	private $login;
	private $email;
	private $full_name;
	private $id;
	private $pass;
	private $active;

	private function __construct($login, $email, $full_name, $pass=null, $active=null, $id = null){
		$this->login = $login;
		$this->email = $email;
		$this->full_name = $full_name;
		$this->pass = $pass;
		$this->id = $id;
		$this->active = $active;
	}

	public static function auth($login, $pass){
		$arParams = array("login" => $login, "pass" => $pass);
		$fields = DataBaseController::getUser($arParams);
		if(!empty($fields)){
			$user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], $fields['id']);
		}else $user = false;
		return $user;
	}

	public static function getByLogin($login){
		$arParams = array("login" => $login);
		$fields = DataBaseController::getUser($arParams);
		if(!empty($fields)){
			$user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], $fields['id']);
		}else $user = false;
		return $user;
	}

	public static function getById($id){
		$arParams = array("id" => $id);
		$fields = DataBaseController::getUser($arParams);
		if(!empty($fields)){
			$user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], $fields['id']);
		}else $user = false;
		return $user;
	}

	public static function createUser($fields){
		$fields['active'] = false;
		$user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active']);
		DataBaseController::insertUser($user);
		return $user;
	}

	public function getProperty($property_name){
		return $this->$property_name;
	}
}
?>