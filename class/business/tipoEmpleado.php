<?php
namespace Business;

class TipoEmpleado {

    private static $_instance;
    
    public static function instance(){
        if (!isset(self::$_instance)){
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        return self::$_instance;
    }

    public function __clone(){
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
    
    public function getTipoEmpleado_All(){
        try{
            $list = \Data\TipoEmpleado::instance()->getTipoEmpleado_All();
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\TipoEmpleado: ' . $ex->getMessage());
        }
    }
    
}