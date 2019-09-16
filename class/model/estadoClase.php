<?php
namespace Model;

/*
++++ Al momento no se crearon las clases en Business y Data ya que no fue necesario ++++
++++ Fue simplemente para ganar tiempo... cuando se realice el ABM de las 'Clases' +++++
++++ será necesario la creación de dichas clases en Business y Data ++++++++++++++++++++
 */

class EstadoClase {
   public $_idEstadoClase;
   public $_nombre;
   
   public function __construct(){
       $this->_idEstadoClase = 0;
       $this->_nombre = '';
   }
   
   public function get_IdEstadoClase(){
       return $this->_idEstadoClase;
   }
   
   public function get_Nombre(){
       return $this->_nombre;
   }
   
   public function set_IdEstadoClase($idEstadoClase){
       $this->_idEstadoClase = $idEstadoClase;
   }
   
   public function set_Nombre($nombre){
       $this->_nombre = $nombre;
   }

}
