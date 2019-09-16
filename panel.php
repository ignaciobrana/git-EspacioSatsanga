<?php
include_once './iniPage.php';
include_once './class/globalclass/execfunction.php';
?>
<html>
    <header>
        <title>hola</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="./javascript/common.js"></script>
    </header>
    <body>
        <div>
            <a href="#" onclick="executePHP('session_destroy');">Cerrar sesión</a>
        </div>
    </body>
</html>