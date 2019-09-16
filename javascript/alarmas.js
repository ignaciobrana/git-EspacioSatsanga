$(function() {    
    var pageName = getPageName(document.referrer); //funcion en common.js

    //validamos que viene de la página de login
    if (pageName === "login") {
        //Verificamos si hay recibos incompletos y mostramos el mensaje de alarma
        validarRecibosIncompletos();
    }

});

function validarRecibosIncompletos() {
    $.ajax({
        url: './class/globalclass/alarmas.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'hayRecibosInconmpletos' }
    }).done(
        function(jsonReturnValue) {
            var retValue = $.parseJSON(jsonReturnValue);
            if (retValue)
                showModalMessage("#dialog-message-alarmaRecibos");
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
}