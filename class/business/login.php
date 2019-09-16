<?php
namespace Business;

//defined("APPPATH") OR die("Access denied");

//use Data\Usuario,
//    GlobalClass\Helper;

class Login {
    
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
    
    public function getUser($userName, $password){
        try{
            $hashPassword = \GlobalClass\Helper::getPasswordHash($password);
            $usuario = \Data\Usuario::instance()->getUsuario($userName, $hashPassword);
            return $usuario;
        } catch(Exception $ex) {
            throw new Exception('Business\Usuario: ' . $ex->getMessage());
        }
    }
    
}