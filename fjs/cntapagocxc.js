$(document).ready(function () {
  var id, opcion
  opcion = 4
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
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7] },
      },
    ],
    stateSave: true,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm bg-purple btnFacturar'><i class='fas fa-file-invoice'></i></button><button class='btn btn-sm btn-danger btnCancelar'><i class='fas fa-ban'></i></button></div></div>",
      },
      {
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
        },
        targets: 2,
      },
      {
        targets: 8,
        render: function (data, type, row, meta) {
          if (data == 1) {
            return '<div class="text-center"><img src="img/check.png"></img></div>'
          } else {
            return '<div class="text-center"><img src="img/uncheck.png"></img></div>'
          }
        },
      },
      {
        targets: 9,
        render: function (data, type, row, meta) {
          if (data == 1) {
            return '<div class="text-center"><img src="img/check.png"></img></div>'
          } else {
            return '<div class="text-center"><img src="img/uncheck.png"></img></div>'
          }
        },
      },
      {
        targets: 12,
        render: function (data, type, row, meta) {
          if (data == 1) {
            return '<div class="text-center"><img src="img/lock.png"></img></div>'
          } else {
            return '<div class="text-center"><img src="img/unlock.png"></img></div>'
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

   
  })

  $('#btnBuscar').click(function () {
    var inicio = $('#inicio').val()
    var final = $('#final').val()

    if (inicio != '' && final != '') {
      $.ajax({
        type: 'POST',
        url: 'bd/buscarpago_cxc.php',
        dataType: 'json',
        data: { inicio: inicio, final: final },
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
                data[i].metodo,
                data[i].fcliente,
                data[i].facturado,
                data[i].factura,
                data[i].fecha_fact,
                data[i].seguro_fact,
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

  $('#btnNuevo').click(function () {

  })

  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    window.location.href = 'venta.php?folio=' + id
  })

  $(document).on('click', '.btnFacturar', function () {
    fila = $(this).closest('tr')

    folio_venta = parseInt(fila.find('td:eq(0)').text())
    folio = parseInt(fila.find('td:eq(3)').text())

    $('#formPago').trigger('reset')
    $.ajax({
        type: 'POST',
        url: 'bd/buscarpcxc.php',
        dataType: 'json',
        async:false,
        data: { folio: folio},
        success: function (data) {

                fecha=data[0].fecha;
                concepto=data[0].concepto;
                obs=data[0].obs;
                metodo=data[0].metodo;
                fcliente=data[0].fcliente;
                facturado=data[0].facturado;
                factura=data[0].factura;
                fecha_fact=data[0].fecha;
                bloqueo=data[0].seguro_fact;
                monto=data[0].monto;

                $('#foliovp').val(folio_venta);
                $('#foliopago').val(folio);
                $('#fechavp').val(fecha);
                $('#conceptovp').val(concepto);
                $('#obsvp').val(obs);
                $('#metodo').val(metodo);
                $('#montopago').val(monto);
                
                $('#factura').val(factura);
                $('#fechafact').val(fecha_fact);

                if (fcliente==1){
                    $('#ccliefact').prop('checked', true)
                }
                else{
                    $('#ccliefact').prop('checked',false)
                }

                if (facturado==1){
                    $('#facturado').prop('checked', true)
                }
                else{
                    $('#facturado').prop('checked',false)
                }

                if (bloqueo==1){
                    $('#cbloqueo').prop('checked', true)
                }
                else{
                    $('#cbloqueo').prop('checked',false)
                }
                if (bloqueo==1){
                    swal.fire({
                        title: 'Registro Bloqueado',
                        text:'No es posible modificar el pago',
                        icon: 'error',
                        focusConfirm: true,
                        confirmButtonText: 'Aceptar',
                      })
                }
                else{
                    $('.modal-header').css('color', 'white')
                    $('#modalPago').modal('show')
                }
        }
    })


    
    //buscar datos del pago y mostrarlo en el modal, pero si esta bloqueado entonces avisar

   
  }),


    $(document).on('click', '.btnCancelar', function () {
      fila = $(this).closest('tr')

      folio_venta = parseInt(fila.find('td:eq(0)').text())
      folio_pago = parseInt(fila.find('td:eq(3)').text())

      $('#formcan').trigger('reset')
      /*$(".modal-header").css("background-color", "#28a745");*/
      $('.modal-header').css('color', 'white')
      $('.modal-title').text('Cancelar Pago')
      $('#modalcan').modal('show')
    })

  $(document).on('click', '#btnGuardar', function () {
    motivo = $('#motivo').val()
    fecha = $('#fecha').val()
    usuario = $('#nameuser').val()
    $('#modalcan').modal('hide')

    if (motivo === '') {
      swal.fire({
        title: 'Datos Incompletos',
        text: 'Verifique sus datos',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    } else {
      $.ajax({
        type: 'POST',
        url: 'bd/cancelarpcxc.php',
        async: false,
        dataType: 'json',
        data: {
          folio_venta: folio_venta,
          folio_pago: folio_pago,
          motivo: motivo,
          fecha: fecha,
          usuario: usuario,
        },
        success: function (res) {
          if (res == 1) {
            mensaje()
            location.reload()
          } else {
            mensajeerror()
          }
        },
      })
    }
  });

  $(document).on('click', '#btnGuardarvp', function () {

    console.log("Botono actualizar pago")
    var folio = $('#foliopago').val()
    var fechavp = $('#fechavp').val()
    var conceptovp = $('#conceptovp').val()
    var obsvp = $('#obsvp').val()
    
    var metodo = $('#metodo').val()
  
    var fcliente=0;
    var facturado=0;
    var bloqueo=0;
    if ($('#ccliefact').prop('checked')){
        fcliente=1
    }
    if ($('#facturado').prop('checked')){

        facturado=1;
    }

    if ($('#bloqueo').prop('checked')){
        bloqueo=1;
    }
    var factura= $('#factura').val();
    var fechafact= $('#fechafact').val();
    opcion=2;
    $.ajax({
        url: 'bd/pagoventa.php',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
          folio: folio,
          fechavp: fechavp,
          obsvp: obsvp,
          conceptovp: conceptovp,
          metodo: metodo,
          fcliente: fcliente,
          facturado: facturado,
          factura: factura,
          fechafact: fechafact,
          bloqueo: bloqueo,
          opcion: opcion,
        },
        success: function (res) {
            
          if (res == 1) {
            swal.fire({
                title: 'Operacion Exitosa',
                text: 'La información del Pago ha sido actualizada',
                icon: 'success',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
            })
            window.setTimeout(function() {
                location.reload();;
            }, 1000);
        } else {
            swal.fire({
              title: 'Error',
              text: 'La operacion no puedo completarse',
              icon: 'warning',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
          }
        },
      })

  });

  function mensaje() {
    swal.fire({
      title: 'Pago Cancelado',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  };

  function mensajeerror() {
    swal.fire({
      title: 'Error al Cancelar el pago',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  };

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

  $(document).on('click', '#ccliefact', function () {
   
    if ($('#ccliefact').prop('checked')) {
      $('#facturado').prop('checked', true)
      $('#factura').prop('disabled', false)
      $('#fechafact').prop('disabled', false)
    }

    if ($('#metodo').val() != 'Efectivo') {
      $('#facturado').prop('checked', true)
      $('#factura').prop('disabled', false)
      $('#fechafact').prop('disabled', false)
    } else {
      if ($('#ccliefact').prop('checked')) {
        $('#facturado').prop('checked', true)
        $('#factura').prop('disabled', false)
        $('#fechafact').prop('disabled', false)
      } else {
        $('#facturado').prop('checked', false)
        $('#factura').prop('disabled', true)
        $('#factura').val('')
        $('#fechafact').prop('disabled', true)
        $('#fechafact').val($('#fechavp').val())
      }
    }
  });

  $(document).on('click', '#facturado', function () {
    if ($('#ccliefact').prop('checked')) {
      $('#facturado').prop('checked', true)
      $('#factura').prop('disabled', false)
      $('#fechafact').prop('disabled', false)
    }

    if ($('#metodo').val() != 'Efectivo') {
      $('#facturado').prop('checked', true)
      $('#factura').prop('disabled', false)
      $('#fechafact').prop('disabled', false)
    }

    if ($('#facturado').prop('checked')) {
      $('#factura').prop('disabled', false)
      $('#fechafact').prop('disabled', false)
    } else {
      $('#factura').prop('disabled', true)
      $('#factura').val('')
      $('#fechafact').prop('disabled', true)
      $('#fechafact').val($('#fechavp').val())
    }
  });

  $(document).on('change', '#metodo', function () {
    if ($('#metodo').val() != 'Efectivo') {
      $('#facturado').prop('checked', true)
      $('#factura').prop('disabled', false)
      $('#fechafact').prop('disabled', false)
    } else {
      if ($('#ccliefact').prop('checked')) {
        $('#facturado').prop('checked', true)
        $('#factura').prop('disabled', false)
        $('#fechafact').prop('disabled', false)
      } else {
        $('#facturado').prop('checked', false)
        $('#factura').prop('disabled', true)
        $('#factura').val('')
        $('#fechafact').prop('disabled', true)
        $('#fechafact').val($('#fechavp').val())
      }
    }
  });

 
})
