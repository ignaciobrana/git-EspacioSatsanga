<?php
namespace Data;

class TipoEmpleado {
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
    
    public function getTipoEmpleado_All(){
        try{
            $returnValue = array();
            $tipoEmpleado = null;
            $sql = 'call getTipoEmpleado_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $tipoEmpleado = new \Model\TipoEmpleado();
                $tipoEmpleado->set_IdTipoEmpleado($data[$i]['idTipoEmpleado']);
                $tipoEmpleado->set_Nombre($data[$i]['Nombre']);
                $tipoEmpleado->set_Descripcion($data[$i]['Descripcion']);
                $returnValue[$i] = $tipoEmpleado;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\TipoEmpleado\getTipoEmpleado_All: ' . $ex->getMessage());
        }
    }
}