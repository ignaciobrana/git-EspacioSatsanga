<?php
include_once './iniPage.php';
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Gestión Espacio Satsanga</title>
        
        <link rel="icon" type="image/x-icon" href="./img/icon.png">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/styleLogin.css">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/cupertino/jquery-ui.css">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="./javascript/common.js"></script>
    </head>
    <body>
        <div id="Contenedor">
            <div>
                <!--Icono de usuario-->
                <img id="HeaderLogo" src="./img/headerlogo.png"/>
            </div>
            <div class="ContentForm" style="margin-top: 8%;">
                <form action="" method="post" name="frmLogin">
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" style="padding-right: 19px;padding-left: 19px;"><img src="./img/user.png" style="width: 18px;" /></span>
                        <input name="txtNombreUsuario" type="text" class="form-control" placeholder="Nombre de Usuario" aria-describedby="sizing-addon1" required>
                    </div>
                    <br>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="sizing-addon1"><img src="./img/lock.png" style="width: 24px;" /></span>
                        <input name="txtPassword" type="password" class="form-control" placeholder="******" aria-describedby="sizing-addon1" required>
                    </div>
                    <br>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" id="IngresoLog" type="submit">Entrar</button>
                </form>
            </div>	
        </div>
        
        <div id="dialog-message" title="Acceso incorrecto" style="display: none;">
            <p>
              <span class="ui-icon ui-icon-close" style="float:left; margin:0 7px 50px 0;"></span>
              El usuario y/o la contraseña son incorrectas.
            </p>
        </div>
    </body>
</html>

<?php
try {
    if(isset($_POST['txtNombreUsuario']) && isset($_POST['txtPassword'])) {
        $user = \Business\Login::instance()->getUser($_POST['txtNombreUsuario'], $_POST['txtPassword']);
        if ($user != null){
            //Seteamos usuario en session y redireccionamos al panel
           \GlobalClass\Session::setSession($user->get_IdUsuario(), $user->get_NombreUsuario());
           //header('Location: estudiantes.php');
           //exit();
	   echo '<script type="text/javascript">location.href="estudiantes.php";</script>';
	   die();
        } else {
            echo '<script type="text/javascript">showModalMessage("#dialog-message");</script>';
        }
    }
} catch(Exception $ex) {
    echo 'Error Login.php: ' . $ex->getMessage();
}