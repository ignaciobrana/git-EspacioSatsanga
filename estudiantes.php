<?php 
    include_once './iniPage.php'; 
    include_once './class/globalclass/database.php';
    include_once './class/business/estudiante.php';
    include_once './class/data/estudiante.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Espacio Satsanga - Estudiantes</title>
        <link rel="icon" type="image/x-icon" href="./img/icon.png">
        
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        
        <link id="boc-style-css" href="./css/style.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" id="boc-fonts-css" href="http://fonts.googleapis.com/css?family=Lato%3A400%2C700%2C900%7COpen+Sans%3A300italic%2C400italic%2C600italic%2C400%2C300%2C600%2C900%7CPT+Serif%3A400%2C400italic&amp;ver=4.9.6" type="text/css" media="all">

        <link rel="stylesheet" type="text/css" href="./css/jsgrid.css" />
        <link rel="stylesheet" type="text/css" href="./css/theme.css" />
        <link rel="stylesheet" type="text/css" href="./css/formulario.css" />
                
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/cupertino/jquery-ui.css">
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
                
        <!--script para configurar lenguajes del datepicker-->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>
        
        <script src="./javascript/common.js"></script>
        <script src="./javascript/constants.js"></script>
        <script src="./javascript/dbEstudiantes.js"></script>
        
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

        <script src="./javascript/alarmas.js"></script>

    </head>
    <body>
        <div id="wrapper" class="full_wrapper ">
  	
            <?php include_once './control/header.php';?>
            
            <div style="height: 100%">
                <!-- Container Row -->
                <div class="container">
                    <div class="row">
			            <div class="sixteen columns">
                            <p class="tituloListado">Listado de Alumnos</p>
                            
                            <div id="jsGrid"></div>

                            <div id="detailsDialog">
                                <form id="detailsForm">
                                    <div class="tabla">
                                        <div>
                                            <div class="col1"><label for="nombreApellido">Nombre y Apellido:</label></div>
                                            <div class="col2"><input id="tNombreApellido" name="tNombreApellido" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="fechaAlta">Fecha Alta:</label></div>
                                            <div class="col2"><input id="dFechaAlta" name="dFechaAlta" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="genero">Genero:</label></div>
                                            <div class="col2"><select name="sGenero" id="sGenero"></select></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="estado">Estado:</label></div>
                                            <div class="col2"><select name="sEstado" id="sEstado"></select></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="fechaBaja">Fecha Baja:</label></div>
                                            <div class="col2"><input id="dFechaBaja" name="dFechaBaja" type="text" disabled="false" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="email">Email:</label></div>
                                            <div class="col2"><input id="tEmail" name="tEmail" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="celular">Celular:</label></div>
                                            <div class="col2"><input id="tCelular" name="tCelular" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="telefono">Teléfono:</label></div>
                                            <div class="col2"><input id="tTelefono" name="tTelefono" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="fechaNacimiento">Fecha Nacimiento:</label></div>
                                            <div class="col2"><input id="dFechaNacimiento" name="dFechaNacimiento" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="comoConocio">Como Conoció?</label></div>
                                            <div class="col2"><select name="sComoConocio" id="sComoConocio"></select></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="observaciones">Observaciones</label></div>
                                            <div class="col2"><textarea id="tObservaciones" name="tObservaciones" ></textarea></div>
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
        <?php include_once './control/mensajesAlarmas.php';?>
    </body>
</html>