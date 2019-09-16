<?php
namespace Business;

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
            $list = \Data\Clase::instance()->getClaseByEstado($idEstadoClase);
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\Clase\getClaseByEstado: ' . $ex->getMessage());
        }
    }
    
    public function getClaseByRecibo($idRecibo){
        try{
            $list = \Data\Clase::instance()->getClaseByRecibo($idRecibo);
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\Clase\getClaseByRecibo: ' . $ex->getMessage());
        }
    }
    
    public function getClases($f_emple_nombreApellido, $f_idEstadoClase, $f_idDia, $f_descripcion) {
        try{
            $list = \Data\Clase::instance()->getClases($f_emple_nombreApellido, $f_idEstadoClase, $f_idDia, $f_descripcion);
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\Clase\getClases: ' . $ex->getMessage());
        }
    }
    
    public function setClase($idClase, $idEmpleado, $idEstadoClase, $idDia, $horaInicio, $horaFin, $descripcion) {
        try{
            $list = \Data\Clase::instance()->setClase($idClase, $idEmpleado, $idEstadoClase, $idDia, $horaInicio, $horaFin, $descripcion);
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\Clase\setClase: ' . $ex->getMessage());
        }
    }
    
}