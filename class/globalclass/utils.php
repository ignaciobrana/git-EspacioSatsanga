<?php
namespace GlobalClass;

/**
 * Description of utils
 *
 * @author ignacio
 */
class Utils {
    
    public static function getFechaLargaActual() {
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        return $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
    }
    
    public static function getMonthByNumberOf($mes) {
        switch ($mes):
            case 1: return 'Enero';
            case 2: return 'Febrero';
            case 3: return 'Marzo';
            case 4: return 'Abril';
            case 5: return 'Mayo';
            case 6: return 'Junio';
            case 7: return 'Julio';
            case 8: return 'Agosto';
            case 9: return 'Septiembre';
            case 10: return 'Octubre';
            case 11: return 'Noviembre';
            case 12: return 'Diciembre';
            default: return 'mes invalido';
        endswitch;
    }
    
}
