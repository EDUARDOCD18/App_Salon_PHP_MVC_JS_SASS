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

    /* Enviar la confirmación de la creación de la cuenta */
    public function enviarConfirmacion()
    {
        // Crear el objeto de email
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASS'];
        $phpmailer->setFrom('cuentas@appsalon.com');
        $phpmailer->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $phpmailer->Subject = 'Crea tu cuenta';

        // SET html
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola, " . $this->nombre . "</strong>. Has creado tu cuenta en nuestro portal web. Confirma la misma dando click en el siguiente botón.</p>";
        $contenido .= "<p>Da click aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, ignora este mensaje</p>";
        $contenido .= "</html>";

        $phpmailer->Body = $contenido;

        // Enviar email
        $phpmailer->send();
    }

    /*  Enviar las instrucciones para el reseteo de la contraseña */
    public function enviarInstrucciones()
    {
        // Crear el objeto de email
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASS'];
        $phpmailer->setFrom('cuentas@appsalon.com');
        $phpmailer->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $phpmailer->Subject = 'Reestablece tu clave';

        // SET html
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola, " . $this->nombre . "</strong>. Has solicitado restablecer tu contraseña, da click en el enlace para hacerlo.</p>";
        $contenido .= "<p>Da click aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Restablecer clave de acceso</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, ignora este mensaje</p>";
        $contenido .= "</html>";

        $phpmailer->Body = $contenido;

        // Enviar email
        $phpmailer->send();
    }
}
