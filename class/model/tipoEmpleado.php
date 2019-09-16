<?php
namespace Model;

class TipoEmpleado {
    public $_idTipoEmpleado;
    public $_nombre;
    public $_descripcion;

    public function __construct(){
        $this->_idTipoEmpleado = 0;
        $this->_nombre = '';
        $this->_descripcion = '';
    }

    public function get_IdTipoEmpleado(){
        return $this->_idTipoEmpleado;
    }

    public function get_Nombre(){
        return $this->_nombre;
    }

    public function get_Descripcion(){
        return $this->_descripcion;
    }

    public function set_IdTipoEmpleado($idTipoEmpleado){
        $this->_idTipoEmpleado = $idTipoEmpleado;
    }

    public function set_Nombre($nombre){
        $this->_nombre = $nombre;
    }

    public function set_Descripcion($descripcion){
        $this->_descripcion = $descripcion;
    }
}