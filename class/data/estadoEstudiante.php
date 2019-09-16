<?php
namespace Data;

class EstadoEstudiante {
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
    
    public function getEstadoEstudiante_All(){
        try{
            $returnValue = array();
            $estadoEstudiante = null;
            $sql = 'call getEstadoEstudiante_All();';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $estadoEstudiante = new \Model\EstadoEstudiante();
                $estadoEstudiante->set_IdEstadoEstudiante($data[$i]['idEstadoEstudiante']);
                $estadoEstudiante->set_Nombre($data[$i]['Nombre']);
                $estadoEstudiante->set_Descripcion($data[$i]['Descripcion']);
                $returnValue[$i] = $estadoEstudiante;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\EstadoEstudiante\getEstadoEstudiante_All: ' . $ex->getMessage());
        }
    }
}