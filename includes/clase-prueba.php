<?php

require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

$mail = new PHPMailer();


//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'just55.justhost.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'themeforest@ismail-hossain.me';                 // SMTP username
$mail->Password = 'AsDf12**';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$message = "";
$status = "false";

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['form_email'] != '' AND $_POST['form_message'] != '' ) {

        $name = 'Quick Contact';
        $email = $_POST['form_email'];
        $message = $_POST['form_message'];

        $subject = isset($subject) ? $subject : 'Solicitud Clase de Prueba | RRTEAM.com';

        $botcheck = $_POST['form_botcheck'];

        $toemail = 'info@reinaldoribeiroteam.com'; // Your Email Address
        $toname = 'RRTeam Barcelona'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $email = isset($email) ? "Email: $email<br><br>" : '';
            $message = isset($message) ? "Mensaje: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>Solicitud Clase de Prueba RRTEAM: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$email $message $referrer";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                $message = 'Hemos recibido tu mensaje y nos pondremos en contacto contigo en breve.';
                $status = "true";
            else:
                $message = 'No pudimos enviar tu correo por un error en el formulario.<br /><br /><strong>Motivo de error:</strong><br />' . $mail->ErrorInfo . '';
                $status = "false";
            endif;
        } else {
            $message = 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
            $status = "false";
        }
    } else {
        $message = 'Por favor rellena todos los campos e intentalo otra vez.';
        $status = "false";
    }
} else {
    $message = 'Ha ocurrido un error por favor intentalo otra vez.';
    $status = "false";
}

$status_array = array( 'message' => $message, 'status' => $status);
echo json_encode($status_array);
?>
