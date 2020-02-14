var showTotal = false; //Lo utilizamos para saber si mostramos el div de total en la parte superior
(function() {  
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();

                var dFechaAltaDesde = (filter._fechaAlta.from !== null) ? (filter._fechaAlta.from.getFullYear() + '-' + (filter._fechaAlta.from.getMonth() + 1) + '-' + filter._fechaAlta.from.getDate()) : null;
                var dFechaAltaHasta = (filter._fechaAlta.to !== null) ? (filter._fechaAlta.to.getFullYear() + '-' + (filter._fechaAlta.to.getMonth() + 1) + '-' + filter._fechaAlta.to.getDate()) : null;
                var dFechaBajaDesde = (filter._fechaBaja.from !== null) ? (filter._fechaBaja.from.getFullYear() + '-' + (filter._fechaBaja.from.getMonth() + 1) + '-' + filter._fechaBaja.from.getDate()) : null;
                var dFechaBajaHasta = (filter._fechaBaja.to !== null) ? (filter._fechaBaja.to.getFullYear() + '-' + (filter._fechaBaja.to.getMonth() + 1) + '-' + filter._fechaBaja.to.getDate()) : null;

                showTotal = dFechaAltaDesde != null || dFechaAltaHasta != null || dFechaBajaDesde != null || dFechaBajaHasta != null;

                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getEstudiantes_All',
                        f_nombreApellido: filter._nombreApellido,
                        f_email: filter._email,
                        f_celular: filter._celular,
                        f_idEstadoEstudiante: filter._estadoEstudiante._idEstadoEstudiante,
                        f_fechaAltaDesde: dFechaAltaDesde,
                        f_fechaAltaHasta: dFechaAltaHasta,
                        f_idComoConocio:filter._comoConocio._idComoConocio,
                        f_fechaBajaDesde: dFechaBajaDesde,
                        f_fechaBajaHasta: dFechaBajaHasta
                    }
                }).done(
                    function(response) {
                        def.resolve(response);
                    }
                ).fail(
                    function( jqXHR, textStatus, errorThrown ) {
                        alert(errorThrown);
                        alert(jqXHR.responseText);
                    }
                );
                return def.promise();
        },
        insertItem: function(insertingEstudiante) {
            //this.estudiantes.push(insertingEstudiante);
        },
        updateItem: function(updatingEstudiante) { }//,
    };
    window.db = db;
}());

