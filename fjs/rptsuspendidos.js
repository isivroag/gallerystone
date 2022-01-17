//falta hora y fecha de ejecucion de llamada
//falta que hacer cuando la llamada 3 es cerrada


$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip()
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
          orthogonal: 'myExport',
          exportOptions: {
            columns: [ 1, 2, 3, 4, 5, 6, 7, 8,9],
            format: {
              body: function (data, row, column, node) {
                if (column === 5) {
                  return data.replace(/[$,]/g, '')
                } else if (column === 8) {
                  /*
                  switch (data) {
                    case '0':
                      return data.replace(0, 'RECHAZADO')
  
                      break
                    case '1':
                      return data.replace('1', 'PENDIENTE')
                      break
                    case '2':
                      return data.replace('2', 'ENVIADO')
                      break
                    case '3':
                      return data.replace('3', 'ACEPTADO')
                      break
                    case '4':
                      return data.replace('4', 'EN ESPERA')
                      break
                    case '5':
                      return data.replace('5', 'EDITADO')
                      break
                  }
                  */
                  return data
                } else if (column === 4 || column === 3) {
                  x = data.replace("<div class='text-wrap width-200'>", '')
                  x = x.replace('</div>', '')
                  return x
                } else {
                  return data
                }
              },
            },
          },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Reporte de Presupuestos',
          className: 'btn bg-danger',
          exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8,9] },
          footer: true,
          /*orthogonal: 'myExport',
          format: {
            body: function (data, row, column, node) {
              if (column === 8) {
                switch (data) {
                  case '0':
                    return data.replace(0, 'RECHAZADO')
  
                    break
                  case '1':
                    return data.replace('1', 'PENDIENTE')
                    break
                  case '2':
                    return data.replace('2', 'ENVIADO')
                    break
                  case '3':
                    return data.replace('3', 'ACEPTADO')
                    break
                  case '4':
                    return data.replace('4', 'EN ESPERA')
                    break
                  case '5':
                    return data.replace('5', 'EDITADO')
                    break
                }
              } else {
                return data
              }
            },
          },*/
        },
      ],
  
      columnDefs: [
        {
          targets:-1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'>\
            <button class='btn btn-sm btn-info btnReactivar' data-toggle='tooltip' data-placement='top' title='Reactivar'><i class='fas fa-check-square '></i></button>\
            </div></div>",
        },{
          targets:0,
          class: "details-control",
          orderable: false,
          data: null,
          defaultContent: ""
      },
   
        {
          targets: 4,
          render: function (data, type, full, meta) {
            return "<div class='text-wrap width-200'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
          },
        },
        {
          targets: 5,
          render: function (data, type, full, meta) {
            return "<div class='text-wrap width-200'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
          },
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
  
        if (data[9] == 'PENDIENTE') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[9]).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('PENDIENTE')
        } else if (data[9] == 'ENVIADO') {
          //$($(row).find("td")[9]).css("background-color", "blue");
          $($(row).find('td')[9]).addClass('bg-gradient-primary')
          //$($(row).find('td')['9']).text('ENVIADO')
        } else if (data[9] == 'ACEPTADO') {
          //$($(row).find("td")[9]).css("background-color", "success");
          $($(row).find('td')[9]).addClass('bg-gradient-success')
          //$($(row).find('td')['9']).text('ACEPTADO')
        } else if (data[9] == 'SEGUIMIENTO') {
          //$($(row).find("td")[9]).css("background-color", "purple");
          $($(row).find('td')[9]).addClass('bg-gradient-purple')
          //$($(row).find('td')['9']).text('EN ESPERA')
        } else if (data[9] == 'MODIFICADO') {
          //$($(row).find("td")[5]).css("background-color", "light-blue");
          $($(row).find('td')[9]).addClass('bg-lightblue')
          //$($(row).find('td')['9']).text('EDITADO')
        } else if (data[9] == 'RECHAZADO'){
          //$($(row).find("td")[5]).css("background-color", "red");
          $($(row).find('td')[9]).addClass('bg-gradient-danger')
          //$($(row).find('td')['8']).text('RECHAZADO')
        }
        else if (data[9] == 'SUSPENDIDO'){
          $($(row).find('td')[9]).addClass('bg-gradient-info')
        }
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
              "<th>Programada</th>" +
              "<th>Nota</th>" +
              "<th>Realizada</th>" +
              "<th>Respuesta</th>" +
              "</tr>" +
              "</thead>" +
              "<tbody>";
  
          $.ajax({
  
              url: "bd/detallellamadas.php",
              type: "POST",
              dataType: "json",
              data: { folio: folio },
              async: false,
              success: function(res) {
                  
                 
                  for (var i = 0; i < res.length; i++) {
                    clase="";
                    console.log(parseInt(res[i].id_llamada));
                    switch(parseInt(res[i].id_llamada)){
                      case 1:
                        clase='class="bg1"';
                        break;
                      case 2:
                        clase='class="bg2"';
                        break;
                      case 3:
                        clase='class="bg3"';
                        break;
                    }
  
                      tabla += '<tr '+clase+'><td class="text-center">' + res[i].id_llamada + '</td><td class="text-center">' + res[i].desc_llamada + '</td><td class="text-center">' + res[i].fecha_llamada + '</td><td class=>' + res[i].nota_ant + '</td><td class="text-center">' + res[i].fecha_rea + '</td><td >' + res[i].nota_rea + '</td></tr>';
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
  
    $('#btnNuevo').click(function () {
      window.location.href = 'presupuesto.php'
      //$("#formDatos").trigger("reset");
      //$(".modal-header").css("background-color", "#28a745");
      //$(".modal-header").css("color", "white");
      //$(".modal-title").text("Nuevo Prospecto");
      //$("#modalCRUD").modal("show");
      //id = null;
      //opcion = 1; //alta
    })
  
    var fila //capturar la fila para editar o borrar el registro
  

  
  
   
  
  
    
      //BOTON RECHAZAR
      $(document).on('click', '.btnReactivar', function () {
        fila = $(this).closest('tr');
        folio = parseInt(fila.find('td:eq(1)').text());
        estado=fila.find('td:eq(9)').text();
        nota = "PRESUPUESTO REACTIVADO"
        fecha = $('#fechasys').val()
        usuario = $('#nameuser').val()
        estado=1;
        $.ajax({
          type: 'POST',
          url: 'bd/estadopres.php',
          dataType: 'json',
    
          data: {
            folio: folio,
            usuario: usuario,
            estado: estado,
            nota: nota,
            fecha: fecha,
          },
          success: function () {
            window.location.reload(true)
          },
        })  
     
      });
    
  //BOTON ENVIAR
  /*
    $(document).on('click', '.btnEnviar', function () {
      fila = $(this).closest('tr');
      id = parseInt(fila.find('td:eq(1)').text());
      estado = fila.find('td:eq(9)').text();
  
      if (estado.trim()=='PENDIENTE' || estado.trim()=='MODIFICADO'){
        swal.fire({
          title: 'El Presupuesto será marcado como ENVIADO',
          
          icon: 'info',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        }) .then(function (isConfirm) {
          if (isConfirm.value) {
            folio = id
            estado = 2;
            nota = "ENVIADO"
            fecha = $('#fechasys').val()
            usuario = $('#nameuser').val()
        
            $.ajax({
              type: 'POST',
              url: 'bd/estadopres.php',
              dataType: 'json',
        
              data: {
                folio: folio,
                usuario: usuario,
                estado: estado,
                nota: nota,
                fecha: fecha,
              },
              success: function () {
  
                swal.fire({
                  title: 'El Presupuesto fue marcado como ENVIADO',
                  
                  icon: 'success',
                  focusConfirm: true,
                  confirmButtonText: 'Aceptar',
                })
                window.location.reload(true)
              },
            })
  
          
          }
        })
  
      }
      else{
        swal.fire({
          title: 'El Presupuesto NO puede ser marcado como ENVIADO',
          
          icon: 'warning',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
      }
      
    });*/

  
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
  