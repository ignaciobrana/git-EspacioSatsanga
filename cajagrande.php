<?php 
    include_once './iniPage.php'; 
    include_once './class/globalclass/database.php';
    include_once './class/business/cajaGrande.php';
    include_once './class/data/cajaGrande.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Espacio Satsanga - Caja Grande</title>
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
        <script src="./javascript/dbCajaGrande.js"></script>
        
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
                    <div class="row" >
                        <div class="sixteen columns">
                            <p class="tituloListado">Caja Grande</p>
                            
                            <div id="divCajaChica" class="recuadro" style="margin-bottom:5px;" >
                                <div class="sixteen columns">
                                    <div id="divDatosCG">
                                        <div>
                                            <span class="spLegenda">Ingresos del Mes: </span>
                                            <span id="spIngresosMes" class="spDescripcion">150000</span><br>
                                            <span class="spLegenda">Egresos del Mes: </span> 
                                            <span id="spEgresosMes" class="spDescripcion">90000</span><br>
                                            <span class="spLegenda">Valor Total: </span>
                                            <span id="spValorTotal" class="spDescripcion">123</span><br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="jsGrid"></div>

                            <div id="detailsDialog">
                                <form id="detailsForm">
                                    <div class="tabla">
                                        <div>
                                            <div class="col1"><label for="fecha">Fecha:</label></div>
                                            <div class="col2"><input id="dFecha" name="dFecha" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="tipoEgresoFijo">Tipo Egreso:</label></div>
                                            <div class="col2"><select name="sTipoEgresoFijo" id="sTipoEgresoFijo" class="select2"></select></div>
                                        </div>
                                        <div id="divEmpleadoAdelanto">
                                            <div class="col1"><label for="empleado">Empleado:</label></div>
                                            <div class="col2"><select name="sEmpleadoAdelanto" id="sEmpleadoAdelanto" class="select2"></select></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="observacion">Observación:</label></div>
                                            <div class="col2"><input id="tObservacion" name="tObservacion" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="valor">Valor:</label></div>
                                            <div class="col2"><input id="tValor" name="tValor" type="text" /></div>
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
        <div id="dialog-message-IngresoAutomatico" title="Atención!" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              No se puede modificar un ingreso a la caja grande que fue realizado desde un retiro de la "caja chica".
            </p>
        </div>
    </body>
</html>