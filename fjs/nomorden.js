$(document).ready(function () {
  var id, opcion;
  opcion = 4;

  tablaVis = $("#tablaV").DataTable({
    stateSave: true,
    paging: false,
    ordering: false,
    dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    buttons: [
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: "Exportar a Excel",
        title: "Progreso de Ordenes",
        className: "btn bg-success ",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          /*format: {
              body: function (data, row, column, node) {
                if (column === 5) {
                  return data.replace(/[$,]/g, '')
                } else if (column === 6) {
                  return data
                } else {
                  return data
                }
              },
            },*/
        },
      },
      {
        extend: "pdfHtml5",
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: "Exportar a PDF",
        title: "Progreso de Ordenes",
        className: "btn bg-danger",
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
        format: {
          body: function (data, row, column, node) {
            if (column === 6) {
              return data;
            } else {
              return data;
            }
          },
        },
      },
    ],
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'>\
            <button class='btn btn-sm btn-primary btnEditar' data-toggle='tooltip' data-placement='top' title='Establer Importe Nom'><i class='fa-solid fa-money-bills'></i></button>\
            <button class='btn btn-sm btn-warning btnbloquear' data-toggle='tooltip' data-placement='top' title='Bloquear'><i class='fa-solid fa-lock text-white'></i></button>\
              </div>",

        //
      },
      { targets: [14], className: "hide_column" },
      { targets: [15], className: "hide_column" },
      { targets: [6], type: "num-html" },
      {
        targets: 4,
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + "</div>";
          //return "<div class='text-wrap width-200'>" + data + '</div>'
        },
      },
      {
        targets: 5,
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + "</div>";
          //return "<div class='text-wrap width-200'>" + data + '</div>'
        },
      },
    ],

    //Para cambiar el lenguaje a español
    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      sSearch: "Buscar:",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      sProcessing: "Procesando...",
    },

    rowCallback: function (row, data) {
      $($(row).find("td")["8"]).css("color", "white");
      $($(row).find("td")["8"]).addClass("text-center");
      $($(row).find("td")["7"]).addClass("text-center");
      $($(row).find("td")["9"]).addClass("text-right");
      $($(row).find("td")["10"]).addClass("text-right");
      $($(row).find("td")["11"]).addClass("text-right");
      $($(row).find("td")["12"]).addClass("text-right");
      $($(row).find("td")["13"]).addClass("text-right");
      fecha = new Date(data[5]).getTime();
      fechaactual = new Date().getTime();

      dias = parseInt(fecha - fechaactual) / (1000 * 60 * 60 * 24);
      avance = data[7];

      barra =
        "<div class='progress mb-3 ' style='width:120px' > \
                <div class='progress-bar bg-success' role='progressbar' aria-valuenow='" +
        avance +
        "' aria-valuemin='0' aria-valuemax='100' style='width:" +
        avance +
        "%'> \
                <span class='text-light text-center'>" +
        avance +
        "%</span> \
                </div> \
                </div>";

      $($(row).find("td")[7]).html(barra);
      estadoord = data[8];

      if (data[8] == "MEDICION") {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find("td")[8]).addClass("bg-gradient-warning");
        //$($(row).find('td')['8']).text('PENDIENTE')
      } else if (data[8] == "CORTE") {
        //$($(row).find("td")[8]).css("background-color", "blue");
        $($(row).find("td")[8]).addClass("bg-gradient-secondary");
        //$($(row).find('td')['8']).text('ENVIADO')
      } else if (data[8] == "ENSAMBLE") {
        //$($(row).find("td")[8]).css("background-color", "success");
        $($(row).find("td")[8]).addClass("bg-lightblue");
        //$($(row).find('td')['8']).text('ACEPTADO')
      } else if (data[8] == "PULIDO") {
        //$($(row).find("td")[8]).css("background-color", "purple");
        $($(row).find("td")[8]).addClass("bg-gradient-purple");
        //$($(row).find('td')['8']).text('EN ESPERA')
      } else if (data[8] == "COLOCACION") {
        //$($(row).find("td")[5]).css("background-color", "light-blue");

        $($(row).find("td")[8]).addClass("bg-gradient-orange");
        //$($(row).find('td')['8']).text('EDITADO')
      } else if (data[8] == "PROCESANDO") {
        //$($(row).find("td")[5]).css("background-color", "red");
        $($(row).find("td")[8]).addClass("bg-gradient-warning");
        //$($(row).find('td')['8']).text('RECHAZADO')
      } else if (data[8] == "LIBERADO") {
        $($(row).find("td")[8]).addClass("bg-gradient-success");
      } else if (data[8] == "ACTIVO") {
        $($(row).find("td")[8]).addClass("bg-gradient-primary");
      } else {
        if (avance == 90) {
          $($(row).find("td")[8]).addClass("bg-gradient-orange");
          $($(row).find("td")[8]).text("COLOCACION");
        }
      }
      if (data[14] == 1) {
        $($(row).find("td")).addClass("amarillot");
      }
      if (data[15] == 1) {
        $($(row).find("td")).addClass("rojot");
      }


    },
  });

  var fila; //capturar la fila para editar o borrar el registro

  $("#btnBuscar").click(function () {
    window.location.href =
      "nomorden.php?inicio=" + $("#inicio").val() + "&fin=" + $("#fin").val();
  });

  $(document).on("click", "#btnDefinir", function (e) {
    e.preventDefault();
    var costo = $("#costoml").val();
    // Resto del código para eliminar la imagen utilizando el 'imagenId'
    swal
      .fire({
        text: "¿Desea definir este costo por ML para las siguientes ordenes que se procesen?",

        showCancelButton: true,
        icon: "info",
        focusConfirm: true,
        confirmButtonText: "Aceptar",

        cancelButtonText: "Cancelar",
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            type: "POST",
            url: "bd/costoml.php",
            dataType: "json",
            data: { costo: costo },
            success: function (res) {
              if (res == 1) {
                window.location.reload();
              } else {
                Swal.fire({
                  title: "Error actualizar el costo por ML",
                  icon: "warning",
                });
              }
            },
          });
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      });
  });

  $(document).on("click", ".btnEditar", function () {
    fila = $(this).closest("tr");
    costoml = $("#costoml").val();
    estadouso = fila.find("td:eq(15)").text();
    estadonom = fila.find("td:eq(14)").text();

    if(estadouso == 1 || estadonom == 1){
      swal.fire({
        title: "ORDEN BLOQUEADA",
        text: "No es posible modificar la orden",
        icon: "error",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
      });
    }
    else{
      $("#formimporte").trigger("reset");
      $("#folioorden").val(fila.find("td:eq(0)").text());
      metros = fila.find("td:eq(9)").text();
      importenom = parseFloat(metros) * parseFloat(costoml);
      importenom = importenom.toFixed(2);
      $("#total").val(fila.find("td:eq(10)").text().replace(/,/g, ""));
      $("#importenom").val(importenom);
      $("#costoml2").val(costoml);
      $("#mlorden").val(metros);
      $("#mlorigen").val(metros);
  
      $("#modalImporte").modal("show");
    }
    

   
  });

  $(document).on("click", ".btnbloquear", function () {
    fila = $(this).closest("tr");
   
    
    folio = fila.find("td:eq(0)").text();
    estado = fila.find("td:eq(15)").text();
    $.ajax({
      url: "bd/bloqueoorden.php",
      type: "POST",
      dataType: "json",
      data: {
        folio: folio,
        estado: estado,
        
      },
      success: function (data) {
        if (data == 1) {
          mensaje();
          
          window.location.reload();
        }
      },
      error: function (data) {
        nomensaje();
      },
    });
    
  });



  
  $(document).on("click", "#btnGuardarimp", function () {
    folio = $("#folioorden").val();
    importe = $("#importenom").val();
    total = $("#total").val();
    ml = $("#mlorden").val();
    costoml = $("#costoml2").val();
    mlorigen = $("#mlorigen").val();
    if (parseFloat(ml) <= parseFloat(mlorigen)) {
      if (folio == "" || importe == "" || ml == "" || costoml == "") {
        nomensaje();
      } else {
        if (parseFloat(total) >= parseFloat(importe)) {
          $.ajax({
            url: "bd/importenom.php",
            type: "POST",
            dataType: "json",
            data: {
              folio: folio,
              importe: importe,
              ml: ml,
              costoml: costoml,
            },
            success: function (data) {
              if (data == 1) {
                mensaje();
                $("#modalImporte").modal("hide");
                $("#formimporte").trigger("reset");
                window.location.reload();
              }
            },
            error: function (data) {
              nomensaje();
            },
          });
        } else {
          swal.fire({
            title: "El Importe excede el Monto de la Venta",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
          });
        }
      }
    } else {
      swal.fire({
        title: "ERROR ML",
        text:"El valor de los ML no puede ser mayor al valor calculado, verifique sus datos",
        icon: "error",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
      });

    }
  });

  document.getElementById("costoml2").onblur = function () {
    calcularimporte();
  };
  // SOLO NUMEROS IVA FACTURA
  document.getElementById("mlorden").onblur = function () {
    calcularimporte();
  };
  function calcularimporte() {
    costoml = $("#costoml2").val();
    valorml = $("#mlorden").val();
    importe = parseFloat(costoml) * parseFloat(valorml);
    $("#importenom").val(importe);
  }

  function mensaje() {
    swal.fire({
      title: "Orden Actualizada",
      icon: "success",
      focusConfirm: true,
      confirmButtonText: "Aceptar",
    });
  }
  function nomensaje() {
    swal.fire({
      title: "No fue posible actualizar la Orden",
      icon: "error",
      focusConfirm: true,
      confirmButtonText: "Aceptar",
    });
  }

  function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    var isNumber = key >= 48 && key <= 57;
    var isSpecial = key == 8 || key == 13 || key == 0 || key == 46;
    if (isNumber || isSpecial) {
      return filter(tempValue);
    }

    return false;
  }
  function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    return preg.test(__val__) === true;
  }
});
