<?php
namespace GlobalClass;
//defined("APPPATH") OR die("Access denied");

class Helper
{
    /**
    * [getConfig Obtenemos la configuraci�n de la app]
    * @return [Array] [Array con la config]
    */
    public static function getConfig()
    {
        $path = realpath(dirname(__FILE__) . '/../..'); //sube dos nuveles '/../..'
        return parse_ini_file($path . '/config/config.ini', true);
    }
    
    /**
    * [isLoginPage Obtenemos el valor bool si está logeado o no el usuario
    * @return [bool] [1 = loggeado]
    */
    public static function isLoginPage() {
        return strtolower(self::getPageName()) == 'login.php';
    }

    /**
    * [getPageName Obtenemos el nombre de la página actual]
    * @return [String] [String con el nombre de la página actual]
    */
    public static function getPageName() {
        $tmp = explode('/', $_SERVER['PHP_SELF']);
        return end($tmp);
    }
    
    /**
    * [getPasswordHash A partir de un password genera un hash]
    * @return [String] [Hash generado a partir del password]
    */
    public static function getPasswordHash($password) {
        //return password_hash(base64_encode(hash('sha256', $password, true)),PASSWORD_DEFAULT);
        return base64_encode(hash('sha256', $password, true));
    }
    
    /**
    * [password_equals A partir de dos valores hash realiza la comparación si son iguales]
    * @return [Bool] [retorna el valor booleano de la comparación de hash]
    */
    public static function password_equals($hash1, $hash2) {
        //return password_hash(base64_encode(hash('sha256', $password, true)),PASSWORD_DEFAULT);
        return hash_equals($hash1, $hash2);
    }
    
}