(function() {  
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();

                var dFechaAltaDesde = (filter._fechaAlta.from !== null) ? (filter._fechaAlta.from.getFullYear() + '-' + (filter._fechaAlta.from.getMonth() + 1) + '-' + filter._fechaAlta.from.getDate()) : null;
                var dFechaAltaHasta = (filter._fechaAlta.to !== null) ? (filter._fechaAlta.to.getFullYear() + '-' + (filter._fechaAlta.to.getMonth() + 1) + '-' + filter._fechaAlta.to.getDate()) : null;

                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getEmpleados_All',
                        f_nombreApellido: filter._nombreApellido,
                        f_email: filter._email,
                        f_idTipoEmpleado: filter._tipoEmpleado._idTipoEmpleado,
                        f_idEstadoEmpleado: filter._estadoEmpleado._idEstadoEmpleado,
                        f_fechaAltaDesde: dFechaAltaDesde,
                        f_fechaAltaHasta: dFechaAltaHasta
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
        insertItem: function(insertingEmpleado) {
            //this.estudiantes.push(insertingEmpleado);
        },
        updateItem: function(updatingEmpleado) { }//,
    };
    window.db = db;
}());

$(function() {
    //utilizamos los siguientes flags para estar seguros de que fueron cargados los datos de estados y tipos
    //previamente a configurar la grid y el form de carga
    //TODO:Ver de hacerlo de una manera mas elegante!!
    var flag_wasEstadoEmpleado = false;
    var flag_wasTipoEmpleado = false;
    
    //Primero cargamos los estadosEmpleados
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getEstadoEmpleados_All' }
    }).done(
        //Una vez cargados los estadosEmpleado configuramos la grid para poder utilizar los estados en los select
        function(jsonEstadoEmpleadoList){
            jsonEstadoEmpleadoList.unshift({ _idEstadoEmpleado: '0', _nombre: '' });
            //seteamos los datos en la variable db para poder utilizarlo luego
            db.estadoEmpleado = jsonEstadoEmpleadoList;
            
            flag_wasEstadoEmpleado = true;
            if(flag_wasTipoEmpleado) {
                //Configuramos el lenguaje de datepicker
                $.datepicker.setDefaults($.datepicker.regional['es']);

                //Configuramos el control jsGrid
                configJSGrid();

                //Seteamos y configuramos controles del formulario de detalle
                configFormControls();
            }
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
    
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getTipoEmpleados_All' }
    }).done(
        //Una vez cargados los tiposEmpleado configuramos la grid para poder utilizar los tipos en los select
        function(jsonTipoEmpleadoList){
            jsonTipoEmpleadoList.unshift({ _idTipoEmpleado: '0', _nombre: '' });
            //seteamos los datos en la variable db para poder utilizarlo luego
            db.tipoEmpleado = jsonTipoEmpleadoList;
            
            flag_wasTipoEmpleado = true;
            if(flag_wasEstadoEmpleado) {
                //Configuramos el lenguaje de datepicker
                $.datepicker.setDefaults($.datepicker.regional['es']);

                //Configuramos el control jsGrid
                configJSGrid();

                //Seteamos y configuramos controles del formulario de detalle
                configFormControls();
            }
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
            sTipo:{ required: true, min:1 },
            sGenero:{ required: true, min:1 },
            dFechaNacimiento: { required: true },
            dFechaAlta: { required: true }
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

    var showDetailsDialog = function(dialogType, empleado) {
        var oDate = null;
        
        $('#tNombreApellido').val(empleado._nombreApellido);
        $('#tEmail').val(empleado._email);
        $('#tCelular').val(empleado._celular);
        $('#tTelefono').val(empleado._telefono);
        
        //$('#dFechaAlta').prop('disabled', dialogType !== 'Nuevo');
        
        if(dialogType === 'Nuevo') {
            oDate = new Date();
            $('#dFechaAlta').val(oDate.getDate() + "/" + (oDate.getMonth() + 1) + "/" + oDate.getFullYear());
            $('#dFechaNacimiento').val('');
            $('#sGenero').val('-1');
            $('#sEstado').val('-1');
            $('#sTipo').val('-1');
        } else {
            //Si se está editando un empleado
            $('#sGenero').val(empleado._genero._idGenero);
            $('#sEstado').val(empleado._estadoEmpleado._idEstadoEmpleado);
            $('#sTipo').val(empleado._tipoEmpleado._idTipoEmpleado);
            
            oDate = new Date(empleado._fechaNacimiento);
            $('#dFechaNacimiento').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
            
            oDate = new Date(empleado._fechaAlta);
            $('#dFechaAlta').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
        }

        formSubmitHandler = function() {
            saveEmpleado(empleado, dialogType === 'Nuevo');
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' empleado')
            .dialog('open');
    };

    var saveEmpleado = function(empleado, isNew) {
        
        showLoading();
        
        var idEmpleado = isNew ? '0' : empleado._idEmpleado;
        var nombreApellido = $('#tNombreApellido').val();
        var fechaNacimiento = $('#dFechaNacimiento').val();
        var idGenero = $('#sGenero').val();
        var idEstadoEmpleado = $('#sEstado').val();
        var idTipoEmpleado = $('#sTipo').val();
        var email = $('#tEmail').val();
        var celular = $('#tCelular').val();
        var telefono = $('#tTelefono').val();
        var fechaAlta = $('#dFechaAlta').val();
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'setEmpleados',
                idEmpleado: idEmpleado,
                nombreApellido: nombreApellido,
                fechaNacimiento: fechaNacimiento,
                idGenero: idGenero,
                idEstadoEmpleado: idEstadoEmpleado,
                idTipoEmpleado: idTipoEmpleado,
                email: email,
                celular: celular,
                telefono: telefono,
                fechaAlta: fechaAlta
            }
        }).done(
            function (MessageResponse) {
                if (MessageResponse == '1')
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
                    name: '_fechaAlta', type: 'date', width: 80, title: 'Fecha Alta', sorting: false, 
                    filtering: true
                },
                { name: '_email', type: 'text', width: 200, title: 'Email', sorting: false },
                { 
                    name: '_tipoEmpleado._idTipoEmpleado', 
                    title: 'Tipo', 
                    type: 'select', 
                    items: db.tipoEmpleado, valueField: '_idTipoEmpleado', textField: '_nombre',
                    sorting: false
                },
                { 
                    name: '_estadoEmpleado._idEstadoEmpleado', 
                    title: 'Estado', 
                    type: 'select', 
                    items: db.estadoEmpleado, valueField: '_idEstadoEmpleado', textField: '_nombre',
                    sorting: false
                },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    headerTemplate: function() {
                        return $('<button>').attr('type', 'button')
                                .attr('title', 'Agregar empleado nuevo')
                                .button({icons: {primary: null}})
                                .addClass("buttonAdd")
                                .on('click', function () { showDetailsDialog('Nuevo', {}); });
                    }
                }
            ],
            onRefreshed: function(args) {
        	var items = args.grid.option("data");
                args.grid._content.append(
                    "<tr><td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"><strong>Registros devueltos</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-left\" style=\"width: 80px;\" colspan=\"5\"><strong>" + items.length  + "</strong></td></tr>"
                );
            }
        });
    }
    
    function configFormControls(){
        //Cargamos select de estadoEmpleados para fomularios
        $.each(db.estadoEmpleado, function (index, data) {
            //No agregamos el elemento vacio que sólo lo utilizamos para el select de la grid
            if (index != 0)
                $("#sEstado").append("<option value='" + data._idEstadoEmpleado + "'>" + data._nombre + "</option>");
        });
        
        //Cargamos select de tipoEmpleados para fomularios
        $.each(db.tipoEmpleado, function (index, data) {
            //No agregamos el elemento vacio que sólo lo utilizamos para el select de la grid
            if (index != 0)
                $("#sTipo").append("<option value='" + data._idTipoEmpleado + "'>" + data._nombre + "</option>");
        });

        $("#dFechaNacimiento").datepicker();
        $('#dFechaAlta').datepicker();
        
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