<?php

namespace Business;

class Recibo {
        
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
    
    public function getRecibos($f_numeroRecibo, $f_fechaDesde, $f_fechaHasta, $f_nombreEstudiante, $f_valor, $f_promocion) {
        try{
            $recibos = \Data\Recibo::instance()->getRecibos($f_numeroRecibo, $f_fechaDesde, $f_fechaHasta, $f_nombreEstudiante, $f_valor, $f_promocion);
            return $recibos;
        } catch(\Exception $ex) {
            throw new \Exception('Business\Recibo\getRecibos: ' . $ex->getMessage());
        }
    }
    
    public function setRecibo($idRecibo, $numeroRecibo, $fecha, $idEstudiante, $vecesPorSemana, $idClases, $observaciones, $valor, $promocion, $idFactura, $proximoMes) {
        try{
            $recibos = \Data\Recibo::instance()->setRecibo($idRecibo, $numeroRecibo, $fecha, $idEstudiante, 
                        $vecesPorSemana, $idClases, $observaciones, $valor, $promocion, $idFactura, $proximoMes);
            return $recibos;
        } catch(\Exception $ex) {
            throw new \Exception('Business\Recibo\setRecibo: ' . $ex->getMessage());
        }
    }

    public function hayRecibosInconmpletos() {
        try{
            $retValue = \Data\Recibo::instance()->hayRecibosInconmpletos();
            return $retValue;
        } catch(\Exception $ex) {
            throw new \Exception('Business\Recibo\hayRecibosInconmpletos: ' . $ex->getMessage());
        }
    }
    
}
