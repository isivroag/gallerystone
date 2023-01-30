$(document).ready(function () {
  var id, opcion
  ;(val = 0), (opcion = 4)
  var folio_venta, folio_pago

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
        title: 'Reporte de Cobranza',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] },
        footer: true,
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Reporte de Cobranza',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] },
      },
    ],
    stateSave: true,
    paging: false,

    columnDefs: [
      {
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
        },
        targets: 1,
      },
     
      {
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
        },
        targets: 2,
      },
      {
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
        },
        targets: 5,
      },
      {
        targets: 7,
        render: function (data, type, row, meta) {
          if (data == 1) {
            return '<div class="btn btn-sm btnasignaru"><img src="img/check.png"></img></div>'
          } else {
            return '<div class="btn btn-sm  btnasignaru"><img src="img/wait.png"></img></div>'
          }
        },
      },
      {
        targets: 10,
        render: function (data, type, row, meta) {
          if (data == 1) {
            return '<div class="btn btn-sm btnasignarm"><img src="img/check.png"></img></div>'
          } else {
            return '<div class="btn btn-sm  btnasignarm"><img src="img/wait.png"></img></div>'
          }
        },
      },
      {
        targets: 13,
        render: function (data, type, row, meta) {
          if (data == 1) {
            return '<div class="btn btn-sm btnasignari"><img src="img/check.png"></img></div>'
          } else {
            return '<div class="btn btn-sm  btnasignari"><img src="img/wait.png"></img></div>'
          }
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
      $($(row).find('td')['6']).addClass('text-right')
      $($(row).find('td')['7']).addClass('text-center')
      $($(row).find('td')['8']).addClass('text-right')
      $($(row).find('td')['9']).addClass('text-right')
      $($(row).find('td')['10']).addClass('text-center')
      $($(row).find('td')['11']).addClass('text-right')
      $($(row).find('td')['12']).addClass('text-right')
      $($(row).find('td')['13']).addClass('text-center')
      $($(row).find('td')['14']).addClass('text-right')
      $($(row).find('td')['15']).addClass('text-right')

      
      

    
      
     
    },
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

      // Total over this page
      pageTotal = api
        .column(6, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      $(api.column(6).footer()).html(
        '$' +
          new Intl.NumberFormat('es-MX').format(
            Math.round((pageTotal + Number.EPSILON) * 100) / 100,
          ),
      )

      pageTotal = api
        .column(8, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      $(api.column(8).footer()).html(
        '$' +
          new Intl.NumberFormat('es-MX').format(
            Math.round((pageTotal + Number.EPSILON) * 100) / 100,
          ),
      )

      pageTotal = api
        .column(9, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      $(api.column(9).footer()).html(
        '$' +
          new Intl.NumberFormat('es-MX').format(
            Math.round((pageTotal + Number.EPSILON) * 100) / 100,
          ),
      )

      pageTotal = api
        .column(11, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      $(api.column(11).footer()).html(
        '$' +
          new Intl.NumberFormat('es-MX').format(
            Math.round((pageTotal + Number.EPSILON) * 100) / 100,
          ),
      )

      pageTotal = api
        .column(12, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      $(api.column(12).footer()).html(
        '$' +
          new Intl.NumberFormat('es-MX').format(
            Math.round((pageTotal + Number.EPSILON) * 100) / 100,
          ),
      )

      pageTotal = api
        .column(14, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      $(api.column(14).footer()).html(
        '$' +
          new Intl.NumberFormat('es-MX').format(
            Math.round((pageTotal + Number.EPSILON) * 100) / 100,
          ),
      )

      pageTotal = api
        .column(15, { page: 'current' })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b)
        }, 0)
      $(api.column(15).footer()).html(
        '$' +
          new Intl.NumberFormat('es-MX').format(
            Math.round((pageTotal + Number.EPSILON) * 100) / 100,
          ),
      )

      // Update footer
    },
  })

  $('#btnBuscar').click(function () {
    buscar()
  })
  function buscar() {
    var inicio = $('#inicio').val()
    var final = $('#final').val()
   
    val = 1

    if (inicio != '' && final != '') {
      $.ajax({
        type: 'POST',
        url: 'bd/buscarflujo.php',
        dataType: 'json',
        data: { inicio: inicio,  final: final },
        success: function (data) {
          tablaVis.clear()
          tablaVis.draw()
          for (var i = 0; i < data.length; i++) {
            tablaVis.row
              .add([
                data[i].folio_vta,
                data[i].cliente,
                data[i].concepto_vta,
                data[i].folio_pagocxc,
                data[i].fecha,
                data[i].concepto,
                data[i].monto,
                data[i].futilidad,
                data[i].util,
                data[i].utilidad,
                data[i].fmant,
                data[i].mante,
                data[i].mant,
                data[i].fimp,
                data[i].impu,
                data[i].imp
              ])
              .draw()

            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
          }
        },
      })
    } else {
      alert('Selecciona ambas fechas')
    }
  }

  $(document).on('click', '.btnImprimir', function () {
    fila = $(this).closest('tr')
    vta = parseInt(fila.find('td:eq(0)').text())
    pago = parseInt(fila.find('td:eq(3)').text())
    imprimirrecibo(vta, pago)
  })

  function imprimirrecibo(folio, pago) {
    var ancho = 1000
    var alto = 800
    var x = parseInt(window.screen.width / 2 - ancho / 2)
    var y = parseInt(window.screen.height / 2 - alto / 2)

    url = 'formatos/pdfrecibo.php?folio=' + folio + '&pago=' + pago

    window.open(
      url,
      'Recibo',
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
  }

  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '.btnasignaru', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    pago=parseInt(fila.find('td:eq(3)').text())
    sugerido=fila.find('td:eq(8)').text()
    monto=fila.find('td:eq(9)').text()


   $('#modalFlujo').modal('show')
   $('#foliopago').val(pago)
   $('#tipo').val("UTILIDAD")
   $('#montos').val(sugerido)
   $('#importeflujo').val(monto)
  })

  $(document).on('click', '.btnasignarm', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    pago=parseInt(fila.find('td:eq(3)').text())
     sugerido=fila.find('td:eq(11)').text()
    monto=fila.find('td:eq(12)').text()
    $('#modalFlujo').modal('show')
   $('#foliopago').val(pago)
   $('#tipo').val("MANTENIMIENTO")
   $('#montos').val(sugerido)
   $('#importeflujo').val(monto)
  })

  $(document).on('click', '.btnasignari', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    pago=parseInt(fila.find('td:eq(3)').text())
     sugerido=fila.find('td:eq(14)').text()
    monto=fila.find('td:eq(15)').text()
    $('#modalFlujo').modal('show')
    $('#foliopago').val(pago)
    $('#tipo').val("IMPUESTOS")
    $('#montos').val(sugerido)
    $('#importeflujo').val(monto)
  })


  $(document).on('click', '#btnGuardar', function () {
    folio = $('#foliopago').val()
    tipo = $('#tipo').val()
    sugerido = $('#montos').val()
    importe = $('#importeflujo').val()
console.log(folio)
console.log(tipo)
console.log(sugerido)
console.log(importe)
      $.ajax({
        type: 'POST',
        url: 'bd/flujo.php',
        async: false,
        dataType: 'json',
        data: {
          folio: folio,
          importe: importe,
          sugerido: sugerido,
          tipo: tipo,
        
        },
        success: function (res) {
          if (res == 1) {
            //window.location.reload()
          } else {
            mensajeerror()
          }
        },
      })
   
  })



  function mensaje() {
    swal.fire({
      title: 'Pago Cancelado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function mensajeerror() {
    swal.fire({
      title: 'Error al Cancelar el pago',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

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
