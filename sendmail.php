<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './lib/PHPMailer/src/Exception.php';
    require './lib/PHPMailer/src/PHPMailer.php';
    require './lib/PHPMailer/src/SMTP.php';

    /* Create a new PHPMailer object; passing `false` disables exceptions */
    $mail = new PHPMailer(false);

    try {
		$mail->isSMTP();							    //Send using SMTP
		$mail->SMTPAuth = true;						    //Enable SMTP authentication
		$mail->SMTPSecure = 'ssl';					    //Set the encryption system
		$mail->SMTPDebug = 0;
		
		$mail->Host = 'ssl://smtp.mail.ru';			    //Set the SMTP server to send through
		$mail->Port = 465;							    //Set the SMTP port
		$mail->Username = 'admin@radikdeveloper.ru';    //SMTP username
		$mail->Password = 'AuRbrMrGmnynXbJTen13';	    //SMTP password
		
		$mail->CharSet = 'UTF-8';					    //Set charset
		$mail->setFrom('admin@radikdeveloper.ru');	    //Set the mail sender
		$mail->addAddress($email);					    //Add a recipient
		$mail->Subject = $subject;	                    //Set the subject
		$mail->Body = $message;                         //Set the mail message body
			
		$mailOk = $mail->send();					    //Send the mail
	} catch (Exception $e) {
		echo $e->errorMessage();
	} catch (\Exception $e) {
		echo $e->getMessage();
	}
?>