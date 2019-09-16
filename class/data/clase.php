<?php
namespace Data;

class Clase {
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
    
    public function getClaseByEstado($idEstadoClase){
        try{
            $returnValue = array();
            $clase = null;
            
            $sql = 'call getClaseByEstado(' . $idEstadoClase . ');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $clase = self::setObjectData($data[$i]);
                $returnValue[$i] = $clase;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\Clase\getClaseByEstado: ' . $ex->getMessage());
        }
    }
    
    public function getClaseByRecibo($idRecibo){
        try{
            $returnValue = array();
            $clase = null;
            
            $sql = 'call getClaseByRecibo(' . $idRecibo . ');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $clase = self::setObjectData($data[$i]);
                $returnValue[$i] = $clase;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\Clase\getClaseByRecibo: ' . $ex->getMessage());
        }
    }
    
    public function getClases($f_emple_nombreApellido, $f_idEstadoClase, $f_idDia, $f_descripcion) {
        try{
            $returnValue = array();
            $clase = null;
            
            $sql = self::getSelectQuery($f_emple_nombreApellido, $f_idEstadoClase, $f_idDia, $f_descripcion);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
             
            for ($i = 0; $i < $rowCount; $i++) {
                $clase = self::setObjectData($data[$i]);
                $returnValue[$i] = $clase;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\Clase\getClases: ' . $ex->getMessage());
        }
    }
    
    public function setClase($idClase, $idEmpleado, $idEstadoClase, $idDia, $horaInicio, $horaFin, $descripcion) {
        try {
            $sql = self::getInsertUpdateQuery($idClase, $idEmpleado, $idEstadoClase, $idDia, $horaInicio, $horaFin, $descripcion);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\Clase\setClase: ' . $ex->getMessage());
        }
    }
    
    private function getSelectQuery($f_emple_nombreApellido, $f_idEstadoClase, $f_idDia, $f_descripcion) {
        $sql = 'call getClasesByFilter(\'' .
                $f_emple_nombreApellido . '\', ' . $f_idEstadoClase . ', ' .
                $f_idDia . ', \'' . $f_descripcion . '\')';
        return $sql;
    }
    
    private function getInsertUpdateQuery($idClase, $idEmpleado, $idEstadoClase, $idDia, $horaInicio, $horaFin, $descripcion) {
        $queryInsertUpdate = 'call setClase(' . $idClase . ', ' . $idEmpleado . ', ' . $idEstadoClase . ', ' .
                $idDia . ', \'' . $horaInicio . ':00' . '\', \'' . $horaFin . ':00' . '\', \'' . $descripcion . '\');';
        return $queryInsertUpdate;
    }
    
    private function setObjectData($data){
        $clase = new \Model\Clase();
        $clase->set_IdClase($data['idClase']);
        $clase->set_HoraInicio($data['horaInicio']);
        $clase->set_HoraFin($data['horaFin']);
        $clase->set_Descripcion($data['descripcion']);
        $clase->set_Duracion($data['duracion']);
        $clase->set_NombreEmpleado($data['nombreApellido']);

        $empleado = new \Model\Empleado();
        $empleado->set_IdEmpleado($data['idEmpleado']);
        $empleado->set_NombreApellido($data['nombreApellido']);
        $clase->set_Empleado($empleado);

        $estadoClase = new \Model\EstadoClase();
        $estadoClase->set_IdEstadoClase($data['idEstadoClase']);
        $estadoClase->set_Nombre($data['nombreEstado']);
        $clase->set_EstadoClase($estadoClase);

        $dia = new \Model\Dia();
        $dia->set_IdDia($data['idDia']);
        $dia->set_Nombre($data['nombreDia']);
        $clase->set_Dia($dia);
        
        return $clase;
    }
}