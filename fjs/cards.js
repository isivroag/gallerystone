$(document).ready(function () {
  var id, opcion;
  opcion = 4;

  tablaB1 = $("#tablalls").DataTable({
    rowCallback: function (row, data) {
      if (data[6] == "LLAMADA 1") {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find("td")[6]).addClass("bg1");
        //$($(row).find('td')['6']).text('PENDIENTE')
      } else if (data[6] == "LLAMADA 2") {
        //$($(row).find("td")[6]).css("background-color", "blue");
        $($(row).find("td")[6]).addClass("bg2");
        //$($(row).find('td')['6']).text('ENVIADO')
      } else if (data[6] == "LLAMADA 3") {
        //$($(row).find("td")[6]).css("background-color", "success");
        $($(row).find("td")[6]).addClass("bg3");
        //$($(row).find('td')['6']).text('ACEPTADO')
      }
    },

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
    ordering: false,
    order: [
      [5, "asc"],
      [0, "asc"],
    ],
    paging: false,
    info: false,
    searching: false,
  });

  tablaOrden = $("#tablaOrden").DataTable({
    rowCallback: function (row, data) {
      avance = data[6];

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

      $($(row).find("td")[6]).html(barra);

      if (data[5] == "MEDICION") {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find("td")[5]).addClass("bg-gradient-warning");
        //$($(row).find('td')['5']).text('PENDIENTE')
      } else if (data[5] == "CORTE") {
        //$($(row).find("td")[5]).css("background-color", "blue");
        $($(row).find("td")[5]).addClass("bg-gradient-secondary");
        //$($(row).find('td')['5']).text('ENVIADO')
      } else if (data[5] == "ENSAMBLE") {
        //$($(row).find("td")[5]).css("background-color", "success");
        $($(row).find("td")[5]).addClass("bg-lightblue");
        //$($(row).find('td')['5']).text('ACEPTADO')
      } else if (data[5] == "PULIDO") {
        //$($(row).find("td")[5]).css("background-color", "purple");
        $($(row).find("td")[5]).addClass("bg-gradient-purple");
        //$($(row).find('td')['5']).text('EN ESPERA')
      } else if (data[5] == "COLOCACION") {
        //$($(row).find("td")[5]).css("background-color", "light-blue");

        $($(row).find("td")[5]).addClass("bg-gradient-orange");
        //$($(row).find('td')['5']).text('EDITADO')
      } else if (data[5] == "PROCESANDO") {
        //$($(row).find("td")[5]).css("background-color", "red");
        $($(row).find("td")[5]).addClass("bg-gradient-warning");
        //$($(row).find('td')['5']).text('RECHAZADO')
      } else if (data[5] == "LIBERADO") {
        $($(row).find("td")[5]).addClass("bg-gradient-success");
      } else if (data[5] == "ACTIVO") {
        $($(row).find("td")[5]).addClass("bg-gradient-primary");
      }
    },

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
    ordering: false,
    order: [
      [5, "asc"],
      [0, "asc"],
    ],
    paging: false,
    
    searching: false,
  });

  tablaC1 = $("#tablallps").DataTable({
    rowCallback: function (row, data) {
      if (data[6] == "LLAMADA 1") {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find("td")[6]).addClass("bg1");
        //$($(row).find('td')['6']).text('PENDIENTE')
      } else if (data[6] == "LLAMADA 2") {
        //$($(row).find("td")[6]).css("background-color", "blue");
        $($(row).find("td")[6]).addClass("bg2");
        //$($(row).find('td')['6']).text('ENVIADO')
      } else if (data[6] == "LLAMADA 3") {
        //$($(row).find("td")[6]).css("background-color", "success");
        $($(row).find("td")[6]).addClass("bg3");
        //$($(row).find('td')['6']).text('ACEPTADO')
      }
    },

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
    ordering: false,
    order: [[3, "asc"]],
    paging: false,
    info: false,
    searching: false,
  });

  tablaVis = $("#tablaV").DataTable({
    rowCallback: function (row, data) {
      $($(row).find("td")["4"]).css("color", "white");
      $($(row).find("td")["4"]).addClass("text-center");
      $($(row).find("td")["3"]).addClass("text-right");
      $($(row).find("td")["3"]).addClass("currency");

      if (data[4] == "PENDIENTE") {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find("td")[4]).addClass("bg-gradient-warning");
        //$($(row).find('td')['4']).text('PENDIENTE')
      } else if (data[4] == "ENVIADO") {
        //$($(row).find("td")[4]).css("background-color", "blue");
        $($(row).find("td")[4]).addClass("bg-gradient-primary");
        //$($(row).find('td')['4']).text('ENVIADO')
      } else if (data[4] == "ACEPTADO") {
        //$($(row).find("td")[4]).css("background-color", "success");
        $($(row).find("td")[4]).addClass("bg-gradient-success");
        //$($(row).find('td')['4']).text('ACEPTADO')
      } else if (data[4] == "SEGUIMIENTO") {
        //$($(row).find("td")[4]).css("background-color", "purple");
        $($(row).find("td")[4]).addClass("bg-gradient-purple");
        //$($(row).find('td')['4']).text('EN ESPERA')
      } else if (data[4] == "MODIFICADO") {
        //$($(row).find("td")[5]).css("background-color", "light-blue");
        $($(row).find("td")[4]).addClass("bg-lightblue");
        //$($(row).find('td')['4']).text('EDITADO')
      } else {
        //$($(row).find("td")[5]).css("background-color", "red");
        $($(row).find("td")[4]).addClass("bg-gradient-danger");
        //$($(row).find('td')['8']).text('RECHAZADO')
      }
    },

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
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button></div></div>",
      },
    ],
    stateSave: true,
    info: false,
  });

  tablaavance = $("#table-avance").DataTable({
    searching: false,
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
    
    ordering: false,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary bntVerorden'><i class='fas fa-search'></i></button></div></div>",
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
  });

  tablaDetalleo = $("#tablaDetalleo").DataTable({
    searching: false,
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
    info: false,
    ordering: false,
    columnDefs: [
      {
        targets: 0,
        className:'text-center'
        
        
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
  });

  
  $(document).on("click", ".bntVerorden", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(0)").text());
    buscarpiezas(id)

    
  });

  function buscarpiezas(folio) {
    tablaDetalleo.clear();
    tablaDetalleo.draw();
    $('#modalDetalleo').modal('show')
  

    $.ajax({
        type: "POST",
        url: "bd/buscardetalleotres.php",
        dataType: "json",
        async:true,
        data: { folio: folio },

        success: function(res) {
            for (var i = 0; i < res.length; i++) {
              piezas=res[i].piezas + "/" + res[i].totalpiezas
              tablaDetalleo.row.add([piezas,res[i].estado]).draw();

           
            }
            tablaDetalleo.columns.adjust().draw()
            //$('#modalpiezas').modal('show')

        },
    });
}

  tablalibproyantes = $(".tablasdetalles").DataTable({
    columnDefs: [
      { width: "10%", targets: 5 },
      { width: "20%", targets: 3 },
      { width: "10%", targets: 6 },
      { width: "10%", targets: 7 },
    ],

    searching: false,
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
    info: false,

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

    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data;

      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
          ? i
          : 0;
      };

      // Total over all pages
      total = api
        .column(6)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      saldo = api
        .column(7)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(6).footer()).html(
        "$" +
          new Intl.NumberFormat("es-MX").format(
            Math.round((total + Number.EPSILON) * 100) / 100
          )
      );
      $(api.column(7).footer()).html(
        "$" +
          new Intl.NumberFormat("es-MX").format(
            Math.round((saldo + Number.EPSILON) * 100) / 100
          )
      );
    },
  });

  $(document).on("click", ".btnEditar", function () {
    fila = $(this).closest("tr");
    id = parseInt(fila.find("td:eq(0)").text());

    window.location.href = "pres.php?folio=" + id;
  });

  $(document).on("click", "#btncalmedir", function () {
    window.location.href = "citaorden.php";
  });

  $(document).on("click", "#btinstalacion", function () {
    window.location.href = "citasventa.php";
  });

  $(document).on("click", "#btnHome", function () {
    fecha = $("#fechahome").val();

    window.location.href = "inicio.php?fecha=" + fecha;
  });

  tablaC = $("#tablaC").DataTable({
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
    stateSave: true,
    info: false,
  });

  tablaIN = $("#tablaIN").DataTable({
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
    searching: false,
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
    info: false,
    order: [[1, "desc"]],
  });


  tablaao = $("#tablaao").DataTable({
    stateSave: true,
    info: false,
    paging:false,
    ordering:false,

  
    columnDefs: [
      {
        targets: 0,
        class: "details-control",
        orderable: false,
        data: null,
        defaultContent: "",
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

    rowCallback: function (row, data) {},
  });

  var detailRows = [];

  $("#tablaao tbody").on("click", "tr td.details-control", function () {
    var tr = $(this).closest("tr");
    var row = tablaao.row(tr);
    var idx = $.inArray(tr.attr("id"), detailRows);
    folio = parseInt($(this).closest("tr").find("td:eq(1)").text());
    fechahome=$('#fechahome').val();

    if (row.child.isShown()) {
      tr.removeClass("details");
      row.child.hide();

      // Remove from the 'open' array
      detailRows.splice(idx, 1);
    } else {
      tr.addClass("details");
      row.child(format(row.data(), folio)).show();

      // Add to the 'open' array
      if (idx === -1) {
        detailRows.push(tr.attr("id"));
      }
    }
  });

  tablaVis.on("draw", function () {
    $.each(detailRows, function (i, id) {
      $("#" + id + " td.details-control").trigger("click");
    });
  });

  function format(d, folio) {
    tabla = "";

    tabla =
      " <div class='container '><div class='row'>" +
      "<div class='col-lg-12'>" +
      "<div class='table-responsive'>" +
      "<table class='table table-sm table-striped table-sm, table-striped table-hover table-bordered table-condensed text-nowrap mx-auto ' style='width:100%'>" +
      "<thead class='text-center bg-gradient-info text-white'>" +
      "<tr class=''>" +
      "<th>ESTADO</th>" +
      "<th>DESCRIPCION</th>" +
      "<th>FECHA INI</th>" +
      "<th>FECHA FIN</th>" +
      "<th>USUARIO</th>" +
      "</tr>" +
      "</thead>" +
      "<tbody>";

    $.ajax({
      url: "bd/avanceorden2.php",
      type: "POST",
      dataType: "json",
      data: { folio: folio, fechahome: fechahome},
      async: false,
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
            clase="";
            tabla +=
            "<tr " +
            clase +
            '><td>' +
            res[i].estado +
            '</td><td >' +
            res[i].descripcion +
            '</td><td class="text-center">' +
            res[i].fecha_ini +
            '</td><td class="text-center">' +
            res[i].fecha_fin +
            '</td><td class="text-center">' +
            res[i].usuario +
            "</td></tr>";
        }
      },
    });

    tabla +=
      "</tbody>" + "</table>" + "</div>" + "</div>" + "</div>" + "</div>";

    return tabla;
  }





});
