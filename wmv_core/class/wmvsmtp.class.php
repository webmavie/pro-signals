<?php
require_once('Exception.php');
require_once('PHPMailer.php');
require_once('SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class wmvsmtp {
	private $share;
	private $email;
	private $sitename;

	function __construct ($host="", $username="", $password="", $secure="", $port="", $sitename="Mailer", $debug=0) {
		$mail = new PHPMailer;
		$mail->SMTPDebug = $debug; // Enable verbose debug output
		$mail->isSMTP();     	// Set mailer to use SMTP
		$mail->Host = $host;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = $username; // SMTP username
		$mail->Password = $password; // SMTP password
		$mail->SMTPSecure = $secure; // Enable TLS encryption, `ssl` also accepted
		$mail->Port = $port; // TCP port to connect to
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->CharSet = 'UTF-8';

		$this->share = $mail;
		$this->email = $username;
		$this->sitename = $sitename;

        return TRUE;
	}

	public function send ($to_email, $subject, $body, $altbody="") {
		$mail=$this->share;
		$mail->setFrom($this->email, $this->sitename);
		$mail->addAddress($to_email, $to_email);
		// $mail->addAddress('ellen@example.com');               // Name is optional
		// $mail->addReplyTo('info@example.com', 'Information');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC($settings['smtp_mail']);
		// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $altbody;

		if ($mail->send()) {
			return TRUE;
		}else {
			return FALSE;
		}

	}
}

?>