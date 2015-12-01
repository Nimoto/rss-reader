<?php
class MailController{
	private static function SendMail($subject, $message, $email = null){
		if($email){
			mail($email, $subject, $message);
		}
		mail(ADMIN_EMAIL, $subject, $message);
	}

	public static function RegisterMail($email){
		$message = "Успешная регистрация. Потом будет контрольная строка для подтверждения ;)";
		self::SendMail("Успешная регистрация на сайте RSS-Reader!", $message, $email);
	}
}
?>