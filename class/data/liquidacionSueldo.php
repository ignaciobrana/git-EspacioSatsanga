<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class LiquidacionSueldo {
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
    
    public function getLiquidacionesSueldo($f_mes, $f_año, $f_nombreEmpleado, $f_valor, $f_observaciones){
        try{
            $arr_liquidaciones = array();
            $liquidacion = null;
            $empleado = null;
            
            $sql = self::getSelectQuery($f_mes, $f_año, $f_nombreEmpleado, $f_valor, $f_observaciones);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $liquidacion = new \Model\LiquidacionSueldo();
                $liquidacion->set_IdLiquidacionSueldo($data[$i]['idLiquidacionSueldo']);
                $liquidacion->set_Mes($data[$i]['mes']);
                $liquidacion->set_Año($data[$i]['año']);
                $liquidacion->set_Valor($data[$i]['valor']);
                $liquidacion->set_Observaciones($data[$i]['observaciones']);
                $liquidacion->set_nombreEmpleado($data[$i]['emp_nombreApellido']);
                
                $empleado = new \Model\Empleado();
                $empleado->set_IdEmpleado($data[$i]['idEmpleado']);
                $empleado->set_NombreApellido($data[$i]['emp_nombreApellido']);
                $liquidacion->set_Empleado($empleado);
                                
                $arr_liquidaciones[] = $liquidacion;
            }
            return $arr_liquidaciones;
        } catch(Exception $ex) {
            throw new Exception('Data\LiquidacionSueldo\getLiquidacionesSueldo: ' . $ex->getMessage());
        }
    }
    
    public function generateLiquidacionSueldo($mes, $ano){
        try {
            $sql = 'call generateLiquidacionSueldo(' . $mes . ', ' . $ano . ');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\LiquidacionSueldo\generateLiquidacionSueldo: ' . $ex->getMessage());
        }
    }
    
    public function setLiquidacionSueldo($idLiquidacionSueldo, $mes, $año, $idEmpleado, $valor, $observaciones) {
        try {
            $sql = self::getInsertUpdateQuery($idLiquidacionSueldo, $mes, $año, $idEmpleado, $valor, $observaciones);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch (Exception $ex) {
            throw new Exception('Data\LiquidacionSueldo\setLiquidacionSueldo: ' . $ex->getMessage());
        }
    }
    
    public function getComprobantesDePago($mes, $ano){
        try {
            $arr_comprobantes = array();
            $comprobante = null;
            $reciboDeComprobante = null;
            $sql = 'call getComprobantesPago(' . $mes . ', ' . $ano . ');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                //Pregunstamos si es el primer ó si cambió de empleado con el registro anterior
                if($i==0 || $data[$i]['idEmpleado'] != $data[$i-1]['idEmpleado']) {
                    if($i-1>=0)
                        $arr_comprobantes[] = $comprobante;
                    
                    $comprobante = new \Model\ComprobantePago();
                    $comprobante->set_IdEmpleado($data[$i]['idEmpleado']);
                    $comprobante->set_NombreApellido($data[$i]['nombreApellido']);
                }
                
                $reciboDeComprobante = new \Model\ReciboDeComprobante();
                $reciboDeComprobante->set_IdRecibo($data[$i]['idRecibo']);
                $reciboDeComprobante->set_NumeroRecibo($data[$i]['numeroRecibo']);
                $reciboDeComprobante->set_ValorRecibo($data[$i]['valorRecibo']);
                $reciboDeComprobante->set_ValorProfe($data[$i]['valorProfe']);
                $reciboDeComprobante->set_ReciboCompartido($data[$i]['reciboCompartido'] != '0' && $data[$i]['reciboCompartido'] != '1');
                $reciboDeComprobante->set_ReciboDeEmpresa($data[$i]['reciboDeEmpresa'] != '0');

                $comprobante->_recibosDeComprobante[] = $reciboDeComprobante;
                
                //preguntamos si este es el último elemento, si es lo agregamos al array a retornar
                if(($i+1) == $rowCount)
                    $arr_comprobantes[] = $comprobante;
            }
            
            return $arr_comprobantes;
        } catch (Exception $ex) {
            throw new Exception('Data\LiquidacionSueldo\getComprobantesDePago: ' . $ex->getMessage());
        }
    }
    
    public function getIdsEmpleadosForComprobanteDePago($mes, $ano){
        try {
            $sql = 'call getIdsEmpleadosForComprobanteDePago(' . $mes . ', ' . $ano . ');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            return $data;
        } catch (Exception $ex) {
            throw new Exception('Data\LiquidacionSueldo\getIdsEmpleadosForComprobanteDePago: ' . $ex->getMessage());
        }
    }
    
    public function getComprobantesDePagoByIdEmpleado($mes, $año, $idEmpleado){
        try {
            $comprobante = null;
            $reciboDeComprobante = null;
            $sql = 'call getComprobantesDePagoByIdEmpleado(' . $mes . ', ' . $año . ', ' . $idEmpleado . ');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            $rowCount = $query->rowCount();
            
            for ($i = 0; $i < $rowCount; $i++) {
                //Pregunstamos si es el primer ó si cambió de empleado con el registro anterior
                if($i==0) {
                    $comprobante = new \Model\ComprobantePago();
                    $comprobante->set_IdEmpleado($data[$i]['idEmpleado']);
                    $comprobante->set_NombreApellido($data[$i]['nombreApellido']);
                }
                
                $reciboDeComprobante = new \Model\ReciboDeComprobante();
                $reciboDeComprobante->set_IdRecibo($data[$i]['idRecibo']);
                $reciboDeComprobante->set_NumeroRecibo($data[$i]['numeroRecibo']);
                $reciboDeComprobante->set_ValorRecibo($data[$i]['valorRecibo']);
                $reciboDeComprobante->set_ValorProfe($data[$i]['valorProfe']);
                $reciboDeComprobante->set_ReciboCompartido($data[$i]['reciboCompartido'] != '0' && $data[$i]['reciboCompartido'] != '1');
                $reciboDeComprobante->set_ReciboDeEmpresa($data[$i]['reciboDeEmpresa'] != '0');

                $comprobante->_recibosDeComprobante[] = $reciboDeComprobante;
            }
            
            return $comprobante;
        } catch (Exception $ex) {
            throw new Exception('Data\LiquidacionSueldo\getComprobantesDePagoByIdEmpleado: ' . $ex->getMessage());
        }
    }
    
    private function getSelectQuery($f_mes, $f_año, $f_nombreEmpleado, $f_valor, $f_observaciones) {
        $sql = 'call getLiquidacionSueldoByFilter(' .
                $f_mes . ', ' . $f_año . ', ' .
                ($f_nombreEmpleado != null ? '\'' . $f_nombreEmpleado . '\'' : 'null') . ', ' . 
                $f_valor . ', ' . 
                ($f_observaciones != null ? '\'' . $f_observaciones . '\'' : 'null') . ')';
        return $sql;
    }
    
    private function getInsertUpdateQuery($idLiquidacionSueldo, $mes, $año, $idEmpleado, $valor, $observaciones) {
        $queryInsertUpdate = 'call setLiquidacionSueldo(' . $idLiquidacionSueldo . ', ' . $mes . ', ' . $año . ', ' .
                $idEmpleado . ', ' . $valor . ', \'' . $observaciones . '\');';
        return $queryInsertUpdate;
    }
    
}
