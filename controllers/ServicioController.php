<?php

namespace Controllers;

use MVC\Router;

class ServicioController
{
    // Muestra los servicios
    public static function index(Router $router)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'] ?? null,
        ]);
    }

    // Crear un nuevo servicio
    public static function crear(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para crear un nuevo servicio

        }

        if (!isset($_SESSION)) {
            session_start();
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? null,
        ]);
    }

    // Actualizar un servicio existente
    public static function actualizar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para actualizar un servicio existente

        }

        if (!isset($_SESSION)) {
            session_start();
        } 

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'] ?? null,
        ]);
    }

    // Eliminar un servicio
    public static function eliminar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para eliminar un servicio

        }
    }
}
