<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;
    
    public function __construct($nombre, $email, $token) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }
    
    public function enviarConfirmacion() {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->setFrom('cuentas@cutappoint.com');
        $mail->addAddress('cuentas@cutappoint.com','CutAppoint.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Crear el contenido del email
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>. Has creado tu cuenta en CutAppoint, confirma tu cuenta haciendo click en el siguiente enlace:</p>";
        $contenido .= "Presiona aquí: <a href='". $_ENV['APP_URL']  ."/confirmar-cuenta?token=" . $this->token ."'>Confirmar cuenta</a>";
        $contenido .= "<p>Si no solicitaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";
    
        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones() {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@cutappoint.com');
        $mail->addAddress('cuentas@cutappoint.com','CutAppoint.com');
        $mail->Subject = 'Reestablece tu contraseña';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Crear el contenido del email
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>. Has solicitado reestablecer tu contraseña. Entre en el siguiente enlace para hacerlo.</p>";
        $contenido .= "Presiona aquí: <a href='". $_ENV['APP_URL']  ."/recuperar?token=" . $this->token ."'>Reestablecer contraseña</a>";
        $contenido .= "<p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";
    
        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }
}