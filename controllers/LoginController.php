<?php

namespace Controllers;

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
        $router->render('auth/olvide-password',[
            
        ]);
    }

    // Recuperar contraseña
    public static function recuperar()
    {
        echo "Recuperar password";
    }

    // Crear cuenta
    public static function crear(Router $router)
    {
        $router->render('auth/crear-cuenta', [

        ]);
    }
}
