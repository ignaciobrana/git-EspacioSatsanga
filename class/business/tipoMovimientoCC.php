<?php
namespace Business;

class TipoMovimientoCC {
    
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
    
    public function getTipoMovimientoCC_All(){
        try{
            $arr_TipoMovimientoCC = \Data\TipoMovimientoCC::instance()->getTipoMovimientoCC_All();
            return $arr_TipoMovimientoCC;
        } catch(Exception $ex) {
            throw new Exception('Business\TipoMovimientoCC: ' . $ex->getMessage());
        }
    }
    
}