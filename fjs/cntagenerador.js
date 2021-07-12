//falta hora y fecha de ejecucion de llamada
//falta que hacer cuando la llamada 3 es cerrada

$(document).ready(function () {
  var id, opcion
  opcion = 4
  var rows_selected = [];

  tablaVis = $('#tablaV').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,
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
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
        exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7, 8, 9] },
        footer: true,
      },
    ],

    columnDefs: [
      {
        targets: 0,
        class: 'details-control',
        orderable: false,
        data: null,
        defaultContent: '',
      },
      { targets: 2, class: 'hide_column' },
      { targets: 4, class: 'hide_column' },
      { targets: 9, class: 'text-right' },
      { targets: 10, class: 'text-right' },
      {
        targets: -1,
        searchable: false,
        orderable: false,
        className: 'dt-body-center',
        render: function (data, type, full, meta,) {
          return (
            '<input type="checkbox" >'
          )
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

    rowCallback: function(row, data, dataIndex){
      // Get row ID
      var rowId = data[1];
   
      // If row ID is in the list of selected row IDs
      if($.inArray(rowId, rows_selected) !== -1){
         $(row).find('input[type="checkbox"]').prop('checked', true);
         $(row).addClass('selected');
    }},

    footerCallback: function (row, data, start, end, display) {
      var api = this.api(),
        data

      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
        return typeof i === 'string'
          ? i.replace(/[\$,]/g, '') * 1
          : typeof i === 'number'
          ? i
          : 0
      }

      // Total over all pages
      total = api
        .column(9)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      total2 = api
        .column(10)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      // Total over this page
      pageTotal = api
        .column(9, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      pageTotal2 = api
        .column(10, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)

      // Update footer
      $(api.column(9).footer()).html(
        commaSeparateNumber(
          parseFloat(
            new Intl.NumberFormat('es-MX').format(
              Math.round((pageTotal + Number.EPSILON) * 100) / 100,
            ),
          ).toFixed(2),
        ),
      )
      $(api.column(10).footer()).html(
        commaSeparateNumber(
          parseFloat(
            new Intl.NumberFormat('es-MX').format(
              Math.round((pageTotal2 + Number.EPSILON) * 100) / 100,
            ),
          ).toFixed(2),
        ),
      )
    },
  })

  $('#tablaV tbody').on('change', 'input[type="checkbox"]', function () {
    // If checkbox is not checked
    if (!this.checked) {
      var el = $('#example-select-all').get(0)
      // If "Select all" control is checked and has 'indeterminate' property
      if (el && el.checked && 'indeterminate' in el) {
        // Set visual state of "Select all" control
        // as 'indeterminate'
        el.indeterminate = true
      }
    }
  })


  $('#formdatos').on('submit', function(e) {
    e.preventDefault();    
    
                $("input[type=checkbox]:checked", $('#tablaV').dataTable().fnGetNodes()).each(function () {
                    var selectedtds = $(this).closest("tr").find("td");
                    var id = $(selectedtds).eq(1).text();
                    rows_selected.push(id);
                    $('#texto').val(id);
                    
                });

                rows_selected.forEach(function(elemento, indice, array) {
                  console.log(elemento, indice);
              })


              window.location = 'datos.php?data='+rows_selected


             
              
                
    
  });



 

  //CHECKBOX
  $('#example-select-all').on('click', function () {
    // Get all rows with search applied
    var rows = tablaVis.rows({ search: 'applied' }).nodes()
    // Check/uncheck checkboxes for all rows in the table
    $('input[type="checkbox"]', rows).prop('checked', this.checked)
  })

  //DETALLES
  var detailRows = []

  $('#tablaV tbody').on('click', 'tr td.details-control', function () {
    var tr = $(this).closest('tr')
    var row = tablaVis.row(tr)
    var idx = $.inArray(tr.attr('id'), detailRows)
    folio = parseInt($(this).closest('tr').find('td:eq(1)').text())

    if (row.child.isShown()) {
      tr.removeClass('details')
      row.child.hide()

      // Remove from the 'open' array
      detailRows.splice(idx, 1)
    } else {
      tr.addClass('details')
      row.child(format(row.data(), folio)).show()

      // Add to the 'open' array
      if (idx === -1) {
        detailRows.push(tr.attr('id'))
      }
    }
  })

  tablaVis.on('draw', function () {
    $.each(detailRows, function (i, id) {
      $('#' + id + ' td.details-control').trigger('click')
    })
  })

  function format(d, folio) {
    tabla = ''

    tabla =
      " <div class='container '><div class='row justify-content-center'>" +
      "<div class='col-lg-8'>" +
      "<div class='table-responsive'>" +
      "<table class='table table-sm table-striped  table-bordered table-condensed text-nowrap mx-auto ' style='width:100%'>" +
      "<thead class='text-center bg-gradient-secondary '>" +
      "<tr class=''>" +
      '<th>Concepto</th>' +
      '<th>Cantidad</th>' +
      '</tr>' +
      '</thead>' +
      '<tbody>'

    $.ajax({
      url: 'bd/bdetallegenerador.php',
      type: 'POST',
      dataType: 'json',
      data: { folio: folio },
      async: false,
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tabla +=
            '<tr><td class="text-center">' +
            res[i].nom_concepto +
            '</td><td class="text-right">' +
            res[i].cantidad +
            '</td></tr>'
        }
      },
    })

    tabla += '</tbody>' + '</table>' + '</div>' + '</div>' + '</div>' + '</div>'

    return tabla
  }

  function commaSeparateNumber(val) {
    while (/(\d+)(\d{3})/.test(val.toString())) {
      val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2')
    }

    return val
  }

  $

  $('#btnestimacion').click(function () {
    var inicio = $('#inicio').val()
    var fin = $('#final').val()
    var folio = $('#folioorden').val()
    var ancho = 1000
    var alto = 800
    var x = parseInt(window.screen.width / 2 - ancho / 2)
    var y = parseInt(window.screen.height / 2 - alto / 2)

    url =
      'formatos/pdfestimacion.php?folio=' +
      folio +
      '&inicio=' +
      inicio +
      '&fin=' +
      fin

    window.open(
      url,
      'Estimación',
      'left=' +
        x +
        ',top=' +
        y +
        ',height=' +
        alto +
        ',width=' +
        ancho +
        'scrollbar=si,location=no,resizable=si,menubar=no',
    )
  })

  $('#btnBuscar').click(function () {
    var inicio = $('#inicio').val()
    var final = $('#final').val()
    var folio = $('#folioorden').val()

    tablaVis.clear()
    tablaVis.draw()

    if (inicio != '' && final != '') {
      $.ajax({
        type: 'POST',
        url: 'bd/bgenerador.php',
        dataType: 'json',
        data: { inicio: inicio, final: final, folio: folio },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            tablaVis.row
              .add([
                ,
                data[i].folio_gen,
                data[i].id_frente,
                data[i].nom_frente,
                data[i].id_area,
                data[i].area,
                data[i].fecha,
                data[i].inicio,
                data[i].fin,
                commaSeparateNumber(data[i].costo_gen),
                commaSeparateNumber(data[i].pp_gen),
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
