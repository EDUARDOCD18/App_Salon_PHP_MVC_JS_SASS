<?php

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {

        if (!$_SESSION['nombre']) {
            session_start(); /* INICIA LA SESIÓN */
            isAuth(); /* VERIFICA QUE LA SESIÓN ESTÉ INICIADA */
        }

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}
