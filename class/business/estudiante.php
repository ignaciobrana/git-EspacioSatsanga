<?php
namespace Business;

class Estudiante {
    
    /**
    * @desc instancia de la base de datos
    * @var $_instance
    * @access private
    */
    private static $_instance;
    
    /**
     * [instance singleton]
     * @return [object] [class database]
     */
    public static function instance(){
        if (!isset(self::$_instance)){
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        return self::$_instance;
    }
    
    /**
     * [__clone Evita que el objeto se pueda clonar]
     * @return [type] [message]
     */
    public function __clone(){
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
    
    public function getEstudiantes($f_nombreApellido, $f_email, $f_celular, $f_idEstadoEstudiante, $f_fechaAltaDesde, $f_fechaAltaHasta, $f_idComoConocio, $f_fechaBajaDesde, $f_fechaBajaHasta) {
        try{
            $estudiantes = \Data\Estudiante::instance()->getEstudiantes($f_nombreApellido, $f_email, $f_celular, 
                            $f_idEstadoEstudiante, $f_fechaAltaDesde, $f_fechaAltaHasta, $f_idComoConocio,
                            $f_fechaBajaDesde, $f_fechaBajaHasta);
            return $estudiantes;
        } catch(Exception $ex) {
            throw new Exception('Business\Estudiante: ' . $ex->getMessage());
        }
    }

    public function getEstudiantesByIdClase($idClase, $mes, $año) {
        try{
            $estudiantes = \Data\Estudiante::instance()->getEstudiantesByIdClase($idClase, $mes, $año);
            return $estudiantes;
        } catch(Exception $ex) {
            throw new Exception('Business\Estudiante: ' . $ex->getMessage());
        }
    }
    
    public function setEstudiante($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEstudiante, $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, $fechaBaja) {
        try{
            $returnValue = \Data\Estudiante::instance()->setEstudiante($idEstudiante, $nombreApellido, $fechaNacimiento, 
                            $idGenero, $idEstadoEstudiante, $idComoConocio, $email, $observaciones, $celular, 
                            $telefono, $fechaAlta, $fechaBaja);
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Business\Estudiante: ' . $ex->getMessage());
        }
    }
    
}