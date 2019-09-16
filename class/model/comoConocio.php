<?php
namespace Model;

class ComoConocio {
   public $_idComoConocio;
   public $_nombre;
   public $_descripcion;
   
   public function __construct(){
       $this->_idComoConocio = 0;
       $this->_nombre = '';
       $this->_descripcion = '';
   }
   
   public function get_IdComoConocio(){
       return $this->_idComoConocio;
   }
   
   public function get_Nombre(){
       return $this->_nombre;
   }
   
   public function get_Descripcion(){
       return $this->_descripcion;
   }
   
   public function set_IdComoConocio($idComoConocio){
       $this->_idComoConocio = $idComoConocio;
   }
   
   public function set_Nombre($nombre){
       $this->_nombre = $nombre;
   }
   
   public function set_Descripcion($descripcion){
       $this->_descripcion = $descripcion;
   }
}
