<?php
namespace GlobalClass;

//defined("APPPATH") OR die("Access denied");

class Session {
    
    public static function session_start() {
        session_start();
    }
    
    public static function isLogged() {
        return isset($_SESSION["session_username"]) && isset($_SESSION["session_iduser"]);
    }
    
    public static function setSession($idUser, $username) {
        $_SESSION["session_iduser"] = $idUser;
        $_SESSION["session_username"] = $username;
    }
    
    public static function getSession_userName() {
        return $_SESSION["session_username"];
    }
    
    public static function getSession_idUser() {
        return $_SESSION["session_iduser"];
    }
    
    public static function session_destroy() {
        // Inicializar la sesión.
        // Si está usando session_name("algo"), ¡no lo olvide ahora!
        session_start();
        
        //self::setSession(null, null);
        $_SESSION = [];

        // Si se desea destruir la sesión completamente, borre también la cookie de sesión.
        // Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión.
        session_destroy();
    }
    
}