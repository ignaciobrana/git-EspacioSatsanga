<?php

ob_start();

$api = true; //Seteamos esta variable que indica a iniPage que se está llamando desde una api
include_once '../iniPage.php';

try {
    $response = array();

    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    //echo $json;
    
    if (isset($obj["idEstudiante"]) && isset($obj["nombreApellido"]) && isset($obj["fechaNacimiento"]) &&
        isset($obj["idComoConocio"]) && isset($obj["email"]) && /*isset($obj["observaciones"]) &&
        isset($obj["celular"]) && isset($obj["telefono"]) &&*/ isset($obj["fechaAlta"]) &&
        isset($obj["fechaBaja"]) && isset($obj["idGenero"]) && isset($obj["idEstadoEstudiante"])) {

            $idEstudiante = $obj["idEstudiante"];
            $nombreApellido = $obj["nombreApellido"]; 
            $fechaNacimiento = $obj["fechaNacimiento"]; 
            $idGenero = $obj["idGenero"];
            $idEstadoEstudiante = $obj["idEstadoEstudiante"];
            $idComoConocio = $obj["idComoConocio"]; 
            $email = $obj["email"]; 
            $observaciones = $obj["observaciones"]; 
            $celular = $obj["celular"]; 
            $telefono = $obj["telefono"];
            $fechaAlta = $obj["fechaAlta"];
            $fechaBaja = $obj["fechaBaja"];

            $returnValue = \Business\Estudiante::instance()->setEstudiante($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, $idEstadoEstudiante,
                            $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, 
                            $fechaBaja);

            $response["status"] = isset($returnValue) ? "success" : "error";
    } else { 
        $response["status"] = "error"; 
        $response["error"] = "Faltan datos."; 
    }
    $json_returnValue = json_encode($response);
    echo $json_returnValue;
} catch (\Exception $ex) {
    echo json_encode(array(
        'status' => 'error',
        'error' => 'Error realizando el guardado de datos: ' . $ex->getMessage()
    ));
}
?>