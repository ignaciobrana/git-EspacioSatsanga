<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class Empresa {
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
    
    public function getEmpresas($f_razonSocial, $f_contacto, $f_telefono, $f_domicilio, $f_cuit, $f_idGestor) {
        try{
            $arr_empresas = array();
            $empresa = null;
            $gestor = null;
            
            $sql = self::getSelectQuery($f_razonSocial, $f_contacto, $f_telefono, $f_domicilio, $f_cuit, $f_idGestor);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $empresa = new \Model\Empresa();
                $empresa->set_IdEmpresa($data[$i]['idEmpresa']);
                $empresa->set_RazonSocial($data[$i]['razonSocial']);
                $empresa->set_Domicilio($data[$i]['domicilio']);
                $empresa->set_Localidad($data[$i]['localidad']);
                $empresa->set_Telefono($data[$i]['telefono']);
                $empresa->set_Email($data[$i]['email']);
                $empresa->set_Cuit($data[$i]['cuit']);
                $empresa->set_Contacto($data[$i]['contacto']);
                $empresa->set_Observaciones($data[$i]['observaciones']);
                
                $gestor = new \Model\Empleado();
                $gestor->set_IdEmpleado($data[$i]['idGestor']);
                $gestor->set_NombreApellido($data[$i]['gestor_nombre']);
                $empresa->set_Gestor($gestor);
                
                $arr_empresas[] = $empresa;
            }
            return $arr_empresas;
        } catch(Exception $ex) {
            throw new Exception('Data\Empresa\getEmpresas: ' . $ex->getMessage());
        }
    }
        
    public function setEmpresa($idEmpresa, $razonSocial, $domicilio, $localidad, $telefono, $email, $cuit, $contacto, $observaciones, $idGestor) {
        try {
            $sql = self::getInsertUpdateQuery($idEmpresa, $razonSocial, $domicilio, $localidad, $telefono, $email, $cuit, $contacto, $observaciones, $idGestor);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $returnValue = $query->rowCount(); //retorna 1 si sale todo bien
            return $returnValue;
        } catch (Exception $ex) {
            throw new Exception('Data\Empresa\setEmpresa: ' . $ex->getMessage());
        }
    }
    
    private function getSelectQuery($f_razonSocial, $f_contacto, $f_telefono, $f_domicilio, $f_cuit, $f_idGestor) {
        $sql = 'call getEmpresasByFilter(' .
                '\'' . $f_razonSocial . '\', \'' . $f_contacto . '\', \'' . $f_telefono . '\', ' .
                '\'' . $f_domicilio . '\', \'' . $f_cuit . '\', ' . $f_idGestor . ');';
        return $sql;
    }
    
    private function getInsertUpdateQuery($idEmpresa, $razonSocial, $domicilio, $localidad, $telefono, $email, $cuit, $contacto, $observaciones, $idGestor) {
        $_idGestor = $idGestor == '' ? 'null' : $idGestor;
        $queryInsertUpdate = 'call setEmpresa(' . $idEmpresa . ', \'' . $razonSocial . '\', ' .
                '\'' . $domicilio . '\', \'' . $localidad . '\', \'' . $telefono . '\', ' .
                '\'' . $email . '\', \'' . $cuit . '\', \'' . $contacto . '\', ' .
                '\'' . $observaciones . '\', ' . $_idGestor . ');';
        return $queryInsertUpdate;
    }
    
}
