<?php
class MainValidatorController{		
	public function validator($value, $rule, $pass_field = null){
		$func_name = "validator_".$rule;
		return $this->$func_name($value, $pass_field);
	}

	private function validator_text($value){
		$return = $this->validator_not_empty($value);
		if ($return === true && preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $value)) {
	        $return = "В поле {field} должны быть только буквы, пробелы или цифры";
		}
		return $return;
	}
	
	private function validator_email($value){
		$return = $this->validator_not_empty($value);
		if ($return === true && preg_match("/[^(\w)|(\@)|(\.)|(\-)]/", $value)) {
	        $return = "В поле {field} должен быть корректный email";
		}
		return $return;
	}
	
	private function validator_not_empty($value){
		$return = true;
		if (empty($value)) {
	        $return = "Поле {field} обязательно для заполнения";
		}
		return $return;
	}

	private function validator_confirm_pass($value, $pass_field){
		$return = $this->validator_not_empty($value);
		if ($return === true && $value != $this->_FORMDATA[$pass_field]) {
	        $return = "Введенные пароли не совпадают";
		}
		return $return;
	}
}
?>