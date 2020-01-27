/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++Funciones javascript que llaman a php+++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function executePHP(functionName) {
    switch(functionName) {
        case 'session_destroy': session_destroy(); break;
    }
}

function session_destroy() {
    $.ajax({
        // aqui va la ubicación de la página PHP
        url: './class/globalclass/execfunction.php',
        type: 'POST',
        dataType: 'html',
        data: { condicion: "session_destroy"},
        success:
            function(){
                window.document.location = './login.php';
            }
  }).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(jqXHR.status);
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
}
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*+++++++++++++++++++++++++Funciones javascript++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
function showModalMessage(divID) {
    $(function() {
        $(divID).dialog({
            modal: true,
            buttons: {
                Ok: function() { $(this).dialog("close"); }
            }
        });
    });
}

function showModalForm(divID) {
    $(function() {
        $(divID).dialog({
            modal: true,
            width: 700,
            height: 500,
            buttons: {
                Ok: function() { $(this).dialog("close"); }
            }
        });
    });
}

function showConfirmMessage(divID, funcNameOK) {
    $(function() {
        $(divID).dialog({
            modal: true,
            buttons: {
                Aceptar: function() { $(this).dialog("close"); eval( funcNameOK ); },
                Cancelar: function() { $(this).dialog("close"); }
            }
        });
    });
}

function getPageName(url) {
    var indexUltimoSlash = url.lastIndexOf("/");
    var indexPuntoPhp = url.lastIndexOf(".php");
    return url.substring(indexUltimoSlash + 1, indexPuntoPhp);
}

function hideLoading() {
    //mostramos la barra de titulo de los popups modales
    $(".ui-dialog-titlebar").show();
    
    // eliminamos el div que bloquea pantalla
    $("#WindowLoad").remove();
}
 
function showLoading() {
    //eliminamos si existe un div ya bloqueando
    hideLoading();
 
    //centrar imagen gif
    height = 20;//El div del titulo, para que se vea mas arriba (H)
    var ancho = 0;
    var alto = 0;
 
    //obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
    if (window.innerWidth == undefined) 
        ancho = window.screen.width;
    else 
        ancho = window.innerWidth;
    
    if (window.innerHeight == undefined) 
        alto = window.screen.height;
    else 
        alto = window.innerHeight;
 
    //operación necesaria para centrar el div que muestra el mensaje
    var heightdivsito = alto/2 - parseInt(height)/2;//Se utiliza en el margen superior, para centrar
 
   //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
    imgCentro = "<div style='text-align:center;'><img src='img/loader.gif'><br>Cargando...</div>";
 
    //creamos el div que bloquea grande------------------------------------------
    div = document.createElement("div");
    div.id = "WindowLoad";
    div.style.display = "none";
    $("body").append(div);

    //centramos el div del texto
    $("#WindowLoad").html(imgCentro);
    
    $("#WindowLoad").dialog({
        modal: true
    });
    
    //escondemos la barra de titulo de los popups modales
    $(".ui-dialog-titlebar").hide();
}

function getMes_descripcion(numeroMes) {
    switch(numeroMes) {
        case "1": return "Enero";
        case "2": return "Febrero";
        case "3": return "Marzo";
        case "4": return "Abril";
        case "5": return "Mayo";
        case "6": return "Junio";
        case "7": return "Julio";
        case "8": return "Agosto";
        case "9": return "Septiembre";
        case "10": return "Octubre";
        case "11": return "Noviembre";
        case "12": return "Diciembre";
        default: return "mes incorrecto";
    }
}

function getDateObject(strDate) {
    var vecFecha = strDate.split("/");
    return new Date(vecFecha[1] + "/" + vecFecha[0] + "/" + vecFecha[2]);
}

function convertStringDate_To_EnglishFormat(strDate) {
    var vecFecha = strDate.split("/");
    return (vecFecha[2] + "-" + vecFecha[1] + "-" + vecFecha[0]);
}

