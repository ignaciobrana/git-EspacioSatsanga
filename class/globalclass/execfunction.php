<?php
namespace GlobalClass;

use GlobalClass\Session,
    Business\Estudiante,
    Business\Empleado,
    Business\Recibo,
    Business\Empresa,
    Business\Factura,
    Business\EstadoEstudiante,
    Business\EstadoEmpleado,
    Business\EstadoClase,
    Business\Genero,
    Business\ComoConocio,
    Business\TipoEmpleado,
    Business\Clase,
    Business\Dia,
    Business\LiquidacionSueldo,
    Business\TipoMovimientoCC,
    Business\TipoEgresoFijo,
    Business\CajaChica,
    Business\MovimientoCajaChica,
    Business\CajaGrande,
    Business\Adelanto;


include_once dirname(__DIR__) . '/globalclass/session.php';
include_once dirname(__DIR__) . '/globalclass/database.php';
include_once dirname(__DIR__) . '/globalclass/helper.php';

include_once dirname(__DIR__) . '/business/estudiante.php';
include_once dirname(__DIR__) . '/business/empleado.php';
include_once dirname(__DIR__) . '/business/recibo.php';
include_once dirname(__DIR__) . '/business/empresa.php';
include_once dirname(__DIR__) . '/business/factura.php';
include_once dirname(__DIR__) . '/business/estadoEstudiante.php';
include_once dirname(__DIR__) . '/business/estadoEmpleado.php';
include_once dirname(__DIR__) . '/business/estadoClase.php';
include_once dirname(__DIR__) . '/business/genero.php';
include_once dirname(__DIR__) . '/business/comoConocio.php';
include_once dirname(__DIR__) . '/business/tipoEmpleado.php';
include_once dirname(__DIR__) . '/business/clase.php';
include_once dirname(__DIR__) . '/business/dia.php';
include_once dirname(__DIR__) . '/business/liquidacionSueldo.php';
include_once dirname(__DIR__) . '/business/clase.php';
include_once dirname(__DIR__) . '/business/tipoMovimientoCC.php';
include_once dirname(__DIR__) . '/business/tipoEgresoFijo.php';
include_once dirname(__DIR__) . '/business/cajaChica.php';
include_once dirname(__DIR__) . '/business/movimientoCajaChica.php';
include_once dirname(__DIR__) . '/business/cajaGrande.php';
include_once dirname(__DIR__) . '/business/adelanto.php';

include_once dirname(__DIR__) . '/data/estudiante.php';
include_once dirname(__DIR__) . '/data/empleado.php';
include_once dirname(__DIR__) . '/data/recibo.php';
include_once dirname(__DIR__) . '/data/empresa.php';
include_once dirname(__DIR__) . '/data/factura.php';
include_once dirname(__DIR__) . '/data/estadoEstudiante.php';
include_once dirname(__DIR__) . '/data/estadoEmpleado.php';
include_once dirname(__DIR__) . '/data/estadoClase.php';
include_once dirname(__DIR__) . '/data/genero.php';
include_once dirname(__DIR__) . '/data/comoConocio.php';
include_once dirname(__DIR__) . '/data/tipoEmpleado.php';
include_once dirname(__DIR__) . '/data/clase.php';
include_once dirname(__DIR__) . '/data/dia.php';
include_once dirname(__DIR__) . '/data/liquidacionSueldo.php';
include_once dirname(__DIR__) . '/data/clase.php';
include_once dirname(__DIR__) . '/data/tipoMovimientoCC.php';
include_once dirname(__DIR__) . '/data/tipoEgresoFijo.php';
include_once dirname(__DIR__) . '/data/cajaChica.php';
include_once dirname(__DIR__) . '/data/movimientoCajaChica.php';
include_once dirname(__DIR__) . '/data/cajaGrande.php';
include_once dirname(__DIR__) . '/data/adelanto.php';

