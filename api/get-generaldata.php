<?php

ob_start();

$api = true; //Seteamos esta variable que indica a iniPage que se está llamando desde una api
include_once '../iniPage.php';
include_once '../class/business/comoConocio.php';
include_once '../class/business/estadoEstudiante.php';
include_once '../class/data/comoConocio.php';
include_once '../class/data/estadoEstudiante.php';
include_once '../class/model/comoConocio.php';
include_once '../class/model/estadoEstudiante.php';

try {

    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    $table = isset($obj['table']) ? $obj['table'] : (isset($_POST['table']) ? $_POST['table'] : '');
    switch ($table) {
        case 'comoConocio':
            get_ComoConocio();
            break;
        case 'estadoEstudiante':
            get_EstadoEstudiante();
            break;
        case 'genero':
            get_Genero();
            break;
        default:
            echo json_encode(array(
                'status' => 'error', 
                'error' => 'No existe la tabla seleccionada'
            ));
            break;
    }

} catch (\Exception $ex) {
    echo json_encode(array(
        'status' => 'error',
        'error' => 'Error obteniendo información de la Base de Datos: ' . $ex->getMessage()
    ));
}

function get_ComoConocio() {
    $arrComoConocio = \Business\ComoConocio::instance()->getComoConocio_All();
    $json_ComoConocio = json_encode($arrComoConocio);
    echo $json_ComoConocio;
}

function get_EstadoEstudiante() {
    $arrEstadoEstudiantes = \Business\EstadoEstudiante::instance()->getEstadoEstudiante_All();
    $json_EstadoEstudiantes = json_encode($arrEstadoEstudiantes);
    echo $json_EstadoEstudiantes;
}

function get_Genero() {
    $arrGenero = \Business\Genero::instance()->getGenero_All();
    $json_Genero = json_encode($arrGenero);
    echo $json_Genero;
}

?>