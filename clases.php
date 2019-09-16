<?php 
    include_once './iniPage.php'; 
    include_once './class/globalclass/database.php';
    include_once './class/business/clase.php';
    include_once './class/data/clase.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Espacio Satsanga - Clases</title>
        <link rel="icon" type="image/x-icon" href="./img/icon.png">
        
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        
        <link id="boc-style-css" href="./css/style.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" id="boc-fonts-css" href="http://fonts.googleapis.com/css?family=Lato%3A400%2C700%2C900%7COpen+Sans%3A300italic%2C400italic%2C600italic%2C400%2C300%2C600%2C900%7CPT+Serif%3A400%2C400italic&amp;ver=4.9.6" type="text/css" media="all">

        <link rel="stylesheet" type="text/css" href="./css/jsgrid.css" />
        <link rel="stylesheet" type="text/css" href="./css/theme.css" />
        <link rel="stylesheet" type="text/css" href="./css/formulario.css" />
        
        <link href="./css/select2.min.css" rel="stylesheet"/>
        <link href="./css/wickedpicker.css" rel="stylesheet"/>
                
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/cupertino/jquery-ui.css">
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>        
        
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
                
        <!--script para configurar lenguajes del datepicker-->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>
        
        <script src="./javascript/common.js"></script>
        <script src="./javascript/dbClases.js"></script>
        
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
        
        <script type="text/javascript" src="./javascript/wickedpicker.js"></script>
                
    </head>
    <body>
        <div id="wrapper" class="full_wrapper ">
  	
            <?php include_once './control/header.php';?>
            
            <div style="height: 100%">
                <!-- Container Row -->
                <div class="container">
                    <div class="row">
			            <div class="sixteen columns">
                            <p class="tituloListado">Listado de Clases</p>
                            
                            <div id="jsGrid"></div>

                            <div id="detailsDialog">
                                <form id="detailsForm">
                                    <div class="tabla">
                                        <div>
                                            <div class="col1"><label for="empleado">Empleado:</label></div>
                                            <div class="col2"><select name="sEmpleado" id="sEmpleado" class="select2" ></select></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="dia">Día:</label></div>
                                            <div class="col2"><select name="sDia" id="sDia" class="select2" ></select></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="horaInicio">Hora Inicio:</label></div>
                                            <div class="col2"><input type="text" id="tHoraInicio" name="tHoraInicio" class="timepicker"/></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="horaFin">Hora Fin:</label></div>
                                            <div class="col2"><input type="text" id="tHoraFin" name="tHoraFin" class="timepicker"/></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="estado">Estado:</label></div>
                                            <div class="col2"><select name="sEstado" id="sEstado" class="select2" ></select></div>
                                        </div>                                      
                                        <div>
                                            <div class="col1"><label for="descripcion">Descripción:</label></div>
                                            <div class="col2"><textarea id="tDescripcion" name="tDescripcion"></textarea></div>
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
        <div id="error-message-HorasIncorrectas" title="Atención!!" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              La hora de Inicio debe ser menor a la hora de finalización de la clase.
            </p>
        </div>
        <div id="error-message-claseDuplicada" title="Atención!!" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              Ya existe una clase para el día y la hora indicada!
            </p>
        </div>
        <div id="divEstudiantes" title="Estudiantes" style="display: none;">
            <p>
                <div id="jsEstudiantes"></div>
            </p>
        </div>
    </body>
</html>