include_once dirname(__DIR__) . '/model/estudiante.php';
include_once dirname(__DIR__) . '/model/empleado.php';
include_once dirname(__DIR__) . '/model/empresa.php';
include_once dirname(__DIR__) . '/model/recibo.php';
include_once dirname(__DIR__) . '/model/empresa.php';
include_once dirname(__DIR__) . '/model/factura.php';
include_once dirname(__DIR__) . '/model/estadoEstudiante.php';
include_once dirname(__DIR__) . '/model/estadoEmpleado.php';
include_once dirname(__DIR__) . '/model/comoConocio.php';
include_once dirname(__DIR__) . '/model/genero.php';
include_once dirname(__DIR__) . '/model/tipoEmpleado.php';
include_once dirname(__DIR__) . '/model/clase.php';
include_once dirname(__DIR__) . '/model/dia.php';
include_once dirname(__DIR__) . '/model/estadoClase.php';
include_once dirname(__DIR__) . '/model/liquidacionSueldo.php';
include_once dirname(__DIR__) . '/model/comprobantePago.php';
include_once dirname(__DIR__) . '/model/tipoMovimientoCC.php';
include_once dirname(__DIR__) . '/model/tipoEgresoFijo.php';
include_once dirname(__DIR__) . '/model/cajaChica.php';
include_once dirname(__DIR__) . '/model/movimientoCajaChica.php';
include_once dirname(__DIR__) . '/model/cajaGrande.php';
include_once dirname(__DIR__) . '/model/adelanto.php';

 // verifica parámetro que se está enviando
