<?php
namespace Business;

class EstadoEmpleado {

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
    
    public function getEstadoEmpleado_All(){
        try{
            $list = \Data\EstadoEmpleado::instance()->getEstadoEmpleado_All();
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\EstadoEmpleado: ' . $ex->getMessage());
        }
    }
    
}