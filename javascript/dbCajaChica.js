(function() {
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();
                var idCajaChica = 0;
                if (db.cajaChica !== undefined) {
                    idCajaChica = (db.cajaChica === null) ? 0 : db.cajaChica._idCajaChica;
                }
                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getMovimientosCCByIdCajaChica',
                        f_idCajaChica: idCajaChica,
                        f_descripcion: filter._descripcion,
                        f_idTipoMovimientoCC: filter._tipoMovimientoCC._idTipoMovimientoCC
                    }
                }).done(
                    function(response) {
                        db.movimientosCajaChica = response;
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
        insertItem: function(insertingClase) {
            //this.clase.push(insertingClase);
        },
        updateItem: function(updatingClase) { }
    };
    window.db = db;
})();

$(function(){
    //Primero cargamos la cajaChica
    getDatosCajaChica();

    //Cargamos los TipoMovimientoCC
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getTipoMovimientoCC_All' }
    }).done(
        //Una vez cargados los tipoMovimientoCC configuramos la grid para poder utilizar los tipos en los select
        function(jsonTipoMovimientoCCList) {
            //insertamos como primer elemento uno vacio
            jsonTipoMovimientoCCList.unshift({ _idTipoMovimientoCC: '0', _nombre: '' });
            
            //seteamos los datos en la variable db para poder utilizarlo luego
            db.tipoMovimientoCC = jsonTipoMovimientoCCList;
            
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
            sTipoMovimientoCC:{ required: true, min:1 },
            sRecibo: {required: false},
            tDescripcion: { required: true, maxlength: 50 },
            tValor: { required: true, number: true }
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
});

var formSubmitHandler = $.noop;
    
var showDetailsDialog = function(dialogType, movimientoCajaChica) {
    
    $('#tDescripcion').val(movimientoCajaChica._descripcion);
    $('#tValor').val(movimientoCajaChica._valor);
    
    if(dialogType === 'Nuevo') {
        $('#sTipoMovimientoCC').val("-1").select2();
        $('#sEmpleadoAdelanto').val("-1").select2();
        $('#sRecibo').val("-1").select2();
    } else {
        //Si se está editando un movimiento seteamos los controles con los datos de la base
        $('#sTipoMovimientoCC').val(movimientoCajaChica._tipoMovimientoCC._idTipoMovimientoCC).select2();
        $('#sEmpleadoAdelanto').val(movimientoCajaChica._adelanto._empleado._idEmpleado).select2();
        $('#sRecibo').val(movimientoCajaChica._recibo._idRecibo).select2();
    }

    if ($('#sTipoMovimientoCC').find("option:selected").text() === "Recibo") {
        $('#divRecibo').show();
        $('#divEmpleadoAdelanto').hide();
    } else if ($('#sTipoMovimientoCC').find("option:selected").text() === "Adelanto") {
        $('#divRecibo').hide();
        $('#divEmpleadoAdelanto').show();
    } else {
        $('#divRecibo').hide();
        $('#divEmpleadoAdelanto').hide();
    }
    
    formSubmitHandler = function() {
        saveMovimiento(movimientoCajaChica, dialogType === 'Nuevo');
    };

    $('#detailsDialog')
        .dialog('option', 'title', dialogType + ' movimiento')
        .dialog('open');
};

