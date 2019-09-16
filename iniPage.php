<?php
//Iniciamos la session
session_start();

//seteamos formato
mb_http_output('UTF-8');
header('Content-Type: text/html; charset=' . mb_http_output());
//header('Content-Type: text/html; charset=UTF-8');

//directorio del proyecto
define("PROJECTPATH", dirname(__DIR__) . '\EspacioSatsanga');
//En hosting descomentar la siguiente linea y comentar la anterior
//define("PROJECTPATH", dirname(__DIR__) . '/gestion');


//directorio app
define("APPPATH", PROJECTPATH);

//autoload con namespaces
function autoload_classes($class_name)
{
    $filename =  PROJECTPATH . '/class/' . strtolower(str_replace('\\', '/', $class_name) .'.php');
    if(is_file($filename))
    {
        try { require $filename; } 
        catch (\Exception $ex) { echo '<br> error haciendo el requiere -> ' . $ex->getMessage();}
    }
}
//registramos el autoload autoload_classes
spl_autoload_register('autoload_classes');

//Iniciamos la session
try{
//\GlobalClass\Session::session_start();
} catch (Exception $ex){ echo $ex->getMessage(); }

//Chequeamos si está logeada la session
if(!\GlobalClass\Helper::isLoginPage() && !\GlobalClass\Session::isLogged()){
    //header('Location: login.php');
    echo '<script type="text/javascript">location.href="login.php";</script>';
    die();
    //exit();
} else if(\GlobalClass\Helper::isLoginPage() && \GlobalClass\Session::isLogged()){
    //header('Location: estudiantes.php');
    echo '<script type="text/javascript">location.href="estudiantes.php";</script>';
    die();
    //exit();
}