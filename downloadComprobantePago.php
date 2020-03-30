<?php
include_once './iniPage.php';
include_once './class/model/comprobantePago.php';
include_once './class/model/adelanto.php';
include_once './class/model/movimientoCajaChica.php';
include_once './class/model/empleado.php';
include_once './class/model/tipoMovimientoCC.php';
include_once './class/model/estadoEmpleado.php';
include_once './class/model/tipoEmpleado.php';
include_once './class/model/cajaGrande.php';

include_once './class/globalclass/database.php';
include_once './class/business/liquidacionSueldo.php';
include_once './class/data/liquidacionSueldo.php';
require_once './tcpdf/tcpdf.php';

$mes = $_REQUEST['mes'];
$año = $_REQUEST['año'];
$idEmpleado = $_REQUEST['idEmpleado'];

$comprobante = \Business\LiquidacionSueldo::instance()->getComprobantesDePagoByIdEmpleado($mes, $año, $idEmpleado);
createAndDownLoadPDF($comprobante, $mes, $año);

function createAndDownLoadPDF($comp, $mes, $año) {
    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Satsanga');
    $pdf->SetTitle('Comprobante de pago');

    $pdf->setPrintHeader(false); 
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(20, 20, 20, false); 
    $pdf->SetAutoPageBreak(true, 20); 
    $pdf->SetFont('Helvetica', '', 10);
    $pdf->addPage();

    $nombreMes = GlobalClass\Utils::getMonthByNumberOf($mes);
    $content = '';

    // set JPEG quality
    //$pdf->setJPEGQuality(75);

    // Image method signature:
    // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

    // Image example with resizing
    $pdf->Image('./img/headerlogo.png', 22, 22, 70, 25, 'png', 'https://www.espaciosatsanga.com/', '', true, 300, '', false, false, 0, false, false, false);

    $content .= '
        <div style="border: 2px solid black; border-radius: 10px; padding: 10px; display:inline-block;">
            <table style="border-bottom: 1px solid black;">
                <tr>
                    <td style="width: 220px; height: 80px;">&nbsp;</td>
                    <td style="vertical-align: bottom;">
                        <br><br><br><br><br><br>                        
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        Comprobante de pago correspondiente <br>
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;
                        a ' . $nombreMes .  ' ' . $año . '.
                    </td>
                </tr>
            </table><br><br>
            &nbsp;<b>Profesor/a:</b> ' . $comp->get_NombreApellido() . ' <br><br>
            <table style="width: 100%; margin-top: 5px;">
                <tr style="text-align: center;">
                    <th><b>Número de Recibo</b></th>
                    <th style="width: 100px;"><b>Valor Cuota</b></th>
                    <th style="width: 160px;"><b>Valor Profesor</b></th>
                </tr>';
    
    $totalRecibos = 0;
    $totalAdelantos = 0;
    $leyendaRecCompartido = false;
    $leyendaRecEmpresa = false;

    foreach($comp->_recibosDeComprobante as $recComp) {
        $content .= '<tr style="text-align: center;"><td>' . $recComp->get_NumeroRecibo();
        if($recComp->get_ReciboCompartido()) {
            $content .= '(*)';
            $leyendaRecCompartido = true;
        }
        if($recComp->get_ReciboDeEmpresa()) {
            $content .= '(**)';
            $leyendaRecEmpresa = true;
        }
        $content .= '</td>';
        
        $content .= '<td>' . $recComp->get_ValorRecibo() . '</td>';
        $content .= '<td>' . $recComp->get_ValorProfe() . '</td>';
        $content .= '</tr>';
        
        $totalRecibos += $recComp->get_ValorProfe();
        
    }

    $content .= '
            <tr style="text-align: center;">
                <td>&nbsp;</td>
                <td style="border-top: 1px solid black;"><b>Total Recibos:</b></td>
                <td style="border-top: 1px solid black;"><b>$' . $totalRecibos . '</b></td>
            </tr>
        </table>';

    if (count($comp->_adelantos) > 0) {
        $content .='<br><table style="width: 100%; margin-top: 5px;">
                <tr style="text-align: center;">
                    <th><b>Fecha Adelanto</b></th>
                    <th style="width: 100px;">&nbsp;</th>
                    <th style="width: 160px;"><b>Valor Adelanto</b></th>
                </tr>';
        foreach($comp->_adelantos as $adelanto) {
            $totalAdelantos += (-1) * $adelanto->_movimientoCajaChica->_valor;
            $content .= '<tr style="text-align: center;"><td>' . $adelanto->get_Fecha() . '</td>';
            $content .= '<td>&nbsp;</td><td>' . ($adelanto->_movimientoCajaChica->get_Valor() * (-1)) . '</td></tr>';
        }
        $content .= '<tr style="text-align: center;">
                        <td>&nbsp;</td>
                        <td style="border-top: 1px solid black;"><b>Total Adelantos:</b></td>
                        <td style="border-top: 1px solid black;"><b>$' . $totalAdelantos . '</b></td>
                    </tr>
                </table>';
    }

    $content .='<br><table style="width: 100%; margin-top: 5px;">
                <tr style="text-align: center;">
                    <th>&nbsp;</th>
                    <th style="width: 100px;"><b>Total a Cobrar:</b></th>';

    if ($totalAdelantos != 0) {
        $content .= '<th style="width: 160px;"><b>$' . $totalRecibos . ' - $' . $totalAdelantos . ' = $' .                  ($totalRecibos - $totalAdelantos) . '</b></th></tr></table>';
    } else {
        $content .= '<th style="width: 160px;"><b>$' . $totalRecibos . '</b></th></tr></table>';
    }
    
    if ($leyendaRecCompartido)
        $content .= '<h5>&nbsp;&nbsp;&nbsp;&nbsp;(*)Recibos compartidos con otros profesores</h5>';
    if ($leyendaRecEmpresa)
        $content .= '<h5>&nbsp;&nbsp;&nbsp;&nbsp;(**)Recibos pertenecientes a clases en empresa</h5>';
    
    $content .= '</div>';

    $pdf->writeHTML($content, true, 0, true, 0, '');

    $pdf->lastPage();
    $pdf->output($comp->get_nombreApellido() . '.pdf', 'D');
}