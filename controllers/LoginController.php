<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    /* Iniciar sesión */
    public static function login(Router $router)
    {
        $alertas = [];
        $auth = new Usuario; /* Autocompletar el usuario */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth  = new Usuario($_POST);

            // Validar el inicio de sesión
            $alertas = $auth->validarLogin();

            /* En caso de que el usuario haya suministrado email y clave,
            validar que el mismo exista */
            if (empty($alertas)) {
                // Comprobar que el usuario exista
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    // Verificar que la clave sea la correcta
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticar el usuario
                        if (!isset($_SESSION)) {
                            session_start();
                        };

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        /*  Redireccionamiento, validar si es admin o no */
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            // Redirecciona al panel de administracion 
                            header('Location: /admin');
                        } else {
                            // Redirecciona al panel de citas
                            header('Location: /cita');
                        }
                    }
                } else {
                    // Si el usuario no existe
                    Usuario::setAlerta('error', 'LA CUENTA NO EXISTE');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    /* Cerrar sesión */
    public static function logout()
    {
        echo "Desde logout";
    }

    /* Contraseña olvidada */
    public static function olvide(Router $router)
    {
        $alertas = [];

        // Validar que el método sea POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            // En caso de que el correo haya sido validado
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                // Confirmar que la cuenta exista y esté confirmada
                if ($usuario && $usuario->confirmado === "1") {
                    // Generar nuevo token para recuperar la clave
                    $usuario->crearToken(); /* Crea el token */
                    $usuario->guardar(); /* Actualiza los datos en la BDD */

                    // Enviar el email con el nuevo token
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de éxito
                    Usuario::setAlerta('exito', 'SE HA ENVIADO A TU CORREO LOS PASOS PARA RECUPERAR LA CONTRASEÑA.');
                } else {
                    Usuario::setAlerta('error', 'LA CUENTA NO EXISTE O NO ESTÁ CONFIRMADA');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    /* Recuperar contraseña */
    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        // Buscar la cuenta por el token en la BDD
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'TOKEN NO VÁLIDO');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer la nueva clave y guardarla

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            // Una vez se valide que el campo no está vacío y que posee los 8 caracteres
            if (empty($alertas)) {
                $usuario->password = null; /* Resetea el campo */
                $usuario->password = $password->password; /* Asigna la nueva clave */
                $usuario->hashPassword(); /* Hashea la clave */
                $usuario->token = null; /* Resetea el token */

                $resultado = $usuario->guardar(); /* Guarda en la BDD */

                if($resultado){
                    header('Location: /');
                }

                debuguear($usuario);
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    /* Crear cuenta */
    public static function crear(Router $router)
    {
        $usuario = new Usuario;

        // Alertas vacías
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alerta esté vacío
            if (empty($alertas)) {
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Generar Toeken único
                    $usuario->crearToken();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }

                    // No está registrado

                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'TOKEN NO VÁLIDO');
        } else {
            // Modificar el usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = "";
            $usuario->guardar();
            Usuario::setAlerta('exito', 'CUENTA VALIDADA CON ÉXITO');
        }

        // Obtener alertas
        $alertas = Usuario::getAlertas();

        // Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
