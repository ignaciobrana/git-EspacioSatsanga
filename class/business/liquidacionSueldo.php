<?php
namespace Business;

class LiquidacionSueldo {
    
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
    
    public function getLiquidacionesSueldo($f_mes, $f_año, $f_nombreEmpleado, $f_valor, $f_observaciones) {
        try{
            $liquidaciones = \Data\LiquidacionSueldo::instance()->getLiquidacionesSueldo($f_mes, $f_año, $f_nombreEmpleado, $f_valor, $f_observaciones);
            return $liquidaciones;
        } catch(Exception $ex) {
            throw new Exception('Business\LiquidacionSueldo\getLiquidacionesSueldo: ' . $ex->getMessage());
        }
    }
    
    public function generateLiquidacionSueldo($mes, $ano) {
        try{
            $returnValue = \Data\LiquidacionSueldo::instance()->generateLiquidacionSueldo($mes, $ano);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\LiquidacionSueldo\generateLiquidacionSueldo: ' . $ex->getMessage());
        }
    }
    
    public function setLiquidacionSueldo($idLiquidacionSueldo, $mes, $año, $idEmpleado, $valor, $observaciones) {
        try{
            $returnValue = \Data\LiquidacionSueldo::instance()->setLiquidacionSueldo($idLiquidacionSueldo, $mes, $año, $idEmpleado, $valor, $observaciones);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\LiquidacionSueldo\setLiquidacionSueldo: ' . $ex->getMessage());
        }
    }
    
    public function getComprobantesDePago($mes, $ano) {
        try{
            $returnValue = \Data\LiquidacionSueldo::instance()->getComprobantesDePago($mes, $ano);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\LiquidacionSueldo\getComprobantesDePago: ' . $ex->getMessage());
        }
    }
    
    public function getIdsEmpleadosForComprobanteDePago($mes, $ano) {
        try{
            $returnValue = \Data\LiquidacionSueldo::instance()->getIdsEmpleadosForComprobanteDePago($mes, $ano);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\LiquidacionSueldo\getIdsEmpleadosForComprobanteDePago: ' . $ex->getMessage());
        }
    }
    
    public function getComprobantesDePagoByIdEmpleado($mes, $año, $idEmpleado) {
        try{
            $comprobante = \Data\LiquidacionSueldo::instance()->getComprobantesDePagoByIdEmpleado($mes, $año, $idEmpleado);
            $arrAdelantos = \Business\Adelanto::instance()->getAdelantos($mes, $año, $idEmpleado);
            $comprobante->set_Adelantos($arrAdelantos);
            return $comprobante;
        } catch(Exception $ex) {
            throw new Exception('Business\LiquidacionSueldo\getComprobantesDePagoByIdEmpleado: ' . $ex->getMessage());
        }
    }
    
}