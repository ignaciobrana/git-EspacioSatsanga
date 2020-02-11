<?php 
    include_once './iniPage.php'; 
    include_once './class/globalclass/database.php';
    include_once './class/business/factura.php';
    include_once './class/data/factura.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Espacio Satsanga - Facturas</title>
        <link rel="icon" type="image/x-icon" href="./img/icon.png">
        
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        
        <link id="boc-style-css" href="./css/style.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" id="boc-fonts-css" href="http://fonts.googleapis.com/css?family=Lato%3A400%2C700%2C900%7COpen+Sans%3A300italic%2C400italic%2C600italic%2C400%2C300%2C600%2C900%7CPT+Serif%3A400%2C400italic&amp;ver=4.9.6" type="text/css" media="all">

        <link rel="stylesheet" type="text/css" href="./css/jsgrid.css" />
        <link rel="stylesheet" type="text/css" href="./css/theme.css" />
        <link rel="stylesheet" type="text/css" href="./css/formulario.css" />
        
        <link href="./css/select2.min.css" rel="stylesheet"/>
                
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/cupertino/jquery-ui.css">
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>        
        
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
                
        <!--script para configurar lenguajes del datepicker-->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>
        
        <script src="./javascript/common.js"></script>
        <script src="./javascript/constants.js"></script>
        <script src="./javascript/dbFacturas.js"></script>
        
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
                            <p class="tituloListado">Listado de Facturas</p>
                            
                            <div id="jsGrid"></div>

                            <div id="detailsDialog">
                                <form id="detailsForm">
                                    <div class="tabla">
                                        <div>
                                            <div class="col1"><label for="numeroFactura">N° Factura:</label></div>
                                            <div class="col2"><input id="tNumeroFactura" name="tNumeroFactura" type="number" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="fecha">Fecha:</label></div>
                                            <div class="col2"><input id="dFecha" name="dFecha" type="text" /></div>
                                        </div>
                                        
                                        <div>
                                            <div class="col1"><label for="para">Factura para:</label></div>
                                            <div class="col2">
                                                <label for="rEstudiante" class="radioButton">Estudiante</label>
                                                <input type="radio" name="rFacturaPara" id="rEstudiante" value="estudiante">
                                                <label for="rEmpresa" class="radioButton">Empresa</label>
                                                <input type="radio" name="rFacturaPara" id="rEmpresa" value="empresa">
                                            </div>
                                        </div>
                                        <div id="divEstudiante">
                                            <div class="col1"><label for="estudiante">Estudiante:</label></div>
                                            <div class="col2">
                                                <select name="sEstudiante" id="sEstudiante" class="select2" ></select>
                                            </div>
                                        </div>
                                        <div id="divEmpresa">
                                            <div class="col1"><label for="estudiante">Empresa:</label></div>
                                            <div class="col2">
                                                <select name="sEmpresa" id="sEmpresa" class="select2" ></select>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="cliente">Cliente:</label></div>
                                            <div class="col2"><input id="tCliente" name="tCliente" type="text" /></div>
                                        </div>
                                        
                                        <div>
                                            <div class="col1"><label for="domicilio">Domicilio:</label></div>
                                            <div class="col2"><input id="tDomicilio" name="tDomicilio" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="localidad">Localidad:</label></div>
                                            <div class="col2"><input id="tLocalidad" name="tLocalidad" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="telefono">Teléfono:</label></div>
                                            <div class="col2"><input id="tTelefono" name="tTelefono" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="cuit">CUIT:</label></div>
                                            <div class="col2"><input id="tCuit" name="tCuit" type="text" /></div>
                                        </div>
                                        
                                        <div>
                                            <div class="col1"><label for="detalle">Detalle:</label></div>
                                            <div class="col2"><textarea id="tDetalle" name="tDetalle"></textarea></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="total">Total:</label></div>
                                            <div class="col2"><input id="tTotal" name="tTotal" type="text" /></div>
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
        <div id="error-message-NumFactura" title="Atención!!" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              Por favor valide el Número de Factura ingresado. Ya existe una con ese mismo valor.
            </p>
        </div>
    </body>
</html>