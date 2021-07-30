$(document).ready(function () {
  var id, opcion, fpago

  tablaVis = $('#tablaV').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      { className: 'text-center', targets: [0] },
      { className: 'text-center', targets: [3] },
      { className: 'text-center', targets: [4] },
      { className: 'text-center', targets: [5] },
    ],

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

  tablaD = $('#tablaD').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnEliminarcom'><i class='fas fa-trash'></i></button></div></div>",
      },
      { className: 'text-center', targets: [0] },
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

  tablaDet = $('#tablaDet').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-gradient-orange btnAreas'><i class='far fa-map text-light'></i></button>\
          <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\
          </div></div>",
      },
      {
        targets: 0,
        class: 'details-control',
        orderable: false,
        data: null,
        defaultContent: '',
      },
      { className: 'text-center', targets: [1] },
    ],

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

  tablaConceptos = $('#tablaConceptos').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnEliminarconceptos'><i class='fas fa-trash'></i></button></div></div>",
      },
      { className: 'text-center', targets: [0] },
      { className: 'text-center', targets: [1] },
      { className: 'text-center', targets: [2] },
      { className: 'text-center', targets: [3] },
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

  var detailRows = []

  $('#tablaDet tbody').on('click', 'tr td.details-control', function () {
    var tr = $(this).closest('tr')
    var row = tablaDet.row(tr)
    var idx = $.inArray(tr.attr('id_frente'), detailRows)
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

  tablaDet.on('draw', function () {
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
      "<table class='tabladetarea table table-sm table-striped  table-hover table-bordered table-condensed text-nowrap mx-auto ' style='width:100%'>" +
      "<thead class='text-center bg-gradient-orange '>" +
      "<tr class=''>" +
      '<th>Id Area</th>' +
      "<th class='hide_column'>Id_Frente</th>" +
      '<th>Area</th>' +
      '<th>Supervisor</th>' +
      '<th>Colocador</th>' +
      '<th>Acciones</th>' +
      '</tr>' +
      '</thead>' +
      '<tbody>'

    $.ajax({
      url: 'bd/buscardetfrente.php',
      type: 'POST',
      dataType: 'json',
      data: { folio: folio },
      async: false,
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tabla +=
            '<tr><td class="text-center">' +
            res[i].id_area +
            '</td><td class="text-center hide_column">' +
            res[i].id_frente +
            '</td><td class="text-center">' +
            res[i].area +
            '</td><td class=>' +
            res[i].supervisor +
            '</td><td class=>' +
            res[i].colocador +
            '</td><td><div class="text-center"><div class="btn-group"><button class="btn btn-sm btn-primary btnDetalleFrente"><i class="fas fa-hard-hat"></i></button>\
                  <button class="btn btn-sm btn-danger btnBorrarA"><i class="fas fa-trash-alt"></i></button>\
                  </div></div></td></tr>'
        }
      },
    })

    tabla += '</tbody>' + '</table>' + '</div>' + '</div>' + '</div>' + '</div>'

    return tabla
  }

  tablaMat = $('#tablaMat').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelMaterial'><i class='fas fa-hand-pointer'></i></button></div></div>",
      },
      { className: 'hide_column', targets: [0] },
      { className: 'hide_column', targets: [9] },
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

  $(document).on('click', '#btlimpiar', function () {
    limpiar()
  })

  $(document).on('click', '.btnAreas', function (event) {
    event.preventDefault()

    fila = $(this)
    id = parseInt($(this).closest('tr').find('td:eq(1)').text())
    nomfrente = $(this).closest('tr').find('td:eq(2)').text()
    $('#formArea').trigger('reset')

    $('#idfrentea').val(id)
    $('#nomfrentea').val(nomfrente)
    $('#modalArea').modal('show')
  })

  $(document).on('click', '.btnBorrar', function (event) {
    event.preventDefault()

    fila = $(this)
    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opcion = 2

    swal
      .fire({
        title: 'Borrar',
        text: '¿Realmente desea borrar este elemento?',

        showCancelButton: true,
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',

        cancelButtonText: 'Cancelar',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: 'bd/frentesobra.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: { id: id, opcion: opcion },
            success: function (data) {
              if (data == 1) {
                tablaDet.row(fila.parents('tr')).remove().draw()
              }
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })

  $(document).on('click', '#btnConceptos', function () {
    //window.location.href = "prospecto.php";
    $('#formConceptos').trigger('reset')

    $('#modalConceptos').modal('show')
  })

  $(document).on('click', '#btnGuardarconcepto', function () {
    idconcepto = $('#conceptod').val()
    idorden = $('#folioorden').val()
    concepto = $('#conceptod option:selected').text()

    if ($('#chestimacion').prop('checked')) {
      estimacion = 1
    } else {
      estimacion = 0
    }

    precio = $('#preciocon').val()
    costo = $('#costocon').val()
    opcion = 1
    console.log(estimacion)

    if (
      idorden.length != 0 &&
      precio.length != 0 &&
      costo.length != 0 &&
      idconcepto.length != 0 &&
      concepto.length != 0
    ) {
      $.ajax({
        type: 'POST',
        url: 'bd/detalleobra.php',
        dataType: 'json',

        data: {
          idorden: idorden,
          idconcepto: idconcepto,
          concepto: concepto,
          precio: precio,
          costo: costo,
          estimacion: estimacion,
          opcion: opcion,
        },
        success: function (data) {
          console.log(data)

          if (data == 0) {
            mensajeduplicado()
            return 0
          } else {
            id_reg = data[0].id_reg
            idconcepto = data[0].id_concepto
            concepto = data[0].nom_concepto
            precio = data[0].precio_concepto
            costo = data[0].costo_concepto

            tablaConceptos.row.add([id_reg, concepto, costo, precio]).draw()
            $('#modalConceptos').modal('hide')
          }
        },
      })
    } else {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Complemento',
        icon: 'warning',
      })
      return false
    }
  })

  $(document).on('click', '.btnEliminarconceptos', function (event) {
    event.preventDefault()

    fila = $(this)
    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opcion = 2

    swal
      .fire({
        title: 'Borrar',
        text: '¿Realmente desea borrar este elemento?',

        showCancelButton: true,
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',

        cancelButtonText: 'Cancelar',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: 'bd/detalleobra.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: { id: id, opcion: opcion },
            success: function (data) {
              if (data == 1) {
                tablaConceptos.row(fila.parents('tr')).remove().draw()
              }
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })

  $(document).on('click', '#btnGuardarArea', function () {
    idfrente = $('#idfrentea').val()
    area = $('#area').val()
    supervisor = $('#supervisor').val()
    colocador = $('#colocador').val()

    opcion = 1

    if (
      idfrente.length != 0 &&
      supervisor.length != 0 &&
      colocador.length != 0 &&
      area.length != 0
    ) {
      $.ajax({
        type: 'POST',
        url: 'bd/areasobras.php',
        dataType: 'json',
        //async: false,
        data: {
          idfrente: idfrente,
          area: area,
          supervisor: supervisor,
          colocador: colocador,
          opcion: opcion,
        },
        success: function (data) {
          window.location.href = 'caratulaobra.php?folio=' + $('#folior').val()
        },
      })
    } else {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Complemento',
        icon: 'warning',
      })
      return false
    }
  })
  $(document).on('click', '#btnGuardarFrente', function () {
    orden = $('#folioorden').val()
    nombre = $('#nombrefrente').val()

    opcion = 1

    if (orden.length != 0 && nombre.length != 0) {
      $.ajax({
        type: 'POST',
        url: 'bd/frentesobra.php',
        dataType: 'json',
        //async: false,
        data: {
          orden: orden,
          nombre: nombre,
          opcion: opcion,
        },
        success: function (data) {
          id_frente = data[0].id_frente
          nombre = data[0].nom_frente

          tablaDet.row.add([, id_frente, nombre]).draw()
          $('#modalFrente').modal('hide')
        },
      })
    } else {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Complemento',
        icon: 'warning',
      })
      return false
    }
  })

  function nomensaje() {
    swal.fire({
      title: 'No existen Inventario suficiente',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  $(document).on('click', '.btnEliminarcom', function (event) {
    event.preventDefault()

    fila = $(this)
    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opcion = 2

    swal
      .fire({
        title: 'Borrar',
        text: '¿Realmente desea borrar este elemento?',

        showCancelButton: true,
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',

        cancelButtonText: 'Cancelar',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: 'bd/complementoorden.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: { id: id, opcion: opcion },
            success: function (data) {
              if (data == 1) {
                tablaD.row(fila.parents('tr')).remove().draw()
              }
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })

  $(document).on('click', '.btnDetalleFrente', function (event) {
    event.preventDefault()

    fila = $(this)

    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    window.location.href = 'detallefrente.php?id=' + id
  })

  $(document).on('click', '#btnAreas', function () {
    //window.location.href = "prospecto.php";
    $('#formFrente').trigger('reset')

    $('#modalFrente').modal('show')
  })
  $(document).on('click', '#btnAddcom', function () {
    //window.location.href = "prospecto.php";
    $('#formCom').trigger('reset')

    $('#modalCom').modal('show')
  })

  $(document).on('click', '#btnGuardarcom', function () {
    orden = $('#folioorden').val()
    cantidad = $('#cantcom').val()
    umedida = $('#umedida').val()
    concepto = $('#concepto').val()
    opcion = 1

    if (
      orden.length != 0 &&
      cantidad.length != 0 &&
      umedida.length != 0 &&
      concepto.length != 0
    ) {
      $.ajax({
        type: 'POST',
        url: 'bd/complementoorden.php',
        dataType: 'json',
        //async: false,
        data: {
          orden: orden,
          cantidad: cantidad,
          umedida: umedida,
          concepto: concepto,
          opcion: opcion,
        },
        success: function (data) {
          console.log(data)
          id_reg = data[0].id_reg
          concepto = data[0].concepto_com
          cantidad = data[0].cant_com
          umedida = data[0].nom_umedida

          tablaD.row.add([id_reg, concepto, cantidad, umedida]).draw()
          $('#modalCom').modal('hide')
        },
      })
    } else {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Complemento',
        icon: 'warning',
      })
      return false
    }
  })

  function mensajeduplicado() {
    swal.fire({
      title: 'El concepto ya se encuentra en la lista',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

  function limpiar() {
    $('#nombre').val('')
  }

  function mensajeerror() {
    swal.fire({
      title: 'Operacion No exitosa',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
})
