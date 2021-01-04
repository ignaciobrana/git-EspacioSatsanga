<?php 
    include_once './iniPage.php'; 
    /*include_once './class/globalclass/database.php';
    include_once './class/business/liquidacionSueldo.php';
    include_once './class/data/liquidacionSueldo.php';*/
?>
<html>
    <head>
        <title>Reporte comprobante Pago</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="icon" type="image/x-icon" href="./img/icon.png">
        
        <!--[if lt IE 9]><script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        
        <link id="boc-style-css" href="./css/style.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" id="boc-fonts-css" href="https://fonts.googleapis.com/css?family=Lato%3A400%2C700%2C900%7COpen+Sans%3A300italic%2C400italic%2C600italic%2C400%2C300%2C600%2C900%7CPT+Serif%3A400%2C400italic&amp;ver=4.9.6" type="text/css" media="all">

        <link rel="stylesheet" type="text/css" href="./css/jsgrid.css" />
        <link rel="stylesheet" type="text/css" href="./css/theme.css" />
        <link rel="stylesheet" type="text/css" href="./css/formulario.css" />
        
        <link href="./css/select2.min.css" rel="stylesheet"/>
                
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/cupertino/jquery-ui.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
                
        <!--script para configurar lenguajes del datepicker-->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>
        
        <script src="./javascript/common.js"></script>
        <script src="./javascript/constants.js"></script>
        <script src="./javascript/dbLiquidacionSueldo.js"></script>
        
        <script src="./javascript/src/jsgrid.core.js"></script>
        <script src="./javascript/src/jsgrid.load-indicator.js"></script>
        <script src="./javascript/src/jsgrid.load-strategies.js"></script>
        <script src="./javascript/src/jsgrid.sort-strategies.js"></script>
        <script src="./javascript/src/jsgrid.validation.js"></script>
        <script src="./javascript/src/jsgrid.field.js"></script>
        <script src="./javascript/src/fields/jsgrid.field.text.js"></script>
        <script src="./javascript/src/fields/jsgrid.field.number.js"></script>
        <script src="./javascript/src/fields/jsgrid.field.select.js"></script>
        <script src="./javascript/src/fields/jsgrid.field.checkbox.js"></script>
        <script src="./javascript/src/fields/jsgrid.field.control.js"></script>
        <script src="./javascript/src/fields/jsgrid.field.date.js"></script>
        <script src="./javascript/src/i18n/es.js"></script>
        
        <script src="./javascript/select2/select2.min.js"></script>
        <script src="./javascript/select2/i18n/es.js"></script>
        
        <script type="text/javascript">
            $(function() {
                //window.open("./pdf_test.php", "pdftest", "width=1, height=1");
                //Usaremos un link para iniciar la descarga
                var save = document.createElement('a');
                save.href = './pdf_test.php';
                save.target = '_blank';
                //Truco: así le damos el nombre al archivo 
                //save.download = 'estudiantes_mails.txt';
                var clicEvent = new MouseEvent('click', {
                  'view': window,
                  'bubbles': true,
                  'cancelable': true
                });
                //Simulamos un clic del usuario
                //no es necesario agregar el link al DOM.
                save.dispatchEvent(clicEvent);
                //Y liberamos recursos...
                (window.URL || window.webkitURL).revokeObjectURL(save.href);
            });
        </script>
    </head>
    <body>
        <?php include_once './control/header.php';?>
        <div style="border: 2px solid black; border-radius: 10px; padding: 10px; display:inline-block;">
            <table style="border-bottom: 1px solid black;">
                <tr>
                    <td>
                        <img src="./img/headerlogo.png" style="width:50%;" alt="Espacio Satsanga">
                    </td>
                    <td>
                        Buenos Aires, 2 de Enero del 2019
                    </td>
                </tr>
            </table>
            <table style="width: 100%; margin-top: 5px;">
                <thead>
                    <tr>
                        <th style="text-align: left;">Número de Recibo</th>
                        <th style="width: 100px;">Valor Cuota</th>
                        <th style="width: 160px;">Valor Profesor</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <tr style="border-bottom: 1px black solid;">
                        <td style="text-align: left;">3015</td>
                        <td>$1200</td>
                        <td>$600</td>
                    </tr>
                    <tr style="border-bottom: 1px black solid;">
                        <td style="text-align: left;">3025</td>
                        <td>$1000</td>
                        <td>$500</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right;"><b>Total a cobrar:</b></td>
                        <td style="text-align: center;"><b>$1100</b></td>
                    </tr>
                </tfoot>
            </table>
            <p style="margin: 0px; font-size: small;">(*)Recibos compartidos con otros profesores</p>
            <p style="margin: 0px; font-size: small;">(**)Recibos pertenecientes a clases en empresa</p>
        </div>
        <?php include_once './control/footer.php';?>
    </body>
</html>