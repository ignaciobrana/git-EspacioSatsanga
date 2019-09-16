<?php
namespace Data;

class Dia {
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
    
    public function getDia_All(){
        try{
            $returnValue = array();
            $dia = null;
            $sql = 'call getDia_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $dia = new \Model\Dia();
                $dia->set_IdDia($data[$i]['idDia']);
                $dia->set_Nombre($data[$i]['Nombre']);
                $returnValue[$i] = $dia;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\Dia\getDia_All: ' . $ex->getMessage());
        }
    }
}