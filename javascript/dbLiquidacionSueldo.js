(function() {  
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();
                
                var iMes = (filter._mes !== undefined) ? filter._mes : 0;
                var iAño = (filter._año !== undefined) ? filter._año : 0;
                var iValor = (filter._valor !== undefined) ? filter._valor : 0;
                var tnombreEmpleado = (filter._nombreEmpleado !== undefined) ? filter._nombreEmpleado : null;
                var tObservaciones = (filter._observaciones !== undefined) ? filter._observaciones : null;
                
                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getLiquidacionesSueldo_All',
                        f_mes: iMes,
                        f_año: iAño,
                        f_nombreEmpleado: tnombreEmpleado,
                        f_valor: iValor,
                        f_observaciones: tObservaciones
                    }
                }).done(
                    function(response) {
                        db.liquidacionSueldo = response;
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
        insertItem: function(insertingRecibo) {
            //this.recibo.push(insertingRecibo);
        },
        updateItem: function(updatingRecibo) { }
    };
    window.db = db;
}());

$(function() {
    db.meses = [ 
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
    //cargamos los meses en select
    $.each(db.meses, function (index, data) {
        $("#sMes").append("<option value='" + data._mes + "'>" + data._descripcion + "</option>");
    });
    
    //cargamos años en select... el actual y el anterior
    var ano = (new Date).getFullYear();
    $("#sAño").append("<option value='" + (ano - 1) + "'>" + (ano - 1) + "</option>");
    $("#sAño").append("<option value='" + ano + "'>" + ano + "</option>");
    
    //seteamos lenguaje de controles e inicializamos los mismos
    $('.select2').select2({language: "es"});
    
    //Configuramos el control jsGrid
    configJSGrid();
        
    $('#generateDialog').dialog({
        autoOpen: false,
        width: 350,
        close: function() {
            $('#generateForm').validate().resetForm();
            $('#generateForm').find('.error').removeClass('error');
        }
    });
    
    $('#detailsDialog').dialog({
        autoOpen: false,
        width: 400
    });
    
    $('#generateForm').validate({
        rules: {
            sMes:{ required: true, min: 1 }
        },
        invalidHandler: function(event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors)
                showModalMessage("#dialog-message");
        },
        submitHandler: function() {
            var butCaption = $('#bGuardar').text();
            if (butCaption === "Generar")
                formSubmitHandlerGenerate();
            else if (butCaption === "Descargar")
                formSubmitHandlerDownloadComprobantes();
        },
        errorPlacement: function (error, element) {
            //Esto está sólo para no mostrar los mensajes de error!
            //Aquí mismo se podrían editar y mostrar los mensajes de forma customizada
        },
        highlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2")) {
                $(".select2-selection--single").addClass(errorClass);
            } else
                    elem.addClass(errorClass);
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
    
    $('#detailsForm').validate({
        submitHandler: function() {
            formSubmitHandlerSave();
        }
    });
    
    var formSubmitHandlerSave = $.noop;
    var formSubmitHandlerGenerate = $.noop;
    var formSubmitHandlerDownloadComprobantes = $.noop;

    var showDetailsDialog = function(dialogType, liquidacionSueldo) {
        $('#tMes').val(getMes_descripcion(liquidacionSueldo._mes));
        $('#tAño').val(liquidacionSueldo._año);
        $('#tEmpleado').val(liquidacionSueldo._nombreEmpleado);
        $('#tValor').val(liquidacionSueldo._valor);
        $('#tObservaciones').val(liquidacionSueldo._observaciones);

        formSubmitHandlerSave = function() {
            saveLiquidacionSueldo(liquidacionSueldo, dialogType === 'Nuevo');
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' liquidación')
            .dialog('open');
    };
    
    var showGenerateDialog = function() {
        var oDate = new Date();
        $('#sMes').val(oDate.getMonth() + 1).select2();
        $('#sAño').val(oDate.getFullYear()).select2();
        $('#bGuardar').html('Generar');

        formSubmitHandlerGenerate = function() {
            generateLiquidacionSueldo();
        };

        $('#generateDialog')
            .dialog('option', 'title', 'Generar Nueva Liquidación de Sueldo')
            .dialog('open');
    };
        
    var showDownloadComprobantes = function() {
        var oDate = new Date();
        $('#sMes').val(oDate.getMonth() + 1).select2();
        $('#sAño').val(oDate.getFullYear()).select2();
        $('#bGuardar').html('Descargar');

        formSubmitHandlerDownloadComprobantes = function() {
            downloadComprobantes();
        };

        $('#generateDialog')
            .dialog('option', 'title', 'Descargar Comprobantes')
            .dialog('open');
    };
    
    var saveLiquidacionSueldo = function(liquidacionSueldo, isNew) {
        var idLiquidacionSueldo = isNew ? '0' : liquidacionSueldo._idLiquidacionSueldo;
        var mes = liquidacionSueldo._mes;
        var año = $('#tAño').val();
        var idEmpleado = liquidacionSueldo._empleado._idEmpleado;
        var valor = $('#tValor').val();
        var observaciones = $('#tObservaciones').val();
        
        showLoading();
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'setLiquidacionSueldo',
                idLiquidacionSueldo: idLiquidacionSueldo,
                mes: mes,
                año: año,
                idEmpleado: idEmpleado,
                valor: valor,
                observaciones: observaciones
            }
        }).done(
            function (MessageResponse) {
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
    
    var generateLiquidacionSueldo = function() {
        var mes = $('#sMes').val();
        var ano = $('#sAño').val();
        
        //validar si ya se había generado la liquidación para el mes seleccionado
        if (existsLiquidacion(mes)) {
            $('#alerta-message-RepetirProceso').dialog({
                modal: true,
                buttons: {
                    Ok: function() { 
                        $(this).dialog("close");
                        execGenerateProcess(mes, ano);
                    },
                    Cancelar: function() { $(this).dialog("close"); return; }
                }
            });
        } else {
            execGenerateProcess(mes, ano);
        }
    };
    
    function downloadComprobantes() {
        var mes = $('#sMes').val();
        var año = $('#sAño').val();
                
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'getEmpleadosForDownloadComprobantes',
                mes: mes,
                año: año
            }
        }).done(
            function (arrIdsEmpleados) {
                var mes = $('#sMes').val();
                var año = $('#sAño').val();
                var save = null;
                for(var i=0; i<arrIdsEmpleados.length; i++) {
                    save = document.createElement('a');
                    save.href = './downloadComprobantePago.php?mes=' + mes + '&año=' + año + '&idEmpleado=' + arrIdsEmpleados[i].idEmpleado;
                    save.target = '_blank';
                    //Truco: así le damos el nombre al archivo 
                    //save.download = 'estudiantes_mails.txt';
                    var clicEvent = new MouseEvent('click', {
                      'view': window,
                      'bubbles': true,
                      'cancelable': true
                    });
                    //Simulamos un clic del usuario
                    //no es necesario agregar el link al DOM.
                    save.dispatchEvent(clicEvent);
                    //Y liberamos recursos...
                    (window.URL || window.webkitURL).revokeObjectURL(save.href);
                    save = null;
                }
                
                $('#generateDialog').dialog('close');
                $("#jsGrid").jsGrid("loadData");
                
                if (arrIdsEmpleados.length == 0)
                    alert('No se encuentran comprobantes para el mes indicado.');
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );
    }
    
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
                { name: '_mes', type: 'select', width: 80, title:'Mes', sorting: true, items: db.meses, valueField: '_mes', textField: '_descripcion' },
                { name: '_año', type: 'number', width: 80, title:'Año', align: 'center' },
                { name: '_nombreEmpleado', type: 'text', title: 'Empleado', align: 'center' },
                { name: '_valor', type: 'number', width: 80, title:'Valor', sorting: true, align: 'center' },
                { name: '_observaciones', type: 'text', title: 'Observaciones', sorting: false },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    width: 75,
                    headerTemplate: function() {                                
                        var $customAddButton = $('<button>').attr('type', 'button')
                                .attr('title', 'Generar Liquidación de Sueldo')
                                .button({icons: {primary: null}})
                                .addClass("buttonAdd")
                                .on('click', function () { showGenerateDialog(); });

                       var $customDownloadButton = $('<button>').attr('type', 'button')
                                .attr('title', 'Descargar Comprobantes de pago')
                                .button({icons: {primary: null}})
                                .addClass("buttonDownloadFile")
                                .on('click', function () { showDownloadComprobantes(); });

                        return $("<div>").append($customAddButton).append($customDownloadButton);
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
                        "<tr><td class=\"jsgrid-cell jsgrid-align-center\" style=\"width: 80px;\"><strong>Total</strong></td>" +
                        "<td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"></td>" +
                        "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td>" +
                        "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.Sum + "</strong></td>" +
                        "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td></tr>"
                        );
                args.grid._content.append(
                        "<tr><td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"><strong>Registros devueltos</strong></td>" +
                        "<td class=\"jsgrid-cell jsgrid-align-left\" style=\"width: 80px;\" colspan=\"4\"><strong>" + items.length  + "</strong></td></tr>"
                        );
              }
        });
    }
    
    function existsLiquidacion(mes) {
        var oDate = new Date();
        var retValue = db.liquidacionSueldo.find(ls =>ls._mes == mes && ls._año == oDate.getFullYear());
        return retValue !== undefined;
    }
    
    function execGenerateProcess(mes, ano) {
        showLoading();
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'generateLiquidacionSueldo',
                mes: mes,
                ano: ano
            }
        }).done(
            function (MessageResponse) {
                $('#generateDialog').dialog('close');
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
    }
    
});