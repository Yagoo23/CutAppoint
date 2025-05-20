<?php

namespace Controllers;

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
        // Almacena la Cita y el Servicio


        echo json_encode(['resultado' => $resultado]);
    }
}