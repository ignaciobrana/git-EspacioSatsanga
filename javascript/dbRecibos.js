(function() {  
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();
                
                var dFechaDesde = (filter._fecha.from !== null) ? (filter._fecha.from.getFullYear() + '-' + (filter._fecha.from.getMonth() + 1) + '-' + filter._fecha.from.getDate()) : null;
                var dFechaHasta = (filter._fecha.to !== null) ? (filter._fecha.to.getFullYear() + '-' + (filter._fecha.to.getMonth() + 1) + '-' + filter._fecha.to.getDate()) : null;
                var iNumeroRecibo = (filter._numeroRecibo !== undefined) ? filter._numeroRecibo : 0;
                var iValor = (filter._valor !== undefined) ? filter._valor : 0;
                var tPromocion = (filter._promocion !== undefined) ? filter._promocion : null;
                
                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getRecibos_All',
                        f_numeroRecibo: iNumeroRecibo,
                        f_fechaDesde: dFechaDesde,
                        f_fechaHasta: dFechaHasta,
                        f_nombreEstudiante: filter._nombreEstudiante,
                        f_valor: iValor,
                        f_promocion: tPromocion
                    }
                }).done(
                    function(response) {
                        db.recibos = response;
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
    var firstTime = true; //bandera para indicar que se está abriendo popup de edición
    var idRecibo = -1; //utilizamos esta variable en la función existeReciboEstudiante, y es seteada en 0 cuando es un nuevo recibo
    
    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);
    
    //Configuramos el control jsGrid
    configJSGrid();

    //Seteamos y configuramos controles del formulario de detalle
    configFormControls();
        
    $('#detailsDialog').dialog({
        autoOpen: false,
        width: 400,
        close: function() {
            $('#detailsForm').validate().resetForm();
            $('#detailsForm').find('.error').removeClass('error');
            firstTime = true; //reseteamos la bandera
        }
    });
    
    $('#detailsForm').validate({
        rules: {
            tNumeroRecibo: 'required',
            dFecha: { required: true },
            sEstudiante:{ required: false, min: 1 },
            tVecesPorSemana: { required: true, max: 5 },
            sClases:{ required: true, min: 1 },
            tObservaciones: { maxlength: 100 },
            tValor: { required: true, number: true },
            tPromocion: { maxlength: 15 }
        },
        invalidHandler: function(event, validator) {
            var errors = validator.numberOfInvalids();
            
            if (errors && existeReciboEstudiante($("#sEstudiante").val(), $("#dFecha").val())) {
                showModalMessage("#error-message-ReciboEstudianteMes");
                return;
            }
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
                if (element.id === "sEstudiante")
                    $(".select2-selection--single").addClass(errorClass);
                else if (element.id === "sClases")
                    $(".select2-selection--multiple").addClass(errorClass);
            } else if (element.id === "dFecha") {
                if (existeReciboEstudiante($('#sEstudiante').val(), elem.val()))
                    elem.addClass(errorClass);
                else
                    elem.removeClass(errorClass);
            } else
                    elem.addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2")) {
                if (element.id === "sEstudiante")
                    $(".select2-selection--single").removeClass(errorClass);
                else if (element.id === "sClases")
                    $(".select2-selection--multiple").removeClass(errorClass);
            } else if(element.id === "dFecha") {
                if (existeReciboEstudiante($('#sEstudiante').val(), elem.val()))
                    elem.addClass(errorClass);
                else
                    elem.removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        }
    });

    var formSubmitHandler = $.noop;

    var showDetailsDialog = function(dialogType, recibo) {
        var oDate = null;
        
        $('#tNumeroRecibo').val(recibo._numeroRecibo);
        $('#tVecesPorSemana').val(recibo._vecesPorSemana);
        $('#tObservaciones').val(recibo._observaciones);
        $('#tValor').val(recibo._valor);
        $('#tPromocion').val(recibo._promocion);
        $('#cbProximoMes')[0].checked = (recibo._proximoMes == "1");
        
        //Limpiamos el control por si queda con información antigua
        $('#sClases').val(null).trigger('change');

        if(dialogType === 'Nuevo') {
            oDate = new Date();
            $('#dFecha').val(oDate.getDate() + "/" + (oDate.getMonth() + 1) + "/" + oDate.getFullYear());
            $('#sEstudiante').val("-1").select2();
            $('#sFactura').val("-1").select2();
            
            //Proponemos próximo N°Recibo
            $('#tNumeroRecibo').val(getNewNumeroRecibo());            
        } else {
            //Si se está editando un recibo seteamos los controles con los datos de la base
            if (recibo._estudiante != null)
                $('#sEstudiante').val(recibo._estudiante._idEstudiante).select2();
            else
                $('#sEstudiante').val("-1").select2();
            
            if (recibo._factura != null)
                $('#sFactura').val(recibo._factura._idFactura).select2();
            else
                $('#sFactura').val("-1").select2();
            
            oDate = new Date(recibo._fecha);
            $('#dFecha').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
            
            //Seteamos el control multiple seleccionando las clases asociadas al recibo en edición
            setSelectedClasesInControl(recibo._idRecibo);
        }

        formSubmitHandler = function() {
            saveRecibo(recibo, dialogType === 'Nuevo');
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' recibo')
            .dialog('open');
    };

    var saveRecibo = function(recibo, isNew) {
        var idRecibo = isNew ? '0' : recibo._idRecibo;
        var numeroRecibo = $('#tNumeroRecibo').val();
        var fecha = $('#dFecha').val();
        var idEstudiante = $('#sEstudiante').val();
        var vecesPorSemana = $('#tVecesPorSemana').val();
        var idClases = $('#sClases').val().join(',');
        var observaciones = $('#tObservaciones').val();
        var valor = $('#tValor').val();
        var promocion = $('#tPromocion').val();
        var idFactura = $('#sFactura').val();
        var proximoMes = ($('#cbProximoMes')[0].checked ? 1 : 0);
        
        //Validamos que no exista un recibo con el mismo numero
        if(existsNumeroRecibo(recibo._idRecibo, numeroRecibo)){
            showModalMessage("#error-message-NumRecibo");
            return;
        }
        
        //Validamos que no exista un recibo para el estudiante en el mes seleccionado
        if (existeReciboEstudiante($('#sEstudiante').val(), $('#dFecha').val())) {
            $("[aria-labelledby='select2-sEstudiante-container']").addClass("error");
            $("#dFecha").addClass("error");
            showModalMessage("#error-message-ReciboEstudianteMes");
            return;
        } else {
            $("[aria-labelledby='select2-sEstudiante-container']").removeClass("error");
            $("#dFecha").removeClass("error");
        }
        
        showLoading();
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'setRecibo',
                idRecibo: idRecibo,
                numeroRecibo: numeroRecibo,
                fecha: fecha,
                idEstudiante: idEstudiante,
                vecesPorSemana: vecesPorSemana,
                idClases: idClases,
                observaciones: observaciones,
                valor: valor,
                promocion: promocion,
                idFactura: idFactura,
                proximoMes: proximoMes
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
                idRecibo = args.item._idRecibo;
                showDetailsDialog('Editar', args.item);
            },
            controller: db,
            fields: [
                { name: '_numeroRecibo', type: 'number', width: 80, title:'N°Recibo', sorting: true, align: 'center' },
                { name: '_nombreEstudiante', type: 'text', width: 80, title:'Estudiante' },
                { name: '_valor', type: 'number', width: 80, title:'Valor', sorting: true, align: 'center' },
                { name: '_promocion', type: 'text', title:'Promo' },
                { name: '_fecha', type: 'date', width: 80, title: 'Fecha', sorting: true, align: 'center' },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    headerTemplate: function() {
                        return $('<button>').attr('type', 'button')
                                .attr('title', 'Agregar recibo nuevo')
                                .button({icons: {primary: null}})
                                .addClass("buttonAdd")
                                .on('click', function () {
                                    idRecibo = 0;
                                    showDetailsDialog('Nuevo', {}); 
                                });
                    }
                }
            ],
            rowClass:
                function(item, itemIndex) {
                    return (item._clases.length == 0 && item._factura == null && item._estudiante == null) ? 'bg-red' : '';
                },
            onRefreshed: 
                function(args) {
                    var items = args.grid.option("data");
                    var total = { Name: "Total", "Sum": 0, IsTotal: true };

                    items.forEach(function(item) {
                        total.Sum += parseInt(item._valor);
                    });

                    args.grid._content.append(
                            "<tr><td class=\"jsgrid-cell jsgrid-align-center\" style=\"width: 80px;\"><strong>Total</strong></td>" +
                            "<td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"></td>" +
                            "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.Sum + "</strong></td>" +
                            "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td>" +
                            "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td>" +
                            "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td></tr>"
                            );
                    args.grid._content.append(
                            "<tr><td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"><strong>Registros devueltos</strong></td>" +
                            "<td class=\"jsgrid-cell jsgrid-align-left\" style=\"width: 80px;\" colspan=\"5\"><strong>" + items.length  + "</strong></td></tr>"
                            );
                }
        });
    }
    
    function configFormControls(){
        //seteamos lenguaje de controles e inicializamos los mismos
        $('.select2').select2({language: "es"});
        $("#sClases").select2({placeholder: ""});
        
        //evento para cambiar clase de 'error' cuando cambia el control
        $("#sClases").select2().on('change', function () {
            if (firstTime) { firstTime = false; return; }
            var vValues = $("#sClases").val();
            if(vValues !== null && !vValues.find(val => val === "0"))
                $(".select2-selection--multiple").removeClass("error");
            else
                $(".select2-selection--multiple").addClass("error");
        });
        
        //evento para cambiar clase de 'error' cuando cambia el control
        $("#sEstudiante").select2().on('change', function () {
            var value = $("#sEstudiante").val();
            if(value !== null && value !== "0") {
                $("[aria-labelledby='select2-sEstudiante-container']").removeClass("error");
                //chequeamos que el estudiante no tenga un recibo cargado en el mes seleccionado
                if (existeReciboEstudiante(value, $('#dFecha').val())) {
                    $("[aria-labelledby='select2-sEstudiante-container']").addClass("error");
                    $("#dFecha").addClass("error");
                    showModalMessage("#error-message-ReciboEstudianteMes");
                } else {
                    $("[aria-labelledby='select2-sEstudiante-container']").removeClass("error");
                    $("#dFecha").removeClass("error");
                }
            } else
                $("[aria-labelledby='select2-sEstudiante-container']").addClass("error");
        });
        
        $('#dFecha').datepicker().on('change', function (){
            var value = $("#dFecha").val();
            if(value !== null) {
                //chequeamos que el estudiante no tenga un recibo cargado en el mes seleccionado
                if (existeReciboEstudiante($('#sEstudiante').val(), value)) {
                    $("[aria-labelledby='select2-sEstudiante-container']").addClass("error");
                    $("#dFecha").addClass("error");
                    showModalMessage("#error-message-ReciboEstudianteMes");
                } else {
                    $("[aria-labelledby='select2-sEstudiante-container']").removeClass("error");
                    $("#dFecha").removeClass("error");
                }
            }
        });
        
        //Cargamos los Estudiantes que se encuentran Activos para cargar en el select del form
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'getEstudiantes_All',
                f_nombreApellido: '',
                f_email: '',
                f_celular: '',
                f_idEstadoEstudiante: '0',
                f_fechaAltaDesde: null,
                f_fechaAltaHasta: null,
                f_idComoConocio: '0',
                f_fechaBajaDesde: null,
                f_fechaBajaHasta: null
            }
        }).done(
            function(jsonEstudianteList){
                //seteamos los datos en la variable db para poder utilizarlo luego
                db.estudiante = jsonEstudianteList;
                $.each(db.estudiante, function (index, data) {
                    $("#sEstudiante").append("<option value='" + data._idEstudiante + "'>" + data._nombreApellido + "</option>");
                });
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );
        
        //Cargamos las Clases que se encuentran en estado "Activa" para setear el select del form
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'getClaseByEstado', 
                f_idEstadoClase: '1' //"Activa" 
            }
        }).done(
            function(jsonClasesActivasList) {
                //seteamos los datos en la variable db para poder utilizarlo luego
                db.clasesActivas = jsonClasesActivasList;
                var duracion = '';
                $.each(db.clasesActivas, function (index, data) {
                    if (data._duracion[0] === '0' && data._duracion[1] === '0')
                        duracion = data._duracion[3] + data._duracion[4] + '\'';
                    else
                        duracion = '60\'';
                    $("#sClases").append("<option value='" + data._idClase + "'>" + data._dia._nombre.substring(0, 3) + " " + data._horaInicio + " / " + data._empleado._nombreApellido + " " + duracion + "</option>");
                });
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );

        //Cargamos las Facturas para asociar al recibo
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'getFacturas_All',
                f_numeroFactura: 0,
                f_cliente: '',
                f_total: 0,
                f_fechaDesde: null,
                f_fechaHasta: null
            }
        }).done(
            function(jsonFacturaList){
                //seteamos los datos en la variable db para poder utilizarlo luego
                db.factura = jsonFacturaList;
                $.each(db.factura, function (index, data) {
                    $("#sFactura").append("<option value='" + data._idFactura + "'>N° " + data._numeroFactura + " / Cliente: " + data._cliente + "</option>");
                });
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );

    }
    
    function setSelectedClasesInControl(idRecibo){
        //Cargamos las Clases correspondientes al idRecibo y las seleccionamos en el select que ya se encuentra
        //cargado con las Clases Activas
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'getClaseByIdRecibo',
                f_idRecibo: idRecibo
            }
        }).done(
            function(jsonClasesList){
                var vIds = new Array();
                $.each(jsonClasesList, function (index, data) {
                    vIds.push(data._idClase);
                });
                $('#sClases').val(vIds);
                $('#sClases').trigger('change');
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );
    }
    
    function existsNumeroRecibo(idRecibo, numeroRecibo){
        var retValue = db.recibos.find(recibo =>recibo._idRecibo != idRecibo && recibo._numeroRecibo === numeroRecibo);
        return retValue !== undefined;
    }
    
    function getNewNumeroRecibo() {
        var vNumRec = new Array();
        var maxNumRec = 0;    
        $.each(db.recibos, function (index, data) {
            vNumRec.push(data._numeroRecibo);
        });
        maxNumRec = Math.max.apply(null, vNumRec);
        return maxNumRec + 1;
    }
    
    function existeReciboEstudiante (idEstudiante, fecha) {
        var mesActual = fecha.split("/")[1];
        var añoActual = fecha.split("/")[2];
        mesActual = (mesActual.length === 1 ? "0" + mesActual : mesActual);
        
        //recibo._fecha -> tiene el formato mes/dia/año
        var retValue = db.recibos.find(r =>r._idRecibo != idRecibo && r._estudiante != null && r._estudiante._idEstudiante == idEstudiante && r._fecha.split("/")[0] == mesActual && r._fecha.split("/")[2] == añoActual);
        return retValue !== undefined;
    }
    
});