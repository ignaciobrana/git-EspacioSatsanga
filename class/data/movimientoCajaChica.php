<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class MovimientoCajaChica {
    private static $_instance;
    
    public static function instance(){
        if (!isset(self::$_instance)){
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        return self::$_instance;
    }
    
    public function __clone() {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
    
    public function getMovimientosCCByIdCajaChica($f_idCajaChica, $f_descripcion, $f_idTipoMovimientoCC) {
        try{
            $arr_movimientosCC = array();
            $movimientoCajaChica = null;
            $recibo = null;
            $adelanto = null;
            $empleadoAdelanto = null;
            $tipoMovimientoCC = null;
            
            $sql = self::getSelectQuery($f_idCajaChica, $f_descripcion, $f_idTipoMovimientoCC);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $movimientoCajaChica = new \Model\MovimientoCajaChica();
                $movimientoCajaChica->set_IdMovimientoCajaChica($data[$i]['idMovimientoCajaChica']);
                $movimientoCajaChica->set_Descripcion($data[$i]['descripcion']);
                $movimientoCajaChica->set_Valor($data[$i]['valor']);
                
                $recibo = new \Model\Recibo();
                $recibo->set_IdRecibo($data[$i]['idRecibo']);
                $recibo->set_NumeroRecibo($data[$i]['numeroRecibo']);
                $recibo->set_Valor($data[$i]['valorRecibo']);
                $movimientoCajaChica->set_Recibo($recibo);

                $adelanto = new \Model\Adelanto();
                $adelanto->set_IdAdelanto($data[$i]['idAdelanto']);
                $empleadoAdelanto = new \Model\Empleado();
                $empleadoAdelanto->set_IdEmpleado($data[$i]['empleAdelanto_idEmpleado']);
                $empleadoAdelanto->set_NombreApellido($data[$i]['empleAdelanto_NombreApellido']);
                $adelanto->set_Empleado($empleadoAdelanto);
                $movimientoCajaChica->set_Adelanto($adelanto);

                $tipoMovimientoCC = new \Model\TipoMovimientoCC();
                $tipoMovimientoCC->set_IdTipoMovimientoCC($data[$i]['idTipoMovimientoCC']);
                $tipoMovimientoCC->set_Nombre($data[$i]['tmcc_nombre']);
                $movimientoCajaChica->set_TipoMovimientoCC($tipoMovimientoCC);
                                
                $arr_movimientosCC[] = $movimientoCajaChica;
            }
            return $arr_movimientosCC;
        } catch(Exception $ex) {
            throw new Exception('Data\MovimientoCajaChica\getMovimientosCCByIdCajaChica: ' . $ex->getMessage());
        }
    }
    
    public function setMovimientoCajaChica($idMovimientoCajaChica, $idCajaChica, $idTipoMoviminetoCC, $idRecibo, $descripcion, $valor, $idAdelanto, $idEmpleadoAdelanto) {
        try {
            $sql = self::getInsertUpdateQuery($idMovimientoCajaChica, $idCajaChica, $idTipoMoviminetoCC, $idRecibo, $descripcion, $valor, $idAdelanto, $idEmpleadoAdelanto);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\MovimientoCajaChica\setMovimientoCajaChica: ' . $ex->getMessage());
        }
    }

    public function deleteMovimientoCajaChica($idMovimientoCajaChica) {
        try{
            $sql = 'call deleteMovimientoCajaChica(' . $idMovimientoCajaChica . ')';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch(Exception $ex) {
            throw new Exception('Data\deleteMovimientoCajaChica: ' . $ex->getMessage());
        }
    }
    
    private function getInsertUpdateQuery($idMovimientoCajaChica, $idCajaChica, $idTipoMoviminetoCC, $idRecibo, $descripcion, $valor, $idAdelanto, $idEmpleadoAdelanto) {
        $queryInsertUpdate = 'call setMovimientoCajaChica(' . $idMovimientoCajaChica . ', ' . $idCajaChica . ', ' . $idTipoMoviminetoCC . ', ' . $idRecibo . ', \'' . $descripcion . '\', ' . $valor . ', ' . 
        $idAdelanto . ', ' . $idEmpleadoAdelanto . ');';
        return $queryInsertUpdate;
    }

    private function getSelectQuery($f_idCajaChica, $f_descripcion, $f_idTipoMovimientoCC) {
        $sql = 'call getMovimientosCCByIdCajaChica(' .
                $f_idCajaChica . ', \'' . $f_descripcion . '\', ' . $f_idTipoMovimientoCC . ')';
        return $sql;
    }
    
}
