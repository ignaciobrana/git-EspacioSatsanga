<?php
namespace Model;

class ComprobantePago {
    public $_idEmpleado;
    public $_nombreApellido;
    public $_recibosDeComprobante;
    public $_adelantos;

    public function __construct(){
        $this->_idEmpleado = 0;
        $this->_nombreApellido = '';
        $this->_recibosDeComprobante = array();
        $this->_adelantos = array();
    }

    public function get_IdEmpleado(){
        return $this->_idEmpleado;
    }

    public function get_NombreApellido(){
        return $this->_nombreApellido;
    }
    
    public function set_IdEmpleado($idEmpleado){
        $this->_idEmpleado = $idEmpleado;
    }

    public function set_NombreApellido($nombreApellido){
        $this->_nombreApellido = $nombreApellido;
    }

    public function get_RecibosDeComprobante(){
        return $this->_recibosDeComprobante;
    }
    
    public function set_RecibosDeComprobante($recibosDeComprobante){
        $this->_recibosDeComprobante = $recibosDeComprobante;
    }

    public function get_Adelantos(){
        return $this->_adelantos;
    }
    
    public function set_Adelantos($adelantos){
        $this->_adelantos = $adelantos;
    }
    
}

class ReciboDeComprobante {
    public $_idRecibo;
    public $_numeroRecibo;
    public $_valorRecibo;
    public $_valorProfe;
    public $_reciboCompartido;
    public $_reciboDeEmpresa;

    public function __construct(){
        $this->_idRecibo = 0;
        $this->_numeroRecibo = 0;
        $this->_valorRecibo = 0;
        $this->_valorProfe = 0;
        $this->_reciboCompartido = false;
        $this->_reciboDeEmpresa = false;
    }

    public function get_IdRecibo(){
        return $this->_idRecibo;
    }

    public function get_NumeroRecibo(){
        return $this->_numeroRecibo;
    }

    public function get_ValorRecibo(){
        return $this->_valorRecibo;
    }

    public function get_ValorProfe(){
        return $this->_valorProfe;
    }

    public function get_ReciboCompartido(){
        return $this->_reciboCompartido;
    }
    
    public function get_ReciboDeEmpresa(){
        return $this->_reciboDeEmpresa;
    }

    public function set_IdRecibo($idRecibo){
        $this->_idRecibo = $idRecibo;
    }

    public function set_NumeroRecibo($numeroRecibo){
        $this->_numeroRecibo = $numeroRecibo;
    }

    public function set_ValorRecibo($valorRecibo){
        $this->_valorRecibo = $valorRecibo;
    }

    public function set_ValorProfe($valorProfe){
        $this->_valorProfe = $valorProfe;
    }
    
    public function set_ReciboCompartido($reciboCompartido){
        $this->_reciboCompartido = $reciboCompartido;
    }
    
    public function set_ReciboDeEmpresa($reciboDeEmpresa){
        $this->_reciboDeEmpresa = $reciboDeEmpresa;
    }
}