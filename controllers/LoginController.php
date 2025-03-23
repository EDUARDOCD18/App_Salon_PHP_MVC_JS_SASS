<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController
{
    // Inicias sesión
    public static function login(Router $router)
    {
        $router->render('auth/login');
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
                    // No está registrado
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
}
