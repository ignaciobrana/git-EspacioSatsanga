<?php
namespace Model;

class Genero {
   public $_idGenero;
   public $_nombre;
   
   public function __construct(){
       $this->_idGenero = 0;
       $this->_nombre = '';
   }
   
   public function get_IdGenero(){
       return $this->_idGenero;
   }
   
   public function get_Nombre(){
       return $this->_nombre;
   }
   
   public function set_IdGenero($idGenero){
       $this->_idGenero = $idGenero;
   }
   
   public function set_Nombre($nombre){
       $this->_nombre = $nombre;
   }
}