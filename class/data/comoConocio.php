<?php
namespace Data;

class ComoConocio {
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
    
    public function getComoConocio_All(){
        try{
            $returnValue = array();
            $comoConocio = null;
            $sql = 'call getComoConocio_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $comoConocio = new \Model\ComoConocio();
                $comoConocio->set_IdComoConocio($data[$i]['idComoConocio']);
                $comoConocio->set_Nombre($data[$i]['Nombre']);
                $comoConocio->set_Descripcion($data[$i]['Descripcion']);
                $returnValue[$i] = $comoConocio;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\ComoConocio\getComoConocio_All: ' . $ex->getMessage());
        }
    }
}