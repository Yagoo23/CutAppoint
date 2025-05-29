<?php

namespace Controllers;

use MVC\Router;

class CitaController {
    public static function index(Router $router) {
        session_start();

       
        // Verifica que el usuario esté autenticado
        isAuth();
        
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'],
        ]);
    }
}