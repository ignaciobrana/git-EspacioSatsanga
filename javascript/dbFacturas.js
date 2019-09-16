(function() {  
    var db = {
        loadData: 
            function(filter) {
                var def = $.Deferred();
                
                var dFechaDesde = (filter._fecha.from !== null) ? (filter._fecha.from.getFullYear() + '-' + (filter._fecha.from.getMonth() + 1) + '-' + filter._fecha.from.getDate()) : null;
                var dFechaHasta = (filter._fecha.to !== null) ? (filter._fecha.to.getFullYear() + '-' + (filter._fecha.to.getMonth() + 1) + '-' + filter._fecha.to.getDate()) : null;
                var iNumeroFactura = (filter._numeroFactura !== undefined) ? filter._numeroFactura : 0;
                var iTotal = (filter._total !== undefined) ? filter._total : 0;
                
                $.ajax({
                    url: './class/globalclass/execfunction.php',
                    type : 'GET',
                    contentType : 'application/json',
                    dataType : 'json',
                    data: { 
                        condicion: 'getFacturas_All',
                        f_numeroFactura: iNumeroFactura,
                        f_fechaDesde: dFechaDesde,
                        f_fechaHasta: dFechaHasta,
                        f_cliente: filter._cliente,
                        f_total: iTotal
                    }
                }).done(
                    function(response) {
                        db.facturas = response;
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
        insertItem: function(insertingFactura) {
            //this.factura.push(insertingFactura);
        },
        updateItem: function(updatingFactura) { }
    };
    window.db = db;
}());

$(function() {
    var firstTime = true; //bandera para indicar que se está abriendo popup de edición
    
    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);
    
    //Configuramos el control jsGrid
    configJSGrid();

    //Seteamos y configuramos controles del formulario de detalle
    configFormControls();
    
    $('#detailsDialog').dialog({
        autoOpen: false,
        width: 450,
        close: function() {
            $('#detailsForm').validate().resetForm();
            $('#detailsForm').find('.error').removeClass('error');
            firstTime = true; //reseteamos la bandera
        }
    });
    
    $('#detailsForm').validate({
        rules: {
            tNumeroFactura: 'required',
            dFecha: { required: true },
            sEstudiante:{ required: true, min:1 },
            sEmpresa:{ required: true, min:1 },
            tCliente: { required: true, maxlength: 50 },
            tDetalle: { required: true, maxlength: 200 },
            tTotal: { required: true, number: true }
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
    
    var showDetailsDialog = function(dialogType, factura) {
        var oDate = null;
        
        $('#tNumeroFactura').val(factura._numeroFactura);
        $('#tCliente').val(factura._cliente);
        $('#tDomicilio').val(factura._domicilio);
        $('#tLocalidad').val(factura._localidad);
        $('#tTelefono').val(factura._telefono);
        $('#tCuit').val(factura._cuit);
        $('#tDetalle').val(factura._detalle);
        $('#tTotal').val(factura._total);
                        
        if(dialogType === 'Nuevo') {
            oDate = new Date();
            $('#dFecha').val(oDate.getDate() + "/" + (oDate.getMonth() + 1) + "/" + oDate.getFullYear());
            $('#sEstudiante').val("-1").select2();
            $('#sEmpresa').val("-1").select2();
            
            //Proponemos próximo N°Factura
            $('#tNumeroFactura').val(getNewNumeroFactura()); 
            
            //escondemos ambos divs Empresa y Estudiante, hasta que se seleccione una opción en el radiobutton
            $('#rEstudiante').prop('checked', false).checkboxradio("refresh");
            $('#rEmpresa').prop('checked', false).checkboxradio("refresh");
            $('#divEmpresa').hide();
            $('#divEstudiante').hide();
        } else {
            //Si se está editando una factura seteamos los controles con los datos de la base
            $('#sEstudiante').val(factura._estudiante._idEstudiante).select2();
            $('#sEmpresa').val(factura._empresa._idEmpresa).select2();
            
            oDate = new Date(factura._fecha);
            $('#dFecha').val(oDate.getDate() + '/' + (oDate.getMonth() + 1) + '/' + oDate.getFullYear());

            if(factura._estudiante._idEstudiante != null && factura._estudiante._idEstudiante != 0 && factura._estudiante._idEstudiante != '0') {
                $('#rEstudiante').prop('checked', true).checkboxradio("refresh");
                $('#rEmpresa').prop('checked', false).checkboxradio("refresh");
                $('#divEstudiante').show();
                $('#divEmpresa').hide();
            } else if(factura._empresa._idEmpresa != null && factura._empresa._idEmpresa != 0 && factura._empresa._idEmpresa != '0') {
                $('#rEmpresa').prop('checked', true).checkboxradio("refresh");
                $('#rEstudiante').prop('checked', false).checkboxradio("refresh");
                $('#divEmpresa').show();
                $('#divEstudiante').hide();
            } else {
                $('#divEmpresa').hide();
                $('#divEstudiante').hide();
            }
        }

        formSubmitHandler = function() {
            saveFactura(factura, dialogType === 'Nuevo');
        };

        $('#detailsDialog')
            .dialog('option', 'title', dialogType + ' factura')
            .dialog('open');
    };

    var saveFactura = function(factura, isNew) {
        var idFactura = isNew ? '0' : factura._idFactura;
        var numeroFactura = $('#tNumeroFactura').val();
        var fecha = $('#dFecha').val();
        var idEstudiante = $("#rEstudiante").prop('checked') ? $('#sEstudiante').val() : null;
        var idEmpresa = $("#rEmpresa").prop('checked') ? $('#sEmpresa').val() : null;
        var cliente = $('#tCliente').val();
        var domicilio = $('#tDomicilio').val();
        var localidad = $('#tLocalidad').val();
        var telefono = $('#tTelefono').val();
        var cuit = $('#tCuit').val();
        var detalle = $('#tDetalle').val();
        var total = $('#tTotal').val();
        
        //seteamos la bandera
        //firstTime = false;
        
        if(existsNumeroFactura(factura._idFactura, numeroFactura)){
            showModalMessage("#error-message-NumFactura");
            return;
        } else
            showLoading();
        
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: {
                condicion: 'setFactura',
                idFactura: idFactura,
                numeroFactura: numeroFactura,
                fecha: fecha,
                idEstudiante: idEstudiante,
                idEmpresa: idEmpresa,
                cliente: cliente,
                domicilio: domicilio,
                localidad: localidad,
                telefono: telefono,
                cuit: cuit,
                detalle: detalle,
                total: total
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
                { name: '_numeroFactura', type: 'number', width: 80, title:'N°Factura', sorting: true, align: 'center' },
                { name: '_cliente', type: 'text', width: 80, title:'Cliente' },
                { name: '_total', type: 'number', width: 80, title:'Total', sorting: true, align: 'center' },
                { name: '_fecha', type: 'date', width: 80, title: 'Fecha', sorting: true, align: 'center' },
                {
                    type: 'control',
                    modeSwitchButton: false,
                    editButton: false,
                    deleteButton: false,
                    headerTemplate: function() {
                        return $('<button>').attr('type', 'button')
                                .attr('title', 'Agregar nueva factura')
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
                    total.Sum += parseInt(item._total);
                });
                
                args.grid._content.append(
                    "<tr><td class=\"jsgrid-cell jsgrid-align-center\" style=\"width: 80px;\"><strong>Total</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.Sum + "</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-right\"><strong></strong></td></tr>"
                );
                
                args.grid._content.append(
                    "<tr><td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"><strong>Registros devueltos</strong></td>" +
                    "<td class=\"jsgrid-cell jsgrid-align-left\" style=\"width: 80px;\" colspan=\"4\"><strong>" + items.length  + "</strong></td></tr>"
                );
            }
        });
    }
    
    function configFormControls() {
        
        $('#dFecha').datepicker();
        
        //seteamos lenguaje de controles e inicializamos los mismos
        $('.select2').select2({language: "es"});
        
        //configuramos radiobuttons y seteamos funcion para el evento onChange
        $("[type=radio]").checkboxradio();
        $("[name='rFacturaPara']").on('change', function (e) {
            var target = $( e.target );
            
            //Limpiamos controles
            $('#tCliente').val(null);
            $('#tDomicilio').val(null);
            $('#tLocalidad').val(null);
            $('#tTelefono').val(null);
            $('#tCuit').val(null);
            
            if (target.val() === 'estudiante' ){
                setControlsEstudianteData($('#sEstudiante').val());
                $('#divEstudiante').show();
                $('#divEmpresa').hide();
                $('#detailsForm').validate({
                    rules: {
                        sEstudiante:{ required: true, min:1 },
                        sEmpresa:{ required: false, min:1 }
                    }
                });
            } else if (target.val() === 'empresa') {
                setControlsEmpresaData($('#sEmpresa').val());
                $('#divEmpresa').show();
                $('#divEstudiante').hide();
                $('#detailsForm').validate({
                    rules: {
                        sEstudiante:{ required: false, min:1 },
                        sEmpresa:{ required: true, min:1 }
                    }
                });
            }
        });
        
        //evento que se dispara cuando cambia el control select
        //y realiza el cambio en los estilos del mismo agregando o quitando la clase 'error'
        $(".select2").select2().on('change', function (e) {
            var target = $(e.target);
            var value = target.val();
            
            //seteamos el resto de los controles con datos del estudiante o de la empresa
            if (target.prop('id') === "sEstudiante")
                setControlsEstudianteData(value);
            else if (target.prop('id') === "sEmpresa")
                setControlsEmpresaData(value);
            
            //agregamos o quitamos clase de error
            if (firstTime) { firstTime = false; return; }
            if(value !== null && value !== "0")
                $("span:visible .select2-selection--single").removeClass("error");
            else
                $("span:visible .select2-selection--single").addClass("error");
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
                f_idEstadoEstudiante: '1', //Sólo obtenemos los estudiantes en estado 'Activo'
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
        
        //Cargamos las Empresas para setear el select del form
        $.ajax({
            url: './class/globalclass/execfunction.php',
            type : 'GET',
            contentType : 'application/json',
            dataType : 'json',
            data: { 
                condicion: 'getEmpresas'
            }
        }).done(
            function(jsonEmpresasList) {
                //seteamos los datos en la variable db para poder utilizarlo luego
                db.empresa = jsonEmpresasList;
                $.each(db.empresa, function (index, data) {
                    $("#sEmpresa").append("<option value='" + data._idEmpresa + "'>" + data._razonSocial + "</option>");
                });
            }
        ).fail(
            function( jqXHR, textStatus, errorThrown ) {
                alert(errorThrown);
                alert(jqXHR.responseText);
            }
        );

    }
    
    function existsNumeroFactura(idFactura, numeroFactura){
        var retValue = db.facturas.find(factura => factura._idFactura != idFactura && factura._numeroFactura === numeroFactura);
        return retValue !== undefined;
    }
    
    function getNewNumeroFactura() {
        var vNumFac = new Array();
        var maxNumFac = 0;    
        $.each(db.facturas, function (index, data) {
            vNumFac.push(data._numeroFactura);
        });
        maxNumFac = Math.max.apply(null, vNumFac);
        return maxNumFac + 1;
    }
    
    function setControlsEstudianteData(idEstudiante) {
        var estudiante = db.estudiante.find(est => est._idEstudiante == idEstudiante);
        
        $("#tCliente").val(estudiante !== undefined ? estudiante._nombreApellido : null);
        $("#tTelefono").val(estudiante !== undefined ? estudiante._telefono : null);
    }
    
    function setControlsEmpresaData(idEmpresa) {
        var empresa = db.empresa.find(emp => emp._idEmpresa == idEmpresa);
        
        $("#tCliente").val(empresa !== undefined ? empresa._razonSocial : null);
        $("#tDomicilio").val(empresa !== undefined ? empresa._domicilio : null);
        $("#tLocalidad").val(empresa !== undefined ? empresa._localidad : null);
        $("#tCuit").val(empresa !== undefined ? empresa._cuit : null);
        $("#tTelefono").val(empresa !== undefined ? empresa._telefono : null);
    }
    
});