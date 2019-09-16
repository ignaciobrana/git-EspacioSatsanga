<?php
namespace Data;

//defined("APPPATH") OR die("Access denied");

//use GlobalClass\Database;

class Usuario {
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
    
    public function getUsuario ($userName, $hash_password){
        try{
            $sql = 'call getUsuarioByLogin(\'' . $userName . '\', \'' . $hash_password . '\');';
            $query = \GlobalClass\Database::instance()->prepare($sql);
            $query->execute();
            $data = $query->fetchAll();
            
            if ($query->rowCount() == 1){
                $user = new \Model\Usuario();
                $user->set_IdUsuario($data[0]['idUsuario']);
                $user->set_NombreUsuario($data[0]['NombreUsuario']);
                $user->set_HashPassword($data[0]['Password']);
                return $user;
            }
            return null;
        } catch(Exception $ex) {
            throw new Exception('Data\Usuario: ' . $ex->getMessage());
        }
    }
}