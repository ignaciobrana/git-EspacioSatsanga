<?php
namespace Business;

class CajaGrande {
    
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
    
    public function getCajaGrande_All($f_idTipoEgresoFijo, $f_fechaDesde, $f_fechaHasta, $f_observacion) {
        try{
            $arrCajaGrande = \Data\CajaGrande::instance()->getCajaGrande_All($f_idTipoEgresoFijo, $f_fechaDesde, $f_fechaHasta, $f_observacion);
            return $arrCajaGrande;
        } catch(Exception $ex) {
            throw new Exception('Business\CajaGrande: ' . $ex->getMessage());
        }
    }
    
    public function setCajaGrande($idCajaGrande, $idTipoEgresoFijo, $fecha, $observacion, $valor, $idMovimientoCajaChica, $idAdelanto, $idEmpleadoAdelanto) {
        try{
            $returnValue = \Data\CajaGrande::instance()->setCajaGrande($idCajaGrande, $idTipoEgresoFijo, $fecha, $observacion, $valor, $idMovimientoCajaChica, $idAdelanto, $idEmpleadoAdelanto);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\CajaGrande: ' . $ex->getMessage());
        }
    }
    
}