if(isset($_REQUEST['condicion'])) {
     switch ($_REQUEST['condicion']) {
        case 'session_destroy':
            try {
                Session::session_destroy();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/session_destroy(): ' . $ex->getMessage());
            }
        case 'getEstudiantes_All':
            try {
                getEstudiantes_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEstudiantes(): ' . $ex->getMessage());
            }
        case 'getEmpleados_All':
            try {
                getEmpleados_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEmpleados_All(): ' . $ex->getMessage());
            }
        case 'getRecibos_All':
            try {
                getRecibo_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getRecibos_All(): ' . $ex->getMessage());
            }
        case 'getFacturas_All':
            try {
                getFactura_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getFacturas_All(): ' . $ex->getMessage());
            }
        case 'getLiquidacionesSueldo_All':
            try {
                getLiquidacionesSueldo_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getLiquidacionesSueldo_All(): ' . $ex->getMessage());
            }
        case 'getClases_All':
            try {
                getClase_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getClases_All(): ' . $ex->getMessage());
            }
        case 'getEmpresas_All':
            try {
                getEmpresa_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEmpresas_All(): ' . $ex->getMessage());
            }
        case 'setEstudiantes':
            setEstudiante();
            exit();
        case 'setEmpleados':
            setEmpleado();
            exit();
        case 'setRecibo':
            setRecibo();
            exit();
        case 'setFactura':
            setFactura();
            exit();
        case 'setLiquidacionSueldo':
            setLiquidacionSueldo();
            exit();
        case 'setClase':
            setClase();
            exit();
        case 'setEmpresa':
            setEmpresa();
            exit();
        case 'generateLiquidacionSueldo':
            generateLiquidacionSueldo();
            exit();
        case 'getEstadoEstudiantes_All':
            try {
                $arrEstadoEstudiantes = EstadoEstudiante::instance()->getEstadoEstudiante_All();
                $json_EstadoEstudiantes = json_encode($arrEstadoEstudiantes);
                echo $json_EstadoEstudiantes;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEstadoEstudiantes_All(): ' . $ex->getMessage());
            }
        case 'getEstadoEmpleados_All':
            try {
                $arrEstadoEmpleados = EstadoEmpleado::instance()->getEstadoEmpleado_All();
                $json_EstadoEmpleados = json_encode($arrEstadoEmpleados);
                echo $json_EstadoEmpleados;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEstadoEstudiantes_All(): ' . $ex->getMessage());
            }
        case 'getEstadoClases_All':
            try {
                $arrEstadoClases = EstadoClase::instance()->getEstadoClase_All();
                $json_EstadoClases = json_encode($arrEstadoClases);
                echo $json_EstadoClases;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEstadoEstudiantes_All(): ' . $ex->getMessage());
            }
        case 'getTipoEmpleados_All':
            try {
                $arrTipoEmpleados = TipoEmpleado::instance()->getTipoEmpleado_All();
                $json_TipoEmpleados = json_encode($arrTipoEmpleados);
                echo $json_TipoEmpleados;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getTipoEmpleados_All(): ' . $ex->getMessage());
            }
        case 'getGenero_All':
            try {
                $arrGenero = Genero::instance()->getGenero_All();
                $json_Genero = json_encode($arrGenero);
                echo $json_Genero;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getGenero_All(): ' . $ex->getMessage());
            }
        case 'getComoConocio_All':
            try {
                $arrComoConocio = ComoConocio::instance()->getComoConocio_All();
                $json_ComoConocio = json_encode($arrComoConocio);
                echo $json_ComoConocio;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getComoConocio_All(): ' . $ex->getMessage());
            }
        case 'getClaseByEstado':
            try {
                $f_idEstadoClase = $_REQUEST['f_idEstadoClase'];
                $arrClases = Clase::instance()->getClaseByEstado($f_idEstadoClase);
                $json_Clases = json_encode($arrClases);
                echo $json_Clases;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getClaseByEstado(): ' . $ex->getMessage());
            }
        case 'getClaseByIdRecibo':
            try {
                $f_idRecibo = $_REQUEST['f_idRecibo'];
                $arrClases = Clase::instance()->getClaseByRecibo($f_idRecibo);
                $json_Clases = json_encode($arrClases);
                echo $json_Clases;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getClaseByIdRecibo(): ' . $ex->getMessage());
            }
        case 'getEmpresas':
            try {
                $arrEmpresas = Empresa::instance()->getEmpresas_All();
                $json_Empresas = json_encode($arrEmpresas);
                echo $json_Empresas;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEmpresas(): ' . $ex->getMessage());
            }
        case 'getDia_All':
            try {
                $arrDias = Dia::instance()->getDia_All();
                $json_Dias = json_encode($arrDias);
                echo $json_Dias;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getDia_All(): ' . $ex->getMessage());
            }
        case 'downloadEstudiantesMails':
            try {
                downloadEstudiantesMails();
                echo '1';
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/downloadEstudiantesMails(): ' . $ex->getMessage());
            }
        case 'getEmpleadosForDownloadComprobantes':
            try {
                $arrIdsEmpleados = getEmpleadosForDownloadComprobantes();
                $json_IdsEmpleados = json_encode($arrIdsEmpleados);
                echo $json_IdsEmpleados;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/downloadComprobantesDePago(): ' . $ex->getMessage());
            }
        case 'getCajaChicaActual':
            try {
                $cajaChica = CajaChica::instance()->getCajaChicaActual();
                $json_cajaChica = json_encode($cajaChica);
                echo $json_cajaChica;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getCajaChicaActual(): ' . $ex->getMessage());
            }
        case 'getMovimientosCCByIdCajaChica':
            try {
                $arrMovimientosCajaChica = getMovimientosCCByIdCajaChica();
                $json_MovimientosCajaChica = json_encode($arrMovimientosCajaChica);
                echo $json_MovimientosCajaChica;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getMovimientosCCByIdCajaChica(): ' . $ex->getMessage());
            }
        case 'getTipoMovimientoCC_All':
            try {
                $arrTipoMovimientosCC = TipoMovimientoCC::instance()->getTipoMovimientoCC_All();
                $json_TipoMovimientosCC = json_encode($arrTipoMovimientosCC);
                echo $json_TipoMovimientosCC;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getTipoMovimientoCC_All(): ' . $ex->getMessage());
            }
        case 'setCajaChica':
            try {
                setCajaChica();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getTipoMovimientoCC_All(): ' . $ex->getMessage());
            }
        case 'setMovimientoCajaChica':
            try {
                setMovimientoCajaChica();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/setMovimientoCajaChica(): ' . $ex->getMessage());
            }
        case 'deleteMovimientoCajaChica':
            try {
                deleteMovimientoCajaChica();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/deleteMovimientoCajaChica(): ' . $ex->getMessage());
            }
        case 'getCajaChica_All':
            try {
                getCajaChica_All();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getCajaChica_All(): ' . $ex->getMessage());
            }
        case 'getCajaGrande_All':
            try {
                $arrCajaGrande = getCajaGrande_All();
                $json_CajaGrande = json_encode($arrCajaGrande);
                echo $json_CajaGrande;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getCajaGrande_All(): ' . $ex->getMessage());
            }
        case 'getTipoEgresoFijo_All':
            try {
                $arrTipoEgresoFijo = TipoEgresoFijo::instance()->getTipoEgresoFijo_All();
                $json_TipoEgresoFijo = json_encode($arrTipoEgresoFijo);
                echo $json_TipoEgresoFijo;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getTipoEgresoFijo_All(): ' . $ex->getMessage());
            }
        case 'setCajaGrande':
            try {
                setCajaGrande();
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/setCajaGrande(): ' . $ex->getMessage());
            }
        case 'getEstudiantesByIdClase':
            try {
                $arrEstudiantes = getEstudiantesByIdClase();
                $json_Estudiantes = json_encode($arrEstudiantes);
                echo $json_Estudiantes;
                exit();
            } catch (\Exception $ex) {
                throw new \Exception('execfunction/getEstudiantesByIdClase(): ' . $ex->getMessage());
            }
        default :
            throw new \Exception('execfunction: Se está enviando un nombre de función incorrecto');
    }
}

