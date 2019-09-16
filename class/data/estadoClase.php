<?php
namespace Data;

class EstadoClase {
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
    
    public function getEstadoClase_All(){
        try{
            $returnValue = array();
            $estadoClase = null;
            $sql = 'call getEstadoClase_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $estadoClase = new \Model\EstadoClase();
                $estadoClase->set_IdEstadoClase($data[$i]['idEstadoClase']);
                $estadoClase->set_Nombre($data[$i]['nombre']);
                $returnValue[$i] = $estadoClase;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\EstadoClase\getEstadoClase_All: ' . $ex->getMessage());
        }
    }
}