<?php
namespace Model;

class CajaChica {
    public $_idCajaChica;
    public $_apertura;
    public $_cierre;
    public $_empleado;
    public $_valorInicial;
    public $_valorFinal;
    public $_movimientosCaja;

    public function __construct(){
        $this->_idCajaChica = 0;
        $this->_apertura = '';
        $this->_cierre = '';
        $this->_empleado = new \Model\Empleado();
        $this->_valorInicial = 0;
        $this->_valorFinal = 0;
        $this->_movimientosCaja = array();
        $this->_nombreEmpleado = '';
    }

    public function get_IdCajaChica(){
        return $this->_idCajaChica;
    }

    public function get_Apertura(){
        return $this->_apertura;
    }
    
    public function get_Cierre(){
        return $this->_cierre;
    }

    public function get_Empleado(){
        return $this->_empleado;
    }
    
    public function get_ValorInicial(){
        return $this->_valorInicial;
    }

    public function get_ValorFinal(){
        return $this->_valorFinal;
    }

    public function get_MovimientosCaja(){
        return $this->_movimientosCaja;
    }

    public function get_NombreEmpleado(){
        return $this->_nombreEmpleado;
    }
    
    public function set_IdCajaChica($idCajaChica){
        $this->_idCajaChica = $idCajaChica;
    }

    public function set_Apertura($apertura){
        $this->_apertura = $apertura;
    }

    public function set_Cierre($cierre){
        $this->_cierre = $cierre;
    }

    public function set_Empleado($empleado){
        $this->_empleado = $empleado;
    }

    public function set_ValorInicial($valorInicial){
        $this->_valorInicial = $valorInicial;
    }

    public function set_ValorFinal($valorFinal){
        $this->_valorFinal = $valorFinal;
    }

    public function set_MovimientosCaja($movimientosCaja){
        $this->_movimientosCaja = $movimientosCaja;
    }
    
    public function add_MovimientosCaja($movimientoCajaChica){
        $this->_movimientosCaja[] = $movimientoCajaChica;
    }

    public function set_NombreEmpleado($nombreEmpleado){
        $this->_nombreEmpleado = $nombreEmpleado;
    }
    
}
