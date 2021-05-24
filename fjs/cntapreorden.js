$(document).ready(function () {
  var id, opcion
  opcion = 4

  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-primary btnVer'><i class='fas fa-search'></i></button>\
             <button class='btn btn-sm bg-success btnLiberar'><i class='fas fa-check-circle'></i></button>\
              </div>",
      },
      {
        targets: 4,
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
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
  })

  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '.btnVer', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(1)').text())

    window.location.href = 'orden.php?folio=' + id
  })

  $(document).on('click', '.btnLiberar', function () {
    fila = $(this).closest('tr');
    folio = parseInt(fila.find('td:eq(0)').text());
    venta = parseInt(fila.find('td:eq(1)').text());
    fecha = fila.find('td:eq(6)').text();
    fechaini = fila.find('td:eq(2)').text();
    $('#formOrden').trigger('reset');

    $('#modalOrden').modal('show');
    $('#fechai').val(fechaini);
    $('#fecha').val(fecha);
    $('#folioorden').val(folio);
    $('#folioventa').val(venta);

  })

  $(document).on('click', '#btnGuardar', function (event) {
    event.preventDefault()

    folio = $('#folioorden').val()
    venta = $('#folioventa').val()
    fecha = $('#fecha').val()
    fechaini= $('#fechai').val()

    estado = 'ACTIVO'
    porcentaje = 0
    if (folio.length == 0 || venta.length == 0 || fecha.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/estadoorden.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
          estado: estado,
          fecha: fecha,
          fechaini,fechaini,
          venta: venta,
          porcentaje: porcentaje,
        },
        success: function (res) {
          if (res == 1) {
            $('#modalOrden').modal('hide')
            mensaje()
            window.location.href = 'cntapreorden.php'
          } else {
            nomensaje()
          }
        },
      })
    }
  })

  function mensaje() {
    swal.fire({
      title: 'Orden de Servicio Actualizada',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
  function nomensaje() {
    swal.fire({
      title: 'No fue posible actualizar la Orden',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
})
