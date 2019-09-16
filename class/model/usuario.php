<?php
namespace Model;

class Usuario {
   public $_idUsuario;
   public $_nombreUsuario;
   public $_hashPassword;
   
   public function __construct(){
       $this->_idUsuario = 0;
       $this->_nombreUsuario = '';
       $this->_hashPassword = '';
   }
   
   public function get_IdUsuario(){
       return $this->_idUsuario;
   }
   
   public function get_NombreUsuario(){
       return $this->_nombreUsuario;
   }
   
   public function get_HashPassword(){
       return $this->_hashPassword;
   }
   
   public function set_IdUsuario($idUsuario){
       $this->_idUsuario = $idUsuario;
   }
   
   public function set_NombreUsuario($nombreUsuario){
       $this->_nombreUsuario = $nombreUsuario;
   }
   
   public function set_HashPassword($hashPassword){
       $this->_hashPassword = $hashPassword;
   }
}
