<?php
namespace Model;

class ClasePrueba {
    public $_idClasePrueba;
    public $_fecha;
    public $_nombre;
    public $_telefono;
    public $_email;
    public $_clase;
    public $_asistio;
    public $_pago;
    public $_promo;
    public $_comoConocio;
    public $_comoContacto;
    public $_observaciones;
    public $_cancelada;

    public function __construct(){
        $this->_idClasePrueba = 0;
        $this->_fecha = '';
        $this->_nombre = '';
        $this->_telefono = '';
        $this->_email = '';
        $this->_clase = new \Model\Clase();
        $this->_asistio = 0;
        $this->_pago = 0;
        $this->_promo = 0;
        $this->_comoConocio = new \Model\ComoConocio();
        $this->_comoContacto = new \Model\ComoContacto();
        $this->_observaciones = '';
        $this->_cancelada = false;
    }

    public function get_IdClasePrueba(){
        return $this->_idClasePrueba;
    }

    public function get_Fecha(){
        return $this->_fecha;
    }

    public function get_Nombre(){
        return $this->_nombre;
    }

    public function get_Telefono(){
        return $this->_telefono;
    }

    public function get_Email(){
        return $this->_email;
    }

    public function get_Clase(){
        return $this->_clase;
    }

    public function get_Asistio(){
        return $this->_asistio;
    }
    
    public function get_Pago(){
        return $this->_pago;
    }
    
    public function get_Promo(){
        return $this->_promo;
    }

    public function get_ComoConocio(){
        return $this->_comoConocio;
    }

    public function get_ComoContacto(){
        return $this->_comoContacto;
    }

    public function get_Observaciones(){
        return $this->_observaciones;
    }

    public function get_Cancelada(){
        return $this->_cancelada;
    }

    public function set_IdClasePrueba($idClasePrueba){
        $this->_idClasePrueba = $idClasePrueba;
    }

    public function set_Fecha($fecha){
        $this->_fecha = $fecha;
    }

    public function set_Nombre($nombre){
        $this->_nombre = $nombre;
    }

    public function set_Telefono($telefono){
        $this->_telefono = $telefono;
    }

    public function set_HoraFin($horaFin){
        $this->_horaFin = $horaFin;
    }

    public function set_Email($email){
        $this->_email = $email;
    }
    
    public function set_Clase($clase){
        $this->_clase = $clase;
    }
    
    public function set_Asistio($asistio){
        $this->_asistio = $asistio;
    }
    
    public function set_Pago($pago){
        $this->_pago = $pago;
    }

    public function set_Promo($promo){
        $this->_promo = $promo;
    }

    public function set_ComoConocio($comoConocio){
        $this->_comoConocio = $comoConocio;
    }

    public function set_ComoContacto($comoContacto){
        $this->_comoContacto = $comoContacto;
    }

    public function set_Observaciones($observaciones){
        $this->_observaciones = $observaciones;
    }

    public function set_Cancelada($cancelada){
        $this->_cancelada = $cancelada;
    }
}
