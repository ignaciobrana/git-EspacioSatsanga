<?php
namespace Business;

class CajaChica {
    
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
    public static function instance() {
        if (!isset(self::$_instance)) {
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        return self::$_instance;
    }
    
    /**
     * [__clone Evita que el objeto se pueda clonar]
     * @return [type] [message]
     */
    public function __clone() {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
    
    public function getCajaChicaActual() {
        try {
            $cajaChica = \Data\CajaChica::instance()->getCajaChicaActual();
            return $cajaChica;
        } catch(Exception $ex) {
            throw new Exception('Business\CajaChica: ' . $ex->getMessage());
        }
    }
    
    public function setCajaChica($idCajaChica, $apertura, $cierre, $idEmpleado, $valorInicial) {
        try {
            $returnValue = \Data\CajaChica::instance()->setCajaChica($idCajaChica, $apertura, $cierre, $idEmpleado, $valorInicial);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\CajaChica: ' . $ex->getMessage());
        }
    }

    public function getCajaChica_All($f_nombreEmpleado, $f_aperturaDesde, $f_aperturaHasta, $f_cierreDesde, $f_cierreHasta, $f_valorInicial) {
        try {
            $arr_cajaChica = \Data\CajaChica::instance()->getCajaChica_All($f_nombreEmpleado, $f_aperturaDesde, $f_aperturaHasta, $f_cierreDesde, $f_cierreHasta, $f_valorInicial);
            return $arr_cajaChica;
        } catch(Exception $ex) {
            throw new Exception('Business\CajaChica: ' . $ex->getMessage());
        }
    }
    
}