function getEstudiantes_All() {
    $f_nombreApellido = $_REQUEST['f_nombreApellido'];
    $f_email = $_REQUEST['f_email'];
    $f_celular = $_REQUEST['f_celular'];
    $f_idEstadoEstudiante = $_REQUEST['f_idEstadoEstudiante'];
    $f_fechaAltaDesde = $_REQUEST['f_fechaAltaDesde'];
    $f_fechaAltaHasta = $_REQUEST['f_fechaAltaHasta'];
    $f_idComoConocio = $_REQUEST['f_idComoConocio'];
    $f_fechaBajaDesde = $_REQUEST['f_fechaBajaDesde'];
    $f_fechaBajaHasta = $_REQUEST['f_fechaBajaHasta'];
    
    $arrEstudiantes = Estudiante::instance()->getEstudiantes($f_nombreApellido, $f_email, $f_celular, 
            $f_idEstadoEstudiante, $f_fechaAltaDesde, $f_fechaAltaHasta, $f_idComoConocio,
            $f_fechaBajaDesde, $f_fechaBajaHasta);
    $json_Estudiantes = json_encode($arrEstudiantes);
    echo $json_Estudiantes;
}

function setEstudiante() {
    try {
        $idEstudiante = $_REQUEST['idEstudiante'];
        $nombreApellido = $_REQUEST['nombreApellido'];
        $email = $_REQUEST['email'];
        $celular = $_REQUEST['celular'];
        $telefono = $_REQUEST['telefono'];
        $observaciones = $_REQUEST['observaciones'];
        $idEstadoEstudiante = $_REQUEST['idEstadoEstudiante'];
        $idGenero = $_REQUEST['idGenero'];
        $idComoConocio = $_REQUEST['idComoConocio'];
        $fechaAlta = $_REQUEST['fechaAlta'];
        $fechaNacimiento = $_REQUEST['fechaNacimiento'];
        $fechaBaja = $_REQUEST['fechaBaja'];
        
        $returnValue = Estudiante::instance()->setEstudiante($idEstudiante, $nombreApellido, $fechaNacimiento, $idGenero, 
                       $idEstadoEstudiante, $idComoConocio, $email, $observaciones, $celular, $telefono, $fechaAlta, 
                       $fechaBaja);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setEstudiantes(): ' . $ex->getMessage());
    }
}

