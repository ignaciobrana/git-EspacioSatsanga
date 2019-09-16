<?php
namespace Model;

class Estudiante {
    public $_idEstudiante;
    public $_nombreApellido;
    public $_fechaAlta;
    public $_estadoEstudiante;
    public $_email;
    public $_observaciones;
    public $_celular;
    public $_telefono;
    public $_fechaNacimiento;
    public $_comoConocio;
    public $_genero;
    public $_fechaBaja;

    public function __construct(){
        $this->_idEstudiante = 0;
        $this->_nombreApellido = '';
        $this->_fechaAlta = '';
        $this->_estadoEstudiante = new \Model\estadoEstudiante();
        $this->_comoConocio = new \Model\comoConocio();
        $this->_genero = new \Model\genero();
        $this->_email = '';
        $this->_observaciones = '';
        $this->_celular = '';
        $this->_telefono = '';
        $this->_fechaNacimiento = '';
        $this->_fechaBaja = '';
    }

    public function get_IdEstudiante(){
        return $this->_idEstudiante;
    }

    public function get_NombreApellido(){
        return $this->_nombreApellido;
    }

    public function get_FechaAlta(){
        return $this->_fechaAlta;
    }

    public function get_EstadoEstudiante(){
        return $this->_estadoEstudiante;
    }

    public function get_ComoConocio(){
        return $this->_comoConocio;
    }

    public function get_Genero(){
        return $this->_genero;
    }

    public function get_Email(){
        return $this->_email;
    }

    public function get_Observaciones(){
        return $this->_observaciones;
    }

    public function get_Celular(){
        return $this->_celular;
    }

    public function get_Telefono(){
        return $this->_telefono;
    }

    public function get_FechaNacimiento(){
        return $this->_fechaNacimiento;
    }
    
    public function get_FechaBaja(){
        return $this->_fechaBaja;
    }

    public function set_IdEstudiante($idEstudiante){
        $this->_idEstudiante = $idEstudiante;
    }

    public function set_NombreApellido($nombreApellido){
        $this->_nombreApellido = $nombreApellido;
    }

    public function set_FechaAlta($fechaAlta){
        $this->_fechaAlta = $fechaAlta;
    }

    public function set_EstadoEstudiante($estadoEstudiante){
        $this->_estadoEstudiante = $estadoEstudiante;
    }

    public function set_ComoConocio($comoConocio){
        $this->_comoConocio = $comoConocio;
    }

    public function set_Genero($genero){
        $this->_genero = $genero;
    }

    public function set_Email($email){
        $this->_email = $email;
    }

    public function set_Observaciones($observaciones){
        $this->_observaciones = $observaciones;
    }

    public function set_Celular($celular){
        $this->_celular = $celular;
    }

    public function set_Telefono($telefono){
        $this->_telefono = $telefono;
    }

    public function set_FechaNacimiento($fechaNacimiento){
        $this->_fechaNacimiento = $fechaNacimiento;
    }
    
    public function set_FechaBaja($fechaBaja){
        $this->_fechaBaja = $fechaBaja;
    }
    
}
