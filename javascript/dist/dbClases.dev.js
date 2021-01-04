"use strict";

(function () {
  var db = {
    loadData: function loadData(filter) {
      var def = $.Deferred();
      $.ajax({
        url: './class/globalclass/execfunction.php',
        type: 'GET',
        contentType: 'application/json',
        dataType: 'json',
        data: {
          condicion: 'getClases_All',
          f_emple_nombreApellido: filter._nombreEmpleado,
          f_idEstadoClase: filter._estadoClase._idEstadoClase,
          f_idDia: filter._dia._idDia,
          f_descripcion: ''
        }
      }).done(function (response) {
        db.clases = response;
        def.resolve(response);
      }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
        alert(jqXHR.responseText);
      });
      return def.promise();
    },
    insertItem: function insertItem(insertingClase) {//this.clase.push(insertingClase);
    },
    updateItem: function updateItem(updatingClase) {}
  };
  var dbEstudiantes = {
    loadData: function loadData(filter) {
      var def = $.Deferred();
      var oDate = new Date(Date.now());
      var mes = $("#sMes_filtro").val() != null ? $("#sMes_filtro").val() : oDate.getMonth() + 1;
      var año = $("#sAño_filtro").val() != null ? $("#sAño_filtro").val() : oDate.getFullYear();
      $.ajax({
        url: './class/globalclass/execfunction.php',
        type: 'GET',
        contentType: 'application/json',
        dataType: 'json',
        data: {
          condicion: 'getEstudiantesByIdClase',
          idClase: idClase,
          mes: mes,
          año: año
        }
      }).done(function (jsonEstudiantesList) {
        dbEstudiantes.estudiantes = jsonEstudiantesList;
        def.resolve(jsonEstudiantesList);
        hideLoading();
      }).fail(function (jqXHR, textStatus, errorThrown) {
        hideLoading();
        alert(errorThrown);
        alert(jqXHR.responseText);
      });
      return def.promise();
    }
  };
  window.idClase = 0;
  window.db = db;
  window.dbEstudiantes = dbEstudiantes;
})();

