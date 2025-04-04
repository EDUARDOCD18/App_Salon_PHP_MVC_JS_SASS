<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    // Iniciar sesión
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

                if($usuario){
                    // Verificar que la clave sea la correcta
                    $usuario->comprobarPasswordAndVerificado($auth->password);

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

    // Cerrar sesión
    public static function logout()
    {
        echo "Desde logout";
    }

    // Olvidar contraseña
    public static function olvide(Router $router)
    {
        $router->render('auth/olvide-password', []);
    }

    // Recuperar contraseña
    public static function recuperar()
    {
        echo "Recuperar password";
    }

    // Crear cuenta
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
