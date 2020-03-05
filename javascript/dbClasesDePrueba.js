(function () {
    var db = {
        loadData:
            function (filter) {
                var def = $.Deferred();

                var dFechaDesde = (filter._fecha.from !== null) ? (filter._fecha.from.getFullYear() + '-' + (filter._fecha.from.getMonth() + 1) + '-' + filter._fecha.from.getDate()) : null;
                var dFechaHasta = (filter._fecha.to !== null) ? (filter._fecha.to.getFullYear() + '-' + (filter._fecha.to.getMonth() + 1) + '-' + filter._fecha.to.getDate()) : null;

                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type: 'GET',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: {
                        condicion: 'getClasesPrueba_All',
                        f_fechaDesde: dFechaDesde,
                        f_fechaHasta: dFechaHasta,
                        f_nombre: filter._nombre,
                        f_telefono: filter._telefono,
                        f_email: filter._email,
                        f_clase: filter._clase._idClase,
                        f_asistio: filter._asistio,
                        f_pago: filter._pago,
                        f_promo: filter._promo,
                        f_comoConocio: filter._comoConocio._idComoConocio,
                        f_comoContacto: filter._comoContacto._idComoContacto,
                        f_observaciones: filter._observaciones
                    }
                }).done(
                    function (response) {
                        //Ordenamos el listado para dejar en el top las clases que ya pasaron 
                        //y no se completó del todo el registro
                        let clasesPrueba = sortClasesPrueba(response); 
                        db.clasesPrueba = clasesPrueba;
                        def.resolve(clasesPrueba);
                    }
                ).fail(
                    function (jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                        alert(jqXHR.responseText);
                    }
                );
                return def.promise();
            },
        insertItem: function (insertingClase) { },
        updateItem: function (updatingClase) { }
    };

    window.db = db;
}());

