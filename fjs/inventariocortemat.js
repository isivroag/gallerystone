$(document).ready(function () {
  var id, opcion
  opcion = 4

  var textcolumnas = permisos()

  document.getElementById('alto').onblur = function () {
    alto = this.value
    if (alto > 0.9) {
      $('#nom_mat').val('PLACA')
    } else {
      $('#nom_mat').val('MEDIA PLACA')
    }
  }

  function permisos() {
    var tipousuario = $('#tipousuario').val()
    var columnas = ''

    if (tipousuario == 5) {
      columnas =
        "<div class='text-center'>\
        <button class='btn btn-sm bg-gradient-green text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fa-solid fa-boxes-packing'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
       </div>"
    } else {
      columnas =
        "<div class='text-center'>\
        <button class='btn btn-sm bg-gradient-green text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fa-solid fa-boxes-packing'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
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
    dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
      {
        extend: 'excelHtml5',
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: 'Exportar a Excel',
        title: 'Inventario de Material',
        className: 'btn bg-success ',
        exportOptions: { columns: [0, 1, 3, 5, 6, 8, 9, 10, 11, 12, 13] },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Inventario de Material',
        className: 'btn bg-danger',
        exportOptions: { columns: [0, 1, 3, 5, 6, 8, 9, 10, 11, 12, 13] },
      },
    ],

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent: textcolumnas,
      },
      { className: 'hide_column', targets: [2] },
      { className: 'hide_column', targets: [7] },
      { className: 'hide_column', targets: [4] },
      { className: 'text-right', targets: [8] },
      { className: 'text-right', targets: [9] },
      { className: 'text-right', targets: [10] },
      { className: 'text-right', targets: [11] },
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
    $('.modal-header').css('background-color', '#28a745')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Nuevo Material')
    $('#modalCRUD').modal('show')
    id = null
    opcion = 1 //alta
  })

  tablaItem = $('#tablaItem').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelItem'><i class='fas fa-hand-pointer'></i></button></div></div>",
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

  $(document).on('click', '#bitem', function () {
    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')

    $('#modalItem').modal('show')
  })

  $(document).on('click', '.btnSelItem', function () {
    fila = $(this).closest('tr')

    iditem = fila.find('td:eq(0)').text()
    nomitem = fila.find('td:eq(3)').text()

    /*
     */

    $('#item').val(nomitem)
    $('#iditem').val(iditem)

    $('#modalItem').modal('hide')
  })

  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    clave = fila.find('td:eq(1)').text()
    iditem = fila.find('td:eq(2)').text()
    nom_item = fila.find('td:eq(3)').text()
    id_umedida = fila.find('td:eq(4)').text()

    nom_mat = fila.find('td:eq(6)').text() //window.location.href = "actprospecto.php?id=" + id;

    cantidad = fila.find('td:eq(7)').text()
    largo = fila.find('td:eq(8)').text()
    alto = fila.find('td:eq(9)').text()
    ancho = fila.find('td:eq(10)').text()
    metros = fila.find('td:eq(11)').text()

    ubicacion = fila.find('td:eq(12)').text()
    obs = fila.find('td:eq(13)').text()

    $('#item').val(nom_item)
    $('#clavemat').val(clave)
    $('#iditem').val(iditem)
    $('#umedida').val(id_umedida)
    $('#nom_mat').val(nom_mat)
    $('#largo').val(largo)
    $('#ancho').val(ancho)
    $('#alto').val(alto)
    $('#cantidad').val(cantidad)
    $('#ubicacion').val(ubicacion)
    $('#metros').val(metros)
    $('#obs').val(obs)

    opcion = 2 //editar

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Editar Material')
    $('#modalCRUD').modal('show')
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
        url: 'bd/crudmaterial.php',
        type: 'POST',
        dataType: 'json',
        data: { id: id, opcion: opcion },

        success: function (data) {
          tablaVis.row(fila.parents('tr')).remove().draw()
        },
      })
    }
  })

  //AGREGAR ITEM
  $('#formDatos').submit(function (e) {
    e.preventDefault()
    var id_item = $.trim($('#iditem').val())
    var clave_mat = $.trim($('#clavemat').val())
    var nom_mat = $.trim($('#nom_mat').val())
    var cantidad = $.trim($('#cantidad').val())
    var alto = $.trim($('#alto').val())
    var ancho = $.trim($('#ancho').val())
    var largo = $.trim($('#largo').val())
    var umedida = $.trim($('#umedida').val())
    var ubicacion = $.trim($('#ubicacion').val())
    var metros = $.trim($('#metros').val())
    var obs = $.trim($('#obs').val())

    if (
      nom_mat.length == 0 ||
      umedida.length == 0 ||
      id_item.length == 0 ||
      clave_mat.length == 0
    ) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Prospecto',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudmaterial.php',
        type: 'POST',
        dataType: 'json',
        data: {
          id_item: id_item,
          umedida: umedida,
          nom_mat: nom_mat,
          cantidad: cantidad,
          clave_mat: clave_mat,
          alto: alto,
          ancho: ancho,
          largo: largo,
          id: id,
          opcion: opcion,
          ubicacion: ubicacion,
          metros: metros,
          obs: obs,
        },
        success: function (data) {
          //tablaPersonas.ajax.reload(null, false);
          id = data[0].id_mat
          iditem = data[0].id_item
          clave = data[0].clave_mat
          item = data[0].nom_item
          umedida = data[0].id_umedida
          nom_umeddia = data[0].nom_umedida
          nom_mat = data[0].nom_mat
          largo = data[0].largo_mat
          ancho = data[0].ancho_mat
          alto = data[0].alto_mat
          cantidad = data[0].cant_mat
          m2_mat = data[0].m2_mat
          ubicacion = data[0].ubi_mat
          obs = data[0].obs_mat
          if (opcion == 1) {
            tablaVis.row
              .add([
                id,
                clave,
                iditem,
                item,
                umedida,
                nom_umeddia,
                nom_mat,
                cantidad,
                largo,
                alto,
                ancho,
                m2_mat,
                ubicacion,
                obs,
              ])
              .draw()
          } else {
            tablaVis
              .row(fila)
              .data([
                id,
                clave,
                iditem,
                item,
                umedida,
                nom_umeddia,
                nom_mat,
                cantidad,
                largo,
                alto,
                ancho,
                m2_mat,
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

  //MOVIMIENTOS

  $(document).on('click', '.btnMov', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    clave = fila.find('td:eq(1)').text()
    nombre = fila.find('td:eq(3)').text()
   
    largo = fila.find('td:eq(8)').text()
    alto = fila.find('td:eq(9)').text()
    ancho = fila.find('td:eq(10)').text()

    saldo = fila.find('td:eq(11)').text()
    nmaterial = fila.find('td:eq(6)').text()


    

    $('#id').val(id)
    $('#nombrep').val(nombre)

    $('#extact').val(saldo)
    $('#nmaterial').val(nmaterial)
    $('#largoact').val(largo)
    $('#altoact').val(alto)
    $('#anchoact').val(ancho)
    $('#claveact').val(clave)

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    
    $('#modalMOV').modal('show')
  })

  $('#formMov').submit(function (e) {
    e.preventDefault()
    var id = $.trim($('#id').val())
    fecha=$('#fechan').val()
    var descripcion = "Corte de Inventario al "+fecha
    var tipomov = "Corte"
    var saldo = $('#extact').val()
    var nuevo = $('#metrosn').val()
    montomov=parseFloat(saldo)-parseFloat(nuevo)
    
    var saldofin = nuevo
    
    var alto = $('#alton').val()
    var ancho = $('#anchon').val()
    var largo = $('#largon').val()
   
    usuario = $('#nameuser').val()

    if (id.length == 0 || tipomov.length == 0 || montomov.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos de la cuenta',
        icon: 'warning',
      })
      return false
    } else {
      switch (tipomov) {
   
        case 'Corte':
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
                  url: 'bd/inventariocortemat.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    id: id,
                    tipomov: tipomov,
                    saldo: saldo,
                    saldofin: saldofin,
                    montomov: montomov,
                    descripcion: descripcion,
                    alto: alto,
                    largo: largo,
                    ancho: ancho,
                    fecha: fecha,
                    usuario: usuario,
                  },
                  success: function (data) {
                    if (data == 4) {
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

          break
      }
    }
  })

  $(document).on('click', '.btnKardex', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    window.location = 'cntamovp.php?id=' + id
  })

  $('#largon').on('change keyup paste click', function () {
    calculo()
  })

  $('#alton').on('change keyup paste click', function () {
    calculo()
  })

  function calculo() {
    alto = $('#alton').val()
    largo = $('#largon').val()
    if (parseFloat(alto) > 0 && parseFloat(largo) > 0) {
      metros = parseFloat(alto) * parseFloat(largo)
    } else {
      metros = 0
    }

    $('#metrosn').val(metros)
  }
})
