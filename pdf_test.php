<?php 
	require_once('tcpdf/tcpdf.php');
        
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Satsanga');
	$pdf->SetTitle('Comprobante de pago');
	
	$pdf->setPrintHeader(false); 
	$pdf->setPrintFooter(false);
	$pdf->SetMargins(20, 20, 20, false); 
	$pdf->SetAutoPageBreak(true, 20); 
	$pdf->SetFont('Helvetica', '', 10);
	$pdf->addPage();

	$content = '';
        
        // set JPEG quality
        //$pdf->setJPEGQuality(75);

        // Image method signature:
        // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

        // Image example with resizing
        $pdf->Image('./img/headerlogo.png', 22, 22, 70, 25, 'png', 'http://www.espaciosatsanga.com/', '', true, 300, '', false, false, 0, false, false, false);

	$content .= '
		<div style="border: 2px solid black; border-radius: 10px; padding: 10px; display:inline-block;">
            <table style="border-bottom: 1px solid black;">
                <tr>
                    <td style="width: 230px; height: 80px;">
                        
                    </td>
                    <td style="vertical-align: bottom;">
                        <br><br><br><br><br><br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Buenos Aires, 2 de Enero del 2019
                    </td>
                </tr>
            </table><br><br>
            &nbsp;<b>Profesor:</b> José Alvarez<br>
            <table style="width: 100%; margin-top: 5px;">
                <tr style="text-align: center;">
                    <th><b>Número de Recibo</b></th>
                    <th style="width: 100px;"><b>Valor Cuota</b></th>
                    <th style="width: 160px;"><b>Valor Profesor</b></th>
                </tr>
                <tr style="text-align: center;">
                    <td>3015(*)</td>
                    <td>$1200</td>
                    <td>$600</td>
                </tr>
                <tr style="text-align: center;">
                    <td>3025</td>
                    <td>$1000</td>
                    <td>$500</td>
                </tr>
                <tr style="text-align: center;">
                    <td></td>
                    <td style="border-top: 1px solid black;"><b>Total a cobrar:</b></td>
                    <td style="border-top: 1px solid black;"><b>$1100</b></td>
                </tr>
            </table>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;(*)Recibos compartidos con otros profesores</h5>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;(**)Recibos pertenecientes a clases en empresa</h5>
        </div>
	';
	
	$pdf->writeHTML($content, true, 0, true, 0, '');
        
	//$pdf->lastPage();
	$pdf->output('Reporte.pdf', 'D');
//}