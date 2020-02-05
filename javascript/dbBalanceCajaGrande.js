(function() {
    var db = {
        loadData: function(filter) {
            var def = $.Deferred();
            var iMes = (filter.mes !== undefined) ? filter.mes : 0;
            var iAño = (filter.año !== undefined) ? filter.año : 0;
            $.ajax({
                url: './class/globalclass/execfunction.php',
                type : 'GET',
                contentType : 'application/json',
                dataType : 'json',
                data: { 
                    condicion: 'getBalanceCajaGrande',
                    mes: iMes,
                    año: iAño
                }
            }).done(
                function(response) {
                    db.balance = response;
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
        loadData: function(filter) {
            var def = $.Deferred();
            let aFDesde = window.fechaDesde != '' ? window.fechaDesde.split('/') : null;
            let aFHasta = window.fechaHasta != '' ? window.fechaHasta.split('/') : null;
            let fechaDesde = aFDesde != null ? (aFDesde[2]+'-'+aFDesde[1]+'-'+aFDesde[0]) : null;
            let fechaHasta = aFHasta != null ? (aFHasta[2]+'-'+aFHasta[1]+'-'+aFHasta[0]) : null;
            $.ajax({
                url: './class/globalclass/execfunction.php',
                type : 'GET',
                contentType : 'application/json',
                dataType : 'json',
                data: { 
                    condicion: 'getEgresosCajaGrande',
                    f_fechaHasta: fechaHasta,
                    f_fechaDesde: fechaDesde,
                    f_observacion: filter._observacion,
                    f_idTipoEgresoFijo: filter._tipoEgresoFijo._idTipoEgresoFijo
                }
            }).done(
                function(response) {
                    dbMov.movimientosCajaGrande = response;
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

    window.fechaDesde = '';
    window.fechaHasta = '';
    window.db = db;
    window.dbMov = dbMov;
})();

$(function() {
    db.meses = get_array_meses(); //common.js

    //Cargamos los TipoEgresoFijo
    $.ajax({
        url: './class/globalclass/execfunction.php',
        type : 'GET',
        contentType : 'application/json',
        dataType : 'json',
        data: { condicion: 'getTipoEgresoFijo_All' }
    }).done(
        //Una vez cargados los tipoMovimientoCC configuramos la grid para poder utilizar los tipos en los select
        function(jsonTipoEgresoFijoList) {
            //insertamos como primer elemento uno vacio
            jsonTipoEgresoFijoList.unshift({ _idTipoEgresoFijo: '0', _nombre: '' });
            
            //seteamos los datos en la variable db para poder utilizarlo luego
            dbMov.tipoEgresoFijo = jsonTipoEgresoFijoList;
            
            //Configuramos el control jsGrid
            configJSGrid();
        }
    ).fail(
        function( jqXHR, textStatus, errorThrown ) {
            alert(errorThrown);
            alert(jqXHR.responseText);
        }
    );
});

function showDetailsDialog(cajaGrande) {
    let mes = cajaGrande.mes;
    let año = cajaGrande.año;

    let fDesde = new Date(año, (mes - 1), 1);
    let fHasta = new Date(año, mes, 0);

    window.fechaDesde = fDesde.getDate() + '/' + (fDesde.getMonth() + 1) + '/' + fDesde.getFullYear();
    window.fechaHasta = fHasta.getDate() + '/' + (fHasta.getMonth() + 1) + '/' + fHasta.getFullYear();

    $("#jsGridMovimientos").jsGrid("loadData");
    showModalForm("#divMovimientos");
}

function configJSGrid() {
    //Configuramos el lenguaje de la grid
    jsGrid.locale('es');

    //Configuramos el lenguaje de datepicker
    $.datepicker.setDefaults($.datepicker.regional['es']);

    $('#jsGridBalances').jsGrid({
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
        controller: db,
        rowClick: function(args) {
            showDetailsDialog(args.item);
        },
        fields: [
            { name: 'mes', type: 'select', width: 80, title:'Mes', sorting: true, align: 'center', items: db.meses, valueField: '_mes', textField: '_descripcion' },
            { name: 'año', type: 'number', width: 80, title:'Año', sorting: true, align: 'center' },
            { name: 'ingresos', type: 'text', width: 80, title: 'Ingresos', sorting: true, filtering:false, align: 'center' },
            { name: 'egresos', type: 'number', width: 80, title:'Egresos', sorting: true, filtering:false, align: 'center' },
            { name: 'utilidadMes', type: 'text', title: 'Utildad del Mes', sorting: true, filtering:false, align: 'center' },
            {
                type: 'control',
                modeSwitchButton: false,
                editButton: false,
                deleteButton: false,
                headerTemplate: function() { }
            }
        ],
        onRefreshed: function(args) {
        	var items = args.grid.option("data");
            var total = { "ingresos": 0, "egresos": 0, "utilidad": 0 };

            items.forEach(function(item) {
                total.ingresos += parseInt(item.ingresos);
                total.egresos += parseInt(item.egresos);
                total.utilidad += parseInt(item.utilidadMes);
            });
                            
            args.grid._content.append(
                "<tr><td class=\"jsgrid-cell jsgrid-align-center\" style=\"width: 80px;\"></td>" +
                "<td class=\"jsgrid-cell jsgrid-align-right\" style=\"width: 80px;\"><strong>Totales</strong></td>" +
                "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.ingresos + "</strong></td>" +
                "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.egresos + "</strong></td>" +
                "<td class=\"jsgrid-cell jsgrid-align-center\"><strong>" + total.utilidad + "</strong></td>"
            );
        }
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
            { name: '_fecha', type: 'date', width: 53, title: 'Fecha', sorting: false, 'filtering': false },
            { name: '_observacion', type: 'text', width: 80, title: 'Observación', sorting: false, filtering: true },
            {
                name: '_tipoEgresoFijo._idTipoEgresoFijo', 
                title: 'Tipo Egreso', 
                type: 'select', 
                items: dbMov.tipoEgresoFijo, valueField: '_idTipoEgresoFijo', textField: '_nombre',
                sorting: false, filtering: true
            },
            { name: '_valor', type: 'text', width: 80, title: 'Valor', align:'center', sorting: false, filtering: false },
            {
                type: 'control',
                modeSwitchButton: false,
                editButton: false,
                deleteButton: false,
                headerTemplate: function() { }
            }
        ]
    });

    //Ocultamos los cuadros de texto para filtrar fechas en los jsGrid
    $('.hasDatepicker').css('display', 'none');
}