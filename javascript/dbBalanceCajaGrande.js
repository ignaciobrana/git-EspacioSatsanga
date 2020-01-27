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

    window.db = db;
})();

$(function() {
    db.meses = get_array_meses(); //common.js

    //Configuramos el control jsGrid
    configJSGrid();
});

function showDetailsDialog(cajaChica) {
    idCajaChica = cajaChica._idCajaChica;
    $("#jsGridMovimientos").jsGrid("loadData");
    showModalForm("#divMovimientos");
}

function configJSGrid() {
    //Configuramos el lenguaje de la grid
    jsGrid.locale('es');

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
        fields: [
            { name: 'mes', type: 'select', width: 80, title:'Mes', sorting: true, align: 'center', items: db.meses, valueField: '_mes', textField: '_descripcion' },
            { name: 'año', type: 'number', width: 80, title:'Año', sorting: true, align: 'center' },
            { name: 'ingresos', type: 'text', width: 80, title: 'Ingresos', sorting: true, filtering:false, align: 'center' },
            { name: 'egresos', type: 'number', width: 80, title:'Egresos', sorting: true, filtering:false, align: 'center' },
            { name: 'utilidadMes', type: 'text', title: 'Utildad del Mes', sorting: true, filtering:false, align: 'center' },
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
}