$(function () {
  var flagFinCargaDatosSelectGrid = false;
  var firstTime = true; //bandera para indicar que se está abriendo popup de edición
  //Primero cargamos los estadosClases

  $.ajax({
    url: './class/globalclass/execfunction.php',
    type: 'GET',
    contentType: 'application/json',
    dataType: 'json',
    data: {
      condicion: 'getEstadoClases_All'
    }
  }).done( //Una vez cargados los estadosClases configuramos la grid para poder utilizar los estados en los select
  function (jsonEstadoClaseList) {
    //insertamos como primer elemento uno vacio
    jsonEstadoClaseList.unshift({
      _idEstadoClase: '0',
      _nombre: ''
    }); //seteamos los datos en la variable db para poder utilizarlo luego

    db.estadoClase = jsonEstadoClaseList;

    if (flagFinCargaDatosSelectGrid) {
      //Configuramos el control jsGrid
      configJSGrid(); //Seteamos y configuramos controles del formulario de detalle

      configFormControls();
    }

    flagFinCargaDatosSelectGrid = true;
  }).fail(function (jqXHR, textStatus, errorThrown) {
    alert(errorThrown);
    alert(jqXHR.responseText);
  }); //cargamos la tabla dia

  $.ajax({
    url: './class/globalclass/execfunction.php',
    type: 'GET',
    contentType: 'application/json',
    dataType: 'json',
    data: {
      condicion: 'getDia_All'
    }
  }).done(function (jsonDiaList) {
    //insertamos como primer elemento uno vacio
    jsonDiaList.unshift({
      _idDia: '0',
      _nombre: ''
    }); //seteamos los datos en la variable db para poder utilizarlo luego

    db.dia = jsonDiaList;

    if (flagFinCargaDatosSelectGrid) {
      //Configuramos el control jsGrid
      configJSGrid(); //Seteamos y configuramos controles del formulario de detalle

      configFormControls();
    }

    flagFinCargaDatosSelectGrid = true;
  }).fail(function (jqXHR, textStatus, errorThrown) {
    alert(errorThrown);
    alert(jqXHR.responseText);
  });
  $('#detailsDialog').dialog({
    autoOpen: false,
    width: 450,
    close: function close() {
      $('#detailsForm').validate().resetForm();
      $('#detailsForm').find('.error').removeClass('error');
      firstTime = true; //reseteamos la bandera
    }
  });
  $('#detailsForm').validate({
    rules: {
      sEmpleado: {
        required: true,
        min: 1
      },
      sDia: {
        required: true,
        min: 1
      },
      tHoraInicio: {
        required: true
      },
      tHoraFin: {
        required: true
      },
      sEstado: {
        required: true,
        min: 1
      },
      tDescripcion: {
        required: false,
        maxlength: 255
      }
    },
    invalidHandler: function invalidHandler(event, validator) {
      var errors = validator.numberOfInvalids();
      if (errors) showModalMessage("#dialog-message");
    },
    submitHandler: function submitHandler() {
      formSubmitHandler();
    },
    errorPlacement: function errorPlacement(error, element) {//Esto está sólo para no mostrar los mensajes de error!
      //Aquí mismo se podrían editar y mostrar los mensajes de forma customizada
    },
    highlight: function highlight(element, errorClass, validClass) {
      var elem = $(element);

      if (elem.hasClass("select2")) {
        $(".select2-selection--single").addClass(errorClass);
      } else {
        elem.addClass(errorClass);
      }
    },
    unhighlight: function unhighlight(element, errorClass, validClass) {
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

var showDetailsDialog = function showDetailsDialog(dialogType, clase) {
  $('#tDescripcion').val(clase._descripcion);

  if (dialogType === 'Nueva') {
    $('#sEmpleado').val("-1").select2();
    $('#sDia').val("-1").select2();
    $('#sEstado').val("-1").select2();
    $('#tHoraInicio').val('12 : 00');
    $('#tHoraFin').val('12 : 00');
  } else {
    //Si se está editando una clase seteamos los controles con los datos de la base
    $('#sEmpleado').val(clase._empleado._idEmpleado).select2();
    $('#sDia').val(clase._dia._idDia).select2();
    $('#sEstado').val(clase._estadoClase._idEstadoClase).select2();
    $('#tHoraInicio').val(clase._horaInicio);
    $('#tHoraFin').val(clase._horaFin);
  }

  formSubmitHandler = function formSubmitHandler() {
    saveClase(clase, dialogType === 'Nueva');
  };

  $('#detailsDialog').dialog('option', 'title', dialogType + ' clase').dialog('open');
};

var saveClase = function saveClase(clase, isNew) {
  var idClase = isNew ? '0' : clase._idClase;
  var idEmpleado = $('#sEmpleado').val();
  var idEstadoClase = $('#sEstado').val();
  var idDia = $('#sDia').val();
  var horaInicio = $('#tHoraInicio').wickedpicker('time').replace(/\s/g, '');
  var horaFin = $('#tHoraFin').wickedpicker('time').replace(/\s/g, '');
  var descripcion = $('#tDescripcion').val();

  if (idEstadoClase != '2') {
    // Si es distinto a Estado Inactivo, entonces...
    //Validamos rango horario y duplicado de clases en dia y horario
    if (validarHorarios(horaInicio, horaFin)) {
      if (claseDuplicada(clase._idClase, idDia, horaInicio, horaFin)) {
        showModalMessage("#error-message-claseDuplicada");
        return;
      } else showLoading();
    } else {
      showModalMessage("#error-message-HorasIncorrectas");
      return;
    }
  } else showLoading();

  $.ajax({
    url: './class/globalclass/execfunction.php',
    type: 'GET',
    contentType: 'application/json',
    dataType: 'json',
    data: {
      condicion: 'setClase',
      idClase: idClase,
      idEmpleado: idEmpleado,
      idEstadoClase: idEstadoClase,
      idDia: idDia,
      horaInicio: horaInicio,
      horaFin: horaFin,
      descripcion: descripcion
    }
  }).done(function (MessageResponse) {
    if (MessageResponse.length > 0) alert('Se guardo el registro correctamente!');
    $('#detailsDialog').dialog('close');
    $("#jsGrid").jsGrid("loadData");
    hideLoading();
  }).fail(function (jqXHR, textStatus, errorThrown) {
    hideLoading();
    alert(errorThrown);
    alert(jqXHR.responseText);
  });
};

var showEstudiantes = function showEstudiantes(value, clase) {
  idClase = clase._idClase;
  var oDate = new Date(Date.now());
  $("#sMes_filtro").val(oDate.getMonth() + 1).select2();
  $("#sAño_filtro").val(oDate.getFullYear()).select2();
  var title = "Estudiantes de la clase: " + clase._dia._nombre + " " + clase._horaInicio + " a " + clase._horaFin; //$("#divEstudiantes").attr("title", title);

  buscarEstudiantes();
  showModalForm("#divEstudiantes", title);
};

function buscarEstudiantes() {
  $("#jsEstudiantes").jsGrid("loadData");
}

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
    rowClick: function rowClick(args) {
      showDetailsDialog('Editar', args.item);
    },
    controller: db,
    fields: [{
      name: '_dia._idDia',
      title: 'Día',
      type: 'select',
      items: db.dia,
      valueField: '_idDia',
      textField: '_nombre',
      sorting: false
    }, {
      name: '_horaInicio',
      type: 'text',
      width: 80,
      title: 'Hora Inicio',
      sorting: false,
      filtering: false
    }, {
      name: '_horaFin',
      type: 'text',
      width: 80,
      title: 'Hora Fin',
      sorting: false,
      filtering: false
    }, {
      name: '_nombreEmpleado',
      type: 'text',
      width: 80,
      title: 'Profesor',
      sorting: true
    }, {
      name: '_estadoClase._idEstadoClase',
      title: 'Estado',
      type: 'select',
      items: db.estadoClase,
      valueField: '_idEstadoClase',
      textField: '_nombre',
      sorting: false
    }, {
      type: 'control',
      modeSwitchButton: false,
      editButton: false,
      deleteButton: false,
      itemTemplate: function itemTemplate(value, item) {
        return $('<button>').attr('type', 'button').attr('title', 'Estudiantes de la clase').button({
          icons: {
            primary: null
          }
        }).addClass("buttonShowEstudiantes").on('click', function (e) {
          showEstudiantes(value, item);
          e.stopPropagation();
        });
      },
      headerTemplate: function headerTemplate() {
        return $('<button>').attr('type', 'button').attr('title', 'Agregar nueva clase').button({
          icons: {
            primary: null
          }
        }).addClass("buttonAdd").on('click', function () {
          showDetailsDialog('Nueva', {});
        });
      }
    }]
  });
  $('#jsEstudiantes').jsGrid({
    height: '360px',
    width: '100%',
    filtering: false,
    editing: false,
    inserting: false,
    sorting: false,
    paging: true,
    autoload: true,
    pageSize: 50,
    pageButtonCount: 5,
    controller: dbEstudiantes,
    fields: [{
      name: '_nombreApellido',
      type: 'text',
      width: 80,
      title: 'Nombre'
    }, {
      name: '_celular',
      type: 'text',
      width: 80,
      title: 'Celular',
      align: 'center'
    }, {
      name: '_telefono',
      type: 'text',
      width: 80,
      title: 'Teléfono',
      align: 'center'
    }, {
      name: '_email',
      type: 'text',
      width: 80,
      title: 'Email',
      align: 'left'
    }, {
      type: 'control',
      modeSwitchButton: false,
      editButton: false,
      deleteButton: false,
      headerTemplate: function headerTemplate() {
        return $('<button>').attr('type', 'button').attr('title', 'Descargar listado').button({
          icons: {
            primary: null
          }
        }).addClass("buttonDownloadFile").on('click', function () {
          downloadList();
        });
      }
    }]
  });
}

function configFormControls() {
  var options = {
    now: "12:00",
    //hh:mm 24 hour format only, defaults to current time 
    twentyFour: true,
    //Display 24 hour format, defaults to false
    upArrow: 'wickedpicker__controls__control-up',
    //The up arrow class selector to use, for custom CSS
    downArrow: 'wickedpicker__controls__control-down',
    //The down arrow class selector to use, for custom CSS
    close: 'wickedpicker__close',
    //The close class selector to use, for custom CSS
    hoverState: 'hover-state',
    //The hover state class to use, for custom CSS
    title: '',
    //The Wickedpicker's title,
    showSeconds: false,
    //Whether or not to show seconds,
    secondsInterval: 1,
    //Change interval for seconds, defaults to 1  ,
    minutesInterval: 15,
    //Change interval for minutes, defaults to 1
    beforeShow: null,
    //A function to be called before the Wickedpicker is shown
    show: null,
    //A function to be called when the Wickedpicker is shown
    clearable: false //Make the picker's input clearable (has clickable "x")

  };
  $('.timepicker').wickedpicker(options);
  $('.select2').select2({
    language: "es"
  }); //Cargamos select de estadoClase para fomularios

  $.each(db.estadoClase, function (index, data) {
    if (index != 0) $("#sEstado").append("<option value='" + data._idEstadoClase + "'>" + data._nombre + "</option>");
  });
  $.each(db.dia, function (index, data) {
    if (index != 0) $("#sDia").append("<option value='" + data._idDia + "'>" + data._nombre + "</option>");
  });
  db.meses = get_array_meses(); //common.js
  //cargamos los meses en select

  $.each(db.meses, function (index, data) {
    $("#sMes_filtro").append("<option value='" + data._mes + "'>" + data._descripcion + "</option>");
  }); //cargamos años en select... el actual y el anterior

  var año = new Date().getFullYear();

  for (var i = 2018; i <= año; i++) {
    $("#sAño_filtro").append("<option value='" + i + "'>" + i + "</option>");
  } //Cargamos los Estudiantes que se encuentran Activos para cargar en el select del form


  $.ajax({
    url: './class/globalclass/execfunction.php',
    type: 'GET',
    contentType: 'application/json',
    dataType: 'json',
    data: {
      condicion: 'getEmpleados_All',
      f_nombreApellido: '',
      f_email: '',
      f_idTipoEmpleado: '1',
      //Tipo Profesor
      f_idEstadoEmpleado: '0',
      f_fechaAltaDesde: null,
      f_fechaAltaHasta: null
    }
  }).done(function (jsonEmpleadoList) {
    //seteamos los datos en la variable db para poder utilizarlo luego
    db.empleado = jsonEmpleadoList;
    $.each(db.empleado, function (index, data) {
      $("#sEmpleado").append("<option value='" + data._idEmpleado + "'>" + data._nombreApellido + "</option>");
    });
  }).fail(function (jqXHR, textStatus, errorThrown) {
    alert(errorThrown);
    alert(jqXHR.responseText);
  });
}

function validarHorarios(horaInicio, horaFin) {
  var fecha1 = new Date('01/01/1990 ' + horaInicio);
  var fecha2 = new Date('01/01/1990 ' + horaFin);
  if (fecha2 <= fecha1) return false;
  return true;
}

function claseDuplicada(idClase, idDia, horaInicio, horaFin) {
  var returnValue = false;
  var clases = db.clases.filter(function (clase) {
    return clase._idClase != idClase && clase._dia._idDia === idDia && clase._estadoClase._idEstadoClase == '1';
  });
  $.each(clases, function (index, data) {
    if (existeInterseccion(data._horaInicio, data._horaFin, horaInicio, horaFin)) {
      returnValue = true;
    }
  });
  return returnValue;
}

function existeInterseccion(hi1, hf1, hi2, hf2) {
  var fi1 = new Date('01/01/1990 ' + hi1);
  var ff1 = new Date('01/01/1990 ' + hf1);
  var fi2 = new Date('01/01/1990 ' + hi2);
  var ff2 = new Date('01/01/1990 ' + hf2);
  return fi1 < fi2 && ff2 < ff1 || fi2 < fi1 && ff1 < ff2 || fi1 < fi2 && fi2 < ff1 || fi2 < fi1 && fi1 < ff2;
}

function downloadList() {
  showLoading();
  var mes = $("#sMes_filtro").val();
  var año = $("#sAño_filtro").val();
  $.ajax({
    url: './class/globalclass/execfunction.php',
    type: 'GET',
    contentType: 'application/json',
    dataType: 'json',
    data: {
      condicion: 'downloadEstudiantesDeClase',
      idClase: idClase,
      año: año,
      mes: mes
    }
  }).done(function (MessageResponse) {
    if (MessageResponse === 1) downloadFile('estudiantes_de_clase.csv');else alert('Se produjo un error armando el archivo.');
    hideLoading();
  }).fail(function (jqXHR, textStatus, errorThrown) {
    alert(errorThrown);
    alert(jqXHR.responseText);
    hideLoading();
  });
}