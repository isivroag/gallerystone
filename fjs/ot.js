$(document).ready(function () {
  const MAXIMO_TAMANIO_BYTES = 12000000
  var opcion

  tablaVis = $('#tabladet').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      { className: 'hide_column', targets: [0] },
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnMedida'><i class='fas fa-ruler'></i></button>\
          <button class='btn btn-sm btn-danger btnBorrardet'><i class='fas fa-trash-alt'></i></button>\
          </div></div>",
      },
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

  $(document).on('click', '#btnAddplano', function () {
    //window.location.href = "prospecto.php";
    $('#formMapa').trigger('reset')

    $('#modalMAPA').modal('show')
  })

  $(document).on("click", "#btnVer", function() {

    folio = $('#folioorden').val();
    var ancho = 1000;
    var alto = 800;
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    url = "formatos/pdforden.php?folio=" + folio;

    window.open(url, "Presupuesto", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

});

  $('#archivo').on('change', function () {
    var fileName = $(this).val().split('\\').pop()
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName)
  })

  $(document).on('click', '#btnGuardar', function () {
    orden = $('#folioorden').val()
    folio = orden
    foliofis = $('#foliof').val()
    //material = $('#material').val()
    //moldura = $('#moldura').val()
    //zoclo = $('#zoclo').val()
    superficie = $('#superficie').val()
    tipo = $('#tipo').val()
    obs = $('#obs').val()
    idot = $('#idot').val()
    usuario = $('#nameuser').val()
    opcion = 1
    $.ajax({
      url: 'bd/crudot.php',
      type: 'POST',
      dataType: 'json',
      async: false,
      data: {
        orden: orden,
        foliofis: foliofis,
       // material: material,
       // moldura: moldura,
       // zoclo: zoclo,
        superficie: superficie,
        tipo: tipo,
        obs: obs,
        idot: idot,
        opcion: opcion,
        usuario: usuario,
      },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            title: 'Registro Actualizado',
            text: 'La orden de Trabajo ha sido actualizada',
            icon: 'success',
          })
          estado = 'CORTE'
          porcentaje = 5

          $.ajax({
            url: 'bd/estadoorden.php',
            type: 'POST',
            dataType: 'json',
            data: {
              folio: folio,
              estado: estado,
              porcentaje: porcentaje,
            },
            success: function (res) {
              if (res == 1) {
                window.location.href = 'cntaorden.php'
              } else {
                Swal.fire({
                  title: 'Registro No actualizado',
                  text: 'La orden de Trabajo no ha sido actualizada',
                  icon: 'error',
                })
              }
            },
          })
        }
      },
    })
  })
  $(document).on('click', '#upload', function () {
    orden = $('#folioorden').val()
    var formData = new FormData()
    var files = $('#archivo')[0].files[0]

    if (files.size > MAXIMO_TAMANIO_BYTES) {
      const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000

      Swal.fire({
        title: 'El tamaño del archivo es muy grande',
        text: 'El archivo no puede exceder los ' + tamanioEnMb + 'MB',
        icon: 'warning',
      })
      // Limpiar
      $('#archivo').val()
    } else {
      formData.append('file', files)
      formData.append('orden', orden)
      $.ajax({
        url: 'bd/uploadot.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response != 0) {
            Swal.fire({
              title: 'Imagen Guardada',
              text: 'Se anexo el documento a la Orden',
              icon: 'success',
            })
            $('#modalMAPA').modal('hide')
            window.location.href = 'ot.php?folio=' + orden
            //respuesta exitosa
          } else {
            //swal incorrecto
            Swal.fire({
              title: 'Formato de Imagen Incorrecto',
              text: 'El archivo no es una imagen ',
              icon: 'warning',
            })
          }
        },
      })
    }

    return false
  })

  $(document).on('click', '#btnadetalle', function () {
    //window.location.href = "prospecto.php";
    $('#formCom').trigger('reset')

    $('#modalCom').modal('show')
  })

  $(document).on('click', '.btnMedida', function (event) {
    event.preventDefault()
    fila = $(this).closest('tr')

    id = fila.find('td:eq(0)').text()
    concepto = fila.find('td:eq(1)').text()
    medida = fila.find('td:eq(2)').text()
    $('#formmed').trigger('reset')
    $('#idreg').val(id)
    $('#conceptocom2').val(concepto)
    $('#medidacom').val(medida)
    $('#modalmed').modal('show')
  })

  $(document).on('click', '.btnBorrardet', function (event) {
    event.preventDefault()
    fila = $(this).closest('tr')

    id = fila.find('td:eq(0)').text()
    opcion = 3
    $.ajax({
      url: 'bd/otdetalle.php',
      type: 'POST',
      dataType: 'json',
      async: false,
      data: {
        id: id,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: 'Registro Actualizado',
            text: 'La orden de Trabajo ha sido actualizada',
            icon: 'success',
          })
          window.location.reload()
        }
      },
      error: function () {
        Swal.fire({
          title: 'Error de Operacion',
          text: 'La orden de Trabajo no ha sido actualizada',
          icon: 'error',
        })
      },
    })
  })

  $(document).on('click', '#btnGuardarcom', function () {
    orden = $('#folioorden').val()
    concepto = $('#conceptocom').val()
    cantidad = $('#cantcom').val()
    opcion = 1
    $.ajax({
      url: 'bd/otdetalle.php',
      type: 'POST',
      dataType: 'json',
      async: false,
      data: {
        orden: orden,
        concepto: concepto,
        cantidad: cantidad,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: 'Registro Actualizado',
            text: 'La orden de Trabajo ha sido actualizada',
            icon: 'success',
          })
          window.location.reload()
        }
      },
      error: function () {
        Swal.fire({
          title: 'Error de Operacion',
          text: 'La orden de Trabajo no ha sido actualizada',
          icon: 'error',
        })
      },
    })
  })


  $(document).on('click', '#btnGuardarmed', function () {
    id = $('#idreg').val()
  
    medida = $('#medidacom').val()
    opcion = 2
    $.ajax({
      url: 'bd/otdetalle.php',
      type: 'POST',
      dataType: 'json',
      async: false,
      data: {
        id: id,
        medida: medida,
      
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: 'Registro Actualizado',
            text: 'La orden de Trabajo ha sido actualizada',
            icon: 'success',
          })
          window.location.reload()
        }
      },
      error: function () {
        Swal.fire({
          title: 'Error de Operacion',
          text: 'La orden de Trabajo no ha sido actualizada',
          icon: 'error',
        })
      },
    })
  })
})
