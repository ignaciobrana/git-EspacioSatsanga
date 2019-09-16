<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");
//include_once dirname(__DIR__) . '/globalclass/database.php';
//echo dirname(__DIR__) . '/globalclass/database.php';

class Factura {
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
    
    public function getFacturas($f_numeroFactura, $f_cliente, $f_total, $f_fechaDesde, $f_fechaHasta){
        try{
            $arr_facturas = array();
            $factura = null;
            $estudiante = null;
            $empresa = null;
            
            $sql = self::getSelectQuery($f_numeroFactura, $f_cliente, $f_total, $f_fechaDesde, $f_fechaHasta);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $factura = new \Model\Factura();
                $factura->set_IdFactura($data[$i]['idFactura']);
                $factura->set_NumeroFactura($data[$i]['numeroFactura']);
                $factura->set_Fecha($data[$i]['fecha']);
                $factura->set_Cliente($data[$i]['cliente']);
                $factura->set_Cuit($data[$i]['cuit']);
                $factura->set_Domicilio($data[$i]['domicilio']);
                $factura->set_Localidad($data[$i]['localidad']);
                $factura->set_Telefono($data[$i]['telefono']);
                $factura->set_RespNoInscripto($data[$i]['respNoInscripto']);
                $factura->set_RespInscripto($data[$i]['respInscripto']);
                $factura->set_Exento($data[$i]['exento']);
                $factura->set_NoResponsable($data[$i]['noResponsable']);
                $factura->set_ConsumidorFinal($data[$i]['consumidorFinal']);
                $factura->set_RespMonotributista($data[$i]['respMonotributista']);
                $factura->set_Contado($data[$i]['contado']);
                $factura->set_CuentaCorriente($data[$i]['cuentaCorriente']);
                $factura->set_NumeroRemito($data[$i]['numeroRemito']);
                $factura->set_Detalle($data[$i]['detalle']);
                $factura->set_Total($data[$i]['total']);
                
                $estudiante = new \Model\Estudiante();
                $estudiante->set_IdEstudiante($data[$i]['idEstudiante']);
                $estudiante->set_NombreApellido($data[$i]['est_nombre']);
                $estudiante->set_Email($data[$i]['est_email']);
                $estudiante->set_Celular($data[$i]['est_celular']);
                $estudiante->set_Telefono($data[$i]['est_telefono']);
                $factura->set_Estudiante($estudiante);
                                
                $empresa = new \Model\Empresa();
                $empresa->set_IdEmpresa($data[$i]['idEmpresa']);
                $empresa->set_RazonSocial($data[$i]['emp_razonSocial']);
                $empresa->set_Email($data[$i]['emp_email']);
                $empresa->set_Cuit($data[$i]['emp_cuit']);
                $empresa->set_Domicilio($data[$i]['emp_domicilio']);
                $empresa->set_Localidad($data[$i]['emp_localidad']);
                $empresa->set_Telefono($data[$i]['emp_telefono']);
                $factura->set_Empresa($empresa);
                
                $arr_facturas[] = $factura;
            }
            return $arr_facturas;
        } catch(Exception $ex) {
            throw new Exception('Data\Factura\getFacturas: ' . $ex->getMessage());
        }
    }
    
    public function setFactura($idFactura, $numeroFactura, $idEstudiante, $idEmpresa, $fecha, $cliente, $domicilio, $localidad, 
            $telefono, $respNoInscripto, $respInscripto, $exento, $noResponsable, $consumidorFinal, $respMonotributista,
            $contado, $cuentaCorriente, $cuit, $numeroRemito, $detalle, $total){
        try {
            $sql = self::getInsertUpdateQuery($idFactura, $numeroFactura, $idEstudiante, $idEmpresa, $fecha, $cliente, $domicilio, $localidad, 
                        $telefono, $respNoInscripto, $respInscripto, $exento, $noResponsable, $consumidorFinal, $respMonotributista,
                        $contado, $cuentaCorriente, $cuit, $numeroRemito, $detalle, $total);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $returnValue = $query->rowCount(); //retorna 1 si sale todo bien
            return $returnValue;
        } catch (Exception $ex) {
            throw new Exception('Data\Factura\setFactura: ' . $ex->getMessage());
        }
    }
    
    private function getSelectQuery($f_numeroFactura, $f_cliente, $f_total, $f_fechaDesde, $f_fechaHasta) {
        $sql = 'call getFacturasByFilter(' .
                $f_numeroFactura . ', \'' . $f_cliente . '\', ' . $f_total . ', ' .
                ($f_fechaDesde != null ? '\'' . $f_fechaDesde . '\'' : 'null') . ', ' . 
                ($f_fechaHasta != null ? '\'' . $f_fechaHasta . '\'' : 'null') . ')';
        return $sql;
    }
    
    private function getInsertUpdateQuery($idFactura, $numeroFactura, $idEstudiante, $idEmpresa, $fecha, $cliente, $domicilio, $localidad, 
                        $telefono, $respNoInscripto, $respInscripto, $exento, $noResponsable, $consumidorFinal, $respMonotributista,
                        $contado, $cuentaCorriente, $cuit, $numeroRemito, $detalle, $total) {
        
        list($f_día, $f_mes, $f_año) = explode('/', $fecha);
        
        $queryInsertUpdate = 'call setFactura(' . $idFactura . ', ' . $numeroFactura . ', ' . 
                ($idEstudiante != null ? $idEstudiante : 'null') . ', ' . ($idEmpresa != null ? $idEmpresa : 'null') . ', \'' . 
                ($f_año . '-' . $f_mes . '-' . $f_día) . '\', \'' .
                $cliente . '\', \'' . $cuit . '\', \'' . $domicilio . '\', \'' . $localidad . '\', \'' . $telefono . '\', ' . 
                ($respNoInscripto != null ? $respNoInscripto : 'null') . ', ' . 
                ($respInscripto != null ? $respInscripto : 'null') . ', ' . 
                ($exento != null ? $exento : 'null') . ', ' . 
                ($noResponsable != null ? $noResponsable : 'null') . ', ' . 
                ($consumidorFinal != null ? $consumidorFinal : 'null') . ', ' . 
                ($respMonotributista != null ? $respMonotributista : 'null') . ', ' . 
                ($contado != null ? $contado : 'null') . ', ' . 
                ($cuentaCorriente != null ? $cuentaCorriente : 'null') . ', ' . 
                ($numeroRemito != null ? $numeroRemito : 'null') . ', \'' . 
                $detalle . '\', ' . $total . ');';
        
        return $queryInsertUpdate;
    }
    
}
