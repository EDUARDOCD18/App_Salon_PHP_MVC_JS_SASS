<?php

namespace Controllers;

use MVC\Router;

class ServicioController
{
    // Muestra los servicios
    public static function index(Router $router)
    {
       $router->render('servicios/index', [
        
       ]);
    }

    // Crear un nuevo servicio
    public static function crear(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para crear un nuevo servicio

        }
    }

    // Actualizar un servicio existente
    public static function actualizar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para actualizar un servicio existente

        }
    }

    // Eliminar un servicio
    public static function eliminar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para eliminar un servicio

        }
    }
}
