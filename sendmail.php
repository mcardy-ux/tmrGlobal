<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/php_mailer/Exception.php';
require 'assets/php_mailer/PHPMailer.php';
require 'assets/php_mailer/SMTP.php'; 


// Obtener los datos del formulario
if (isset($_POST['enviar'])) {

$name= $_POST['name'];
$email= $_POST['email'];
$country= $_POST['country'];
$company= $_POST['company'];
$phone= $_POST['phone'];
$type_message= $_POST['type_message'];
$message= $_POST['message'];

// Crea una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurar el servidor SMTP de Hostinger
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com'; // Cambia esto por el servidor SMTP de Hostinger
    $mail->SMTPAuth = true;
    $mail->Username = 'notify_noreply@tmr.global'; // Cambia esto por tu dirección de correo
    $mail->Password = 'Dademaro,123'; // Cambia esto por tu contraseña de correo
    $mail->Port = 465; // Puerto SMTP de Hostinger
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    
    // Dirección de correo del remitente
    $mail->setFrom('notify_noreply@tmr.global', 'WebMail Tmr.global'); // Cambia esto por tu dirección de correo y tu nombre

    // Dirección de correo del destinatario
    $mail->addAddress('juanchodavidcardenas@outlook.com'); // Cambia esto por la dirección del destinatario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Formulario de contacto - Mensaje de ' . $nombre;
    $mail->Body = "<p><b>Nombre:</b> $name</p><p><b>Email:</b> $email</p><p><b>Mensaje:</b><br>$message</p>";

    // Envío del correo
    $mail->send();
    echo 'Correo enviado exitosamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}

}
    // // Your email here
    // $email = 'notify_noreply@tmr.global';

    // // Errors Object
    // $serverErrors = array();

    // // Errors strings
    // $name_error      = '*Invalid name (Only letters and white space allowed) <br>';
    // $email_error     = '*Invalid email format <br>';
    // $phone_error     = '*Invalid phone number <br>';
    // $subject_error   = '*Please choose the subject <br>';
    // $message_error   = '*Please write your message <br>';

    // // Status strings
    // $sent_message = 'Email Sent Successfully!';
    // $send_error_message = 'Error, please try again...';

    // // Email subject
    // $email_subject = 'New message from ' . "[$_SERVER[HTTP_HOST]]";

    // $post_data = "";

    // $sender_email = '';

    // function secure ($var){
    //     return stripslashes(htmlspecialchars($var));
    // }
    // $form_data = json_decode( file_get_contets( 'php://input' ), true );

    // foreach ($form_data as $key => $value){
    //     $value = secure($value);

    //     switch ($key){
    //         case 'name':
    //             if( !preg_match("/^[a-zA-Z ]*$/", $value) || empty($value) ) {
    //                 $serverErrors['errors'] .= $name_error;
    //             }
    //             else{
    //                 $post_data .= "<strong>$key:</strong> $value <br>";
    //             }
    //             break;
    //         case 'email':
    //             if( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
    //                 $serverErrors['errors'] .= $email_error;
    //             }
    //             else{
    //                 $post_data .= "<strong>$key:</strong> $value <br>";
    //                 $sender_email = $value;
    //             }
    //             break;
    //         case 'phone':
    //             if( empty($value) ){
    //                 $serverErrors['errors'] .= $phone_error;
    //             }
    //             else{
    //                 $post_data .= "<strong>$key:</strong> $value <br>";
    //             }
    //             break;
    //         case 'subject':
    //             if( empty($value) ){
    //                 $serverErrors['errors'] .= $subject_error;
    //             }
    //             else{
    //                 $post_data .= "<strong>$key:</strong> $value <br>";
    //             }
    //             break;
    //         case 'message':
    //             if( empty($value) ){
    //                 $serverErrors['errors'] .= $message_error;
    //             }
    //             else{
    //                 $post_data .= "<br><strong>$key:</strong> $value <br>";
    //             }
    //             break;
    //         default: if( !empty($value) ) $post_data .= "<strong>$key:</strong> $value <br>";
    //     }
    // }

    // // Set and return status ERROR if anny errors found
    // if( count($serverErrors) > 0 ) {
    //     $serverErrors['status'] = 'error';

    //     // Return JSON Errors
    //     echo json_encode($serverErrors, JSON_FORCE_OBJECT);
    //     exit;
    // }
    // else{
    //     /*
    //     * If no errors prepare and send email
    //     */

    //     if( !empty($sender_email) ){
    //         $sender = "{$sender_email} <noreply@{$_SERVER['HTTP_HOST']}>";
    //     }
    //     else{
    //         $sender = "{$email} <noreply@{$_SERVER['HTTP_HOST']}>";
    //     }

    //     // Setting up header
    //     $header  = 'MIME-Version: 1.0' . "\r\n";
    //     $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //     $header .= 'From: '.$sender."\r\n".
    //         'Reply-To: '.$sender."\r\n" .
    //         'X-Mailer: PHP/' . phpversion();

    //     //  $message = $post_data . "\n\n"."User IP: <a href='#'>User IP</a>" . $_SERVER['REMOTE_ADDR'] . "\n\n"  .date("H:i M.d.Y ")."\n";

    //     $message = '<html><body>';
    //     $message .= '<p style="display: block; max-width: 550px; font-size: 16px">'. $post_data . '</p>';
    //     $message .= '<br>';
    //     $message .= '<a href="https://iplocation.com/?ip='.$_SERVER['REMOTE_ADDR'].'" style="text-decoration: underline; color: #27AE60"><strong style="color: #27AE60">VIEW USER LOCALIZATION</strong></a>';
    //     $message .= '<p style="color: #999999; font-size: 14px"><strong>SENT:</strong> ' . date("H:i M.d.Y ") . '</p>';
    //     $message .= '<p style="color: #999999; font-size: 11px; margin-top: 50px;"> Powered by <a href="#" style="color: #EB3B5B">Simple AJAX Contact Form</a></p>';
    //     $message .= '</body></html>';

    //     // Verification before sending
    //     $verify = mail($email,$email_subject,$message,$header);

    //     // Return Server Response
    //     if ($verify == 'true'){

    //         // Return Success Message
    //         $serverErrors['status'] = 'success';
    //         $serverErrors['message'] = $sent_message;
    //         echo json_encode($serverErrors, JSON_FORCE_OBJECT);

    //         exit;
    //     }
    //     else {

    //         // Return Error Message
    //         $serverErrors['status'] = 'error';
    //         $serverErrors['message'] = $send_error_message;
    //         echo json_encode($serverErrors, JSON_FORCE_OBJECT);

    //         exit;
    //     }
    // }
