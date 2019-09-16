<?php
namespace Model;

class TipoEgresoFijo {
    public $_idTipoEgresoFijo;
    public $_nombre;

    public function __construct(){
        $this->_idTipoEgresoFijo = 0;
        $this->_nombre = '';
    }

    public function get_IdTipoEgresoFijo(){
        return $this->_idTipoEgresoFijo;
    }

    public function get_Nombre(){
        return $this->_nombre;
    }

    public function set_IdTipoEgresoFijo($idTipoEgresoFijo){
        $this->_idTipoEgresoFijo = $idTipoEgresoFijo;
    }

    public function set_Nombre($nombre){
        $this->_nombre = $nombre;
    }

}