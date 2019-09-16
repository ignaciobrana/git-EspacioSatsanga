<?php
namespace Model;

class EstadoEmpleado {
    public $_idEstadoEmpleado;
    public $_nombre;
    public $_descripcion;

    public function __construct(){
        $this->_idEstadoEmpleado = 0;
        $this->_nombre = '';
        $this->_descripcion = '';
    }

    public function get_IdEstadoEmpleado(){
        return $this->_idEstadoEmpleado;
    }

    public function get_Nombre(){
        return $this->_nombre;
    }

    public function get_Descripcion(){
        return $this->_descripcion;
    }

    public function set_IdEstadoEmpleado($idEstadoEmpleado){
        $this->_idEstadoEmpleado = $idEstadoEmpleado;
    }

    public function set_Nombre($nombre){
        $this->_nombre = $nombre;
    }

    public function set_Descripcion($descripcion){
        $this->_descripcion = $descripcion;
    }
}
