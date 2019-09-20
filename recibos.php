<?php 
    include_once './iniPage.php'; 
    include_once './class/globalclass/database.php';
    include_once './class/business/recibo.php';
    include_once './class/data/recibo.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Espacio Satsanga - Recibos</title>
        <link rel="icon" type="image/x-icon" href="./img/icon.png">
        
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        
        <link id="boc-style-css" href="./css/style.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" id="boc-fonts-css" href="http://fonts.googleapis.com/css?family=Lato%3A400%2C700%2C900%7COpen+Sans%3A300italic%2C400italic%2C600italic%2C400%2C300%2C600%2C900%7CPT+Serif%3A400%2C400italic&amp;ver=4.9.6" type="text/css" media="all">

        <link rel="stylesheet" type="text/css" href="./css/jsgrid.css" />
        <link rel="stylesheet" type="text/css" href="./css/theme.css" />
        <link rel="stylesheet" type="text/css" href="./css/formulario.css" />
        
        <link href="./css/select2.min.css" rel="stylesheet"/>
                
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/cupertino/jquery-ui.css">
        
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
                
        <!--script para configurar lenguajes del datepicker-->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>
        
        <script src="./javascript/common.js"></script>
        <script src="./javascript/dbRecibos.js"></script>
        
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
    </head>
    <body>
        <div id="wrapper" class="full_wrapper ">
  	
            <?php include_once './control/header.php';?>
            
            <div style="height: 100%">
                <!-- Container Row -->
                <div class="container">
                    <div class="row">
			<div class="sixteen columns">
                            <p class="tituloListado">Listado de Recibos</p>
                            
                            <div id="jsGrid"></div>

                            <div id="detailsDialog">
                                <form id="detailsForm">
                                    <div class="tabla">
                                        <div>
                                            <div class="col1"><label for="numeroRecibo">N° Recibo:</label></div>
                                            <div class="col2"><input id="tNumeroRecibo" name="tNumeroRecibo" type="number" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="estudiante">Asociar Factura:</label></div>
                                            <div class="col2">
                                                <select name="sFactura" id="sFactura" class="select2" ></select>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="estudiante">Estudiante:</label></div>
                                            <div class="col2">
                                                <select name="sEstudiante" id="sEstudiante" class="select2" ></select>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="valor">Valor:</label></div>
                                            <div class="col2"><input id="tValor" name="tValor" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="fecha">Fecha:</label></div>
                                            <div class="col2"><input id="dFecha" name="dFecha" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="fecha">Promo:</label></div>
                                            <div class="col2"><input id="tPromocion" name="tPromocion" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="vecesPorSemana">Veces por semana:</label></div>
                                            <div class="col2"><input id="tVecesPorSemana" name="tVecesPorSemana" type="number" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="clases">Clases:</label></div>
                                            <div class="col2">
                                                <select name="sClases" id="sClases" class="select2" multiple ></select>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="proximoMes">Valido para el próximo mes:</label></div>
                                            <div class="col2">
                                                <input id="cbProximoMes" name="cbProximoMes" type="checkbox" style="text-align: left; width: 13px; margin-left: 0px;margin-right: 0px;margin-top: 10px;" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="observaciones">Observaciones:</label></div>
                                            <div class="col2"><textarea id="tObservaciones" name="tObservaciones"></textarea></div>
                                        </div>
                                        
                                        <div class="derecha">
                                            <button type="submit" id="bGuardar">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
			</div>
                    </div>
                </div>
                <!-- Container Row :: END -->
            </div>
            
            <!-- Footer -->
            <?php include_once './control/footer.php';?>
            <!-- Footer::END -->
        </div>
        <div id="dialog-message" title="Datos incompletos" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              Complete todos los campos requeridos!
            </p>
        </div>
        <div id="error-message-NumRecibo" title="Atención!!" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              Por favor valide el Número de Recibo ingresado. Ya existe uno con ese mismo valor.
            </p>
        </div>
        <div id="error-message-ReciboEstudianteMes" title="Atención!!" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              Ya existe un recibo asociado para el estudiante en el mes seleccionado.
            </p>
        </div>
    </body>
</html>