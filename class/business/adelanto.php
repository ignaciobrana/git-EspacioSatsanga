<?php
namespace Business;

class Adelanto {
    
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
    
    public function getAdelantos($mes, $año, $idEmpleado) {
        try{
            $adelantos = \Data\Adelanto::instance()->getAdelantos($mes, $año, $idEmpleado);
            return $adelantos;
        } catch(Exception $ex) {
            throw new Exception('Business\Adelanto: ' . $ex->getMessage());
        }
    }
    
    /*public function setEmpleado($idEmpleado, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEmpleado, $idTipoEmpleado, $email, $celular, $telefono, $fechaAlta) {
        try{
            $returnValue = \Data\Empleado::instance()->setEmpleado($idEmpleado, $nombreApellido, $fechaNacimiento, 
                    $idGenero, $idEstadoEmpleado, $idTipoEmpleado, $email, $celular, $telefono, $fechaAlta);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\Empleado: ' . $ex->getMessage());
        }
    }*/
    
}