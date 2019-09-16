<?php
namespace Model;

class TipoMovimientoCC {
    public $_idTipoMovimientoCC;
    public $_nombre;

    public function __construct(){
        $this->_idTipoMovimientoCC = 0;
        $this->_nombre = '';
    }

    public function get_IdTipoMovimientoCC(){
        return $this->_idTipoMovimientoCC;
    }

    public function get_Nombre(){
        return $this->_nombre;
    }

    public function set_IdTipoMovimientoCC($idTipoMovimientoCC){
        $this->_idTipoMovimientoCC = $idTipoMovimientoCC;
    }

    public function set_Nombre($nombre){
        $this->_nombre = $nombre;
    }

}