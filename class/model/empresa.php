<?php
namespace Model;

class Empresa {
    public $_idEmpresa;
    public $_razonSocial;
    public $_domicilio;
    public $_localidad;
    public $_telefono;
    public $_email;
    public $_cuit;
    public $_observaciones;
    public $_contacto;
    public $_gestor;
    
    public function __construct(){
        $this->_idEmpresa = 0;
        $this->_razonSocial = '';
        $this->_domicilio = '';
        $this->_localidad = '';
        $this->_telefono = '';
        $this->_email = '';
        $this->_cuit = '';
        $this->_observaciones = '';
        $this->_contacto = '';
        $this->_gestor = new \Model\Empleado();
    }
    
    public function get_IdEmpresa(){
        return $this->_idEmpresa;
    }

    public function get_RazonSocial(){
        return $this->_razonSocial;
    }

    public function get_Domicilio(){
        return $this->_domicilio;
    }

    public function get_Localidad(){
        return $this->_localidad;
    }

    public function get_Telefono(){
        return $this->_telefono;
    }

    public function get_Email(){
        return $this->_email;
    }

    public function get_Cuit(){
        return $this->_cuit;
    }
    
    public function get_Observaciones(){
        return $this->_observaciones;
    }
    
    public function get_Contacto(){
        return $this->_contacto;
    }
    
    public function get_Gestor(){
        return $this->_gestor;
    }

    public function set_IdEmpresa($idEmpresa){
        $this->_idEmpresa = $idEmpresa;
    }

    public function set_RazonSocial($razonSocial){
        $this->_razonSocial = $razonSocial;
    }

    public function set_Domicilio($domicilio){
        $this->_domicilio = $domicilio;
    }

    public function set_Localidad($localidad){
        $this->_localidad = $localidad;
    }

    public function set_Telefono($telefono){
        $this->_telefono = $telefono;
    }

    public function set_Email($email){
        $this->_email = $email;
    }

    public function set_Cuit($cuit){
        $this->_cuit = $cuit;
    }
    
    public function set_Observaciones($observaciones){
        $this->_observaciones = $observaciones;
    }

    public function set_Contacto($contacto){
        $this->_contacto = $contacto;
    }
    
    public function set_Gestor($gestor){
        $this->_gestor = $gestor;
    }
    
}