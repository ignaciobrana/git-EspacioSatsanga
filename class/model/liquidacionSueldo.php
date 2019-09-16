<?php
namespace Model;

class LiquidacionSueldo {
    public $_idLiquidacionSueldo;
    public $_empleado;
    public $_mes;
    public $_año;
    public $_valor;
    public $_observaciones;
    public $_nombreEmpleado; //utlizamos esta variable para poder usar en la grilla y realizar los filtrados

    public function __construct(){
        $this->_idLiquidacionSueldo = 0;
        $this->_empleado = new \Model\Empleado();
        $this->_mes = 0;
        $this->_año = 0;
        $this->_valor = 0;
        $this->_observaciones = null;
    }

    public function get_IdLiquidacionSueldo(){
        return $this->_idLiquidacionSueldo;
    }

    public function get_Empleado(){
        return $this->_empleado;
    }

    public function get_Mes(){
        return $this->_mes;
    }

    public function get_Año(){
        return $this->_año;
    }

    public function get_Valor(){
        return $this->_valor;
    }

    public function get_Observaciones(){
        return $this->_observaciones;
    }
    
    public function get_NombreEmpleado(){
        return $this->_nombreEmpleado;
    }

    public function set_IdLiquidacionSueldo($idLiquidacionSueldo){
        $this->_idLiquidacionSueldo = $idLiquidacionSueldo;
    }

    public function set_Empleado($empleado){
        $this->_empleado = $empleado;
    }

    public function set_Mes($mes){
        $this->_mes = $mes;
    }

    public function set_Año($año){
        $this->_año = $año;
    }

    public function set_Valor($valor){
        $this->_valor = $valor;
    }

    public function set_Observaciones($observaciones){
        $this->_observaciones = $observaciones;
    }
    
    public function set_nombreEmpleado($nombreEmpleado){
        $this->_nombreEmpleado = $nombreEmpleado;
    }
}
