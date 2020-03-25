<?php 
    mb_http_output('UTF-8');
    header('Content-Type: text/html; charset=' . mb_http_output());
    //header('Content-Type: text/html; charset=UTF-8');
    
    //directorio del proyecto
    define("PROJECTPATH", dirname(__DIR__) . '\EspacioSatsanga');
    //En hosting descomentar la siguiente linea y comentar la anterior
    //define("PROJECTPATH", dirname(__DIR__) . '/gestion');
    
    
    //directorio app
    define("APPPATH", PROJECTPATH);
    
    //autoload con namespaces
    function autoload_classes($class_name)
    {
        $filename =  PROJECTPATH . '/class/' . strtolower(str_replace('\\', '/', $class_name) .'.php');
        if(is_file($filename))
        {
            try { require $filename; } 
            catch (\Exception $ex) { echo '<br> error haciendo el requiere -> ' . $ex->getMessage();}
        }
    }
    //registramos el autoload autoload_classes
    spl_autoload_register('autoload_classes');
    
    include_once './class/globalclass/database.php';
    include_once './class/business/estudiante.php';
    include_once './class/data/estudiante.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Espacio Satsanga - Estudiantes</title>
        <link rel="icon" type="image/x-icon" href="./img/icon.png">
        
        <!--[if lt IE 9]><script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        
        <link id="boc-style-css" href="./css/style.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" id="boc-fonts-css" href="https://fonts.googleapis.com/css?family=Lato%3A400%2C700%2C900%7COpen+Sans%3A300italic%2C400italic%2C600italic%2C400%2C300%2C600%2C900%7CPT+Serif%3A400%2C400italic&amp;ver=4.9.6" type="text/css" media="all">

        <link rel="stylesheet" type="text/css" href="./css/theme.css" />
        <link rel="stylesheet" type="text/css" href="./css/formulario.css" />

        <link href="./css/select2.min.css" rel="stylesheet"/>
                
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/cupertino/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
                
        <!--script para configurar lenguajes del datepicker-->
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>
        
        <script src="./javascript/common.js"></script>
        <script src="./javascript/constants.js"></script>
        <script src="./javascript/estudianteNuevo.js"></script>

        <script src="./javascript/select2/select2.min.js"></script>
        <script src="./javascript/select2/i18n/es.js"></script>
    </head>
    <body>
        <div id="wrapper" class="full_wrapper ">
  	
            <?php include_once './control/header2.php';?>
            
            <div style="height: 100%">
                <!-- Container Row -->
                <div class="container">
                    <div class="row">
			            <div class="sixteen columns">
                            <p class="tituloListado">Estudiante Nuevo</p>
                            
                            <div id="detailsDialog">
                                <form id="detailsForm">
                                    <div class="tabla">
                                        <div>
                                            <div class="col1"><label for="nombreApellido">Nombre y Apellido:</label></div>
                                            <div class="col2"><input id="tNombreApellido" name="tNombreApellido" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="genero">Genero:</label></div>
                                            <div class="col2"><select name="sGenero" id="sGenero" class="select2" ></select></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="email">Email:</label></div>
                                            <div class="col2"><input id="tEmail" name="tEmail" type="text" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="email2">Confirme su Email:</label></div>
                                            <div class="col2"><input id="tEmail2" name="tEmail2" type="text" /></div>
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
                                            <div class="col2"><input id="dFechaNacimiento" name="dFechaNacimiento" type="text" placeholder="dd/mm/aaaa" onKeyUp="this.value = formatearfecha(this.value);" /></div>
                                        </div>
                                        <div>
                                            <div class="col1"><label for="comoConocio">Como Conoció?</label></div>
                                            <div class="col2"><select name="sComoConocio" id="sComoConocio" class="select2" ></select></div>
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
        <div id="dm-GuardadoCorrectamente" title="Bienvenido!" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              Bienvenido al espacio Satsanga. Que disfrutes de tu práctica!!
            </p>
        </div>
    </body>
</html>