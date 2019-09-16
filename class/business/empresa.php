<?php
namespace Business;

class Empresa {
    
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
    
    public function getEmpresas_All(){
        try{
            $empresas = self::instance()->getEmpresas('', '', '', '', '', 0);
            return $empresas;
        } catch(Exception $ex) {
            throw new Exception('Business\Empresa\getEmpresas_All: ' . $ex->getMessage());
        }
    }
    
    public function getEmpresas($f_razonSocial, $f_contacto, $f_telefono, $f_domicilio, $f_cuit, $f_idGestor){
        try{
            $empresas = \Data\Empresa::instance()->getEmpresas($f_razonSocial, $f_contacto, $f_telefono, $f_domicilio, $f_cuit, $f_idGestor);
            return $empresas;
        } catch(Exception $ex) {
            throw new Exception('Business\Empresa\getEmpresas: ' . $ex->getMessage());
        }
    }
    
    public function setEmpresa($idEmpresa, $razonSocial, $domicilio, $localidad, $telefono, $email, $cuit, $contacto, $observaciones, $idGestor) {
        try{
            $returnValue = \Data\Empresa::instance()->setEmpresa($idEmpresa, $razonSocial, $domicilio, $localidad, $telefono, $email, $cuit, $contacto, $observaciones, $idGestor);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\Empresa\setEmpresa: ' . $ex->getMessage());
        }
    }
    
}