function getEmpleados_All() {
    $f_nombreApellido = $_REQUEST['f_nombreApellido'];
    $f_email = $_REQUEST['f_email'];
    $f_idTipoEmpleado = $_REQUEST['f_idTipoEmpleado'];
    $f_idEstadoEmpleado = $_REQUEST['f_idEstadoEmpleado'];
    $f_fechaAltaDesde = $_REQUEST['f_fechaAltaDesde'];
    $f_fechaAltaHasta = $_REQUEST['f_fechaAltaHasta'];
    $arrEmpleados = Empleado::instance()->getEmpleados($f_nombreApellido, $f_email, $f_idTipoEmpleado, 
            $f_idEstadoEmpleado, $f_fechaAltaDesde, $f_fechaAltaHasta);
    $json_Empleados = json_encode($arrEmpleados);
    echo $json_Empleados;
}

function setEmpleado() {
    try {
        $idEmpleado = $_REQUEST['idEmpleado'];
        $nombreApellido = $_REQUEST['nombreApellido'];
        $email = $_REQUEST['email'];
        $celular = $_REQUEST['celular'];
        $telefono = $_REQUEST['telefono'];
        $idTipoEmpleado = $_REQUEST['idTipoEmpleado'];
        $idEstadoEmpleado = $_REQUEST['idEstadoEmpleado'];
        $idGenero = $_REQUEST['idGenero'];
        $fechaAlta = $_REQUEST['fechaAlta'];
        $fechaNacimiento = $_REQUEST['fechaNacimiento'];
        
        $returnValue = Empleado::instance()->setEmpleado($idEmpleado, $nombreApellido, $fechaNacimiento, $idGenero, 
                        $idEstadoEmpleado, $idTipoEmpleado, $email, $celular, $telefono, $fechaAlta);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setEmpleados(): ' . $ex->getMessage());
    }
}

function setRecibo() {
    try {
        $idRecibo = $_REQUEST['idRecibo'];
        $numeroRecibo = $_REQUEST['numeroRecibo'];
        $fecha = $_REQUEST['fecha'];
        $idEstudiante = $_REQUEST['idEstudiante'];
        $vecesPorSemana = $_REQUEST['vecesPorSemana'];
        $idClases = $_REQUEST['idClases'];
        $observaciones = $_REQUEST['observaciones'];
        $valor = $_REQUEST['valor'];
        $promocion = $_REQUEST['promocion'];
        $idFactura = $_REQUEST['idFactura'];
        
        $returnValue = Recibo::instance()->setRecibo($idRecibo, $numeroRecibo, $fecha, $idEstudiante, 
                        $vecesPorSemana, $idClases, $observaciones, $valor, $promocion, $idFactura);
        
        $json_returnValue = json_encode($idClases);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setRecibo(): ' . $ex->getMessage());
    }
}

function getRecibo_All() {
    $f_numeroRecibo = $_REQUEST['f_numeroRecibo'];
    $f_fechaDesde = $_REQUEST['f_fechaDesde'];
    $f_fechaHasta = $_REQUEST['f_fechaHasta'];
    $f_nombreEstudiante = $_REQUEST['f_nombreEstudiante'];
    $f_valor = $_REQUEST['f_valor'];
    $f_promocion = $_REQUEST['f_promocion'];
    $arrRecibos = Recibo::instance()->getRecibos($f_numeroRecibo, $f_fechaDesde, $f_fechaHasta, $f_nombreEstudiante, $f_valor, $f_promocion);
    $json_Recibos = json_encode($arrRecibos);
    echo $json_Recibos;
}

function getFactura_All() {
    $f_numeroFactura = $_REQUEST['f_numeroFactura'];
    $f_fechaDesde = $_REQUEST['f_fechaDesde'];
    $f_fechaHasta = $_REQUEST['f_fechaHasta'];
    $f_cliente = $_REQUEST['f_cliente'];
    $f_total = $_REQUEST['f_total'];
    $arrFacturas = Factura::instance()->getFacturas($f_numeroFactura, $f_cliente, $f_total, $f_fechaDesde, $f_fechaHasta);
    $json_Facturas = json_encode($arrFacturas);
    echo $json_Facturas;
}

