(function() { var db = {}; window.db = db; })();

$(function() {

    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);

    //Cargamos la tabla de comoConocio y el select
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getComoConocio_All' }
    }).done(
        function (jsonComoConocioList){
            jsonComoConocioList.unshift({ _idComoConocio: '0', _nombre: '' });
            db.comoConocio = jsonComoConocioList;
            //Seteamos y configuramos controles del formulario de detalle
            configFormControls();
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );

    $('#detailsForm').validate({
        rules: {
            tNombreApellido: { required: true, maxlength: 255 },
            tEmail: { required: true, email: true, maxlength: 255},
            tEmail2: { required: true, email: true, maxlength: 255, equalTo: "#tEmail"},
            tCelular: { required: true, maxlength: 20},
            tTelefono: { required: false, maxlength: 20},
            sComoConocio:{ required: true, min:1 },
            sGenero:{ required: true, min:1 },
            dFechaNacimiento: { required: true }
        },
        invalidHandler: function(event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors)
                showModalMessage("#dialog-message");
        },
        submitHandler: function() {
            formSubmitHandler();
        },
        errorPlacement: function (error, element) {
            //Esto está sólo para no mostrar los mensajes de error!
            //Aquí mismo se podrían editar y mostrar los mensajes de forma customizada
        },
        highlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2")) {
                $(".select2-selection--single").addClass(errorClass);
            } else {
                elem.addClass(errorClass);
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2")) {
                $(".select2-selection--single").removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        }
    });

    var formSubmitHandler = $.noop;

    formSubmitHandler = function() {
        saveEstudiante();
    };

    function configFormControls() {
        //$("#dFechaNacimiento").datepicker();
        //seteamos lenguaje de controles e inicializamos los mismos
        $('.select2').select2({language: "es"});

        //Cargamos el select de comoConocio
        $.each(db.comoConocio, function (index, data) {
            $("#sComoConocio").append("<option value='" + data._idComoConocio + "'>" + data._nombre + "</option>");
        });
        
        //Cargamos la tabla de genero y el select
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { condicion: 'getGenero_All' }
        }).done(
            function (jsonGeneroList){
                jsonGeneroList.unshift({ _idGenero: '0', _nombre: '' });
                db.genero = jsonGeneroList;
                $.each(db.genero, function (index, data) {
                    $("#sGenero").append("<option value='" + data._idGenero + "'>" + data._nombre + "</option>");
                });
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );
    }

    var saveEstudiante = function() {
        showLoading();
        var idEstudiante = '0';
        var nombreApellido = $('#tNombreApellido').val();
        var fechaNacimiento = $('#dFechaNacimiento').val();
        var idGenero = $('#sGenero').val();
        var idEstadoEstudiante = '1'; //Estado Activo
        var idComoConocio = $('#sComoConocio').val();
        var email = $('#tEmail').val();
        var observaciones = '';
        var celular = $('#tCelular').val();
        var telefono = $('#tTelefono').val();
        var oDate = new Date();
        var fechaAlta = oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear();
        var fechaBaja = '';
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'setEstudiantes',
                idEstudiante: idEstudiante,
                nombreApellido: nombreApellido,
                fechaNacimiento: fechaNacimiento,
                idGenero: idGenero,
                idEstadoEstudiante: idEstadoEstudiante,
                idComoConocio: idComoConocio,
                email: email,
                observaciones: observaciones,
                celular: celular,
                telefono: telefono,
                fechaAlta: fechaAlta,
                fechaBaja: fechaBaja
            }
        }).done(
            function (MessageResponse) {
                showModalMessage("#dm-GuardadoCorrectamente");
                cleanForm();
                hideLoading();
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
                hideLoading();
            }
        );
    };

    function cleanForm() {
        $('#tNombreApellido').val('');
         $('#dFechaNacimiento').val('');
        $('#sGenero').val('-1').select2();
        $('#sComoConocio').val('-1').select2();
        $('#tEmail').val('');
        $('#tEmail2').val('');
        $('#tCelular').val('');
        $('#tTelefono').val('');
    }

});