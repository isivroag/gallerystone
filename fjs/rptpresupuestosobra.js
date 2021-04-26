$(document).ready(function () {
    var id, opcion
    opcion = 4

    $('#tablaV thead tr').clone(true).appendTo( '#tablaV thead' );
    $('#tablaV thead tr:eq(1) th').each( function (i) {

      
      
        var title = $(this).text();
        $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
          
          if (i==6){

           /* switch(this.value){
              case 'rechazado':
              case 'Rechazado':
              case 'RECHAZADO':
                valbuscar="0";
              break;
              case 'pendiente':
              case 'Pendiente':
              case 'PENDIENTE':
                valbuscar="1";
              break;
              case 'enviado':
              case 'Enviado':
              case 'ENVIADO':
                  valbuscar="2";
                break;
              case 'aceptado':
              case 'Aceptado':
              case 'ACEPTADO':
                  valbuscar="3";
                break;
              case 'en espera':
              case 'En espera':
              case 'en Espera':
              case 'En Espera':
              case 'EN ESPERA':
              case 'Espera':
              case 'espera':
              case 'ESPERA':
                  valbuscar="4";
                break;
              case 'editado':
              case 'Editado':
              case 'EDITADO':
                valbuscar="5";
                break; 
              default:
                valbuscar="";
            }*/
            
            valbuscar=this.value;
          }else{
            valbuscar=this.value;

          }
          
            if ( tablaVis.column(i).search() !== valbuscar ) {
                tablaVis
                    .column(i)
                    .search( valbuscar,true,true )
                    .draw();
            }
        } );


    } );

  
    tablaVis = $('#tablaV').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        columnDefs: [
          
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
         
          {
            "targets": 3,
            "render": function ( data, type, row, meta ) {
              return '<a href=rptpresclie.php?id_clie='+row[2]+'>'+data+'</a>';    }
         },
         { "width": "50px", "targets": 2 }
        ],
    
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Reporte de Presupuestos',
          className: 'btn bg-success ',
          footer: true,
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5,6,7],
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
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Reporte de Presupuestos',
          footer: true,
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5,6,7] },
          format: {
              body: function (data, row, column, node) {
                if (column === 6) {
                  /*switch (data) {
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
                  }*/
                  return data
                } else {
                  return data
                }
              },
            },
        },
      ],
      stateSave: true,
      orderCellsTop: true,
    fixedHeader: true,
    paging:false,
      
  
      
  
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
        $($(row).find('td')['7']).css('color', 'white')
        $($(row).find('td')['7']).addClass('text-center')
        $($(row).find('td')['6']).addClass('text-right')
        $($(row).find('td')['6']).addClass('currency')
  
        if (data[7] == 'PENDIENTE') {
          //$($(row).find("td")[7]).css("background-color", "warning");
          $($(row).find('td')[7]).addClass('bg-gradient-warning')
          //$($(row).find('td')['7']).text('PENDIENTE')
        } else if (data[7] == 'ENVIADO') {
          //$($(row).find("td")[7]).css("background-color", "blue");
          $($(row).find('td')[7]).addClass('bg-gradient-primary')
          //$($(row).find('td')['7']).text('ENVIADO')
        } else if (data[7] == 'ACEPTADO') {
          //$($(row).find("td")[7]).css("background-color", "success");
          $($(row).find('td')[7]).addClass('bg-gradient-success')
          //$($(row).find('td')['7']).text('ACEPTADO')
        } else if (data[7] == 'SEGUIMIENTO') {
          //$($(row).find("td")[7]).css("background-color", "purple");
          $($(row).find('td')[7]).addClass('bg-gradient-purple')
          //$($(row).find('td')['7']).text('EN ESPERA')
        } else if (data[7] == 'MODIFICADO') {
          //$($(row).find("td")[5]).css("background-color", "light-blue");
          $($(row).find('td')[7]).addClass('bg-lightblue')
          //$($(row).find('td')['7']).text('EDITADO')
        } else {
          //$($(row).find("td")[5]).css("background-color", "red");
          $($(row).find('td')[7]).addClass('bg-gradient-danger')
          //$($(row).find('td')['8']).text('RECHAZADO')
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
            .column( 6 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 6 ).footer() ).html(
            '$'+ new Intl.NumberFormat('es-MX').format(Math.round((pageTotal + Number.EPSILON) * 100) / 100) 
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
      tipo_proy=2;
  
      if ($('#ctodos').prop('checked')) {
        opcion = 0
      } else {
        opcion = 1
      }
  
      tablaVis.clear()
      tablaVis.draw()
  
      console.log('opcion '+opcion)
  
      if (inicio != '' && final != '') {
        $.ajax({
          type: 'POST',
          url: 'bd/buscarpresupuestos.php',
          dataType: 'json',
          data: { inicio: inicio, final: final,tipo_proy: tipo_proy, opcion: opcion },
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
              estado = data[i].estado_pres
              total = data[i].gtotal
              idpros='<a href=rptpresclie.php?id_clie='+data[i].id_pros+'>'+data[i].id_pros+'</a>'
              console.log('id_pros '+idpros)
              console.log('data ' +data[i].id_pros);
              tablaVis.row
                .add([
                  data[i].folio_pres,
                  data[i].fecha_pres,
                  data[i].id_pros,
                  data[i].nombre,
                  data[i].concepto_pres,
                  data[i].ubicacion,
                  data[i].gtotal,
                  data[i].estado_pres,
                  data[i].vendedor,
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
  

