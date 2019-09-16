<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class Adelanto {
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
    
    public function getAdelantos($mes, $año, $idEmpleado) {
        try{
            $arr_adelantos = array();
            $adelanto = null;
            $movimientoCajaChica = null;
            
            $sql = 'call getAdelantos(' . $mes . ', ' . $año . ', ' . $idEmpleado . ');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $adelanto = new \Model\Adelanto();
                $adelanto->set_IdAdelanto($data[$i]['idAdelanto']);
                $adelanto->set_Fecha($data[$i]['fecha']);
                
                $movimientoCajaChica = new \Model\MovimientoCajaChica();
                $movimientoCajaChica->set_IdMovimientoCajaChica($data[$i]['idMovimientoCajaChica']);
                $movimientoCajaChica->set_Valor($data[$i]['valor']);
                $adelanto->set_MovimientoCajaChica($movimientoCajaChica);
                
                $arr_adelantos[] = $adelanto;
            }
            return $arr_adelantos;
        } catch(Exception $ex) {
            throw new Exception('Data\Adelanto\getAdelantos: ' . $ex->getMessage());
        }
    }
    
    /*
    public function setEmpleado($idEmpleado, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEmpleado, $idTipoEmpleado, $email, $celular, $telefono, $fechaAlta){
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
