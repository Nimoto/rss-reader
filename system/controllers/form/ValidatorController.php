<?php
class MainValidatorController{		
	public function validator($value, $rule, $pass_field = null, $_FORMDATA = null){
		$func_name = "validator_".$rule;
		$confirm_value = null;
		if($pass_field){
			$confirm_value = $_FORMDATA[$pass_field];
		}
		return $this->$func_name($value, $confirm_value);
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

	private function validator_confirm_pass($value, $confirm_value){
		$return = $this->validator_not_empty($value);
		if ($return === true && $value != $confirm_value) {
	        $return = "Введенные пароли не совпадают";
		}
		return $return;
	}
}
?>