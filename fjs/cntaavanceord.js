$(document).ready(function () {
  var id, opcion;
  opcion = 4;

  tablaVis = $("#tablaV").DataTable({
    stateSave: true,
    info: false,

  
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

  $("#tablaV tbody").on("click", "tr td.details-control", function () {
    var tr = $(this).closest("tr");
    var row = tablaVis.row(tr);
    var idx = $.inArray(tr.attr("id"), detailRows);
    folio = parseInt($(this).closest("tr").find("td:eq(1)").text());

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
      "<thead class='text-center bg-gradient-orange text-white'>" +
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
      url: "bd/avanceorden.php",
      type: "POST",
      dataType: "json",
      data: { folio: folio },
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

  var fila;

  function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    //Add a zero in front of numbers<10
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
    var time = setTimeout(function () {
      startTime();
    }, 500);
  }

  function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }

  $("#btnBuscar").click(function () {
    var inicio = $("#inicio").val();
    var final = $("#final").val();
    window.location.href =
      "cntaavanceord.php?inicio=" + inicio + "&fin=" + final;
  });
});
