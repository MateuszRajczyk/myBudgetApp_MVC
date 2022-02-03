<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Config;



class Mail
{
	public static function send($to, $subject, $message, $headers)
	{
		return mail($to, $subject, $message, $headers);
	}
}