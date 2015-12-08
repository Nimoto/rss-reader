<?php
class MailController{
	private static function SendMail($subject, $message, $email = null){
		if($email){
			mail($email, $subject, $message);
		}
		mail(ADMIN_EMAIL, $subject, $message);
	}

	public static function RegisterMail($email, $code){
		$message = "Успешная регистрация. 
		Перейдите по ссылке для активации аккаунта: 
		http://".$_SERVER["HTTP_HOST"]."/activate/?code=".$code."&email=".$email.";";
		self::SendMail("Успешная регистрация на сайте RSS-Reader!", $message, $email);
	}
}
?>