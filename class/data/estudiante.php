<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class Estudiante {
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
    
    public function getEstudiantes($f_nombreApellido, $f_email, $f_celular, $f_idEstadoEstudiante, $f_fechaAltaDesde, $f_fechaAltaHasta, $f_idComoConocio, $f_fechaBajaDesde, $f_fechaBajaHasta){
        try{
            $arr_estudiantes = array();
            $estudiante = null;
            $estado = null;
            $comoConocio = null;
            $genero = null;
            
            $sql = self::getSelectQuery($f_nombreApellido, $f_email, $f_celular, $f_idEstadoEstudiante, $f_fechaAltaDesde, $f_fechaAltaHasta, $f_idComoConocio, $f_fechaBajaDesde, $f_fechaBajaHasta);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $estudiante = new \Model\Estudiante();
                $estudiante->set_IdEstudiante($data[$i]['idEstudiante']);
                $estudiante->set_NombreApellido($data[$i]['nombreApellido']);
                $estudiante->set_FechaAlta($data[$i]['fechaAlta']);
                $estudiante->set_FechaBaja($data[$i]['fechaBaja']);
                
                $estado = new \Model\EstadoEstudiante();
                $estado->set_IdEstadoEstudiante($data[$i]['idEstadoEstudiante']);
                $estado->set_Nombre($data[$i]['estado']);
                $estudiante->set_EstadoEstudiante($estado);
                
                $estudiante->set_Email($data[$i]['email']);
                $estudiante->set_Observaciones($data[$i]['observaciones']);
                
                $estudiante->set_Celular($data[$i]['celular']);
                $estudiante->set_Telefono($data[$i]['telefono']);
                $estudiante->set_FechaNacimiento($data[$i]['fechaNacimiento']);
                
                $comoConocio = new \Model\ComoConocio();
                $comoConocio->set_IdComoConocio($data[$i]['idComoConocio']);
                $comoConocio->set_Nombre($data[$i]['comoConocio']);
                $estudiante->set_ComoConocio($comoConocio);
                
                $genero = new \Model\Genero();
                $genero->set_IdGenero($data[$i]['idGenero']);
                $genero->set_Nombre($data[$i]['genero']);
                $estudiante->set_Genero($genero);
                
                $arr_estudiantes[] = $estudiante;
            }
            return $arr_estudiantes;
        } catch(Exception $ex) {
            throw new Exception('Data\Estudiante\getEstudiantes: ' . $ex->getMessage());
        }
    }

    public function getEstudiantesByIdClase($idClase, $mes, $año) {
        try{
            $arr_estudiantes = array();
            $estudiante = null;
            $estado = null;
            $comoConocio = null;
            $genero = null;
            
            $sql = 'call getEstudiantesByIdClase(' . $idClase . ', ' . $año . ', ' . $mes . ')';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $estudiante = new \Model\Estudiante();
                $estudiante->set_IdEstudiante($data[$i]['idEstudiante']);
                $estudiante->set_NombreApellido($data[$i]['nombreApellido']);
                $estudiante->set_FechaAlta($data[$i]['fechaAlta']);
                $estudiante->set_FechaBaja($data[$i]['fechaBaja']);
                
                $estado = new \Model\EstadoEstudiante();
                $estado->set_IdEstadoEstudiante($data[$i]['idEstadoEstudiante']);
                $estudiante->set_EstadoEstudiante($estado);
                
                $estudiante->set_Email($data[$i]['email']);
                $estudiante->set_Observaciones($data[$i]['observaciones']);
                
                $estudiante->set_Celular($data[$i]['celular']);
                $estudiante->set_Telefono($data[$i]['telefono']);
                $estudiante->set_FechaNacimiento($data[$i]['fechaNacimiento']);
                
                $comoConocio = new \Model\ComoConocio();
                $comoConocio->set_IdComoConocio($data[$i]['idComoConocio']);
                $estudiante->set_ComoConocio($comoConocio);
                
                $genero = new \Model\Genero();
                $genero->set_IdGenero($data[$i]['idGenero']);
                $estudiante->set_Genero($genero);
                
                $arr_estudiantes[] = $estudiante;
            }
            return $arr_estudiantes;
        } catch(Exception $ex) {
            throw new Exception('Data\Estudiante\getEstudiantesByIdClase: ' . $ex->getMessage());
        }
    }
    
    public function setEstudiante($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEstudiante, $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, $fechaBaja){
        try {
            $sql = self::getInsertUpdateQuery($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEstudiante, $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, $fechaBaja);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $returnValue = $query->rowCount(); //retorna 1 si sale todo bien
            return $returnValue;
        } catch (Exception $ex) {
            throw new Exception('Data\Estudiante\setEstudiantes: ' . $ex->getMessage());
        }
    }
    
    private function getSelectQuery($f_nombreApellido, $f_email, $f_celular, $f_idEstadoEstudiante, $f_fechaAltaDesde, $f_fechaAltaHasta, $f_idComoConocio, $f_fechaBajaDesde, $f_fechaBajaHasta) {
        $sql = 'call getEstudiantesByFilter(\'' .
                $f_nombreApellido . '\', \'' . $f_email . '\', ' . 
                '\'' . $f_celular . '\', ' . $f_idEstadoEstudiante . ', ' . 
                ($f_fechaAltaDesde != null ? '\'' . $f_fechaAltaDesde . '\'' : 'null') . ', ' . 
                ($f_fechaAltaHasta != null ? '\'' . $f_fechaAltaHasta . '\'' : 'null') . ', ' .
                $f_idComoConocio . ', ' . 
                ($f_fechaBajaDesde != null ? '\'' . $f_fechaBajaDesde . '\'' : 'null') . ', ' . 
                ($f_fechaBajaHasta != null ? '\'' . $f_fechaBajaHasta . '\'' : 'null') . ')';
        return $sql;
    }
    
    private function getInsertUpdateQuery($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEstudiante, $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, $fechaBaja) {
        list($fnac_día, $fnac_mes, $fnac_año) = explode('/', $fechaNacimiento);
        list($falta_día, $falta_mes, $falta_año) = explode('/', $fechaAlta);
        $fbaja_día = '';
        $fbaja_mes = '';
        $fbaja_año = '';
        if ($fechaBaja != '')
            list($fbaja_día, $fbaja_mes, $fbaja_año) = explode('/', $fechaBaja);
        
        $paramFechaBaja = $fechaBaja != '' ? ('\'' . $fbaja_año . '-' . $fbaja_mes . '-' . $fbaja_día . '\'') : 'null';
        
        $queryInsertUpdate = 'call setEstudiante(' . $idEstudiante . ', \'' . $nombreApellido . '\', ' .
                '\'' . ($fnac_año . '-' . $fnac_mes . '-' . $fnac_día) . '\', ' .
                $idGenero . ', ' . $idEstadoEstudiante . ', ' . $idComoConocio . ', \'' . $email . '\', ' . 
                '\'' . $observaciones . '\', \'' . $celular . '\', \'' . $telefono . '\', ' . 
                '\'' . ($falta_año . '-' . $falta_mes . '-' . $falta_día) . '\', ' . $paramFechaBaja .');';
        return $queryInsertUpdate;
    }
    
}
