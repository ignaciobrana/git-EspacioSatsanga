<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class TipoEgresoFijo {
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
    
    public function getTipoEgresoFijo_All() {
        try {
            $arr_tipoEgresoFijo = array();
            $tipoEgresoFijo = null;
            
            $sql = 'call getTipoEgresoFijo_All()';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $tipoEgresoFijo = new \Model\TipoEgresoFijo();
                $tipoEgresoFijo->set_idTipoEgresoFijo($data[$i]['idTipoEgresoFijo']);
                $tipoEgresoFijo->set_Nombre($data[$i]['nombre']);
                                
                $arr_tipoEgresoFijo[] = $tipoEgresoFijo;
            }
            return $arr_tipoEgresoFijo;
        } catch(Exception $ex) {
            throw new Exception('Data\TipoEgresoFijo\getTipoEgresoFijo_All: ' . $ex->getMessage());
        }
    }
    
    /*public function setEmpleado($idEmpleado, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEmpleado, $idTipoEmpleado, $email, $celular, $telefono, $fechaAlta){
        try {
            $sql = self::getInsertUpdateQuery($idEmpleado, $nombreApellido, $fechaNacimiento, 
                    $idGenero, $idEstadoEmpleado, $idTipoEmpleado, $email, $celular, $telefono, $fechaAlta);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\Empleado\setEmpleado: ' . $ex->getMessage());
        }
    }
    
    private function getSelectQuery($f_nombreApellido, $f_email, $f_idTipoEmpleado, $f_idEstadoEmpleado, $f_fechaAltaDesde, $f_fechaAltaHasta) {
        $sql = 'call getEmpleadosByFilter(\'' .
                $f_nombreApellido . '\', \'' . $f_email . '\', ' .
                $f_idTipoEmpleado . ', ' . $f_idEstadoEmpleado . ', ' . 
                ($f_fechaAltaDesde != null ? '\'' . $f_fechaAltaDesde . '\'' : 'null') . ', ' . 
                ($f_fechaAltaHasta != null ? '\'' . $f_fechaAltaHasta . '\'' : 'null') . ')';
        return $sql;
    }
    
    private function getInsertUpdateQuery($idEmpleado, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEmpleado, $idTipoEmpleado, $email, $celular, $telefono, $fechaAlta) {
        list($fnac_día, $fnac_mes, $fnac_año) = explode('/', $fechaNacimiento);
        list($falta_día, $falta_mes, $falta_año) = explode('/', $fechaAlta);
        $queryInsertUpdate = 'call setEmpleado(' . $idEmpleado . ', \'' . $nombreApellido . '\', ' .
                '\'' . ($fnac_año . '-' . $fnac_mes . '-' . $fnac_día) . '\', ' .
                $idGenero . ', ' . $idEstadoEmpleado . ', ' . $idTipoEmpleado . ', \'' . $email . '\', ' . 
                '\'' . $celular . '\', \'' . $telefono . '\', ' . 
                '\'' . ($falta_año . '-' . $falta_mes . '-' . $falta_día) . '\');';
        return $queryInsertUpdate;
    }*/
    
}
