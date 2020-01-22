(function() {  
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();
                
                var dFechaDesde = (filter._fecha.from !== null) ? (filter._fecha.from.getFullYear() + '-' + (filter._fecha.from.getMonth() + 1) + '-' + filter._fecha.from.getDate()) : null;
                var dFechaHasta = (filter._fecha.to !== null) ? (filter._fecha.to.getFullYear() + '-' + (filter._fecha.to.getMonth() + 1) + '-' + filter._fecha.to.getDate()) : null; (filter._total !== undefined) ? filter._total : 0;
                
                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getCajaGrande_All',
                        f_idTipoEgresoFijo: filter._tipoEgresoFijo._idTipoEgresoFijo,
                        f_fechaDesde: dFechaDesde,
                        f_fechaHasta: dFechaHasta,
                        f_observacion: filter._observacion
                    }
                }).done(
                    function(response) {
                        db.cajaGrande = response;
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
        insertItem: function(insertingCajaGrande) { },
        updateItem: function(updatingCajaGrande) { }
    };
    window.db = db;
}());

$(function() {
    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);

    //Cargamos los TipoEgresoFijo para cargar en el select del form
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getTipoEgresoFijo_All' }
    }).done(
        function(jsonTipoEgresoFijoList) {
            //insertamos como primer elemento uno vacio
            jsonTipoEgresoFijoList.unshift({ _idTipoEgresoFijo: '0', _nombre: '' });

            //seteamos los datos en la variable db para poder utilizarlo luego
            db.tipoEgresoFijo = jsonTipoEgresoFijoList;

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
            tObservacion: { required: true, maxlength: 50 },
            dFecha: { required: true },
            tValor:{ required: true, number: true },
            sTipoEgresoFijo:{ required: true, min:1 }
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
    
    var showDetailsDialog = function(dialogType, cajaGrande) {
        var oDate = null;
        
        $('#tObservacion').val(cajaGrande._observacion);
        $('#tValor').val(cajaGrande._valor);

        if(dialogType === 'Nuevo') {
            oDate = new Date();
            $('#dFecha').val(oDate.getDate() + "/" + (oDate.getMonth() + 1) + "/" + oDate.getFullYear());
            $('#sTipoEgresoFijo').val("-1").select2();
            $('#sEmpleadoAdelanto').val("-1").select2();
        } else {

            if (cajaGrande._tipoEgresoFijo === null) {
                showModalMessage("#dialog-message-IngresoAutomatico");
                return;
            }

            //Si se está editando una cajaGrande seteamos los controles con los datos de la base
            $('#sTipoEgresoFijo').val(cajaGrande._tipoEgresoFijo._idTipoEgresoFijo).select2();
            $('#sEmpleadoAdelanto').val(cajaGrande._adelanto._empleado._idEmpleado).select2();
            
            oDate = new Date(cajaGrande._fecha);
            $('#dFecha').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
        }

        if ($('#sTipoEgresoFijo').find("option:selected").text() === "Adelanto") {
            $('#divEmpleadoAdelanto').show();
        } else {
            $('#divEmpleadoAdelanto').hide();
        }

        formSubmitHandler = function() {
            saveCajaGrande(cajaGrande, dialogType === 'Nuevo');
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' movimiento caja grande')
            .dialog('open');
    };

    var saveCajaGrande = function(cajaGrande, isNew) {
        var idCajaGrande = isNew ? '0' : cajaGrande._idCajaGrande;
        var idTipoEgresoFijo = $('#sTipoEgresoFijo').val();
        var fecha = $('#dFecha').val();
        var observacion = $('#tObservacion').val();
        var valor = $("#tValor").val();
        
        var idAdelanto = 0;
        var idEmpleadoAdelanto = 0;
        
        showLoading();

        if ($('#sTipoEgresoFijo').find("option:selected").text() === 'Adelanto') {
            idAdelanto =  (cajaGrande._adelanto === undefined) ? 0 : cajaGrande._adelanto._idAdelanto;
            idEmpleadoAdelanto = $('#sEmpleadoAdelanto').val();
            idAdelanto = idAdelanto !== null ? idAdelanto : 0;
            idEmpleadoAdelanto = idEmpleadoAdelanto !== null ? idEmpleadoAdelanto : 0;
        } else if (cajaGrande._adelanto !== undefined) {
            idAdelanto =  cajaGrande._adelanto._idAdelanto;
            idEmpleadoAdelanto = 0;
        }
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'setCajaGrande',
                idCajaGrande: idCajaGrande,
                idTipoEgresoFijo: idTipoEgresoFijo,
                fecha: fecha,
                observacion: observacion,
                valor: valor,
                idMovimientoCajaChica: 0,
                idAdelanto: idAdelanto,
                idEmpleadoAdelanto: idEmpleadoAdelanto
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
                hideLoading();
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );
    };
    
    function configJSGrid() {
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
                { name: '_fecha', type: 'date', width: 80, title: 'Fecha', sorting: true, align: 'center' },
                {
                    name: '_tipoEgresoFijo._idTipoEgresoFijo', 
                    title: 'Tipo Egreso', 
                    type: 'select', 
                    items: db.tipoEgresoFijo, valueField: '_idTipoEgresoFijo', textField: '_nombre',
                    sorting: false, filtering: true
                },
                { name: '_observacion', type: 'text', width: 80, title:'Observacion' },
                { name: '_valor', type: 'number', width: 80, title:'Valor', filtering: false, sorting: true, align: 'center' },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    headerTemplate: function() {
                        return $('<button>').attr('type', 'button')
                                .attr('title', 'Agregar movimiento caja grande')
                                .button({icons: {primary: null}})
                                .addClass("buttonAdd")
                                .on('click', function () { showDetailsDialog('Nuevo', {}); });
                    }
                }
            ],
            onRefreshed: function(args) {
        	var items = args.grid.option("data");
                var total = { Name: "Total", "Sum": 0, IsTotal: true };

                items.forEach(function(item) {
                    total.Sum += parseInt(item._valor);
                });
                
                args.grid._content.append(
                    "<tr><td class=\"jsgrid-cell jsgrid-align-center\" style=\"width: 80px;\"></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-right\"><strong>Total</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.Sum + "</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td></tr>"
                );

                //mostramos información de los datos Actuales de la CajaGrande
                showInfoEstadoActualCaja(total.Sum);
            }
        });
    }
    
    function configFormControls() {
        $('#dFecha').datepicker();
        
        //seteamos lenguaje de controles e inicializamos los mismos
        $('.select2').select2({language: "es"});

        //Cargamos los tipoEgresoFijo del formulario
        $.each(db.tipoEgresoFijo, function (index, data) {
            $("#sTipoEgresoFijo").append("<option value='" + data._idTipoEgresoFijo + "'>" + data._nombre + "</option>");
        });

        $("#sTipoEgresoFijo").select2().on('change', function (e) {
            var target = $(e.target);
            var value = target.val();
            var selectedText = target.find("option:selected").text();
    
            if (selectedText === "Adelanto") {
                $('#divEmpleadoAdelanto').show();
                $('#sEmpleadoAdelanto').rules('add',  { required: true });
            } else {
                $('#sEmpleadoAdelanto').rules('remove');
                $('#divEmpleadoAdelanto').hide();
            }
        });

        //Cargamos los Empleados que se encuentran Activos para cargar en el select del form
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'getEmpleados_All',
                f_nombreApellido: '',
                f_email: '',
                f_idTipoEmpleado: '0', //Tipo Profesor
                f_idEstadoEmpleado: '1', 
                f_fechaAltaDesde: null,
                f_fechaAltaHasta: null
            }
        }).done(
            function(jsonEmpleadoList) {
                //seteamos los datos en la variable db para poder utilizarlo luego
                db.empleado = jsonEmpleadoList;
                $("#sEmpleado").append("<option value='0'>(Seleccionar)</option>");
                $.each(db.empleado, function (index, data) {
                    $("#sEmpleado").append("<option value='" + data._idEmpleado + "'>" + data._nombreApellido + "</option>");
                    $("#sEmpleadoAdelanto").append("<option value='" + data._idEmpleado + "'>" + data._nombreApellido + "</option>");
                });
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );

    }

    function showInfoEstadoActualCaja(totalCaja) {
        var año = new Date().getFullYear();
        var mes = new Date().getMonth() + 1;
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'getBalanceCajaGrande',
                año: año,
                mes: mes
            }
        }).done(
            function(jsonBalance) {
                if (jsonBalance.length == 0) {
                    $("#spIngresosMes").text("$ 0");
                    $("#spEgresosMes").text("$ 0");
                } else {
                    $("#spIngresosMes").text("$ " + jsonBalance[0]["ingresos"]);
                    $("#spEgresosMes").text("$ " + jsonBalance[0]["egresos"]);
                }
                $("#spValorTotal").text("$ " + totalCaja);
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );
    }
    
});