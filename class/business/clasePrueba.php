<?php
namespace Business;

class ClasePrueba {

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
    
    public function getClasesPrueba($f_fechaDesde, $f_fechaHasta, $f_nombre, $f_telefono, $f_email, $f_clase, $f_asistio, $f_pago, $f_promo, $f_comoConocio, $f_comoContacto, $f_observaciones) {
        try{
            $list = \Data\ClasePrueba::instance()->getClasesPrueba($f_fechaDesde, $f_fechaHasta, $f_nombre, $f_telefono, $f_email, $f_clase, $f_asistio, $f_pago, $f_promo, $f_comoConocio, $f_comoContacto, $f_observaciones);
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\Clase\getClasesPrueba: ' . $ex->getMessage());
        }
    }
    
    /*public function getClaseByRecibo($idRecibo){
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
    }*/
    
    public function setClasePrueba($idClasePrueba, $fecha, $nombre, $telefono, $email, $idClase, $asistio, $pago, $promo, $idComoConocio, $idComoContacto, $observaciones, $cancelada) {
        try{
            $list = \Data\ClasePrueba::instance()->setClasePrueba($idClasePrueba, $fecha, $nombre, $telefono, $email, $idClase, $asistio, $pago, $promo, $idComoConocio, $idComoContacto, $observaciones, $cancelada);
            return $list;
        } catch(Exception $ex) {
            throw new Exception('Business\Clase\setClasePrueba: ' . $ex->getMessage());
        }
    }
    
}