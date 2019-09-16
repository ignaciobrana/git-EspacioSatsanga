<?php
include_once './iniPage.php';

try {
    $objBusiness = \Business\Login::instance();
    $user = $objBusiness->getUser('satsanga', 'upasaka0');
    if ($user != null){
        echo 'id: '.$user->get_IdUsuario();
        echo '<br>usuario: '.$user->get_NombreUsuario();
        echo '<br>hash: '.$user->get_HashPassword();
    } else {
        echo 'retornó Null la base de datos';
    }
} catch (Exception $ex) { echo $ex->getMessage(); }