function getDayAndHour(fecha){
    var oDate = new Date(fecha);
    var numDiaSem = oDate.getDay(); //getDay() devuelve el dia de la semana.(0-6).
    //Creamos un Array para los nombres de los días    
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var diaLetras = diasSemana[oDate.getDay()];   //El día de la semana en letras. getDay() devuelve el dia de la semana.(0-6).
    //Otro Array para los nombres de los meses    
    var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var mesLetras = meses[oDate.getMonth()];  //El mes en letras
    var diaMes = (oDate.getDate());   //getDate() devuelve el dia(1-31).
    var anho = oDate.getFullYear();  //getFullYear() devuelve el año(4 dígitos).
    var hora = oDate.getHours();    //getHours() devuelve la hora(0-23).
    var min = oDate.getMinutes();   //getMinutes() devuelve los minutos(0-59).
    if ((min >= 0) && (min < 10)) {    //Algoritmo para añadir un cero cuando el min tiene 1 cifra.
      min = "0" + min;
    }
    var returnValue = diaLetras+ ", " + diaMes + " de " + mesLetras + " de " + anho + " a las " + hora + ":" + min + " hs.";
    return returnValue;
  }

$(function () {
    $('.menu-item').hover(
        function () { 
            $(this).find('div').css('display','block'); 
            if ($(this).prop('className') != 'menu-item has-children')
                $(this).find('div.subsub_menu').css('display','none');
        },
        function () { $(this).find('div').css('display','none'); }
    );
});

function IsNumeric(valor) { 
    var log = valor.length; 
    var sw = "S"; 
    for (x = 0; x < log; x++) { 
        v1 = valor.substr(x, 1); 
        v2 = parseInt(v1); 
        //Compruebo si es un valor numérico 
        if (isNaN(v2)) 
            sw = "N";
    } 
    return sw == "S";
} 

function formatearfecha(fecha) {
    var primerslap = false; 
    var segundoslap = false;
    var long = fecha.length; 
    var dia; 
    var mes; 
    var ano; 
    if ((long >= 2) && !primerslap) { 
        dia = fecha.substr(0, 2); 
        if (IsNumeric(dia) && (dia <= 31) && (dia != "00")) { 
            fecha = fecha.substr(0, 2) + "/" + fecha.substr(3, 7); 
            primerslap = true; 
        } else { 
            fecha = ""; 
            primerslap = false;
        } 
    } else { 
        dia = fecha.substr(0, 1); 
        if (!IsNumeric(dia))
            fecha = ""; 
        if ((long <= 2) && primerslap) {
            fecha = fecha.substr(0, 1); 
            primerslap = false; 
        }
    }
    if ((long >= 5) && !segundoslap) { 
        mes = fecha.substr(3,2);
        if (IsNumeric(mes) && (mes <= 12) && (mes != "00")) {
            fecha = fecha.substr(0, 5) + "/" + fecha.substr(6, 4); 
            segundoslap = true; 
        } else { 
            fecha = fecha.substr(0,3); 
            segundoslap = false;
        }
    } else { 
        if ((long <= 5) && segundoslap) { 
            fecha = fecha.substr(0, 4); 
            segundoslap = false; 
        } 
    } 
    
    if (long >= 7) { 
        ano = fecha.substr(6, 4); 
        if (!IsNumeric(ano)) 
            fecha = fecha.substr(0, 6);
        else { 
            if (long == 10) { 
                if ((ano == 0) || (ano < 1900) || (ano > 2100)) 
                fecha = fecha.substr(0, 6);  
            }
        }
    }
    
    if (long >= 10) { 
        fecha = fecha.substr(0, 10); 
        dia = fecha.substr(0, 2); 
        mes = fecha.substr(3, 2); 
        ano = fecha.substr(6, 4); 
        // Año no viciesto y es febrero y el dia es mayor a 28 
        if ( (ano % 4 != 0) && (mes == 02) && (dia > 28) )
            fecha = fecha.substr(0, 2) + "/";
    }
    return (fecha); 
}

function get_array_meses() {
    let meses = [ 
        {_mes: "0", _descripcion: ""},
        {_mes: "1", _descripcion: "Enero"},
        {_mes: "2", _descripcion: "Febrero"}, 
        {_mes: "3", _descripcion: "Marzo"},
        {_mes: "4", _descripcion: "Abril"},
        {_mes: "5", _descripcion: "Mayo"},
        {_mes: "6", _descripcion: "Junio"},
        {_mes: "7", _descripcion: "Julio"},
        {_mes: "8", _descripcion: "Agosto"},
        {_mes: "9", _descripcion: "Septiembre"},
        {_mes: "10", _descripcion: "Octubre"},
        {_mes: "11", _descripcion: "Noviembre"},
        {_mes: "12", _descripcion: "Diciembre"}
    ];
    return meses;
}