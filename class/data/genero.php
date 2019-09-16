<?php
namespace Data;

class Genero {
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
    
    public function getGenero_All(){
        try{
            $returnValue = array();
            $genero = null;
            $sql = 'call getGenero_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $genero = new \Model\Genero();
                $genero->set_IdGenero($data[$i]['idGenero']);
                $genero->set_Nombre($data[$i]['Nombre']);
                $returnValue[$i] = $genero;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\Genero\getGenero_All: ' . $ex->getMessage());
        }
    }
}