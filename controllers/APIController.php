<?php

namespace Controllers;

use Model\CitaServicio;
use Model\Servicio;
use Model\Cita;

class APIController{
    public static function index(){
       $servicios = Servicio::all();
       echo json_encode($servicios);
    }
       public static function guardar() {
        
        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena la Cita y el Servicio

        // Almacena los Servicios with el ID de la Cita
        $idServicios = explode(",", $_POST['servicios']);
        $idServicios = array_map('trim', $idServicios);

        foreach($idServicios as $idServicio) {
            $idServicio = trim($idServicio); // Limpia espacios
            if ($idServicio !== '') { // Evita insertar servicios vacíos
                $args = [
                    'cita_Id' => trim($id), // Por si acaso $id tiene espacios
                    'servicio_Id' => $idServicio
                ];
                $citaServicio = new CitaServicio($args);
                $citaServicio->guardar();
            }
        }

        echo json_encode(['resultado' => $resultado]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}