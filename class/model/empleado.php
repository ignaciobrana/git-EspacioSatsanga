<?php
namespace Model;

class Empleado {
    public $_idEmpleado;
    public $_nombreApellido;
    public $_estadoEmpleado;
    public $_tipoEmpleado;
    public $_genero;
    public $_email;
    public $_celular;
    public $_telefono;
    public $_fechaAlta;
    public $_fechaNacimiento;
    
    public function __construct(){
        $this->_idEmpleado = 0;
        $this->_nombreApellido = '';
        $this->_estadoEmpleado = new \Model\EstadoEmpleado();
        $this->_tipoEmpleado = new \Model\TipoEmpleado();
        $this->_genero = new \Model\genero();
        $this->_email = '';
        $this->_celular = '';
        $this->_telefono = '';
        $this->_fechaAlta = '';
        $this->_fechaNacimiento = '';
    }
    
    public function get_IdEmpleado(){
        return $this->_idEmpleado;
    }

    public function get_NombreApellido(){
        return $this->_nombreApellido;
    }

    public function get_FechaAlta(){
        return $this->_fechaAlta;
    }

    public function get_EstadoEmpleado(){
        return $this->_estadoEmpleado;
    }

    public function get_TipoEmpleado(){
        return $this->_tipoEmpleado;
    }

    public function get_Genero(){
        return $this->_genero;
    }

    public function get_Email(){
        return $this->_email;
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

    public function set_IdEmpleado($idEmpleado){
        $this->_idEmpleado = $idEmpleado;
    }

    public function set_NombreApellido($nombreApellido){
        $this->_nombreApellido = $nombreApellido;
    }

    public function set_FechaAlta($fechaAlta){
        $this->_fechaAlta = $fechaAlta;
    }

    public function set_EstadoEmpleado($estadoEmpleado){
        $this->_estadoEmpleado = $estadoEmpleado;
    }

    public function set_TipoEmpleado($tipoEmpleado){
        $this->_tipoEmpleado = $tipoEmpleado;
    }

    public function set_Genero($genero){
        $this->_genero = $genero;
    }

    public function set_Email($email){
        $this->_email = $email;
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
}