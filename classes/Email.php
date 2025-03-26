<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // Crear el objeto de email
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'd53fb87dbd1d98';
        $phpmailer->Password = 'f528a3bc34ba62';
        $phpmailer->setFrom('cuentas@appsalon.com');
        $phpmailer->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $phpmailer->Subject = 'Crea tu cuenta';

        // SET html
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola, " . $this->nombre . "</strong>. Has creado tu cuenta en nuestro portal web. Confirma la misma dando click en el siguiente botón.</p>";
        $contenido .= "<p>Da click aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, ignora este mensaje</p>";
        $contenido .= "</html>";

        $phpmailer->Body = $contenido;

        // Enviar email
        $phpmailer->send();
    }
}