var saveMovimiento = function(movimientoCajaChica, isNew) {
    var idMovimientoCajaChica = isNew ? '0' : movimientoCajaChica._idMovimientoCajaChica;
    var idCajaChica = db.cajaChica._idCajaChica;
    var idTipoMovimientoCC = $('#sTipoMovimientoCC').val();
    var descripcion = $('#tDescripcion').val();
    var valor = $('#tValor').val();

    var idRecibo = 0;
    var idAdelanto = 0;
    var idEmpleadoAdelanto = 0;

    showLoading();

    if ($('#sTipoMovimientoCC').find("option:selected").text() === 'Recibo') {
        idRecibo = $('#sRecibo').val();
        idRecibo = idRecibo !== null ? idRecibo : 0;
    } else if ($('#sTipoMovimientoCC').find("option:selected").text() === 'Adelanto') {
        idAdelanto =  (movimientoCajaChica._adelanto === undefined) ? 0 :movimientoCajaChica._adelanto._idAdelanto;
        idEmpleadoAdelanto = $('#sEmpleadoAdelanto').val();
        idAdelanto = idAdelanto !== null ? idAdelanto : 0;
        idEmpleadoAdelanto = idEmpleadoAdelanto !== null ? idEmpleadoAdelanto : 0;
    }
    
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: {
            condicion: 'setMovimientoCajaChica',
            idMovimientoCajaChica: idMovimientoCajaChica,
            idCajaChica: idCajaChica,
            idTipoMovimientoCC: idTipoMovimientoCC,
            idRecibo: idRecibo,
            descripcion: descripcion,
            valor: valor,
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
            loadRecibos();
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
        deleteItem: function (item) {
            confirmDelete(item);
        },
        controller: db,
        fields: [
            { name: '_descripcion', type: 'text', width: 80, title: 'Descripción', sorting: false, filtering: true },
            {
                name: '_tipoMovimientoCC._idTipoMovimientoCC', 
                title: 'Tipo Movimiento', 
                type: 'select', 
                items: db.tipoMovimientoCC, valueField: '_idTipoMovimientoCC', textField: '_nombre',
                sorting: false, filtering: true
            },
            { name: '_valor', type: 'text', width: 80, title: 'Valor', align:'center', sorting: false, filtering: false },
            {
                type: 'control',
                modeSwitchButton: false,
                editButton: false,
                deleteButton: true,
                headerTemplate: function() {
                    return $('<button>').attr('type', 'button')
                            .attr('title', 'Agregar nuevo movimiento')
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
                "<tr><td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td>" + 
                "<td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"><strong>Total</strong></td>" +
                "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.Sum + "</strong></td>" +
                "</tr>"
            );
        }
    });
}

