<?php
namespace Model;

class EstadoEstudiante {
   public $_idEstadoEstudiante;
   public $_nombre;
   public $_descripcion;
   
   public function __construct(){
       $this->_idEstadoEstudiante = 0;
       $this->_nombre = '';
       $this->_descripcion = '';
   }
   
   public function get_IdEstadoEstudiante(){
       return $this->_idEstadoEstudiante;
   }
   
   public function get_Nombre(){
       return $this->_nombre;
   }
   
   public function get_Descripcion(){
       return $this->_descripcion;
   }
   
   public function set_IdEstadoEstudiante($idEstadoEstudiante){
       $this->_idEstadoEstudiante = $idEstadoEstudiante;
   }
   
   public function set_Nombre($nombre){
       $this->_nombre = $nombre;
   }
   
   public function set_Descripcion($descripcion){
       $this->_descripcion = $descripcion;
   }
}
