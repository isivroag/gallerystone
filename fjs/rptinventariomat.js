//falta hora y fecha de ejecucion de llamada
//falta que hacer cuando la llamada 3 es cerrada


$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      stateSave: true,
      info: false,
      //orderCellsTop: true,
      //fixedHeader: true,
  
      dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
      {
        extend: 'excelHtml5',
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: 'Exportar a Excel',
        title: 'Reporte de Presupuestos',
        className: 'btn bg-success ',
        customizeData: function(data) {
            for(var i = 0; i < data.body.length; i++) {
              for(var j = 0; j < data.body[i].length; j++) {
                data.body[i][j] = '\u200C' + data.body[i][j];
              }
            }
          }

      
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Reporte de Presupuestos',
        className: 'btn bg-danger', 
        footer: true,

      },
    ],
  
      columnDefs: [
       {
          targets:0,
          class: "details-control",
          orderable: false,
          data: null,
          defaultContent: ""
      },

      ],
  
      
  
      //Para cambiar el lenguaje a español
      language: {
        lengthMenu: 'Mostrar _MENU_ registros',
        zeroRecords: 'No se encontraron resultados',
        info:
          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
        infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
        infoFiltered: '(filtrado de un total de _MAX_ registros)',
        sSearch: 'Buscar:',
        oPaginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior',
        },
        sProcessing: 'Procesando...',
      },
  
      rowCallback: function (row, data) {
        $($(row).find('td')['9']).css('color', 'white')
        $($(row).find('td')['9']).addClass('text-center')
        $($(row).find('td')['8']).addClass('text-right')
        $($(row).find('td')['8']).addClass('currency')

      },
  
   
    })
  
    var detailRows = [];
  
      $('#tablaV tbody').on('click', 'tr td.details-control', function() {
          var tr = $(this).closest('tr');
          var row = tablaVis.row(tr);
          var idx = $.inArray(tr.attr('id'), detailRows);
          folio = parseInt($(this).closest("tr").find('td:eq(1)').text());
  
  
          if (row.child.isShown()) {
              tr.removeClass('details');
              row.child.hide();
  
              // Remove from the 'open' array
              detailRows.splice(idx, 1);
          } else {
              tr.addClass('details');
              row.child(format(row.data(), folio)).show();
  
              // Add to the 'open' array
              if (idx === -1) {
                  detailRows.push(tr.attr('id'));
              }
          }
      });
  
      tablaVis.on('draw', function() {
          $.each(detailRows, function(i, id) {
              $('#' + id + ' td.details-control').trigger('click');
          })
      });
  
      function format(d, folio) {
  
          tabla = "";
  
          tabla = " <div class='container '><div class='row'>" +
              "<div class='col-lg-12'>" +
              "<div class='table-responsive'>" +
              "<table class='table table-sm table-striped  table-bordered table-condensed text-nowrap mx-auto ' style='width:100%'>" +
              "<thead class='text-center bg-white '>" +
              "<tr class='bg-white'>" +
              "<th>Id</th>" +
              "<th>Descripcion</th>" +
              "<th>Largo</th>" +
              "<th>Alto</th>" +
              "<th>Ancho</th>" +
              "<th>M2</th>" +
              "<th>Ubicacion</th>" +
              "</tr>" +
              "</thead>" +
              "<tbody>";
  
          $.ajax({
  
              url: "bd/detallematerial.php",
              type: "POST",
              dataType: "json",
              data: { folio: folio },
              async: false,
              success: function(res) {
                  
                 
                  for (var i = 0; i < res.length; i++) {
  
                      tabla += '<tr><td class="text-center">' + res[i].id_mat + '</td><td>' + res[i].nom_mat + '</td><td class="text-center">' + res[i].largo_mat + '</td><td class="text-center">' 
                      + res[i].alto_mat + '</td><td class="text-center">' + res[i].ancho_mat + '</td><td class="text-center">' + res[i].m2_mat + '</td><td>'+ res[i].ubi_mat +'</td></tr>';
                  }
  
              }
          });
  
          tabla += "</tbody>" +
              "</table>" +
              "</div>" +
              "</div>" +
              "</div>" +
              "</div>";
  
          return tabla;
      };
  
  
  
    var fila //capturar la fila para editar o borrar el registro
  





  
    function startTime() {
      var today = new Date()
      var hr = today.getHours()
      var min = today.getMinutes()
      var sec = today.getSeconds()
      //Add a zero in front of numbers<10
      min = checkTime(min)
      sec = checkTime(sec)
      document.getElementById('clock').innerHTML = hr + ' : ' + min + ' : ' + sec
      var time = setTimeout(function () {
        startTime()
      }, 500)
    }
  
    function checkTime(i) {
      if (i < 10) {
        i = '0' + i
      }
      return i
    }

  })
  