<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class TipoMovimientoCC {
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
    
    public function getTipoMovimientoCC_All(){
        try{
            $arr_tipoMovimientoCC = array();
            $tipoMovimientoCC = null;
            
            $sql = 'call getTipoMovimientoCC_All()';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $tipoMovimientoCC = new \Model\TipoMovimientoCC();
                $tipoMovimientoCC->set_IdTipoMovimientoCC($data[$i]['idTipoMovimientoCC']);
                $tipoMovimientoCC->set_Nombre($data[$i]['nombre']);
                
                $arr_tipoMovimientoCC[] = $tipoMovimientoCC;
            }
            return $arr_tipoMovimientoCC;
        } catch(Exception $ex) {
            throw new Exception('Data\TipoMovimientoCC\getTipoMovimientoCC_All: ' . $ex->getMessage());
        }
    }
    
}
