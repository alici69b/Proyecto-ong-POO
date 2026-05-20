<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config/mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private static function getInstance(): PHPMailer
    {
        $mail = new PHPMailer(true);

        if (empty(MAIL_USERNAME) || empty(MAIL_PASSWORD)) {
            throw new RuntimeException(
                'Configura MAIL_USERNAME y MAIL_PASSWORD en app/config/mail.php'
            );
        }

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = MAIL_DEBUG ? 2 : 0;

        $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);

        return $mail;
    }

    public static function send(string $to, string $subject, string $body, ?string $replyTo = null): bool
    {
        try {
            $mail = self::getInstance();
            $mail->addAddress($to);
            if ($replyTo) {
                $mail->addReplyTo($replyTo);
            }
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer error: " . $mail->ErrorInfo);
            return false;
        }
    }

    public static function notifyAdminContact(array $data): bool
    {
        $subject = 'Nuevo mensaje de contacto - RESET';
        $body = "
            <h2>Nuevo mensaje de contacto</h2>
            <p><strong>Nombre:</strong> {$data['nombre_remitente']}</p>
            <p><strong>Email:</strong> {$data['email_remitente']}</p>
            <p><strong>Asunto:</strong> {$data['asunto']}</p>
            <p><strong>Mensaje:</strong></p>
            <p>" . nl2br($data['cuerpo_mensaje']) . "</p>
        ";

        return self::send(
            MAIL_ADMIN_ADDRESS,
            $subject,
            $body,
            $data['email_remitente']
        );
    }

    public static function sendPasswordReset(string $to, string $token): bool
    {
        $resetLink = "http://{$_SERVER['HTTP_HOST']}/Proyecto-ong-POO/app/controllers/controller_resetPassword.php?token=$token";
        $subject = 'Restablece tu contraseña - RESET';
        $body = "
            <h2>Restablece tu contraseña</h2>
            <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
            <p>Haz clic en el siguiente enlace para crear una nueva contraseña:</p>
            <p><a href='$resetLink'>$resetLink</a></p>
            <p>Si no solicitaste esto, ignora este mensaje.</p>
        ";

        return self::send($to, $subject, $body);
    }
}
