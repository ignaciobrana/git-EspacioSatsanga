<?php
namespace Model;

class CajaGrande {
    public $_idCajaGrande;
    public $_tipoEgresoFijo;
    public $_valor;
    public $_observacion;
    public $_movimientoCajaChica; //Cuando se trata de un ingreso a la CajaGrande,
                                  //tendrá asociado el movimiento de CajaChica
                                  //y tipoEgresoFijo será null.
                                  //Sí es un egreso, el movimientoCajaChica será null
    public $_fecha;
    public $_adelanto;

    public function __construct(){
        $this->_idCajaGrande = 0;
        $this->_tipoEgresoFijo = null;
        $this->_valor = 0;
        $this->_observacion = '';
        $this->_movimientoCajaChica = null;
        $this->_fecha = '';
        $this->_adelanto = null;
    }

    public function get_IdCajaGrande(){
        return $this->_idCajaGrande;
    }

    public function get_TipoEgresoFijo(){
        return $this->_tipoEgresoFijo;
    }
    
    public function get_Valor(){
        return $this->_valor;
    }

    public function get_Observacion(){
        return $this->_observacion;
    }
    
    public function get_MovimientoCajaChica(){
        return $this->_movimientoCajaChica;
    }

    public function get_Fecha(){
        return $this->_fecha;
    }

    public function get_Adelanto(){
        return $this->_adelanto;
    }
    
    public function set_IdCajaGrande($idCajaGrande){
        $this->_idCajaGrande = $idCajaGrande;
    }

    public function set_TipoEgresoFijo($tipoEgresoFijo){
        $this->_tipoEgresoFijo = $tipoEgresoFijo;
    }

    public function set_Valor($valor){
        $this->_valor = $valor;
    }

    public function set_Observacion($observacion){
        $this->_observacion = $observacion;
    }

    public function set_MovimientoCajaChica($movimientoCajaChica){
        $this->_movimientoCajaChica = $movimientoCajaChica;
    }

    public function set_Fecha($fecha){
        $this->_fecha = $fecha;
    }

    public function set_Adelanto($adelanto){
        $this->_adelanto = $adelanto;
    }
    
}