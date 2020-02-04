<?php

namespace GlobalClass;

include_once '../class/globalclass/database.php';
include_once '../class/globalclass/helper.php';
include_once '../class/business/estudiante.php';
include_once '../class/data/estudiante.php';

use Business\Estudiante;

//class ApiEstudiante {
    
    //function setEstudiante($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEstudiante,
    //                $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, 
    //                $fechaBaja) {
        $response = array();

        if (isset($_POST["idEstudiante"]) && isset($_POST["nombreApellido"]) && isset($_POST["fechaNacimiento"]) &&
            isset($_POST["idComoConocio"]) && isset($_POST["email"]) && isset($_POST["observaciones"]) &&
            isset($_POST["celular"]) && isset($_POST["telefono"]) && isset($_POST["fechaAlta"]) &&
            isset($_POST["fechaBaja"]) && isset($_POST["idGenero"]) && isset($_POST["idEstadoEstudiante"])) {
        

                $idEstudiante = $_POST["idEstudiante"];
                $nombreApellido = $_POST["nombreApellido"]; 
                $fechaNacimiento = $_POST["fechaNacimiento"]; 
                $idGenero = $_POST["idGenero"];
                $idEstadoEstudiante = $_POST["idEstadoEstudiante"];
                $idComoConocio = $_POST["idComoConocio"]; 
                $email = $_POST["email"]; 
                $observaciones = $_POST["observaciones"]; 
                $celular = $_POST["celular"]; 
                $telefono = $_POST["telefono"];
                $fechaAlta = $_POST["fechaAlta"];
                $fechaBaja = $_POST["fechaBaja"];

                $returnValue = Estudiante::instance()->setEstudiante($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEstudiante,
                                $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, 
                                $fechaBaja);

                $response["status"] = isset($returnValue) ? "success" : "error";
            
        } else {
            $response["status"] = "error";
        }
        $json_returnValue = json_encode($response);
        echo $json_returnValue;
    //}

//}

?>