<?php

namespace Model;

class CitaServicio extends ActiveRecord
{
   protected static $tabla = 'citaservicios';
    protected static $columnasDB = ['id', 'cita_Id', 'servicio_Id'];

    public $id;
    public $cita_Id;
    public $servicio_Id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cita_Id = $args['cita_Id'] ?? '';
        $this->servicio_Id = $args['servicio_Id'] ?? '';
    }


}