function getLiquidacionesSueldo_All() {
    $f_mes = $_REQUEST['f_mes'];
    $f_año = $_REQUEST['f_año'];
    $f_nombreEmpleado = $_REQUEST['f_nombreEmpleado'];
    $f_valor = $_REQUEST['f_valor'];
    $f_observaciones = $_REQUEST['f_observaciones'];
    $arrLiquidaciones = LiquidacionSueldo::instance()->getLiquidacionesSueldo($f_mes, $f_año, $f_nombreEmpleado, $f_valor, $f_observaciones);
    $json_Liquidaciones = json_encode($arrLiquidaciones);
    echo $json_Liquidaciones;
}

function setFactura() {
    try {
        $idFactura = $_REQUEST['idFactura'];
        $numeroFactura = $_REQUEST['numeroFactura'];
        $fecha = $_REQUEST['fecha'];
        $idEstudiante = $_REQUEST['idEstudiante'];
        $idEmpresa = $_REQUEST['idEmpresa'];
        $cliente = $_REQUEST['cliente'];
        $domicilio = $_REQUEST['domicilio'];
        $localidad = $_REQUEST['localidad'];
        $telefono = $_REQUEST['telefono'];
        $cuit = $_REQUEST['cuit'];
        $detalle = $_REQUEST['detalle'];
        $total = $_REQUEST['total'];
        
        $returnValue = Factura::instance()->setFactura($idFactura, $numeroFactura, $idEstudiante, $idEmpresa,
                        $fecha, $cliente, $domicilio, $localidad, $telefono, null, null, null, null, null, null,
                        null, null, $cuit, null, $detalle, $total);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setFactura(): ' . $ex->getMessage());
    }
}

function setLiquidacionSueldo() {
    try {
        $idLiquidacionSueldo = $_REQUEST['idLiquidacionSueldo'];
        $mes = $_REQUEST['mes'];
        $año = $_REQUEST['año'];
        $idEmpleado = $_REQUEST['idEmpleado'];
        $valor = $_REQUEST['valor'];
        $observaciones = $_REQUEST['observaciones'];
        
        $returnValue = LiquidacionSueldo::instance()->setLiquidacionSueldo($idLiquidacionSueldo, $mes, $año, $idEmpleado, $valor, $observaciones);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setLiquidacionSueldo(): ' . $ex->getMessage());
    }
}

function generateLiquidacionSueldo() {
    try {
        $mes = $_REQUEST['mes'];
        $ano = $_REQUEST['ano'];
        
        $returnValue = LiquidacionSueldo::instance()->generateLiquidacionSueldo($mes, $ano);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/generateLiquidacionSueldo(): ' . $ex->getMessage());
    }
}

function getClase_All() {
    $f_emple_nombreApellido = $_REQUEST['f_emple_nombreApellido'];
    $f_idEstadoClase = $_REQUEST['f_idEstadoClase'];
    $f_idDia = $_REQUEST['f_idDia'];
    $f_descripcion = $_REQUEST['f_descripcion'];
    $arrClases = Clase::instance()->getClases($f_emple_nombreApellido, $f_idEstadoClase, $f_idDia, $f_descripcion);
    $json_Clases = json_encode($arrClases);
    echo $json_Clases;
}

function setClase() {
    $idClase = $_REQUEST['idClase'];
    $idEmpleado = $_REQUEST['idEmpleado'];
    $idEstadoClase = $_REQUEST['idEstadoClase'];
    $idDia = $_REQUEST['idDia'];
    $horaInicio = $_REQUEST['horaInicio'];
    $horaFin = $_REQUEST['horaFin'];
    $descripcion = $_REQUEST['descripcion'];
    $returnValue = Clase::instance()->setClase($idClase, $idEmpleado, $idEstadoClase, $idDia, $horaInicio, $horaFin, $descripcion);
    $json_returnValue = json_encode($returnValue);
    echo $json_returnValue;
}

function getEmpresa_All() {
    $f_razonSocial = $_REQUEST['f_razonSocial'];
    $f_contacto = $_REQUEST['f_contacto'];
    $f_telefono = $_REQUEST['f_telefono'];
    $f_domicilio = $_REQUEST['f_domicilio'];
    $f_cuit = $_REQUEST['f_cuit'];
    $f_idGestor = $_REQUEST['f_idGestor'];
    $arrEmpresas = Empresa::instance()->getEmpresas($f_razonSocial, $f_contacto, $f_telefono, $f_domicilio, $f_cuit, $f_idGestor);
    $json_Empresas = json_encode($arrEmpresas);
    echo $json_Empresas;
}

