<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class CajaGrande {
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
    
    public function getCajaGrande_All($f_idTipoEgresoFijo, $f_fechaDesde, $f_fechaHasta, $f_observacion) {
        try{
            $arr_CajaGrande = array();
            $cajaGrande = null;
            $tipoEgresoFijo = null;
            $movimientoCajaChica = null;
            $adelanto = null;
            $empleado = null;
            
            $sql = self::getSelectQuery($f_idTipoEgresoFijo, $f_fechaDesde, $f_fechaHasta, $f_observacion);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $cajaGrande = new \Model\CajaGrande();
                $cajaGrande->set_IdCajaGrande($data[$i]['idCajaGrande']);
                $cajaGrande->set_Fecha($data[$i]['fecha']);
                $cajaGrande->set_Observacion($data[$i]['observacion']);
                $cajaGrande->set_Valor($data[$i]['valor']);
                
                if ($data[$i]['idTipoEgresoFijo'] != null) {
                    $tipoEgresoFijo = new \Model\TipoEgresoFijo();
                    $tipoEgresoFijo->set_IdTipoEgresoFijo($data[$i]['idTipoEgresoFijo']);
                    //$tipoEgresoFijo->set_Nombre($data[$i]['nombre']);
                    $cajaGrande->set_TipoEgresoFijo($tipoEgresoFijo);
                }
                
                if ($data[$i]['idMovimientoCajaChica'] != null) {
                    $movimientoCajaChica = new \Model\MovimientoCajaChica();
                    $movimientoCajaChica->set_IdMovimientoCajaChica($data[$i]['idMovimientoCajaChica']);
                    $cajaGrande->set_MovimientoCajaChica($movimientoCajaChica);
                }

                $adelanto = new \Model\Adelanto();
                $adelanto->set_IdAdelanto($data[$i]['idAdelanto']);
                $empleado = new \Model\Empleado();
                $empleado->set_idEmpleado($data[$i]['idEmpleado']);
                $adelanto->set_Empleado($empleado);
                $cajaGrande->set_Adelanto($adelanto);
                
                $arr_CajaGrande[] = $cajaGrande;
            }
            return $arr_CajaGrande;
        } catch(Exception $ex) {
            throw new Exception('Data\CajaGrande\getCajaGrande_All: ' . $ex->getMessage());
        }
    }
    
    public function setCajaGrande($idCajaGrande, $idTipoEgresoFijo, $fecha, $observacion, $valor, $idMovimientoCajaChica, $idAdelanto, $idEmpleadoAdelanto) {
        try {
            $sql = self::getInsertUpdateQuery($idCajaGrande, $idTipoEgresoFijo, $fecha, $observacion, $valor, $idMovimientoCajaChica, $idAdelanto, $idEmpleadoAdelanto);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\CajaGrande\setCajaGrande: ' . $ex->getMessage());
        }
    }
    
    private function getInsertUpdateQuery($idCajaGrande, $idTipoEgresoFijo, $fecha, $observacion, $valor, $idMovimientoCajaChica, $idAdelanto, $idEmpleadoAdelanto) {
        list($f_día, $f_mes, $f_año) = explode('/', $fecha);
        $queryInsertUpdate = 'call setCajaGrande(' . $idCajaGrande . ', ' . 
                ($idTipoEgresoFijo != '0' ? $idTipoEgresoFijo : 'null') . ', ' .
                ($idMovimientoCajaChica != '0' ? $idMovimientoCajaChica : 'null') . ', \'' . 
                ($f_año . '-' . $f_mes . '-' . $f_día) . '\', \'' . $observacion . '\', ' .
                $valor . ', ' . ($idAdelanto != '' ? $idAdelanto : 'null') . ', ' . $idEmpleadoAdelanto . ');';
        return $queryInsertUpdate;
    }

    private function getSelectQuery($f_idTipoEgresoFijo, $f_fechaDesde, $f_fechaHasta, $f_observacion) {
        $sql = 'call getCajaGrandeByFilter(' .
                $f_idTipoEgresoFijo . ', ' . 
                ($f_fechaDesde != null ? '\'' . $f_fechaDesde . '\'' : 'null') . ', ' . 
                ($f_fechaHasta != null ? '\'' . $f_fechaHasta . '\'' : 'null') . ', \'' . $f_observacion . '\')';
        return $sql;
    }
    
}
