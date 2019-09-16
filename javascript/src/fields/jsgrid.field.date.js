(function(jsGrid, $, undefined) {
    
    var DateField = function(config) {
        jsGrid.Field.call(this, config);
    };

    DateField.prototype = new jsGrid.Field({
        sorter: function(date1, date2) {
            return new Date(date1) - new Date(date2);
        },    

        itemTemplate: function(value) {
            var date = new Date(value);
            return date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
        },

        filterTemplate: function() {
            var now = new Date();
            this._fromPicker = $("<input>").datepicker({ 
                defaultDate: now.setFullYear(now.getFullYear() - 1),
                dateFormat: "dd/mm/yy"
            });
            this._toPicker = $("<input>").datepicker({ 
                defaultDate: now.setFullYear(now.getFullYear() + 1),
                dateFormat: "dd/mm/yy"
            });
            return $("<div>").append(this._fromPicker).append(this._toPicker);
        },

        insertTemplate: function(value) {
            return this._insertPicker = $("<input>").datepicker({ defaultDate: new Date() });
        },

        editTemplate: function(value) {
            return this._editPicker = $("<input>").datepicker().datepicker("setDate", new Date(value));
        },

        insertValue: function() {
            return this._insertPicker.datepicker("getDate").toISOString();
        },

        editValue: function() {
            return this._editPicker.datepicker("getDate").toISOString();
        },

        filterValue: function() {
            return {
                from: this._fromPicker.datepicker("getDate"),
                to: this._toPicker.datepicker("getDate")
            };
        }
    });

    jsGrid.fields.date = DateField;

}(jsGrid, jQuery));