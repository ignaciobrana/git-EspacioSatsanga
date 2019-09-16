<?php
namespace Business;

class Genero {

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
    
    public function getGenero_All(){
        try{
            $list = \Data\Genero::instance()->getGenero_All();
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\Genero: ' . $ex->getMessage());
        }
    }
    
}