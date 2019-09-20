<?php
namespace Model;

class Recibo {
    public $_idRecibo;
    public $_estudiante;
    public $_fecha;
    public $_numeroRecibo;
    public $_valor;
    public $_vecesPorSemana;
    public $_observaciones;
    public $_clases;
    public $_promocion;
    public $_factura;
    public $_nombreEstudiante; //Utilizamos esta varialbe para que se pueda generar el ordenamiento automatico en jsGrid
    public $_proximoMes;
    
    public function __construct(){
        $this->_idRecibo = 0;
        $this->_estudiante = new \Model\Estudiante();
        $this->_fecha = '';
        $this->_numeroRecibo = 0;
        $this->_valor = 0;
        $this->_vecesPorSemana = 0;
        $this->_observaciones = '';
        $this->_clases = array();
        $this->_promocion = '';
        $this->_factura = new \Model\Factura();
        $this->_nombreEstudiante = '';
        $this->_proximoMes = 0;
    }
    
    public function get_IdRecibo(){
        return $this->_idRecibo;
    }

    public function get_Estudiante(){
        return $this->_estudiante;
    }

    public function get_Fecha(){
        return $this->_fecha;
    }

    public function get_NumeroRecibo(){
        return $this->_numeroRecibo;
    }

    public function get_Valor(){
        return $this->_valor;
    }

    public function get_VecesPorSemana(){
        return $this->_vecesPorSemana;
    }

    public function get_Observaciones(){
        return $this->_observaciones;
    }

    public function get_Clases(){
        return $this->_clases;
    }
    
    public function get_Promocion(){
        return $this->_promocion;
    }
    
    public function get_Factura(){
        return $this->_factura;
    }
    
    public function get_nombreEstudiante(){
        return $this->_nombreEstudiante;
    }
    
    public function get_proximoMes(){
        return $this->_proximoMes;
    }

    public function set_IdRecibo($idRecibo){
        $this->_idRecibo = $idRecibo;
    }

    public function set_Estudiante($estudiante){
        $this->_estudiante = $estudiante;
    }

    public function set_Fecha($fecha){
        $this->_fecha = $fecha;
    }

    public function set_NumeroRecibo($numeroRecibo){
        $this->_numeroRecibo = $numeroRecibo;
    }

    public function set_Valor($valor){
        $this->_valor = $valor;
    }

    public function set_VecesPorSemana($vecesPorSemana){
        $this->_vecesPorSemana = $vecesPorSemana;
    }

    public function set_Observaciones($observaciones){
        $this->_observaciones = $observaciones;
    }

    public function set_Clases($clases){
        $this->_clases = $clases;
    }
    
    public function set_Promocion($promocion){
        $this->_promocion = $promocion;
    }
    
    public function set_Factura($factura){
        $this->_factura = $factura;
    }
    
    public function set_nombreEstudiante($nombreEstudiante){
        $this->_nombreEstudiante = $nombreEstudiante;
    }
    
    public function set_proximoMes($proximoMes){
        $this->_proximoMes = $proximoMes;
    }

}