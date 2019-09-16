<?php
namespace Data;

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
            $returnValue = array();
            $estadoEmpleado = null;
            $sql = 'call getEstadoEmpleado_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $estadoEmpleado = new \Model\EstadoEmpleado();
                $estadoEmpleado->set_IdEstadoEmpleado($data[$i]['idEstadoEmpleado']);
                $estadoEmpleado->set_Nombre($data[$i]['Nombre']);
                $estadoEmpleado->set_Descripcion($data[$i]['Descripcion']);
                $returnValue[$i] = $estadoEmpleado;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\EstadoEmpleado\getEstadoEmpleado_All: ' . $ex->getMessage());
        }
    }
}