$(document).ready(function () {
  var id, opcion, fpago

  tablaVis = $('#tablaV').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
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

  tablaDet = $('#tablaDet').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
         defaultContent: "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>",
      },
      { className: 'hide_column', targets: [1] },
      { className: 'hide_column', targets: [2] },
      { className: 'hide_column', targets: [10] },
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

  $(document).on('click', '#btnMaterial', function () {
    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')

    $('#modalMat').modal('show')
  })

  $(document).on('click', '.btnSelMaterial', function () {
    fila = $(this).closest('tr')
    iditem = fila.find('td:eq(0)').text()
    idMaterial = fila.find('td:eq(1)').text()
    ClaveMaterial = fila.find('td:eq(2)').text()
    NomMaterial = fila.find('td:eq(3)').text()

    formato = fila.find('td:eq(4)').text()
    idumedida = fila.find('td:eq(9)').text()
    nomumedida = fila.find('td:eq(10)').text()

    m2 = fila.find('td:eq(8)').text()
    alto = fila.find('td:eq(7)').text()
    ancho = fila.find('td:eq(6)').text()
    largo = fila.find('td:eq(5)').text()
    ubicacion = fila.find('td:eq(11)').text()
    cantidaddis = fila.find('td:eq(12)').text()

    /*
     */
    $('#iditem').val(iditem)
    $('#clavemat').val(idMaterial)
    $('#material').val(NomMaterial)
    $('#clave').val(ClaveMaterial)
    $('#id_umedida').val(idumedida)
    $('#nom_umedida').val(nomumedida)
    $('#m2').val(m2)
    $('#alto').val(alto)
    $('#ancho').val(ancho)
    $('#largo').val(largo)
    $('#ubicacionm').val(ubicacion)
    $('#formato').val(formato)
    $('#cantidaddis').val(cantidaddis)
    $('#cantidad').prop('disabled', false)

    $('#modalMat').modal('hide')
  })

  $(document).on('click', '#btlimpiar', function () {
   limpiar();
  })

  $(document).on('click', '#btnagregar', function () {
    folio = $('#folioorden').val();
   
    idmat = $('#clavemat').val();
  
    cantidad = $('#cantidad').val();
    cantidaddis = $('#cantidaddis').val();
    opcion=1;

    if (parseFloat(cantidad) > parseFloat(cantidaddis)) {
      nomensaje();
      return 0;
    }

    
    console.log(idmat);
 
    if (
      folio.length != 0 &&
      idmat.length != 0 &&
      cantidad.length != 0
    ) {
      $.ajax({
        type: 'POST',
        url: 'bd/detalleorden.php',
        dataType: 'json',
        //async: false,
        data: {
          folio: folio,
          idmat: idmat,
          cantidad: cantidad,
          opcion: opcion,
        },
        success: function (data) {
          console.log(data);
          id_reg = data[0].id_reg;
          id_mat = data[0].id_mat;
          id_item = data[0].id_item;
          clave_item = data[0].clave_item;
          nom_item = data[0].nom_item;
          formato = data[0].formato;
          largo_mat = data[0].largo_mat;
          ancho_mat = data[0].ancho_mat;
          alto_mat = data[0].alto_mat;
          id_umedida = data[0].id_umedida;
          nom_umedida = data[0].nom_umedida;
          m2_mat = data[0].m2_mat;
          ubi_mat = data[0].ubi_mat;
          cant_mat = data[0].cant_mat;
          

          tablaDet.row
            .add([
              id_reg,
              id_item,
              id_mat,
              clave_item,
              nom_item,
              formato,
              largo_mat,
              ancho_mat,
              alto_mat,
              m2_mat,
              id_umedida,
              nom_umedida,
              ubi_mat,
              cant_mat,
            ])
            .draw();
        limpiar();

        },
      })
    } else {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Item',
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

  $(document).on("click", ".btnBorrar", function() {
   

    fila = $(this).closest("tr");

    id = fila.find("td:eq(0)").text();
    console.log(id);
    opcion = 2;

    $.ajax({
        type: "POST",
        url: "bd/detalleorden.php",
        dataType: "json",
        data: { id: id, opcion: opcion },
        success: function(data) {
          console.log(data);
          if (data == 1) {
            
            tablaDet.row(fila.parents("tr")).remove().draw();
        }
        else{
          mensajeerror();
        }

            
        },
    });
});

  function limpiar(){
    $('#clavemat').val('')
    $('#material').val('')
    $('#clave').val('')
    $('#formato').val('')
    $('#id_umedida').val('')
    $('#m2').val('')
    $('#largo').val('')
    $('#ancho').val('')
    $('#alto').val('')
    $('#cantidad').val('')
    $('#cantidaddis').val('')
    $('#ubicacionm').val('')
    $('#nom_umedida').val('')
    $('#cantidad').prop('disabled', true)
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
