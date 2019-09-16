(function() {  
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();

                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getEmpresas_All',
                        f_razonSocial: filter._razonSocial,
                        f_contacto: filter._contacto,
                        f_telefono: filter._telefono,
                        f_domicilio: filter._domicilio,
                        f_cuit: filter._cuit,
                        f_idGestor:filter._gestor._idEmpleado
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
        insertItem: function(insertingEmpresa) {
            //this.estudiantes.push(insertingEmpresa);
        },
        updateItem: function(updatingEmpresa) { }//,
    };
    window.db = db;
}());

$(function() {
    //Primero cargamos los empleados
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { 
            condicion: 'getEmpleados_All',
            f_nombreApellido: '',
            f_email : '',
            f_idTipoEmpleado: 0,
            f_idEstadoEmpleado: 0,
            f_fechaAltaDesde: null,
            f_fechaAltaHasta: null
        }
    }).done(
        //Una vez cargados los Empleados configuramos la grid para poder utilizar los estados en los select
        function(jsonEmpleadoList){
            //insertamos como primer elemento uno vacio
            jsonEmpleadoList.unshift({ _idEmpleado: '0', _nombreApellido: '' });
            
            //seteamos los datos en la variable db para poder utilizarlo luego
            db.empleado = jsonEmpleadoList;
            
            //Configuramos el control jsGrid
            configJSGrid();

            //Seteamos y configuramos controles del formulario de detalle
            configFormControls();
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
            tRazonSocial: { required: true , maxlength: 50 },
            tDomicilio: { required: true , maxlength: 50 },
            tLocalidad: { required: true , maxlength: 50 },
            tTelefono: { required: false , maxlength: 20 },
            tEmail: { required: true, email: true, maxlength: 50},
            tCuit: { required: true, maxlength: 20 },
            tContacto: { required: true, maxlength: 20 },
            tObservaciones: { maxlength: 255 }
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

    var showDetailsDialog = function(dialogType, empresa) {
        
        $('#tRazonSocial').val(empresa._razonSocial);
        $('#tDomicilio').val(empresa._domicilio);
        $('#tLocalidad').val(empresa._localidad);
        $('#tCuit').val(empresa._cuit);
        $('#tContacto').val(empresa._contacto);
        $('#tTelefono').val(empresa._telefono);
        $('#tEmail').val(empresa._email);
        $('#tObservaciones').val(empresa._observaciones);
        
        if(dialogType === 'Nueva')
            $('#sGestor').val('-1').select2();
        else
            $('#sGestor').val(empresa._gestor._idEmpleado).select2();
            
        formSubmitHandler = function() {
            saveEmpresa(empresa, dialogType === 'Nueva');
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' empresa')
            .dialog('open');
    };

    var saveEmpresa = function(empresa, isNew) {
        
        showLoading();
        
        var idEmpresa = isNew ? '0' : empresa._idEmpresa;
        var razonSocial = $('#tRazonSocial').val();
        var domicilio = $('#tDomicilio').val();
        var localidad = $('#tLocalidad').val();
        var cuit = $('#tCuit').val();
        var contacto = $('#tContacto').val();
        var telefono = $('#tTelefono').val();
        var email = $('#tEmail').val();
        var observaciones = $('#tObservaciones').val();
        var idGestor = $('#sGestor').val() != null ? $('#sGestor').val() : '';
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'setEmpresa',
                idEmpresa: idEmpresa,
                razonSocial: razonSocial,
                domicilio: domicilio,
                localidad: localidad,
                cuit: cuit,
                contacto: contacto,
                telefono: telefono,
                email: email,
                observaciones: observaciones,
                idGestor: idGestor
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
                { name: '_razonSocial', type: 'text', width: 150, title:'Razón Social', sorting: true, filtering: true },
                { name: '_contacto', type: 'text', width: 80, title: 'Contacto', sorting: true, filtering: true },
                { name: '_telefono', type: 'text', width: 80, title: 'Teléfono', sorting: true, filtering: true},
                { name: '_domicilio', type: 'text', title: 'Domicilio', sorting: true, filtering: true},
                { name: '_cuit', type: 'text', title: 'Cuit', sorting: true, filtering: true},
                { 
                    name: '_gestor._idEmpleado', 
                    title: 'Gestor', 
                    type: 'select', 
                    items: db.empleado, valueField: '_idEmpleado', textField: '_nombreApellido',
                    sorting: false
                },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    headerTemplate: function() {
                        return $('<button>').attr('type', 'button')
                                .attr('title', 'Agregar empresa nueva')
                                .button({icons: {primary: null}})
                                .addClass("buttonAdd")
                                .on('click', function () { showDetailsDialog('Nueva', {}); });
                    }
                }
            ]
        });
    }
    
    function configFormControls(){
        $('.select2').select2({language: "es"});
        //Cargamos select de gestor (empleados) para fomularios
        $.each(db.empleado, function (index, data) {
            //No agregamos el elemento vacío que sólo lo utilizamos para el select de la grid
            if (index != 0)
                $("#sGestor").append("<option value='" + data._idEmpleado + "'>" + data._nombreApellido + "</option>");
        });
    }
    
});