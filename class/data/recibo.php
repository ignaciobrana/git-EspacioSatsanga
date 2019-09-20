<?php

namespace Data;

class Recibo {
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
    
    public function getRecibos($f_numeroRecibo, $f_fechaDesde, $f_fechaHasta, $f_nombreEstudiante, $f_valor, $f_promocion){
        try{
            $arr_recibos = array();
            $recibo = null;
            $estudiante = null;
            $factura = null;
            
            $sql = self::getSelectQuery($f_numeroRecibo, $f_fechaDesde, $f_fechaHasta, $f_nombreEstudiante, $f_valor, $f_promocion);
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            for ($i = 0; $i < $query->rowCount(); $i++){
                $recibo = new \Model\Recibo();
                $recibo->set_IdRecibo($data[$i]['idRecibo']);
                $recibo->set_NumeroRecibo($data[$i]['numeroRecibo']);
                $recibo->set_Fecha($data[$i]['fecha']);
                $recibo->set_Valor($data[$i]['valor']);
                $recibo->set_VecesPorSemana($data[$i]['vecesPorSemana']);
                $recibo->set_Observaciones($data[$i]['observaciones']);
                $recibo->set_Promocion($data[$i]['promocion']);
                $recibo->set_nombreEstudiante($data[$i]['est_NombreApellido']);
                $recibo->set_proximoMes($data[$i]['proximoMes']);
                
                if ($data[$i]['idEstudiante'] != null) {
                    $estudiante = new \Model\Estudiante();
                    $estudiante->set_IdEstudiante($data[$i]['idEstudiante']);
                    $estudiante->set_NombreApellido($data[$i]['est_NombreApellido']);
                    $recibo->set_Estudiante($estudiante);
                } else { $recibo->set_Estudiante(null); }
                
                if ($data[$i]['idFactura'] != null) {
                    $factura = new \Model\Factura();
                    $factura->set_IdFactura($data[$i]['idFactura']);
                    $factura->set_NumeroFactura($data[$i]['fact_numeroFactura']);
                    $factura->set_Fecha($data[$i]['fact_fecha']);
                    $factura->set_Cuit($data[$i]['fact_cuit']);
                    $factura->set_Detalle($data[$i]['fact_detalle']);
                    $factura->set_Total($data[$i]['fact_total']);
                    $factura->set_Cliente($data[$i]['fact_cliente']);
                    $recibo->set_Factura($factura);
                } else { $recibo->set_Factura(null); }
                
                /*------------------------------------------------------------------
                ---Nota: Al momento de editar el recibo se obtendran sus clases!!---
                --------------------------------------------------------------------*/
                
                $arr_recibos[] = $recibo;
            }
            return $arr_recibos;
        } catch(\Exception $ex) {
            throw new \Exception('Data\Recibo\getRecibos: ' . $ex->getMessage());
        }
    }
    
    public function setRecibo($idRecibo, $numeroRecibo, $fecha, $idEstudiante, $vecesPorSemana, $idClases, $observaciones, $valor, $promocion, $idFactura, $proximoMes) {
        try {
            $sql = self::getInsertUpdateQuery($idRecibo, $numeroRecibo, $fecha, $idEstudiante, $vecesPorSemana,
                    $observaciones, $valor, $idClases, $promocion, $idFactura, $proximoMes);
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch(\Exception $ex) {
            throw new \Exception('Data\Recibo\setRecibo: ' . $ex->getMessage());
        }
    }

    public function hayRecibosInconmpletos() {
        try{
            $sql = "call getRecibosIncompletos()";
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            
            return ($query->rowCount() > 0 ? "true" : "false");
        } catch(\Exception $ex) {
            throw new \Exception('Data\Recibo\hayRecibosInconmpletos: ' . $ex->getMessage());
        }
    }
    
    function getSelectQuery($f_numeroRecibo, $f_fechaDesde, $f_fechaHasta, $f_nombreEstudiante, $f_valor, $f_promocion) {
        $numRec = ($f_numeroRecibo != '' && $f_numeroRecibo != null ? $f_numeroRecibo : 0);
        $valor = ($f_valor != '' && $f_valor != null ? $f_valor : 0);
        
        $sql = 'call getRecibosByFilter(' . $numRec . ', \'' . $f_nombreEstudiante . '\', ' . $valor . ', ' .
                ($f_fechaDesde != null ? '\'' . $f_fechaDesde . '\'' : 'null') . ', ' . 
                ($f_fechaHasta != null ? '\'' . $f_fechaHasta . '\'' : 'null') . ', \'' . $f_promocion . '\')';
        
        return $sql;
    }
    
    function getInsertUpdateQuery($idRecibo, $numeroRecibo, $fecha, $idEstudiante, $vecesPorSemana, $observaciones, $valor, $idClases, $promocion, $idFactura, $proximoMes) {
        list($f_día, $f_mes, $f_año) = explode('/', $fecha);
        //$ids = implode(",", $vIdClases);
        $queryInsertUpdate = 'call setRecibo(' . $idRecibo . ', ' . $numeroRecibo . ', ' .
                '\'' . ($f_año . '-' . $f_mes . '-' . $f_día) . '\', ' .
                ($idEstudiante != null ? $idEstudiante : 'null') . ', ' . $vecesPorSemana . ', \'' . $observaciones . '\', ' . 
                $valor . ', \'' . $idClases . '\', \'' . $promocion . '\', ' . 
                ($idFactura != null ? $idFactura : 'null') . ', ' . $proximoMes . ');';
        return $queryInsertUpdate;
    }
    
    function setReciboClases($idRecibo, $vIdsClases){
        try {
            $ids = implode(",", $vIdsClases);
            $sql = 'call setReciboClase(' . $idRecibo . ', \'' . $ids . '\');';
            
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            
            return $query->rowCount(); //retorna 1 si sale todo bien
        } catch(\Exception $ex) {
            throw new \Exception('Data\Recibo\setReciboClases: ' . $ex->getMessage());
        }
    }
    
}
