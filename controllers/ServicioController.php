<?php

namespace Controllers;

use Model\Servicio; // Importa el modelo Servicio
use MVC\Router; // Importa la clase Router

class ServicioController
{
    // Muestra los servicios
    public static function index(Router $router)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $servicios = Servicio::all(); // Obtiene todos los servicios de la base de datos

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'] ?? null,
            'servicios' => $servicios
        ]);
    }

    // Crear un nuevo servicio
    public static function crear(Router $router)
    {
        // Verifica si la sesión está iniciada
        if (!isset($_SESSION)) {
            session_start();
        }

        $servicio = new Servicio; // Instancia del modelo Servicio
        $alertas = []; // Inicializa un array para almacenar alertas
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST); // Sincroniza los datos del formulario con el modelo
            $alertas = $servicio->validar(); // Valida los datos del servicio

            if(empty($aletas)){
                $servicio->guardar(); // Guarda el servicio en la base de datos
                header('Location: /servicios'); // Redirige a la página de servicios
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? null,
            'servicio' => $servicio,
            'alertas' => $alertas
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
