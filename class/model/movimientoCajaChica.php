<?php
namespace Model;

class MovimientoCajaChica {
    public $_idMovimientoCajaChica;
    public $_descripcion;
    public $_valor;
    public $_tipoMovimientoCC;
    public $_recibo;
    public $_adelanto;

    public function __construct(){
        $this->_idMovimientoCajaChica = 0;
        $this->_descripcion = '';
        $this->_valor = 0;
        $this->_tipoMovimientoCC = new \Model\TipoMovimientoCC();
        $this->_recibo = null;
        $this->_adelanto = null;
    }

    public function get_IdMovimientoCajaChica(){
        return $this->_idMovimientoCajaChica;
    }

    public function get_Descripcion(){
        return $this->_descripcion;
    }
    
    public function get_Valor(){
        return $this->_valor;
    }

    public function get_TipoMovimientoCC(){
        return $this->_tipoMovimientoCC;
    }
    
    public function get_Recibo(){
        return $this->_recibo;
    }
    
    public function get_Adelanto(){
        return $this->_adelanto;
    }

    public function set_IdMovimientoCajaChica($idMovimientoCajaChica){
        $this->_idMovimientoCajaChica = $idMovimientoCajaChica;
    }

    public function set_Descripcion($descripcion){
        $this->_descripcion = $descripcion;
    }

    public function set_Valor($valor){
        $this->_valor = $valor;
    }

    public function set_TipoMovimientoCC($tipoMovimientoCC){
        $this->_tipoMovimientoCC = $tipoMovimientoCC;
    }

    public function set_Recibo($recibo){
        $this->_recibo = $recibo;
    }

    public function set_Adelanto($adelanto){
        $this->_adelanto = $adelanto;
    }
}
