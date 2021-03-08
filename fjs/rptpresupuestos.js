$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
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
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5,6],
            format: {
              body: function (data, row, column, node) {
                if (column === 5) {
                  return data.replace(/[$,]/g, '')
                } else if (column === 6) {
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
            },
          },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Reporte de Presupuestos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5,6] },
          format: {
              body: function (data, row, column, node) {
                if (column === 6) {
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
            },
        },
      ],
      stateSave: true,
      
  
      
  
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
        $($(row).find('td')['6']).css('color', 'white')
        $($(row).find('td')['6']).addClass('text-center')
        $($(row).find('td')['5']).addClass('text-right')
        $($(row).find('td')['5']).addClass('currency')
  
        if (data[6] == 1) {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[6]).addClass('bg-gradient-warning')
          $($(row).find('td')['6']).text('PENDIENTE')
        } else if (data[6] == 2) {
          //$($(row).find("td")[6]).css("background-color", "blue");
          $($(row).find('td')[6]).addClass('bg-gradient-primary')
          $($(row).find('td')['6']).text('ENVIADO')
        } else if (data[6] == 3) {
          //$($(row).find("td")[6]).css("background-color", "success");
          $($(row).find('td')[6]).addClass('bg-gradient-success')
          $($(row).find('td')['6']).text('ACEPTADO')
        } else if (data[6] == 4) {
          //$($(row).find("td")[6]).css("background-color", "purple");
          $($(row).find('td')[6]).addClass('bg-gradient-purple')
          $($(row).find('td')['6']).text('EN ESPERA')
        } else if (data[6] == 5) {
          //$($(row).find("td")[5]).css("background-color", "light-blue");
          $($(row).find('td')[6]).addClass('bg-lightblue')
          $($(row).find('td')['6']).text('EDITADO')
        } else {
          //$($(row).find("td")[5]).css("background-color", "red");
          $($(row).find('td')[6]).addClass('bg-gradient-danger')
          $($(row).find('td')['6']).text('CANCELADO')
        }
      },


      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        total = api
            .column( 5 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 5, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 5 ).footer() ).html(
            '$'+ new Intl.NumberFormat('es-MX').format(Math.round((total + Number.EPSILON) * 100) / 100) 
        );
        }
    });
  
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
  
    //botón EDITAR
    $(document).on('click', '.btnEditar', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
  
      window.location.href = 'pres.php?folio=' + id
    })
  
    $(document).on('click', '.btnLlamar', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
      $('#formllamada').trigger('reset')
      $('.modal-header').css('background-color', '#28a745')
      $('.modal-header').css('color', 'white')
      $('.modal-title').text('Llamada de seguimiento')
      $('#modalcall').modal('show')
    })
  
    $(document).on('click', '.btnhistory', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
      window.location.href = 'verhistorialpres.php?folio=' + id
    })
  
    //botón BORRAR
    $(document).on('click', '.btnBorrar', function () {
      fila = $(this).closest('tr')
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
      opcion = 3 //borrar
      //agregar codigo de sweatalert2
      var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')
      folio = id
      estado = 0
      nota = 'CANCELACIÓN'
      fecha = $('#fechasys').val()
      usuario = $('#nameuser').val()
      if (respuesta) {
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
          success: function (data) {
            if (data == 1) {
              window.location.reload(true)
            }
          },
        })
      }
    })
  
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
  
    $('#formllamada').submit(function (e) {
      e.preventDefault()
      folio = id
      estado = $('#estado').val()
      nota = $('#nota').val()
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
          window.location.reload(true)
        },
      })
      $('#modalcall').modal('hide')
    })
  
    $('#btnBuscar').click(function () {
      var inicio = $('#inicio').val()
      var final = $('#final').val()
  
      if ($('#ctodos').prop('checked')) {
        opcion = 0
      } else {
        opcion = 1
      }
  
      tablaVis.clear()
      tablaVis.draw()
  
      console.log(opcion)
  
      if (inicio != '' && final != '') {
        $.ajax({
          type: 'POST',
          url: 'bd/buscarpresupuestos.php',
          dataType: 'json',
          data: { inicio: inicio, final: final, opcion: opcion },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              estado = data[i].estado_pres
              total = data[i].gtotal
  
              tablaVis.row
                .add([
                  data[i].folio_pres,
                  data[i].fecha_pres,
                  data[i].nombre,
                  data[i].concepto_pres,
                  data[i].ubicacion,
                  data[i].gtotal,
                  data[i].estado_pres,
                ])
                .draw()
  
              //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
            }
          },
        })
      } else {
        alert('Selecciona ambas fechas')
      }
    })
  })
  
