$(document).ready(function () {
  var id, opcion
  opcion = 4

  var textcolumnas = permisos()

  function permisos() {
    var estado = $('#estadocorte').val()
    var columnas = ''

    if (estado == 1) {
      columnas =
        "<div class='text-center'>\
            <button class='btn btn-sm bg-gradient-green text-light btnMov' data-toggle='tooltip' data-placement='top' title='Cambiar cantidades'><i class='fa-solid fa-boxes-packing'></i></button>\
            <button class='btn btn-sm bg-gradient-primary text-light btnIgual' data-toggle='tooltip' data-placement='top' title='Cantidades Iguales'><i class='fa-solid fa-equals'></i></button>\
           </div>"
    } else {
      columnas = "<div class='text-center'>\
           </div>"
    }
    return columnas
  }

  tablaVis = $('#tablaV').DataTable({
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
    ordering: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas,
      },
      { className: 'hide_column', targets: [0] },
      { className: 'hide_column', targets: [4] },
      { className: 'text-right', targets: [5] },
      { className: 'text-right', targets: [6] },
      { className: 'text-right', targets: [6] },
      { className: 'text-right', targets: [8] },
      { className: 'text-right', targets: [9] },
      { className: 'text-right', targets: [10] },
      { className: 'text-right', targets: [11] },
      { className: 'text-right', targets: [12] },
      { className: 'text-right', targets: [13] },
      { className: 'text-right', targets: [14] },
      { className: 'text-right', targets: [15] },
      { className: 'text-right', targets: [16] },

      { className: 'hide_column', targets: [17] },
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
      if (data[17] != 0) {
        $($(row).find('td')).addClass('bg-lightblue')
      } else {
      }
    },
  })

  var fila //capturar la fila para editar o borrar el registro

  //MOVIMIENTOS

  $(document).on('click', '.btnMov', function () {
    fila = $(this).closest('tr')
    idreg = parseInt(fila.find('td:eq(0)').text())
    id = parseInt(fila.find('td:eq(1)').text())
    clave = fila.find('td:eq(2)').text()
    nombre = fila.find('td:eq(3)').text()
    costo = fila.find('td:eq(5)').text()
    presentacion = fila.find('td:eq(6)').text()
    idunidad = fila.find('td:eq(4)').text()
    unidad = fila.find('td:eq(7)').text()
    cantidad = fila.find('td:eq(8)').text()

    contenidona = fila.find('td:eq(9)').text()
    contenidoaa = fila.find('td:eq(10)').text()
    contenidoat = fila.find('td:eq(11)').text()

    $('#idreg').val(idreg)
    $('#id').val(id)
    $('#claveact').val(clave)
    $('#costo').val(costo)
    $('#ninsumo').val(nombre)

    $('#presentacion').val(presentacion)
    $('#idunidad').val(idunidad)
    $('#umedida').val(unidad)
    $('#cant_act').val(cantidad)
    $('#contenidonact').val(contenidona)
    $('#contenidoaact').val(contenidoaa)
    $('#contenidotact').val(contenidoat)

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')

    $('#modalMOV').modal('show')
  })

  $(document).on('click', '.btnIgual', function () {
 
    fila = $(this).closest('tr')
    idreg = parseInt(fila.find('td:eq(0)').text())
    folio = $('#foliocorte').val()
    costo = fila.find('td:eq(5)').text()
    presentacion = fila.find('td:eq(6)').text()
 
    ncantidad = fila.find('td:eq(8)').text()

    ncontenidon = fila.find('td:eq(9)').text()
    ncontenidoa = fila.find('td:eq(10)').text()
    ncontenidot = fila.find('td:eq(11)').text()
    dcosto=0
    usuario = $('#nameuser').val()

    $.ajax({
      url: 'bd/bdcorteins.php',
      type: 'POST',
      dataType: 'json',
      data: {
        idreg: idreg,
        ncantidad: ncantidad,
        ncontenidon: ncontenidon,
        ncontenidoa: ncontenidoa,
        ncontenidot: ncontenidot,
        dcosto: dcosto,
      },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            title: 'Operación Exitosa',
            text: 'Movimiento Guardado',
            icon: 'success',
          })
          //$('#modalMOV').modal('hide')
          window.location.reload()
        } else {
          Swal.fire({
            title: 'No fue posible concluir la operacion',
            text: 'Movimiento No Guardado',
            icon: 'error',
          })
        }
      },
    })

})
  $('#formMov').submit(function (e) {
    e.preventDefault()
    var idreg = $.trim($('#idreg').val())
    var folio = $('#foliocorte').val()

    var presentacion = $('#presentacion').val()
    var costo = $('#costo').val()

    var contenidota = $('#contenidotact').val()

    var ncantidad = $('#cantidadn').val()
    var ncontenidon = $('#contenidonn').val()
    var ncontenidoa = $('#contenidoan').val()
    var ncontenidot = $('#contenidotn').val()

    dcosto = (( ncontenidot-contenidota ) / presentacion) * costo

    usuario = $('#nameuser').val()

    if (idreg.length == 0 || folio.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos de la cuenta',
        icon: 'warning',
      })
      return false
    } else {
      //Advertir y preguntar
      swal
        .fire({
          title: 'Corte',
          text:
            'Este movimiento cambia las Existencias totales del Producto por la cantidad establecida sin importar los movimientos anteriores ¿Desea Continuar?',

          showCancelButton: true,
          icon: 'warning',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',

          cancelButtonText: 'Cancelar',
        })
        .then(function (isConfirm) {
          if (isConfirm.value) {
            $.ajax({
              url: 'bd/bdcorteins.php',
              type: 'POST',
              dataType: 'json',
              data: {
                idreg: idreg,
                ncantidad: ncantidad,
                ncontenidon: ncontenidon,
                ncontenidoa: ncontenidoa,
                ncontenidot: ncontenidot,
                dcosto: dcosto,
              },
              success: function (data) {
                if (data == 1) {
                  Swal.fire({
                    title: 'Operación Exitosa',
                    text: 'Movimiento Guardado',
                    icon: 'success',
                  })
                  $('#modalMOV').modal('hide')
                  window.location.reload()
                } else {
                  Swal.fire({
                    title: 'No fue posible concluir la operacion',
                    text: 'Movimiento No Guardado',
                    icon: 'error',
                  })
                }
              },
            })
          } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
          }
        })
    }
  })

  $('#cantidadn').on('change keyup paste click', function () {
    calculo2()
  })
  $('#contenidonn').on('change keyup paste click', function () {
    calculo()
  })

  $('#contenidoan').on('change keyup paste click', function () {
    calculo()
  })

  $('#btnGuardar').click(function () {
    folio = $('#foliocorte').val()
    fecha = $('#fechan').val()
    obs = $('#obs').val()
    usuario = $('#nameuser').val()
    //revisar que todos los renglones esten llenos
    swal
      .fire({
        title: 'Corte',
        text: '¿Desea Guardar el corte de Insumos?',

        showCancelButton: true,
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',

        cancelButtonText: 'Cancelar',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: 'bd/revisardetalleins.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
              folio: folio,
            },
            success: function (data) {
              if (data == 1) {
                Swal.fire({
                  title: 'Operación Fallida',
                  text:
                    'No es posible guardar, debe  aplicar movimiento a todos los materiales, revise sus datos',
                  icon: 'error',
                })
              } else {
                // guardar y aplicar los movimientos
                $.ajax({
                  url: 'bd/guardarcorteins.php',
                  type: 'POST',
                  dataType: 'json',
                  async: false,
                  data: {
                    folio: folio,
                    fecha: fecha,
                    obs: obs,
                    usuario: usuario,
                  },
                  success: function (data) {
                    if (data == 0) {
                      Swal.fire({
                        title: 'Operación Fallida',
                        text: 'No fue posible aplicar todos los movimientos',
                        icon: 'error',
                      })
                    } else {
                      Swal.fire({
                        title: 'Operación Existosa',
                        icon: 'success',
                      })
                    }
                  },
                })
              }
            },
          })
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      })
  })

  function calculo() {
    let regex = /^\d*\.?\d+$/
    contenidonn = $('#contenidonn').val()
    contenidoan = $('#contenidoan').val()
    if (regex.test(contenidonn)) {
    } else {
      contenidonn = 0
    }
    if (regex.test(contenidoan)) {
    } else {
      contenidoan = 0
    }

    total = parseFloat(contenidonn) + parseFloat(contenidoan)

    $('#contenidotn').val(total)
  }

  function calculo2() {
    let regex = /^\d*\.?\d+$/
    cantidad = $('#cantidadn').val()
    presentacion = $('#presentacion').val()


    if (regex.test(cantidad)) {
    } else {
      cantidad = 0
    }
  


  
      contenido = parseFloat(cantidad) * parseFloat(presentacion)
    

    $('#contenidonn').val(contenido)
    calculo()
  }

  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }
})
