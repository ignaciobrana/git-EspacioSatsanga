<?php
namespace Model;

class ComoContacto {
   public $_idComoContacto;
   public $_nombre;
   public $_descripcion;
   
   public function __construct(){
       $this->_idComoContacto = 0;
       $this->_nombre = '';
       $this->_descripcion = '';
   }
   
   public function get_IdComoContacto(){
       return $this->_idComoContacto;
   }
   
   public function get_Nombre(){
       return $this->_nombre;
   }
   
   public function get_Descripcion(){
       return $this->_descripcion;
   }
   
   public function set_IdComoContacto($idComoContacto){
       $this->_idComoContacto = $idComoContacto;
   }
   
   public function set_Nombre($nombre){
       $this->_nombre = $nombre;
   }
   
   public function set_Descripcion($descripcion){
       $this->_descripcion = $descripcion;
   }
}