function configFormControls() {
    $('.select2').select2({language: "es"});

    //Cargamos select de tipoMovimientoCC para fomularios
    $.each(db.tipoMovimientoCC, function (index, data) {
        $("#sTipoMovimientoCC").append("<option value='" + data._idTipoMovimientoCC + "'>" + data._nombre + "</option>");
    });

    $("#sTipoMovimientoCC").select2().on('change', function (e) {
        var target = $(e.target);
        var value = target.val();
        var selectedText = target.find("option:selected").text();

        if (selectedText === "Recibo") {
            $('#divRecibo').show();
            $('#sEmpleadoAdelanto').rules('remove');
            $('#divEmpleadoAdelanto').hide();
        } else if (selectedText === "Adelanto") {
            $('#divRecibo').hide();
            $('#divEmpleadoAdelanto').show();
            $('#sEmpleadoAdelanto').rules('add',  { required: true });
        } else {
            $('#divRecibo').hide();
            $('#sEmpleadoAdelanto').rules('remove');
            $('#divEmpleadoAdelanto').hide();
        }
    });

    $("#sRecibo").select2().on('change', function (e) {
        var target = $(e.target);
        var value = target.val();
        var recibo = db.recibo.find(function(r) { return r._idRecibo === value; });
        $("#tValor").val(recibo._valor);
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

    //CargamosRecibos
    loadRecibos();
}

function getDatosCajaChica() {
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getCajaChicaActual' }
    }).done(
        function(jsonCajaChica){
            db.cajaChica = jsonCajaChica;
            if(jsonCajaChica !== null) {
                //Significa que hay actualmente una caja abierta!
                //Pongo visible el div donde se muestran los movimientos
                $("#divListadoMovimientos").css("visibility", "");
                
                //Muestro los datos de la caja chica
                setDatosFormCajaChica();

                //Recargamos jsGrid
                $("#jsGrid").jsGrid("loadData");
            } else {
                //Seteamos el formulario para abrir una nueva caja
                showFormNuevaCaja();
            }
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
}

function setDatosFormCajaChica() {
    $("#divDatosCC").css("display", "");
    $("#divFormAperturaCC").css("display", "none");
    var strDayHour = getDayAndHour(db.cajaChica._apertura);
    $('#spFechaApertura').text(strDayHour);
    $('#spEmpleado').text(db.cajaChica._empleado._nombreApellido);
    $('#spValorInicial').text(db.cajaChica._valorInicial);
}

function showFormNuevaCaja() {
    $("#divListadoMovimientos").css("visibility", "hidden");
    //Mostamos el formulario para abrir una nueva caja
    $("#divDatosCC").css("display", "none");
    $("#divFormAperturaCC").css("display", "");
}

function abrirCaja() {
    var idEmpleado = $('#sEmpleado').val();
    var oDate = new Date();
    var fechaApertura = oDate.getFullYear() + '-' + (oDate.getMonth() + 1) + '-' + oDate.getDate() + ' ' + oDate.getHours() + ':' + oDate.getMinutes() + ':' + oDate.getSeconds();

    if (idEmpleado === "0") {
        showModalMessage("#dm-SelEmpleado");
    } else {
        showLoading();
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'setCajaChica',
                idCajaChica: 0,
                apertura: fechaApertura,
                cierre: '',
                idEmpleado: idEmpleado,
                valorInicial: 0
            }
        }).done(
            function(jsonEmpleadoList) {
                getDatosCajaChica();
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
}

function cerrarCaja() {    
    showConfirmMessage("#dm-ConfirmCerrarCaja", "setCerrarCaja()");
}

function setCerrarCaja() {
    var idCajaChica = db.cajaChica._idCajaChica; 
    var idEmpleado = db.cajaChica._empleado._idEmpleado;
    var fechaApertura = db.cajaChica._apertura;
    var valorInicial = db.cajaChica._valorInicial;
    var oDate = new Date();
    var fechaCierre = oDate.getFullYear() + '-' + (oDate.getMonth() + 1) + '-' + oDate.getDate() + ' ' + oDate.getHours() + ':' + oDate.getMinutes() + ':' + oDate.getSeconds();
    
    showLoading();
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { 
            condicion: 'setCajaChica',
            idCajaChica: idCajaChica,
            apertura: fechaApertura,
            cierre: fechaCierre,
            idEmpleado: idEmpleado,
            valorInicial: valorInicial
        }
    }).done(
        function(jsonEmpleadoList) {
            showFormNuevaCaja();
            hideLoading();
            showModalMessage("#dm-CajaCerradaOK");
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            hideLoading();
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
}

function confirmDelete(item) {
    var execFunction = "deleteMovimientoCajaChica(" + item._idMovimientoCajaChica + ")";
    showConfirmMessage("#dm-ConfirmDeleteMovimiento", execFunction);
}

function deleteMovimientoCajaChica(idMovimientoCajaChica) {
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: {
            condicion: 'deleteMovimientoCajaChica',
            idMovimientoCajaChica: idMovimientoCajaChica
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
}

function loadRecibos() {
    //Cargamos los Recibos para cargar en el select del form
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { 
            condicion: 'getRecibos_All',
            f_numeroRecibo: 0,
            f_fechaDesde: '',
            f_fechaHasta: '',
            f_nombreEstudiante: '',
            f_valor: 0,
            f_promocion: ''
        }
    }).done(
        function(jsonReciboList) {
            //seteamos los datos en la variable db para poder utilizarlo luego
            db.recibo = jsonReciboList;
            $("#sRecibo").append("<option value='0'>(Seleccionar)</option>");
            $.each(db.recibo, function (index, data) {
                $("#sRecibo").append("<option value='" + data._idRecibo + "'>" + data._numeroRecibo + "</option>");
            });
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
}