<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class Empleado {
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
    
    public function getEmpleados($f_nombreApellido, $f_email, $f_idTipoEmpleado, $f_idEstadoEmpleado, $f_fechaAltaDesde, $f_fechaAltaHasta){
        try{
            $arr_empleados = array();
            $empleado = null;
            $estado = null;
            $tipo = null;
            $genero = null;
            
            $sql = self::getSelectQuery($f_nombreApellido, $f_email, $f_idTipoEmpleado, $f_idEstadoEmpleado, $f_fechaAltaDesde, $f_fechaAltaHasta);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $empleado = new \Model\Empleado();
                $empleado->set_IdEmpleado($data[$i]['idEmpleado']);
                $empleado->set_NombreApellido($data[$i]['nombreApellido']);
                $empleado->set_FechaAlta($data[$i]['fechaAlta']);
                
                $estado = new \Model\EstadoEmpleado();
                $estado->set_IdEstadoEmpleado($data[$i]['idEstadoEmpleado']);
                $estado->set_Nombre($data[$i]['estado']);
                $empleado->set_EstadoEmpleado($estado);
                
                $empleado->set_Email($data[$i]['email']);
                $empleado->set_Celular($data[$i]['celular']);
                $empleado->set_Telefono($data[$i]['telefono']);
                $empleado->set_FechaNacimiento($data[$i]['fechaNacimiento']);
                
                $tipo = new \Model\TipoEmpleado();
                $tipo->set_IdTipoEmpleado($data[$i]['idTipoEmpleado']);
                $tipo->set_Nombre($data[$i]['tipoEmpleado']);
                $empleado->set_TipoEmpleado($tipo);
                
                $genero = new \Model\Genero();
                $genero->set_IdGenero($data[$i]['idGenero']);
                $genero->set_Nombre($data[$i]['genero']);
                $empleado->set_Genero($genero);
                
                $arr_empleados[] = $empleado;
            }
            return $arr_empleados;
        } catch(Exception $ex) {
            throw new Exception('Data\Empleado\getEmpleados: ' . $ex->getMessage());
        }
    }
    
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
    }
    
}
