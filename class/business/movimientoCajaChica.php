<?php
namespace Business;

class MovimientoCajaChica {
    
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
    
    public function getMovimientosCCByIdCajaChica($f_idCajaChica, $f_descripcion, $f_idTipoMovimientoCC) {
        try{
            $movimientosCC = \Data\MovimientoCajaChica::instance()->getMovimientosCCByIdCajaChica($f_idCajaChica, $f_descripcion, $f_idTipoMovimientoCC);
            return $movimientosCC;
        } catch(Exception $ex) {
            throw new Exception('Business\MovimientoCajaChica: ' . $ex->getMessage());
        }
    }
    
    public function setMovimientoCajaChica($idMovimientoCajaChica, $idCajaChica, $idTipoMoviminetoCC, $idRecibo, $descripcion, $valor, $idAdelanto, $idEmpleadoAdelanto) {
        try{
            $returnValue = \Data\MovimientoCajaChica::instance()->setMovimientoCajaChica($idMovimientoCajaChica, $idCajaChica, $idTipoMoviminetoCC, $idRecibo, $descripcion, $valor, $idAdelanto, $idEmpleadoAdelanto);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\MovimientoCajaChica: ' . $ex->getMessage());
        }
    }

    public function deleteMovimientoCajaChica($idMovimientoCajaChica) {
        try{
            $returnValue = \Data\MovimientoCajaChica::instance()->deleteMovimientoCajaChica($idMovimientoCajaChica);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\deleteMovimientoCajaChica: ' . $ex->getMessage());
        }
    }
    
}