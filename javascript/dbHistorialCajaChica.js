(function() {
    var db = {
        loadData: 
        function(filter) {
            var def = $.Deferred();
            var f_aperturaDesde = (filter._apertura.from !== null) ? (filter._apertura.from.getFullYear() + '-' + (filter._apertura.from.getMonth() + 1) + '-' + filter._apertura.from.getDate()) : null;
            var f_aperturaHasta = (filter._apertura.to !== null) ? (filter._apertura.to.getFullYear() + '-' + (filter._apertura.to.getMonth() + 1) + '-' + filter._apertura.to.getDate()) : null;
            var f_cierreDesde = (filter._cierre.from !== null) ? (filter._cierre.from.getFullYear() + '-' + (filter._cierre.from.getMonth() + 1) + '-' + filter._cierre.from.getDate()) : null;
            var f_cierreHasta = (filter._cierre.to !== null) ? (filter._cierre.to.getFullYear() + '-' + (filter._cierre.to.getMonth() + 1) + '-' + filter._cierre.to.getDate()) : null;
            $.ajax({
                url: './class/globalclass/execfunction.php',
                type : 'GET',
                contentType : 'application/json',
                dataType : 'json',
                data: { 
                    condicion: 'getCajaChica_All',
                    f_nombreEmpleado: filter._nombreEmpleado,
                    f_aperturaDesde: f_aperturaDesde,
                    f_aperturaHasta: f_aperturaHasta,
                    f_cierreDesde: f_cierreDesde,
                    f_cierreHasta: f_cierreHasta,
                    f_valorInicial: 0
                }
            }).done(
                function(response) {
                    db.cajaChica = response;
                    def.resolve(response);
                }
            ).fail(
                function( jqXHR, textStatus, errorThrown ) {
                    alert(errorThrown);
                    alert(jqXHR.responseText);
                }
            );
            return def.promise();
        }
    };

    var dbMov = {
        loadData: 
        function(filter) {
            var def = $.Deferred();
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
                    dbMov.movimientosCajaChica = response;
                    def.resolve(response);
                }
            ).fail(
                function( jqXHR, textStatus, errorThrown ) {
                    alert(errorThrown);
                    alert(jqXHR.responseText);
                }
            );
            return def.promise();
        }
    };

    window.idCajaChica = 0;
    window.db = db;
    window.dbMov = dbMov;
})();

$(function() {
    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);

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
            dbMov.tipoMovimientoCC = jsonTipoMovimientoCCList;
            
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
});

function showDetailsDialog(cajaChica) {
    idCajaChica = cajaChica._idCajaChica;
    $("#jsGridMovimientos").jsGrid("loadData");
    showModalForm("#divMovimientos");
}

function configJSGrid() {
    //Configuramos el lenguaje de la grid
    jsGrid.locale('es');

    $('#jsGridHistorial').jsGrid({
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
            showDetailsDialog(args.item);
        },
        controller: db,
        fields: [
            { name: '_apertura', type: 'date', width: 80, title: 'Apertura', sorting: true, align: 'center' },
            { name: '_cierre', type: 'date', width: 80, title: 'Cierre', sorting: true, align: 'center' },
            { name: '_nombreEmpleado', type: 'text', width: 80, title: 'Empleado', align:'center', sorting: true, filtering: true },
            { name: '_valorInicial', type: 'text', width: 80, title: 'Valor Inicial', align:'center', sorting: true, filtering: false },
            { name: '_valorFinal', type: 'text', width: 80, title: 'Valor Final', align:'center', sorting: true, filtering: false },
            {
                type: 'control',
                modeSwitchButton: false,
                editButton: false,
                deleteButton: false,
                headerTemplate: function() { }
            }
        ]
    });

    $('#jsGridMovimientos').jsGrid({
        height: '360px',
        width: '100%',
        filtering: true,
        editing: false,
        inserting: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 50,
        pageButtonCount: 5,
        controller: dbMov,
        fields: [
            { name: '_descripcion', type: 'text', width: 80, title: 'Descripción', sorting: false, filtering: true },
            {
                name: '_tipoMovimientoCC._idTipoMovimientoCC', 
                title: 'Tipo Movimiento', 
                type: 'select', 
                items: dbMov.tipoMovimientoCC, valueField: '_idTipoMovimientoCC', textField: '_nombre',
                sorting: false, filtering: true
            },
            { name: '_valor', type: 'text', width: 80, title: 'Valor', align:'center', sorting: false, filtering: false },
            { name: '_recibo._numeroRecibo', type: 'text', width: 80, title: 'N°Recibo', align:'center', sorting: false, filtering: false },
            {
                type: 'control',
                modeSwitchButton: false,
                editButton: false,
                deleteButton: false,
                headerTemplate: function() { }
            }
        ]
    });
}

function configFormControls() {
    /*
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
    );*/

}