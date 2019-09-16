<?php
namespace Business;

class Factura {
    
    /**
    * @desc instancia de la base de datos
    * @var $_instance
    * @access private
    */
    private static $_instance;
    
    /**
     * [instance singleton]
     * @return [object] [class database]
     */
    public static function instance(){
        if (!isset(self::$_instance)){
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        return self::$_instance;
    }
    
    /**
     * [__clone Evita que el objeto se pueda clonar]
     * @return [type] [message]
     */
    public function __clone(){
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
    
    public function getFacturas($f_numeroFactura, $f_cliente, $f_total, $f_fechaDesde, $f_fechaHasta){
        try{
            $facturas = \Data\Factura::instance()->getFacturas($f_numeroFactura, $f_cliente, $f_total, $f_fechaDesde, $f_fechaHasta);
            return $facturas;
        } catch(Exception $ex) {
            throw new Exception('Business\Factura: ' . $ex->getMessage());
        }
    }
    
    public function setFactura($idFactura, $numeroFactura, $idEstudiante, $idEmpresa, $fecha, $cliente, $domicilio, $localidad, 
            $telefono, $respNoInscripto, $respInscripto, $exento, $noResponsable, $consumidorFinal, $respMonotributista,
            $contado, $cuentaCorriente, $cuit, $numeroRemito, $detalle, $total){
        try{
            $returnValue = \Data\Factura::instance()->setFactura($idFactura, $numeroFactura, $idEstudiante, $idEmpresa, $fecha, $cliente, $domicilio, $localidad, 
                            $telefono, $respNoInscripto, $respInscripto, $exento, $noResponsable, $consumidorFinal, $respMonotributista,
                            $contado, $cuentaCorriente, $cuit, $numeroRemito, $detalle, $total);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\Factura: ' . $ex->getMessage());
        }
    }
    
}