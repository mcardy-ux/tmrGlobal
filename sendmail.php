<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/php_mailer/Exception.php';
require 'assets/php_mailer/PHPMailer.php';
require 'assets/php_mailer/SMTP.php'; 


// Obtener los datos del formulario


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