$(function() {
    var flagFinCargaDatosSelectGrid = false;
    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);
    
    //Primero cargamos los estadosEstudiantes
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getEstadoEstudiantes_All' }
    }).done(
        //Una vez cargados los estadosEstudiantes configuramos la grid para poder utilizar los estados en los select
        function(jsonEstadoEstudianteList){
            //insertamos como primer elemento uno vacio
            jsonEstadoEstudianteList.unshift({ _idEstadoEstudiante: '0', _nombre: '' });
            
            //seteamos los datos en la variable db para poder utilizarlo luego
            db.estadoEstudiante = jsonEstadoEstudianteList;
            
            if (flagFinCargaDatosSelectGrid) {
                //Configuramos el control jsGrid
                configJSGrid();

                //Seteamos y configuramos controles del formulario de detalle
                configFormControls();
            }
            flagFinCargaDatosSelectGrid = true;
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
    
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
            
            if (flagFinCargaDatosSelectGrid) {
                //Configuramos el control jsGrid
                configJSGrid();

                //Seteamos y configuramos controles del formulario de detalle
                configFormControls();
            }
            flagFinCargaDatosSelectGrid = true;
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );

    $('#detailsDialog').dialog({
        autoOpen: false,
        width: 450,
        close: function() {
            $('#detailsForm').validate().resetForm();
            $('#detailsForm').find('.error').removeClass('error');
        }
    });

    $('#detailsForm').validate({
        rules: {
            tNombreApellido: 'required',
            tEmail: { required: true, email: true},
            sEstado:{ required: true, min:1 },
            sComoConocio:{ required: true, min:1 },
            sGenero:{ required: true, min:1 },
            dFechaNacimiento: { required: true },
            dFechaAlta: { required: true },
            dFechaBaja: { required: false },
            tObservaciones: { maxlength:255 }
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
        }
    });

    var formSubmitHandler = $.noop;

    var showDetailsDialog = function(dialogType, estudiante) {
        var oDate = null;
        
        $('#tNombreApellido').val(estudiante._nombreApellido);
        $('#tEmail').val(estudiante._email);
        $('#tObservaciones').val(estudiante._observaciones);
        $('#tCelular').val(estudiante._celular);
        $('#tTelefono').val(estudiante._telefono);
        
        //$('#dFechaAlta').prop('disabled', dialogType !== 'Nuevo');
        
        if(dialogType === 'Nuevo') {
            oDate = new Date();
            $('#dFechaAlta').val(oDate.getDate() + "/" + (oDate.getMonth() + 1) + "/" + oDate.getFullYear());
            $('#dFechaNacimiento').val('');
            $('#dFechaBaja').val('');
            $('#sGenero').val('0');
            $('#sEstado').val('0');
            $('#sComoConocio').val('0');
        } else {
            //Si se está editando un estudiante
            $('#sGenero').val(estudiante._genero._idGenero);
            $('#sEstado').val(estudiante._estadoEstudiante._idEstadoEstudiante);
            $('#sComoConocio').val(estudiante._comoConocio._idComoConocio);
            
            oDate = new Date(estudiante._fechaNacimiento);
            $('#dFechaNacimiento').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
            
            oDate = new Date(estudiante._fechaAlta);
            $('#dFechaAlta').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
            
            if (estudiante._fechaBaja != null) {
                oDate = new Date(estudiante._fechaBaja);
                $('#dFechaBaja').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
            } else
                $('#dFechaBaja').val('');
        }

        formSubmitHandler = function() {
            saveEstudiante(estudiante, dialogType === 'Nuevo');
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' alumno')
            .dialog('open');
    };

    var saveEstudiante = function(estudiante, isNew) {
        
        showLoading();
        
        var idEstudiante = isNew ? '0' : estudiante._idEstudiante;
        var nombreApellido = $('#tNombreApellido').val();
        var fechaNacimiento = $('#dFechaNacimiento').val();
        var idGenero = $('#sGenero').val();
        var idEstadoEstudiante = $('#sEstado').val();
        var idComoConocio = $('#sComoConocio').val();
        var email = $('#tEmail').val();
        var observaciones = $('#tObservaciones').val();
        var celular = $('#tCelular').val();
        var telefono = $('#tTelefono').val();
        var fechaAlta = $('#dFechaAlta').val();
        var fechaBaja = $('#dFechaBaja').val();
        
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
                if (MessageResponse.length > 0)
                    alert('Se guardo el registro correctamente!');
                $('#detailsDialog').dialog('close');
                $("#jsGrid").jsGrid("loadData");
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
    
    var downloadMails = function() {
        showLoading();
        
        var grid = $("#jsGrid").data("JSGrid");
        var f_nombreApellido = grid.fields[0].filterControl[0].value;
        var dFechaAltaDesde = grid.fields[1]._fromPicker[0].value !== "" ? convertStringDate_To_EnglishFormat(grid.fields[1]._fromPicker[0].value) : null;
        var dFechaAltaHasta = grid.fields[1]._toPicker[0].value !== "" ? convertStringDate_To_EnglishFormat(grid.fields[1]._toPicker[0].value) : null;
        var f_email = grid.fields[2].filterControl[0].value;
        var f_celular = grid.fields[3].filterControl[0].value;
        var f_idEstado = grid.fields[4].filterControl[0].value;
        var f_idComoConocio = grid.fields[5].filterControl[0].value;
        var dFechaBajaDesde = grid.fields[6]._fromPicker[0].value !== "" ? convertStringDate_To_EnglishFormat(grid.fields[6]._fromPicker[0].value) : null;
        var dFechaBajaHasta = grid.fields[6]._toPicker[0].value !== "" ? convertStringDate_To_EnglishFormat(grid.fields[6]._toPicker[0].value) : null;
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'downloadEstudiantesMails',
                f_nombreApellido: f_nombreApellido,
                f_email: f_email,
                f_celular: f_celular,
                f_idEstadoEstudiante: f_idEstado,
                f_fechaAltaDesde: dFechaAltaDesde,
                f_fechaAltaHasta: dFechaAltaHasta,
                f_idComoConocio: f_idComoConocio,
                f_fechaBajaDesde: dFechaBajaDesde,
                f_fechaBajaHasta: dFechaBajaHasta
            }
        }).done(
            function (MessageResponse) {
                if (MessageResponse === 1)
                    downloadFile('estudiantes_mails.txt');
                else
                    alert('Se produjo un error armando el archivo.');
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
    
    function configJSGrid(){
        //Configuramos el lenguaje de la grid
        jsGrid.locale('es');
        
        $('#jsGrid').jsGrid({
            height: '500px',
            width: '100%',
            filtering: true,
            editing: false,
            inserting: false,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 50,
            pageButtonCount: 5,
            rowClick: function(args) {
                showDetailsDialog('Editar', args.item);
            },
            controller: db,
            fields: [
                { name: '_nombreApellido', type: 'text', width: 150, title:'Nombre', sorting: true },
                { 
                    name: '_fechaAlta', type: 'date', width: 70, title: 'Fecha Alta', sorting: true, 
                    filtering: true
                },
                { name: '_email', type: 'text', width: 170, title: 'Email', sorting: false },
                { name: '_celular', type: 'text', title: 'Celular', sorting: false },
                { 
                    name: '_estadoEstudiante._idEstadoEstudiante', 
                    title: 'Estado', 
                    type: 'select', 
                    items: db.estadoEstudiante, valueField: '_idEstadoEstudiante', textField: '_nombre',
                    sorting: false
                },
                { 
                    name: '_comoConocio._idComoConocio', 
                    title: 'Como Conoció?', 
                    type: 'select', 
                    items: db.comoConocio, valueField: '_idComoConocio', textField: '_nombre',
                    sorting: false
                },
                { 
                    name: '_fechaBaja', type: 'date', width: 70, title: 'Fecha Baja', sorting: true, filtering: true, 
                    itemTemplate : 
                        function(value){
                            if (value == null) return ''; 
                            else {
                                var d = new Date(value);
                                return ('0' + d.getDate()).slice(-2) + '/' + ('0' + (d.getMonth()+1)).slice(-2) + '/' + d.getFullYear();
                            }
                        }
                },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    width: 75,
                    headerTemplate: function() {
                        var $customAddButton = $('<button>').attr('type', 'button')
                                .attr('title', 'Agregar nuevo alumno')
                                .button({icons: {primary: null}})
                                .addClass("buttonAdd")
                                .on('click', function () { showDetailsDialog('Nuevo', {}); });

                       var $customDownloadButton = $('<button>').attr('type', 'button')
                                .attr('title', 'Descargar listado de mails')
                                .button({icons: {primary: null}})
                                .addClass("buttonDownloadFile")
                                .on('click', function () { downloadMails(); });

                        return $("<div>").append($customAddButton).append($customDownloadButton);
                    }
                }
            ],
            onRefreshed: function(args) {
        	    var items = args.grid.option("data");
                args.grid._content.append(
                    "<tr><td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"><strong>Registros devueltos</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-left\" style=\"width: 80px;\" colspan=\"6\"><strong>" + items.length  + "</strong></td></tr>"
                );
                if (showTotal) {
                    $("#spTotal").text(items.length);
                    $("#divTotal").show();
                    showTotal = false;
                } else $("#divTotal").hide();
            }
        });
    }
    
    function configFormControls(){
        //Cargamos select de estadoEstudiantes para fomularios
        $.each(db.estadoEstudiante, function (index, data) {
            //No agregamos el elemento vacio que sólo lo utilizamos para el select de la grid
            if (index != 0)
                $("#sEstado").append("<option value='" + data._idEstadoEstudiante + "'>" + data._nombre + "</option>");
        });
        
        $.each(db.comoConocio, function (index, data) {
            //No agregamos el elemento vacio que sólo lo utilizamos para el select de la grid
            if (index != 0)
            $("#sComoConocio").append("<option value='" + data._idComoConocio + "'>" + data._nombre + "</option>");
        });

        $("#dFechaNacimiento").datepicker();
        $('#dFechaAlta').datepicker();
        $('#dFechaBaja').datepicker();
        
        //Cargamos la tabla de genero y el select
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { condicion: 'getGenero_All' }
        }).done(
            function (jsonGeneroList){
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
    
});