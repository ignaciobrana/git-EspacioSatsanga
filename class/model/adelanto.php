<?php
namespace Model;

class Adelanto {
    public $_idAdelanto;
    public $_movimientoCajaChica;
    public $_cajaGrande;
    public $_empleado;
    public $_fecha;

    public function __construct(){
        $this->_idAdelanto = 0;
        $this->_movimientoCajaChica = new \Model\MovimientoCajaChica();
        $this->_cajaGrande = new \Model\CajaGrande();
        $this->_empleado = new \Model\Empleado();
        $this->_fecha = '';
    }

    public function get_IdAdelanto(){
        return $this->_idAdelanto;
    }

    public function get_MovimientoCajaChica(){
        return $this->_movimientoCajaChica;
    }

    public function get_CajaGrande(){
        return $this->_cajaGrande;
    }
    
    public function get_Empleado(){
        return $this->_empleado;
    }

    public function get_Fecha(){
        return $this->_fecha;
    }
    
    public function set_IdAdelanto($idAdelanto){
        $this->_idAdelanto = $idAdelanto;
    }

    public function set_MovimientoCajaChica($movimientoCajaChica){
        $this->_movimientoCajaChica = $movimientoCajaChica;
    }

    public function set_CajaGrande($cajaGrande){
        $this->_cajaGrande = $cajaGrande;
    }

    public function set_Empleado($empleado){
        $this->_empleado = $empleado;
    }

    public function set_Fecha($fecha){
        $this->_fecha = $fecha;
    }

}