$(function () {
    var flagFinCargaDatosSelectGrid = 0;
    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);

    //Cargamos tablas que utilizamos en campos select
    loadSecundaryTables();

    $('#detailsDialog').dialog({
        autoOpen: false,
        width: 450,
        close: function () {
            $('#detailsForm').validate().resetForm();
            $('#detailsForm').find('.error').removeClass('error');
        }
    });

    $('#detailsForm').validate({
        rules: {
            dFecha: { required: true },
            tNombre: { required: true, maxlength: 50 },
            tEmail: { email: true, maxlength: 255 },
            tTelefono: { maxlength: 50 },
            sClase: { required: true, min: 1 },
            /*sComoConocio: { min: 1 },
            sComoContacto: { min: 1 },*/
            tObservaciones: { maxlength: 255 }
        },
        invalidHandler: function (event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors)
                showModalMessage("#dialog-message");
        },
        submitHandler: function () {
            formSubmitHandler();
        },
        errorPlacement: function (error, element) {
            //Esto está sólo para no mostrar los mensajes de error!
            //Aquí mismo se podrían editar y mostrar los mensajes de forma customizada
        },
        highlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2")) {
                $("#select2-" + elem.context.name + "-container").parent().addClass(errorClass);
            } else
                elem.addClass(errorClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            var elem = $(element);
            if (elem.hasClass("select2")) {
                $("#select2-" + elem.context.name + "-container").parent().removeClass(errorClass);
            } else {
                elem.removeClass(errorClass);
            }
        }
    });

    var formSubmitHandler = $.noop;

    
    var showDetailsDialog = function (dialogType, clasePrueba) {
        var oDate = null;
        var oldCancelada = null;
        var oldFecha = null;

        $('#tNombre').val(clasePrueba._nombre);
        $('#tTelefono').val(clasePrueba._telefono);
        $('#tEmail').val(clasePrueba._email);
        $('#tObservaciones').val(clasePrueba._observaciones);

        if (dialogType === 'Nueva') {
            $('#dFecha').val("");
            $('#sClase').val('0').select2();
            $('#sAsistio').val(null).select2();
            $('#sPago').val(null).select2();
            $('#sPromo').val(null).select2();
            $('#sComoConocio').val('0').select2();
            $('#sComoContacto').val('0').select2();
            $('#chkCancelada').prop('checked', false);
        } else {
            oDate = new Date(clasePrueba._fecha);
            $('#dFecha').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());
            $('#sClase').val(clasePrueba._clase._idClase).select2();
            $('#sAsistio').val(clasePrueba._asistio).select2();
            $('#sPago').val(clasePrueba._pago).select2();
            $('#sPromo').val(clasePrueba._promo).select2();
            $('#sComoConocio').val(clasePrueba._comoConocio._idComoConocio).select2();
            $('#sComoContacto').val(clasePrueba._comoContacto._idComoContacto).select2();
            $('#chkCancelada').prop('checked', clasePrueba._cancelada);
            oldCancelada = clasePrueba._cancelada;
            oldFecha = oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear();
        }

        formSubmitHandler = function () {
            saveClasePrueba(clasePrueba, dialogType === 'Nueva', oldCancelada, oldFecha);
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' Clase de Prueba')
            .dialog('open');
    };

    
    var saveClasePrueba = function (clasePrueba, isNew, oldCancelada, oldFecha) {

        showLoading();

        var idClasePrueba = isNew ? '0' : clasePrueba._idClasePrueba;
        var fecha = $('#dFecha').val();
        var nombre = $('#tNombre').val();
        var telefono = $('#tTelefono').val();
        var email = $('#tEmail').val();
        var idClase = $('#sClase').val();
        var asistio = $('#sAsistio').val();
        var pago = $('#sPago').val();
        var promo = $('#sPromo').val();
        var idComoConocio = $('#sComoConocio').val();
        var idComoContacto = $('#sComoContacto').val();
        var observaciones = $('#tObservaciones').val();
        var cancelada = $('#chkCancelada').prop('checked');

        asistio = (asistio == 0 ? null : asistio);
        pago = (pago == 0 ? null : pago);
        promo = (promo == 0 ? null : promo);

        //Si comoConocio o comoContacto están seteados en "Otros" y no se agregó nada en el campo Observaciones
        //mostramos mensaje y cortamos ejecución
        if ((idComoConocio == get_idComoConocio_Otros() || idComoContacto == get_idComoContacto_Otros()) && observaciones == '') {
            alert('Debe de especificar en el campo "Observaciones" de que manera conoció y contactó el estudiante!');
            hideLoading();
            return;
        }

        $.ajax({
            url: './class/globalclass/execfunction.php',
            type: 'GET',
            contentType: 'application/json',
            dataType: 'json',
            data: {
                condicion: 'setClasePrueba',
                idClasePrueba: idClasePrueba,
                fecha: fecha,
                nombre: nombre,
                telefono: telefono,
                email: email,
                idClase: idClase,
                asistio: asistio,
                pago: pago,
                promo: promo,
                idComoConocio: idComoConocio,
                idComoContacto: idComoContacto,
                observaciones: observaciones,
                cancelada: cancelada
            }
        }).done(
            function (response) {
                //envío de mensaje por whatsApp
                if (response.clase != null) {
                    let mensaje = "";
                    let aFecha = fecha.split("/");
                    let date = new Date(aFecha[2] + "/" + aFecha[1] + "/" + aFecha[0]);
                    let dia = getDia_descripcion(date.getDay().toString()) + " " + date.getDate() + "/" + (date.getMonth() + 1);
                    if (isNew || (!isNew && fecha != oldFecha)) {
                        mensaje += "CLASE de PRUEBA - " + dia + " - " + response.clase._horaInicio + "hs - " + nombre;
                        send_whatsapp(response.clase._empleado._celular, mensaje);
                    } else if (cancelada && !oldCancelada) {
                        mensaje += "Cancelación clase de prueba del " + dia + " - " + response.clase._horaInicio + "hs";
                        send_whatsapp(response.clase._empleado._celular, mensaje);
                    }
                }
                $('#detailsDialog').dialog('close');
                $("#jsGrid").jsGrid("loadData");
                hideLoading();
            }
        ).fail(
            function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                alert(jqXHR.responseText);
                hideLoading();
            }
        );
    };

    function configJSGrid() {
        //Configuramos el lenguaje de la grid
        jsGrid.locale('es');
        
        $('#jsGrid').jsGrid({
            height: '1000px',
            width: '100%',
            filtering: true,
            editing: false,
            inserting: false,
            sorting: true,
            paging: true,
            autoload: true,
            pageSize: 50,
            pageButtonCount: 5,
            rowClick: function (args) {
                showDetailsDialog('Editar', args.item);
            },
            controller: db,
            fields: [
                {   
                    name: '_fecha', type: 'date', width: 80, title: 'Fecha', sorting: true, filtering: true,
                    itemTemplate: function(value) {
                        var date = new Date(value);
                        return getDia_descripcion(date.getDay().toString()).substring(0, 3) + " " + date.getDate() + " " + getMes_descripcion((date.getMonth() + 1).toString()).substring(0, 3);
                    }
                },
                { 
                    name: '_nombre', type: 'text', width: 150, title: 'Nombre y Apellido', sorting: true,
                    itemTemplate: function(value) {
                        return value.split(" ", 2).join(" ");
                    }
                },
                {
                    name: '_clase._idClase',
                    title: 'Clase',
                    type: 'select',
                    items: db.clase, valueField: '_idClase', textField: '_descripcion',
                    sorting: false,
                    itemTemplate: function(value, item) {
                        return item._clase._dia._nombre.substring(0, 3) + " " + item._clase._horaInicio + " " + item._clase._empleado._nombreApellido.split(" ", 1);
                    }
                },
                {
                    name: '_asistio',
                    title: 'Asistió',
                    width: 70,
                    type: 'select',
                    items: db.asistio, valueField: '_id', textField: '_descripcion',
                    sorting: false
                },
                {
                    name: '_pago',
                    title: 'Pagó',
                    width: 70,
                    type: 'select',
                    items: db.pago, valueField: '_id', textField: '_descripcion',
                    sorting: false
                },
                {
                    name: '_promo',
                    title: 'Promo',
                    width: 70,
                    type: 'select',
                    items: db.promo, valueField: '_value', textField: '_descripcion',
                    sorting: false
                },
                { name: '_telefono', type: 'text', width: 100, title: 'Teléfono', sorting: true, filtering: true },
                { name: '_email', type: 'text', width: 190, title: 'Email', sorting: false, filtering: true },
                {
                    name: '_comoConocio._idComoConocio',
                    width: 130,
                    title: 'Cómo conoció?',
                    type: 'select',
                    items: db.comoConocio, valueField: '_idComoConocio', textField: '_nombre',
                    sorting: false
                },
                {
                    name: '_comoContacto._idComoContacto',
                    width: 130,
                    title: 'Cómo contactó?',
                    type: 'select',
                    items: db.comoContacto, valueField: '_idComoContacto', textField: '_nombre',
                    sorting: false,
                    width: 150
                },
                { 
                    name: '_observaciones', type: 'text', width: 170, 
                    title: 'Observaciones', sorting: false, filtering: true,
                    itemTemplate: function(value) {
                        let obs = value.split(" ", 3).join(" ");
                        obs += (value.split(" ").length > 3 ? "..." : "");
                        return obs;
                    }
                },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    width: 95,
                    headerTemplate: function () {
                        var $customAddButton = $('<button>').attr('type', 'button')
                            .attr('title', 'Agregar clase de prueba')
                            .button({ icons: { primary: null } })
                            .addClass("buttonAdd")
                            .on('click', function () { showDetailsDialog('Nueva', {}); });

                        var $customDownloadButton = $('<button>').attr('type', 'button')
                            .attr('title', 'Descargar listado de mails')
                            .button({icons: {primary: null}})
                            .addClass("buttonDownloadFile")
                            .on('click', function () { downloadMails(); });

                        return $("<div>").append($customAddButton).append($customDownloadButton);
                    },
                    itemTemplate: function(value, item) {
                        let msg = "Hola " + item._clase._empleado._nombreApellido.split(" ", 1) + "!";
                        return $('<button>').attr('type', 'button')
                                .attr('title', 'Enviar mensaje de WhatsApp')
                                .button({icons: {primary: null}})
                                .addClass("buttonWhatsApp")
                                .on('click', function (e) { send_whatsapp(item._clase._empleado._celular, msg); e.stopPropagation(); });
                    }
                }
            ],
            rowClass: function(item, itemIndex) {
                let class_style = '';
                let date_now = new Date(Date.now());
                let dateClase = new Date(item._fecha + ' ' + item._clase._horaInicio);
                if (item._asistio == idAsistio_Cerrado || (dateClase <= date_now && item._asistio != null && item._asistio != idAsistio_No && item._pago != null))
                    class_style = 'bg-green';
                else if (item._cancelada || item._asistio == idAsistio_No)
                    class_style = 'bg-orange';
                else if (dateClase <= date_now && (item._asistio == null || item._pago == null))
                    class_style = 'bg-red';
                return class_style;
            },
            onRefreshed: function (args) {
                var items = args.grid.option("data");
                args.grid._content.append(
                    "<tr><td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 100px;\"><strong>Registros devueltos</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-left\" style=\"width: 80px;\" colspan=\"6\"><strong>" + items.length + "</strong></td></tr>"
                );
            }
        });
    }

    var downloadMails = function() {
        showLoading();
        
        var grid = $("#jsGrid").data("JSGrid");
        
        var f_fechaDesde = grid.fields[0]._fromPicker[0].value !== "" ? convertStringDate_To_EnglishFormat(grid.fields[0]._fromPicker[0].value) : null;
        var f_fechaHasta = grid.fields[0]._toPicker[0].value !== "" ? convertStringDate_To_EnglishFormat(grid.fields[0]._toPicker[0].value) : null;
        var f_nombre = grid.fields[1].filterControl[0].value;
        var f_clase = grid.fields[2].filterControl[0].value;
        var f_asistio = grid.fields[3].filterControl[0].value;
        var f_pago = grid.fields[4].filterControl[0].value;
        var f_promo = grid.fields[5].filterControl[0].value;
        var f_telefono = grid.fields[6].filterControl[0].value;
        var f_email = grid.fields[7].filterControl[0].value;
        var f_comoConocio = grid.fields[8].filterControl[0].value;
        var f_comoContacto = grid.fields[9].filterControl[0].value;
        var f_observaciones = grid.fields[10].filterControl[0].value;
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'downloadMails_ClasesDePrueba',
                f_fechaDesde: f_fechaDesde,
                f_fechaHasta: f_fechaHasta,
                f_nombre: f_nombre,
                f_clase: f_clase,
                f_asistio: f_asistio,
                f_pago: f_pago,
                f_promo: f_promo,
                f_telefono: f_telefono,
                f_email: f_email,
                f_comoConocio: f_comoConocio,
                f_comoContacto: f_comoContacto,
                f_observaciones: f_observaciones
            }
        }).done(
            function (MessageResponse) {
                if (MessageResponse === 1)
                    downloadFile('alumnos_mails_clasesdeprueba.txt');
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

    function configFormControls() {
        $("#dFecha").datepicker();
        $('#sClase').val("-1").select2();
        $('#sAsistio').val("-1").select2();
        $('#sPago').val("-1").select2();
        $('#sPromo').val("-1").select2();
        $('#sComoConocio').val("-1").select2();
        $('#sComoContacto').val("-1").select2();

        //Cargamos select de Clases para fomularios
        $.each(db.clase, function (index, data) {
            if (index == 0)
                $("#sClase").append("<option value='" + data._idClase + "'>" + data._descripcion + "</option>");
            else {
                //sólo cargamos las clases activas
                if (data._estadoClase._idEstadoClase == '1') // == 'Activa'
                    $("#sClase").append("<option value='" + data._idClase + "'>" + data._descripcion + "</option>");
            }
        });

        $.each(db.comoConocio, function (index, data) {
            $("#sComoConocio").append("<option value='" + data._idComoConocio + "'>" + data._nombre + "</option>");
        });

        $.each(db.comoContacto, function (index, data) {
            $("#sComoContacto").append("<option value='" + data._idComoContacto + "'>" + data._nombre + "</option>");
        });

        $.each(db.asistio, function (index, data) {
            $("#sAsistio").append("<option value='" + data._id + "'>" + data._descripcion + "</option>");
        });

        $.each(db.pago, function (index, data) {
            $("#sPago").append("<option value='" + data._id + "'>" + data._descripcion + "</option>");
        });

        $.each(db.promo, function (index, data) {
            $("#sPromo").append("<option value='" + data._value + "'>" + data._descripcion + "</option>");
        });
    }

    function loadSecundaryTables() {

        //cargamos datos que vienen de constants.js
        db.asistio = get_array_asistio();
        db.pago = get_array_pago();
        db.promo = get_array_promo();

        //Primero cargamos los estadosEstudiantes
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type: 'GET',
            contentType: 'application/json',
            dataType: 'json',
            data: { condicion: 'getComoConocio_All' }
        }).done(
            //Una vez cargados los datos configuramos la grid para poder utilizarlos en los select
            function (jsonComoConocioList) {
                //insertamos como primer elemento uno vacio
                jsonComoConocioList.unshift({ _idComoConocio: '0', _nombre: '' });

                //seteamos los datos en la variable db para poder utilizarlo luego
                db.comoConocio = jsonComoConocioList;

                flagFinCargaDatosSelectGrid++;
                if (flagFinCargaDatosSelectGrid == 3) {
                    //Configuramos el control jsGrid
                    configJSGrid();

                    //Seteamos y configuramos controles del formulario de detalle
                    configFormControls();
                }
            }
        ).fail(
            function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );

        //Cargamos la tabla de comoContacto y el select
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type: 'GET',
            contentType: 'application/json',
            dataType: 'json',
            data: { condicion: 'getComoContacto_All' }
        }).done(
            function (jsonComoContactoList) {
                jsonComoContactoList.unshift({ _idComoContacto: '0', _nombre: '' });
                db.comoContacto = jsonComoContactoList;

                flagFinCargaDatosSelectGrid++;
                if (flagFinCargaDatosSelectGrid == 3) {
                    //Configuramos el control jsGrid
                    configJSGrid();

                    //Seteamos y configuramos controles del formulario de detalle
                    configFormControls();
                }
            }
        ).fail(
            function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );

        //Cargamos la tabla de clases y el select
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type: 'GET',
            contentType: 'application/json',
            dataType: 'json',
            data: { 
                condicion: 'getClases_All',
                f_emple_nombreApellido: '',
                f_idEstadoClase: 0,
                f_idDia: 0,
                f_descripcion: ''
            }
        }).done(
            function (jsonClasesList) {
                jsonClasesList.unshift({ _idClase: '0', _descripcion: '' });
                
                for (let i = 1; i < jsonClasesList.length; i++) {
                    jsonClasesList[i]._descripcion = jsonClasesList[i]._dia._nombre.substring(0, 3) + ' ' + jsonClasesList[i]._horaInicio + ' - ' + jsonClasesList[i]._empleado._nombreApellido.split(" ", 1)[0];
                }

                db.clase = jsonClasesList;

                flagFinCargaDatosSelectGrid++;
                if (flagFinCargaDatosSelectGrid == 3) {
                    //Configuramos el control jsGrid
                    configJSGrid();

                    //Seteamos y configuramos controles del formulario de detalle
                    configFormControls();
                }
            }
        ).fail(
            function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );
    }

});

//Función para colocar en el top las clases que ya pasaron y no se asignaron
//las propiedades de 'asistió' y 'pagó'
function sortClasesPrueba(clasesPrueba_list) {
    var sort_list = new Array();
    var top_list = new Array();
    var date_now = new Date(Date.now());
    $.each(clasesPrueba_list, (i, clasePrueba) => {
        let dateClase = new Date(clasePrueba._fecha + ' ' + clasePrueba._clase._horaInicio);
        if (dateClase <= date_now) {
            if (clasePrueba._asistio == idAsistio_Cerrado || (clasePrueba._asistio != null && clasePrueba._pago != null))
                sort_list.push(clasePrueba);
            else if (clasePrueba._cancelada || clasePrueba._asistio == null || clasePrueba._pago == null)
                top_list.push(clasePrueba);
            else
                sort_list.push(clasePrueba);
        } else if (clasePrueba._cancelada) {
            top_list.push(clasePrueba);
        } else 
            sort_list.push(clasePrueba);
    });

    //agregamos al inicio de la lista los elementos de top_list comenzando del final para mantener el ordenamiento
    for (let i = top_list.length - 1; i >= 0; i--)
        sort_list.unshift(top_list[i]);

    return sort_list;
}