function setEmpresa() {
    $idEmpresa = $_REQUEST['idEmpresa'];
    $razonSocial = $_REQUEST['razonSocial'];
    $domicilio = $_REQUEST['domicilio'];
    $localidad = $_REQUEST['localidad'];
    $telefono = $_REQUEST['telefono'];
    $email = $_REQUEST['email'];
    $cuit = $_REQUEST['cuit'];
    $contacto = $_REQUEST['contacto'];
    $observaciones = $_REQUEST['observaciones'];
    $idGestor = $_REQUEST['idGestor'];
    $returnValue = Empresa::instance()->setEmpresa($idEmpresa, $razonSocial, $domicilio, $localidad, $telefono, $email, $cuit, $contacto, $observaciones, $idGestor);
    $json_returnValue = json_encode($returnValue);
    echo $json_returnValue;
}

function downloadEstudiantesMails() {
    $nombre_archivo = "../../temp/estudiantes_mails.txt";
    $mails = getMails();
    if($archivo = fopen($nombre_archivo, "w"))
    {
        fwrite($archivo, $mails);
        fclose($archivo);
    }
}

function getMails() {
    $mails = '';
    $i = 0;
  
    //Primero Obtenemos estudiantes Activos
    $f_nombreApellido = $_REQUEST['f_nombreApellido'];
    $f_email = $_REQUEST['f_email'];
    $f_celular = $_REQUEST['f_celular'];
    $f_idEstadoEstudiante = $_REQUEST['f_idEstadoEstudiante'];
    $f_fechaAltaDesde = $_REQUEST['f_fechaAltaDesde'];
    $f_fechaAltaHasta = $_REQUEST['f_fechaAltaHasta'];
    $f_idComoConocio = $_REQUEST['f_idComoConocio'];
    $f_fechaBajaDesde = $_REQUEST['f_fechaBajaDesde'];
    $f_fechaBajaHasta = $_REQUEST['f_fechaBajaHasta'];
    
    $arrEstudiantes = Estudiante::instance()->getEstudiantes($f_nombreApellido, $f_email, $f_celular, 
            $f_idEstadoEstudiante, $f_fechaAltaDesde, $f_fechaAltaHasta, $f_idComoConocio,
            $f_fechaBajaDesde, $f_fechaBajaHasta);
    
    foreach ($arrEstudiantes as $est) {
        if ($i === 0) {
            $mails .= $est->get_Email();
            $i = 1;
        } else
            $mails .= "\r\n" . $est->get_Email();
    }
    
    return $mails;
}

function getEmpleadosForDownloadComprobantes() {
    $mes = $_REQUEST['mes'];
    $año = $_REQUEST['año'];
        
    $arrIdsEmpleados = LiquidacionSueldo::instance()->getIdsEmpleadosForComprobanteDePago($mes, $año);
    return $arrIdsEmpleados;
}

function getMovimientosCCByIdCajaChica() {
    $f_idCajaChica = $_REQUEST['f_idCajaChica'];
    $f_descripcion = $_REQUEST['f_descripcion'];
    $f_idTipoMovimientoCC = $_REQUEST['f_idTipoMovimientoCC'];
        
    $arrMovimientosCajaChica = MovimientoCajaChica::instance()->getMovimientosCCByIdCajaChica($f_idCajaChica, $f_descripcion, $f_idTipoMovimientoCC);
    return $arrMovimientosCajaChica;
}

function setCajaChica() {
    try {
        $idCajaChica = $_REQUEST['idCajaChica'];
        $apertura = $_REQUEST['apertura'];
        $cierre = $_REQUEST['cierre'];
        $idEmpleado = $_REQUEST['idEmpleado'];
        $valorInicial = $_REQUEST['valorInicial'];
        
        $returnValue = CajaChica::instance()->setCajaChica($idCajaChica, $apertura, $cierre, $idEmpleado, $valorInicial);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setCajaChica(): ' . $ex->getMessage());
    }
}

