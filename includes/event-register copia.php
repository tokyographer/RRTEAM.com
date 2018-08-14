<?php

require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

$mail = new PHPMailer();


//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.reinaldoribeiroteam.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'contacto@reinaldoribeiroteam.com';                 // SMTP username
$mail->Password = '|7!8@}Ma0S7';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                   // TCP port to connect to

$message = "";
$status = "false";

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['reservation_name'] != '' AND $_POST['register_email'] != '' AND $_POST['reservation_phone'] != '') {

        $name = $_POST['reservation_name'];
        $email = $_POST['register_email'];
        $phone = $_POST['reservation_phone'];
        $tarifa = $_POST['person_select'];
        $horario = $_POST['event_post'];

        $subject = isset($subject) ? $subject : 'Mensaje nuevo RRTeam.com | Nuevo alumno';

        $botcheck = $_POST['form_botcheck'];

        $toemail = 'contacto@reinadoribeiroteam.com'; // Your Email Address
        $toname = 'RRTeam.com';                // Receiver Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );

            $name = isset($name) ? "Nombre: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Telefono: $phone<br><br>" : '';
            $tarifa = isset($tarifa) ? "Tarifa escogida: $tarifa<br><br>" : '';
            $horario = isset($horario) ? "Horario: $horario<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>Este mensaje ha sido enviado por: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $tarifa $horario";

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                $message = 'Hemos recibido tu mensaje con éxito, en breve te responderemos.';
                $status = "true";
            else:
                $message = 'No hemos podido enviar tu mensaje debido a un error. Por favor intentalo nuevamente.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
                $status = "false";
            endif;
        } else {
            $message = 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
            $status = "false";
        }
    } else {
        $message = 'Por favor rellena todos los campos e intentalo nuevamente.';
        $status = "false";
    }
} else {
    $message = 'Ha ocurrido un error, por favor intentalo nuevamente.';
    $status = "false";
}

$status_array = array( 'message' => $message, 'status' => $status);
echo json_encode($status_array);
?>
