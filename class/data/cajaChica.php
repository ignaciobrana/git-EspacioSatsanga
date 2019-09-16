<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class CajaChica {
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
    
    public function getCajaChicaActual(){
        try{
            $cajaChica = null;
            $empleado = null;
            
            $sql = 'call getCajaChicaActual()';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            if ($query->rowCount() > 0) {
                $cajaChica = new \Model\CajaChica();
                $cajaChica->set_IdCajaChica($data[0]['idCajaChica']);
                $cajaChica->set_Apertura($data[0]['apertura']);
                $cajaChica->set_Cierre($data[0]['cierre']);
                $cajaChica->set_ValorInicial($data[0]['valorInicial']);
                $cajaChica->set_NombreEmpleado($data[0]['emple_nombreApellido']);

                $empleado = new \Model\Empleado();
                $empleado->set_IdEmpleado($data[0]['idEmpleado']);
                $empleado->set_NombreApellido($data[0]['emple_nombreApellido']);
                $cajaChica->set_Empleado($empleado);
            }
            return $cajaChica;
        } catch(Exception $ex) {
            throw new Exception('Data\CajaChica\getCajaChicaActual: ' . $ex->getMessage());
        }
    }
    
    public function setCajaChica($idCajaChica, $apertura, $cierre, $idEmpleado, $valorInicial) {
        try {
            $sql = self::getInsertUpdateQuery($idCajaChica, $apertura, $cierre, $idEmpleado, $valorInicial);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\CajaChica\setCajaChica: ' . $ex->getMessage());
        }
    }

    public function getCajaChica_All($f_nombreEmpleado, $f_aperturaDesde, $f_aperturaHasta, $f_cierreDesde, $f_cierreHasta, $f_valorInicial) {
        try{
            $arr_cajaChica = array();
            $cajaChica = null;
            $empleado = null;
            
            $sql = self::getSelectQuery($f_nombreEmpleado, $f_aperturaDesde, $f_aperturaHasta, $f_cierreDesde, $f_cierreHasta, $f_valorInicial);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++) {
                $cajaChica = new \Model\CajaChica();
                $cajaChica->set_IdCajaChica($data[$i]['idCajaChica']);
                $cajaChica->set_Apertura($data[$i]['apertura']);
                $cajaChica->set_Cierre($data[$i]['cierre']);
                $cajaChica->set_ValorInicial($data[$i]['valorInicial']);
                $cajaChica->set_ValorFinal($data[$i]['valorFinal']);
                $cajaChica->set_NombreEmpleado($data[$i]['emple_nombreApellido']);

                $empleado = new \Model\Empleado();
                $empleado->set_IdEmpleado($data[$i]['idEmpleado']);
                $empleado->set_NombreApellido($data[$i]['emple_nombreApellido']);
                $cajaChica->set_Empleado($empleado);
                $arr_cajaChica[] = $cajaChica;
            }
            return $arr_cajaChica;
            return $sql;
        } catch(Exception $ex) {
            throw new Exception('Data\CajaChica\getCajaChicaActual: ' . $ex->getMessage());
        }
    }

    private function getSelectQuery($f_nombreEmpleado, $f_aperturaDesde, $f_aperturaHasta, $f_cierreDesde, $f_cierreHasta, $f_valorInicial) {
        $sql = 'call getCajaChicaByFilter(\'' . $f_nombreEmpleado . '\', ' . 
                ($f_aperturaDesde != null ? '\'' . $f_aperturaDesde . '\'' : 'null') . ', ' . 
                ($f_aperturaHasta != null ? '\'' . $f_aperturaHasta . '\'' : 'null') . ', ' . 
                ($f_cierreDesde != null ? '\'' . $f_cierreDesde . '\'' : 'null') . ', ' . 
                ($f_cierreHasta != null ? '\'' . $f_cierreHasta . '\'' : 'null') . ', ' . 
                ($f_valorInicial == '' ? 'null' : $f_valorInicial) . ')';
        return $sql;
    }
        
    private function getInsertUpdateQuery($idCajaChica, $apertura, $cierre, $idEmpleado, $valorInicial) {
        $queryInsertUpdate = 'call setCajaChica(' . $idCajaChica . ', \'' . $apertura . '\', ' . 
            ($cierre != '' ? '\'' . $cierre . '\'' : 'null') . 
            ', ' . $idEmpleado . ', ' . $valorInicial . ');';
        return $queryInsertUpdate;
    }
    
}
