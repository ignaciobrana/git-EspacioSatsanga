<?php
namespace Model;

class Clase {
    public $_idClase;
    public $_empleado;
    public $_dia;
    public $_horaInicio;
    public $_horaFin;
    public $_descripcion;
    public $_estadoClase;
    public $_duracion;
    public $_nombreEmpleado;

    public function __construct(){
        $this->_idClase = 0;
        $this->_empleado = new \Model\Empleado();
        $this->_dia = new \Model\Dia();
        $this->_horaInicio = '';
        $this->_horaFin = '';
        $this->_descripcion = '';
        $this->_estadoClase = new \Model\EstadoClase();
        $this->_nombreEmpleado = '';
    }

    public function get_IdClase(){
        return $this->_idClase;
    }

    public function get_Empleado(){
        return $this->_empleado;
    }

    public function get_Dia(){
        return $this->_dia;
    }

    public function get_HoraInicio(){
        return $this->_horaInicio;
    }

    public function get_HoraFin(){
        return $this->_horaFin;
    }

    public function get_Descripcion(){
        return $this->_descripcion;
    }

    public function get_EstadoClase(){
        return $this->_estadoClase;
    }
    
    public function get_Duracion(){
        return $this->_duracion;
    }
    
    public function get_NombreEmpleado(){
        return $this->_nombreEmpleado;
    }

    public function set_IdClase($idClase){
        $this->_idClase = $idClase;
    }

    public function set_Empleado($empleado){
        $this->_empleado = $empleado;
    }

    public function set_Dia($dia){
        $this->_dia = $dia;
    }

    public function set_HoraInicio($horaInicio){
        $this->_horaInicio = $horaInicio;
    }

    public function set_HoraFin($horaFin){
        $this->_horaFin = $horaFin;
    }

    public function set_Descripcion($descripcion){
        $this->_descripcion = $descripcion;
    }
    
    public function set_EstadoClase($estadoClase){
        $this->_estadoClase = $estadoClase;
    }
    
    public function set_Duracion($duracion){
        $this->_duracion = $duracion;
    }
    
    public function set_NombreEmpleado($nombreEmpleado){
        $this->_nombreEmpleado = $nombreEmpleado;
    }
}