function setMovimientoCajaChica() {
    try {
        $idMovimientoCajaChica = $_REQUEST['idMovimientoCajaChica'];
        $idCajaChica = $_REQUEST['idCajaChica'];
        $idTipoMoviminetoCC = $_REQUEST['idTipoMovimientoCC'];
        $idRecibo = $_REQUEST['idRecibo'];
        $descripcion = $_REQUEST['descripcion'];
        $valor = $_REQUEST['valor'];
        $idAdelanto = $_REQUEST['idAdelanto'];
        $idEmpleadoAdelanto = $_REQUEST['idEmpleadoAdelanto'];
        
        $returnValue = MovimientoCajaChica::instance()->setMovimientoCajaChica($idMovimientoCajaChica, $idCajaChica, $idTipoMoviminetoCC, $idRecibo, $descripcion, $valor, $idAdelanto, $idEmpleadoAdelanto);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setMovimientoCajaChica(): ' . $ex->getMessage());
    }
}

function deleteMovimientoCajaChica() {
    try {
        $idMovimientoCajaChica = $_REQUEST['idMovimientoCajaChica'];
        
        $returnValue = MovimientoCajaChica::instance()->deleteMovimientoCajaChica($idMovimientoCajaChica);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/deleteMovimientoCajaChica(): ' . $ex->getMessage());
    }
}

function getCajaChica_All() {
    $f_nombreEmpleado = $_REQUEST['f_nombreEmpleado'];
    $f_aperturaDesde = $_REQUEST['f_aperturaDesde'];
    $f_aperturaHasta = $_REQUEST['f_aperturaHasta'];
    $f_cierreDesde = $_REQUEST['f_cierreDesde'];
    $f_cierreHasta = $_REQUEST['f_cierreHasta'];
    $f_valorInicial = $_REQUEST['f_valorInicial'];
        
    $arrCajaChica = CajaChica::instance()->getCajaChica_All($f_nombreEmpleado, $f_aperturaDesde, $f_aperturaHasta, $f_cierreDesde, $f_cierreHasta, $f_valorInicial);
    $json_CajaChica = json_encode($arrCajaChica);
    echo $json_CajaChica;
}

function getCajaGrande_All() {
    $f_idTipoEgresoFijo = $_REQUEST['f_idTipoEgresoFijo'];
    $f_fechaDesde = $_REQUEST['f_fechaDesde'];
    $f_fechaHasta = $_REQUEST['f_fechaHasta'];
    $f_observacion = $_REQUEST['f_observacion'];
        
    $arrCajaGrande = CajaGrande::instance()->getCajaGrande_All($f_idTipoEgresoFijo, $f_fechaDesde, $f_fechaHasta, $f_observacion);
    return $arrCajaGrande;
}

function setCajaGrande() {
    try {
        $idCajaGrande = $_REQUEST['idCajaGrande'];
        $idTipoEgresoFijo = $_REQUEST['idTipoEgresoFijo'];
        $fecha = $_REQUEST['fecha'];
        $observacion = $_REQUEST['observacion'];
        $valor = $_REQUEST['valor'];
        $idMovimientoCajaChica = $_REQUEST['idMovimientoCajaChica'];
        $idAdelanto = $_REQUEST['idAdelanto'];
        $idEmpleadoAdelanto = $_REQUEST['idEmpleadoAdelanto'];
        
        $returnValue = CajaGrande::instance()->setCajaGrande($idCajaGrande, $idTipoEgresoFijo, $fecha, $observacion, $valor, $idMovimientoCajaChica, $idAdelanto, $idEmpleadoAdelanto);
        
        $json_returnValue = json_encode($returnValue);
        echo $json_returnValue;
    } catch (\Exception $ex) {
        echo json_encode('execfunction/setCajaGrande(): ' . $ex->getMessage());
    }
}

function getEstudiantesByIdClase() {
    $idClase = $_REQUEST['idClase'];
        
    $arrEstudiantes = Estudiante::instance()->getEstudiantesByIdClase($idClase);
    return $arrEstudiantes;
}