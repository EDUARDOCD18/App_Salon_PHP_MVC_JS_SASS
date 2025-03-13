<?php

namespace Controllers;

class LoginController
{
    // Inicias sesión
    public static function login()
    {
        echo "Desde login";
    }

    // Cerrar sesión
    public static function logout()
    {
        echo "Desde logout";
    }

    // Olvidar contraseña
    public static function olvide()
    {
        echo "Password olvidado";
    }

    // Recuperar contraseña
    public static function recuperar()
    {
        echo "Recuperar password";
    }

    // Crear cuenta
    public static function crear()
    {
        echo "crear cuenta";
    }
}
