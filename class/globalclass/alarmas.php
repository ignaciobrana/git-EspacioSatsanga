<?php
namespace GlobalClass;

use Business\Recibo;

include_once dirname(__DIR__) . '/globalclass/session.php';
include_once dirname(__DIR__) . '/globalclass/database.php';
include_once dirname(__DIR__) . '/globalclass/helper.php';

include_once dirname(__DIR__) . '/business/recibo.php';
include_once dirname(__DIR__) . '/data/recibo.php';
include_once dirname(__DIR__) . '/model/recibo.php';

// verifica parámetro que se está enviando
if(isset($_REQUEST['condicion'])) {
    switch ($_REQUEST['condicion']) {
        case 'hayRecibosInconmpletos':
            try {
                $returnValue = Recibo::instance()->hayRecibosInconmpletos();
                $json_returnValue = json_encode($returnValue);
                echo $json_returnValue;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('alarmas/hayRecibosInconmpletos(): ' . $ex->getMessage());
            }
        default :
            throw new \Exception('alarmas: Se está enviando un nombre de función incorrecto');
    }
}