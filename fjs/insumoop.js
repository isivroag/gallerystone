$(document).ready(function () {
  var id, opcion
  opcion = 4


  var textcolumnas = permisos()

  function permisos() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''
   
    if (tipousuario == 5) {
      columnas = "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Abrir Insumo'><i class='fas fa-box-open'></i></button>\
      <button class='btn btn-sm bg-gradient-info text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Cerrado'><i class='fas fa-box'></i></button>\
      <button class='btn btn-sm bg-gradient-orange text-light btnMova' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Abierto'><i class='fas fa-fill-drip'></i></button>\
      <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
      </div>"
    } else {
      columnas = "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Abrir Insumo'><i class='fas fa-box-open'></i></button>\
      <button class='btn btn-sm bg-gradient-info text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Cerrado'><i class='fas fa-box'></i></button>\
      <button class='btn btn-sm bg-gradient-orange text-light btnMova' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Abierto'><i class='fas fa-fill-drip'></i></button>\
      <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
       <button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-trash-alt'></i></button></div>"
    }
    return columnas
  }

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
        title: 'Inventario de Insumos',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Inventario de Insumos',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10] },
      },
    ],

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas,
      },
      { className: 'hide_column', targets: [3] },
      { className: 'text-right', targets: [4] },
      { className: 'text-right', targets: [5] },
      { className: 'text-right', targets: [6] },
      { className: 'text-right', targets: [7] },
      { className: 'text-right', targets: [8] },
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

  $('#btnNuevo').click(function () {
    //window.location.href = "prospecto.php";
    $('#formDatos').trigger('reset')

    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Nuevo Insumo')
    $('#modalCRUD').modal('show')
    id = null
    opcion = 1 //alta
  })

  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    $('#formAbrir').trigger('reset')
    id = parseInt(fila.find('td:eq(0)').text())
    id_umedida = fila.find('td:eq(3)').text()
    nom_cons = fila.find('td:eq(1)').text() //window.location.href = "actprospecto.php?id=" + id;
    cantidad = fila.find('td:eq(4)').text()
    presentacion = fila.find('td:eq(5)').text()
    contenidon = fila.find('td:eq(6)').text()
    contenidoa = fila.find('td:eq(7)').text()
    contenidot = fila.find('td:eq(8)').text()
    ubicacion = fila.find('td:eq(9)').text()
    obs = fila.find('td:eq(10)').text()
    $('#ida').val(id)
    $('#umedidaa').val(id_umedida)
    $('#nom_consa').val(nom_cons)
    $('#cantidada').val(cantidad)
    $('#presentaciona').val(presentacion)
    $('#contenidona').val(contenidon)
    $('#contenidoaa').val(contenidoa)
    $('#contenidota').val(contenidot)

    opcion = 2 //editar

    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Abrir Insumo')
    $('#modalAbrir').modal('show')
  })

  //botón BORRAR
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this)

    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opcion = 3 //borrar

    //agregar codigo de sweatalert2
    var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')

    if (respuesta) {
      $.ajax({
        url: 'bd/crudinsumoop.php',
        type: 'POST',
        dataType: 'json',
        data: { id: id, opcion: opcion },

        success: function (data) {
          tablaVis.row(fila.parents('tr')).remove().draw()
        },
      })
    }
  })

  $('#formDatos').submit(function (e) {
    e.preventDefault()

    var nom_cons = $.trim($('#nom_cons').val())
    var cantidad = $.trim($('#cantidad').val())

    var umedida = $.trim($('#umedida').val())
    var ubicacion = $.trim($('#ubicacion').val())

    var obs = $.trim($('#obs').val())

    var contenidoa = $('#contenidoa').val()
    var contenidon = $('#contenidon').val()
    var contenidot = $('#contenidot').val()
    var presentacion = $('#presentacion').val()

    console.log(presentacion)
    console.log(contenidon)
    console.log(contenidoa)
    console.log(contenidot)

    if (
      nom_cons.length == 0 ||
      umedida.length == 0 ||
      presentacion.length == 0 ||
      contenidoa.length == 0 ||
      cantidad.length == 0

    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos marcados con *',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudinsumoop.php',
        type: 'POST',
        dataType: 'json',
        data: {
          umedida: umedida,
          nom_cons: nom_cons,
          cantidad: cantidad,
          id: id,
          opcion: opcion,
          ubicacion: ubicacion,
          obs: obs,
          presentacion: presentacion,
          contenidon: contenidon,
          contenidoa: contenidoa,
          contenidot: contenidot,
        },
        success: function (data) {
          id = data[0].id_cons
          umedida = data[0].id_umedida
          nom_umedida = data[0].nom_umedida
          nom_cons = data[0].nom_cons
          cantidad = data[0].cant_cons
          ubicacion = data[0].ubi_cons
          obs = data[0].obs_cons

          presentacion = data[0].presentacion
          contenidon = data[0].contenidon
          contenidoa = data[0].contenidoa
          contenidot = data[0].contenidot
          if (opcion == 1) {
            tablaVis.row
              .add([
                id,
                nom_cons,
                nom_umedida,
                umedida,
                cantidad,
                presentacion,
                contenidon,
                contenidoa,
                contenidot,
                ubicacion,
                obs,
              ])
              .draw()
          } else {
            tablaVis
              .row(fila)
              .data([
                id,
                nom_cons,
                nom_umedida,
                umedida,
                cantidad,
                presentacion,
                contenidon,
                contenidoa,
                contenidot,
                ubicacion,
                obs,
              ])
              .draw()
          }
        },
      })
      $('#modalCRUD').modal('hide')
    }
  })

  //MOVIMIENTOS DE INVENTARIO CERRADO

  $(document).on('click', '.btnMov', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    nombre = fila.find('td:eq(1)').text()
    saldo = fila.find('td:eq(4)').text()

    presentacion = fila.find('td:eq(5)').text()
    contenidoc = fila.find('td:eq(6)').text()

    $('#id').val(id)
    $('#nmaterial').val(nombre)

    $('#extact').val(saldo)
    $('#presentacionmov').val(presentacion)
    $('#contenidomov').val(contenidoc)

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Movimiento de Inventario')
    $('#modalMOV').modal('show')
  })


  $(document).on('click', '#btnGuardarM', function () {
  
    
    var id = $.trim($('#id').val())
    var descripcion = $('#descripcion').val()
    var tipomov = $.trim($('#tipomov').val())
    var saldo = $('#extact').val()
    var montomov = $('#montomov').val()
    var saldofin = 0
    var usuario = $('#nameuser').val()

    if (id.length == 0 || tipomov.length == 0 || montomov.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos de la cuenta',
        icon: 'warning',
      })
      return false
    } else {
      switch (tipomov) {
        case 'Entrada':
          saldofin = parseFloat(saldo) + parseFloat(montomov)
          $.ajax({
            url: 'bd/crudmovimientoinvin.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion,
              usuario: usuario
            },
            success: function (data) {
              if (data == 1) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
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

          break
        case 'Salida':
          saldofin = parseFloat(saldo) - parseFloat(montomov)
          $.ajax({
            url: 'bd/crudmovimientoinvin.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion,
              usuario: usuario
            },
            success: function (data) {
              if (data == 1) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
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
          break
        case 'Inventario Inicial':
          //Advertir y preguntar
          swal
            .fire({
              title: 'Inventario Inicial',
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
                saldofin = montomov

                $.ajax({
                  url: 'bd/crudmovimientoinvin.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    id: id,
                    tipomov: tipomov,
                    saldo: saldo,
                    saldofin: saldofin,
                    montomov: montomov,
                    descripcion: descripcion,
                    usuario: usuario
                  },
                  success: function (data) {
                    if (data == 1) {
                      Swal.fire({
                        title: 'Operación Exitosa',
                        text: 'Movimiento Guardado',
                        icon: 'success',
                      })
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

          break
      }
    }
  })

  //MOVIMIENTOS DE INVENTARIO ABIERTO
  $(document).on('click', '.btnMova', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    nombre = fila.find('td:eq(1)').text()
    saldo = fila.find('td:eq(7)').text()

    presentacion = fila.find('td:eq(5)').text()
    contenidoab = fila.find('td:eq(7)').text()

    $('#idma').val(id)
    $('#nmaterialab').val(nombre)

    $('#extactab').val(saldo)
    $('#presentacionmovab').val(presentacion)
    $('#contenidomovab').val(contenidoab)

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Movimiento de Inventario')
    $('#modalMOVAB').modal('show')
  })


  $(document).on('click', '#btnGuardarMab', function () {
  
    
    var id = $.trim($('#idma').val())
    var descripcion = $('#descripcionab').val()
    var tipomov = $.trim($('#tipomovab').val())
    var saldo = $('#extactab').val()
    var montomov = $('#montomovab').val()
    var saldofin = 0
    var usuario = $('#nameuser').val()

 

    if (id.length == 0 || tipomov.length == 0 || montomov.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos de la cuenta',
        icon: 'warning',
      })
      return false
    } else {
      switch (tipomov) {
        case 'Entrada':
          saldofin = parseFloat(saldo) + parseFloat(montomov)
          $.ajax({
            url: 'bd/crudmovconsumible.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion,
              usuario: usuario
            },
            success: function (data) {
              if (data == 1) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
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

          break
        case 'Salida':
          saldofin = parseFloat(saldo) - parseFloat(montomov)
          $.ajax({
            url: 'bd/crudmovconsumible.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion,
              usuario: usuario
            },
            success: function (data) {
              if (data == 1) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
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
          break
        case 'Inventario Inicial':
          //Advertir y preguntar
          swal
            .fire({
              title: 'Inventario Inicial',
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
                saldofin = montomov

                $.ajax({
                  url: 'bd/crudmovconsumible.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    id: id,
                    tipomov: tipomov,
                    saldo: saldo,
                    saldofin: saldofin,
                    montomov: montomov,
                    descripcion: descripcion,
                    usuario: usuario
                  },
                  success: function (data) {
                    if (data == 1) {
                      Swal.fire({
                        title: 'Operación Exitosa',
                        text: 'Movimiento Guardado',
                        icon: 'success',
                      })
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

          break
      }
    }
  })


  $('#formAbrir').submit(function (e) {
    e.preventDefault()
    var id = $.trim($('#ida').val())
    var descripcion = 'APERTURA DE INSUMO'
    var tipomov = 'Apertura'
    var saldo = $('#cantidada').val()
    var montomov = $('#contenidoabr').val()
    var saldofin = 0
    var usuario = $('#nameuser').val()

    $.ajax({
      url: 'bd/abrirpaqueten.php',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
        tipomov: tipomov,
        saldo: saldo,
        montomov: montomov,
        descripcion: descripcion,
        usuario: usuario,
      },
      success: function (data) {
        if (data == 3) {
          Swal.fire({
            title: 'Operación Exitosa',
            text: 'Movimiento Guardado',
            icon: 'success',
          })
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

  $(document).on('click', '.btnKardex', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    window.location = 'cntamovconsumible.php?id=' + id
  })

  $('#presentacion').on('change keyup paste click', function () {
    calculo()
  })

  $('#cantidad').on('change keyup paste click', function () {
    calculo()
  })
  $('#contenidoa').on('change keyup paste click', function () {
    calculo()
  })

  $('#contenidoa').on('change keyup paste click', function () {
    valor = $('#contenidoa').val()
    pres = $('#presentacion').val()
    if (parseFloat(valor) > parseFloat(pres)) {
      Swal.fire({
        title: 'Valor no permitido',
        text:
          'El contenido abierto no puede ser mayor al de la presentación cerrada',
        icon: 'warning',
      })
      valor = $('#contenidoa').val(pres)
    }
  })

  $('#contenidoabr').on('change keyup paste click', function () {
    valor = $('#contenidoabr').val()
    pres = $('#cantidada').val()
    if (parseFloat(valor) > parseFloat(pres)) {
      Swal.fire({
        title: 'Valor no permitido',
        text: 'No es posible abrir una cantidad mayor a la existente',
        icon: 'warning',
      })
      valor = $('#contenidoabr').val(pres)
    } else {
      presentacion = $('#presentaciona').val()
      actual = $('#contenidoaa').val()
      conversion = parseFloat(presentacion) * parseFloat(valor)

      $('#contenidotp').val(parseFloat(actual) + parseFloat(conversion))
    }
  })

  function calculo() {
    presentacion = $('#presentacion').val()
    console.log(presentacion)

    cantidad = $('#cantidad').val()
    console.log(cantidad)

    contenidoa = $('#contenidoa').val()
    console.log(contenidoa)

    contenidon = parseFloat(presentacion) * parseFloat(cantidad)
    console.log(contenidon)

    contenidot = parseFloat(contenidon) + parseFloat(contenidoa)
    console.log(contenidot)

    $('#contenidon').val(contenidon)
    $('#contenidot').val(contenidot)
  }

  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }
})

function filterFloat(evt, input) {
  // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
  var key = window.Event ? evt.which : evt.keyCode
  var chark = String.fromCharCode(key)
  var tempValue = input.value + chark
  var isNumber = key >= 48 && key <= 57
  var isSpecial = key == 8 || key == 13 || key == 0 || key == 46
  if (isNumber || isSpecial) {
    return filter(tempValue)
  }

  return false
}
function filter(__val__) {
  var preg = /^([0-9]+\.?[0-9]{0,2})$/
  return preg.test(__val__) === true
}
