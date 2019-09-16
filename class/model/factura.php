<?php
namespace Model;

class Factura {
    public $_idFactura;
    public $_cliente;
    public $_numeroFactura;
    public $_estudiante;
    public $_empresa;
    public $_fecha;
    public $_domicilio;
    public $_localidad;
    public $_telefono;
    public $_respNoInscripto;
    public $_respInscripto;
    public $_exento;
    public $_noResponsable;
    public $_consumidorFinal;
    public $_respMonotributista;
    public $_contado;
    public $_cuentaCorriente;
    public $_cuit;
    public $_numeroRemito;
    public $_detalle;
    public $_total;
    
    public function __construct(){
        $this->_idFactura = 0;
        $this->_cliente = '';
        $this->_numeroFactura = 0;
        $this->_estudiante = new \Model\Estudiante();
        $this->_empresa = new \Model\Empresa();
        $this->_fecha = '';
        $this->_domicilio = '';
        $this->_localidad = '';
        $this->_telefono = '';
        $this->_respNoInscripto = 0;
        $this->_respInscripto = 0;
        $this->_exento = 0;
        $this->_noResponsable = 0;
        $this->_consumidorFinal = 0;
        $this->_respMonotributista = 0;
        $this->_contado = 0;
        $this->_cuentaCorriente = 0;
        $this->_cuit = '';
        $this->_numeroRemito = 0;
        $this->_detalle = '';
        $this->_total = 0;
    }
    
    public function get_IdFactura(){
        return $this->_idFactura;
    }

    public function get_Cliente(){
        return $this->_cliente;
    }
    
    public function get_NumeroFactura(){
        return $this->_numeroFactura;
    }

    public function get_Estudiante(){
        return $this->_estudiante;
    }

    public function get_Empresa(){
        return $this->_empresa;
    }

    public function get_Fecha(){
        return $this->_fecha;
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

    public function get_RespNoInscripto(){
        return $this->_respNoInscripto;
    }
    
    public function get_RespInscripto(){
        return $this->_respInscripto;
    }
    
    public function get_Exento(){
        return $this->_exento;
    }
    
    public function get_NoResponsable(){
        return $this->_noResponsable;
    }
    
    public function get_ConsumidorFinal(){
        return $this->_consumidorFinal;
    }
    
    public function get_RespMonotributista(){
        return $this->_respMonotributista;
    }
    
    public function get_Contado(){
        return $this->_contado;
    }
    
    public function get_CuentaCorriente(){
        return $this->_cuentaCorriente;
    }
    
    public function get_Cuit(){
        return $this->_cuit;
    }
    
    public function get_NumeroRemito(){
        return $this->_numeroRemito;
    }
    
    public function get_Detalle(){
        return $this->_detalle;
    }
    
    public function get_Total(){
        return $this->_total;
    }

    public function set_IdFactura($idFactura){
        $this->_idFactura = $idFactura;
    }
    
    public function set_Cliente($cliente){
        $this->_cliente = $cliente;
    }

    public function set_NumeroFactura($numeroFactura){
        $this->_numeroFactura = $numeroFactura;
    }

    public function set_Estudiante($estudiante){
        $this->_estudiante = $estudiante;
    }

    public function set_Empresa($empresa){
        $this->_empresa = $empresa;
    }

    public function set_Fecha($fecha){
        $this->_fecha = $fecha;
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

    public function set_RespNoInscripto($respNoInscripto){
        $this->_respNoInscripto = $respNoInscripto;
    }
    
    public function set_RespInscripto($respInscripto){
        $this->_respInscripto = $respInscripto;
    }
    
    public function set_Exento($exento){
        $this->_exento = $exento;
    }
    
    public function set_NoResponsable($noResponsable){
        $this->_noResponsable = $noResponsable;
    }
    
    public function set_ConsumidorFinal($consumidorFinal){
        $this->_consumidorFinal = $consumidorFinal;
    }
    
    public function set_RespMonotributista($respMonotributista){
        $this->_respMonotributista = $respMonotributista;
    }
    
    public function set_Contado($contado){
        $this->_contado = $contado;
    }
    
    public function set_CuentaCorriente($cuentaCorriente){
        $this->_cuentaCorriente = $cuentaCorriente;
    }
    
    public function set_Cuit($cuit){
        $this->_cuit = $cuit;
    }
    
    public function set_NumeroRemito($numeroRemito){
        $this->_numeroRemito = $numeroRemito;
    }
    
    public function set_Detalle($detalle){
        $this->_detalle = $detalle;
    }
    
    public function set_Total($total){
        $this->_total = $total;
    }
}