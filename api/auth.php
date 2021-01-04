<?php

ob_start();

$api = true; //Seteamos esta variable que indica a iniPage que se está llamando desde una api
include_once '../iniPage.php';

try {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    $uu =  isset($obj["username"]) ? $obj["username"] : (isset($_POST["username"]) ? $_POST["username"] : "");
    $pass =  isset($obj["password"]) ? $obj["password"] : (isset($_POST["password"]) ? $_POST["password"] : "");

    //$uu =  $_REQUEST["username"];
    //$pass = $_REQUEST["password"];
    
    if (isset($uu) && isset($pass)) {
        $user = \Business\Login::instance()->getUser($uu, $pass);
        echo json_encode(array(
            'success' => $user != null,
            'user' => $user
        ));
    }
} catch (Exception $ex) {
    echo json_encode(array(
        'success' => false,
        'error' => 'Error realizando el autentificación: ' . $ex->getMessage()
    ));
}
?>