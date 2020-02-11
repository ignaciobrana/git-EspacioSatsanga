<?php
namespace Data;

class ComoContacto {
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
    
    public function getComoContacto_All(){
        try{
            $returnValue = array();
            $comoContacto = null;
            $sql = 'call getComoContacto_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $comoContacto = new \Model\ComoContacto();
                $comoContacto->set_IdComoContacto($data[$i]['idComoContacto']);
                $comoContacto->set_Nombre($data[$i]['Nombre']);
                $comoContacto->set_Descripcion($data[$i]['Descripcion']);
                $returnValue[$i] = $comoContacto;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\ComoContacto\getComoContacto_All: ' . $ex->getMessage());
        }
    }
}