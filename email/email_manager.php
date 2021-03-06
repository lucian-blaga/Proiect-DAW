<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/globals/config.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/pdf/pdf_manager.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

class email_manager
{
	/*
	 * Send an activation email with a register confirmation token to the specified destination email
	 * Sends using gmail smtp based on info saved in the '/globals/config.php' file
	 *
	 * @param	string	$to			Email to send the mail to
	 * @param	string	$full_name	Recipient's full name
	 * @param	string	$token		Register confirmation token
	 *
	 * @return	bool				True if email has been sent successfully and false otherwise
	 */
	public static function activation_email($to, $full_name, $token)
	{
		$mail = new PHPMailer(true);

		try {
			$mail->SMTPDebug  = 1;
			$mail->SMTPAuth   = TRUE;
			$mail->SMTPSecure = "tls";
			$mail->Port       = 587;
			$mail->Host       = EMAIL_HOST;
			$mail->Password   = EMAIL_PASS;

			$mail->setFrom(EMAIL_HOST, EMAIL_NAME);
			$mail->addAddress($to, $full_name);
			$mail->addReplyTo(EMAIL_HOST, EMAIL_NAME);

			$mail->isHTML(true);
			$mail->Subject = 'Confirm your account';
			$mail->Body    = 'Click this to activate your account: ' .
				'<a href="' .
				'https://www.blagalucianflorin.ro/controllers/users_controller.php?' .
				'_action=CONFIRM_REGISTER' .
				"&token=$token" .
				'">Activate</a>';

			$mail->send();
			return (true);
		} catch (Exception $e) {
			return (false);
		}
	}

	public static function ticket_email ($to, $full_name, $ticket_id)
	{
		$mail = new PHPMailer(true);

		try {
			$mail->SMTPDebug  = 1;
			$mail->SMTPAuth   = TRUE;
			$mail->SMTPSecure = "tls";
			$mail->Port       = 587;
			$mail->Host       = EMAIL_HOST;
			$mail->Password   = EMAIL_PASS;

			$mail->setFrom(EMAIL_HOST, EMAIL_NAME);
			$mail->addAddress($to, $full_name);
			$mail->addReplyTo(EMAIL_HOST, EMAIL_NAME);

			$mail->isHTML(true);
			$mail->Subject = 'Ticket bought';
			$mail->Body    = "Hello, you'll find your bought ticket attached to this email";

			$pdf = pdf_manager::ticket_pdf (tickets_controller::get_ticket ($ticket_id));
			$mail->addStringAttachment($pdf, 'ticket.pdf');

			$mail->send();
			return (true);
		} catch (Exception $e) {
			return (false);
		}
	}
}