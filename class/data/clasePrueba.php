<?php
namespace Data;

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
            $returnValue = array();
            $clasePrueba = null;
            
            $sql = self::getSelectQuery($f_fechaDesde, $f_fechaHasta, $f_nombre, $f_telefono, $f_email, $f_clase, $f_asistio, $f_pago, $f_promo, $f_comoConocio, $f_comoContacto, $f_observaciones);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                $clasePrueba = self::setObjectData($data[$i]);
                $returnValue[$i] = $clasePrueba;
            }
            return $returnValue;
        } catch(Exception $ex) {
            throw new Exception('Data\Clase\getClasesPrueba: ' . $ex->getMessage());
        }
    }
    
    /*public function getClaseByRecibo($idRecibo){
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
    }*/
    
    public function setClasePrueba($idClasePrueba, $fecha, $nombre, $telefono, $email, $idClase, $asistio, $pago, $promo, $idComoConocio, $idComoContacto, $observaciones, $cancelada) {
        try {
            $sql = self::getInsertUpdateQuery($idClasePrueba, $fecha, $nombre, $telefono, $email, $idClase, $asistio, $pago, $promo, $idComoConocio, $idComoContacto, $observaciones, $cancelada);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\Clase\setClasePrueba: ' . $ex->getMessage());
        }
    }
    
    private function getSelectQuery($f_fechaDesde, $f_fechaHasta, $f_nombre, $f_telefono, $f_email, $f_clase, $f_asistio, $f_pago, $f_promo, $f_comoConocio, $f_comoContacto, $f_observaciones) {
        $sql = 'call getClasesPruebaByFilter(' .
                ($f_fechaDesde != null ? '\'' . $f_fechaDesde . '\'' : 'null') . ', ' .
                ($f_fechaHasta != null ? '\'' . $f_fechaHasta . '\'' : 'null') . ', \'' .
                $f_nombre . '\', \'' . $f_telefono . '\', \'' . $f_email . '\', ' . $f_clase . ', ' .
                $f_asistio . ', ' . $f_pago . ', ' . $f_promo . ', ' . $f_comoConocio . ', ' . $f_comoContacto . 
                ', \'' . $f_observaciones . '\')';
        return $sql;
    }
    
    private function getInsertUpdateQuery($idClasePrueba, $fecha, $nombre, $telefono, $email, $idClase, $asistio, $pago, $promo, $idComoConocio, $idComoContacto, $observaciones, $cancelada) {
        list($f_día, $f_mes, $f_año) = explode('/', $fecha);
        $queryInsertUpdate = 'call setClasePrueba(' . $idClasePrueba . ', \'' . 
                ($f_año . '-' . $f_mes . '-' . $f_día) . '\', \'' . $nombre . '\', \'' .
                $telefono . '\', \'' . $email . '\', ' . $idClase . ', ' . 
                ($asistio == null ? 'null' : $asistio) . ', ' . 
                ($pago == null ? 'null' : $pago) . ', ' . 
                ($promo == null ? 'null' : $promo) . ', ' . 
                ($idComoConocio == null ? 'null' : $idComoConocio) . ', ' . 
                ($idComoContacto == null ? 'null' : $idComoContacto) . ', \'' .
                $observaciones . '\', ' . ($cancelada == "true" ? 1 : 0) . ');';
        return $queryInsertUpdate;
    }
    
    private function setObjectData($data){
        $clasePrueba = new \Model\ClasePrueba();
        $clasePrueba->set_IdClasePrueba($data['idClasePrueba']);
        $clasePrueba->set_Fecha($data['fecha']);
        $clasePrueba->set_Nombre($data['nombre']);
        $clasePrueba->set_Telefono($data['telefono']);
        $clasePrueba->set_Email($data['email']);
        $clasePrueba->set_Asistio($data['asistio']);
        $clasePrueba->set_Pago($data['pago']);
        $clasePrueba->set_Promo($data['promo']);
        $clasePrueba->set_Observaciones($data['observaciones']);
        $clasePrueba->set_Cancelada(($data['cancelada'] == '1'));

        
        $clase = new \Model\Clase();
        $clase->set_IdClase($data['idClase']);
        $clase->set_HoraInicio($data['horaInicio']);

        $dia =  new \Model\Dia();
        $dia->set_IdDia($data['idDia']);
        $dia->set_Nombre($data['dia_nombre']);
        $clase->set_Dia($dia);

        $empleado = new \Model\Empleado();
        $empleado->set_NombreApellido($data['emple_nombre']);
        $empleado->set_Celular($data['emple_celular']);
        $clase->set_Empleado($empleado);
        $clasePrueba->set_Clase($clase);

        $comoConocio = new \Model\ComoConocio();
        $comoConocio->set_IdComoConocio($data['idComoConocio']);
        $clasePrueba->set_ComoConocio($comoConocio);

        $comoContacto = new \Model\ComoContacto();
        $comoContacto->set_IdComoContacto($data['idComoContacto']);
        $clasePrueba->set_ComoContacto($comoContacto);
        
        return $clasePrueba;
    }
}