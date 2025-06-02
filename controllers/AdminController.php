<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        session_start();

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        // Validar que la fecha sea válida
        $fechas = explode('-', $fecha);
        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            // Si la fecha no es válida, redirigir a la fecha actual
            header('Location: /admin?fecha=' . date('Y-m-d'));
            exit;
        }

        //Consultar la base de datos para obtener las citas
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuario_Id=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citaservicios ";
        $consulta .= " ON citaservicios.cita_Id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citaservicios.servicio_Id ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);
        
        $router->render('admin/index', [
            'nombre'=> $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}