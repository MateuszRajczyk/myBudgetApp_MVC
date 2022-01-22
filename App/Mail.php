<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Config;



class Mail
{
	public static function send($to, $subject, $message)
	{
		/*
		// To send HTML mail, the Content-type header must be set
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=UTF-8';

		// Additional headers
		$headers[] = 'From: <admin@budgetfinance.com>';
		
		return mail($to, $subject, $message, implode("\r\n", $headers));
		
		*/
		 
		$mail = new PHPMailer; 
		 
		$mail->isSMTP();                      // Set mailer to use SMTP 
		$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
		$mail->SMTPAuth = true;               // Enable SMTP authentication 
		$mail->Username = Config::USERNAME_GMAIL;   // SMTP username 
		$mail->Password = Config::PASSWORD_GMAIL;   // SMTP password 
		$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
		$mail->Port = 587;                    // TCP port to connect to 
		 
		// Sender info 
		$mail->setFrom('admin@budget.mateuszrajczyk.com', 'Home Budget Application'); 
		 
		// Add a recipient 
		$mail->addAddress($to); 
		 
		//$mail->addCC('cc@example.com'); 
		//$mail->addBCC('bcc@example.com'); 
		 
		// Set email format to HTML 
		$mail->isHTML(true); 
		 
		// Mail subject 
		$mail->Subject = $subject; 
		 
		// Mail body content 
		$mail->Body = $message; 
		 
		 
		$mail->send();
	}
}