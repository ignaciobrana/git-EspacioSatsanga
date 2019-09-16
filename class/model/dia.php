<?php
namespace Model;

class Dia {
   public $_idDia;
   public $_nombre;
   
   public function __construct(){
       $this->_idDia = 0;
       $this->_nombre = '';
   }
   
   public function get_IdDia(){
       return $this->_idDia;
   }
   
   public function get_Nombre(){
       return $this->_nombre;
   }
   
   public function set_IdDia($idDia){
       $this->_idDia = $idDia;
   }
   
   public function set_Nombre($nombre){
       $this->_nombre = $nombre;
   }

}
