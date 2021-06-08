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
          "<div class='text-center'><button class='btn btn-sm btn-primary btnDetalleFrente'><i class='fas fa-hard-hat'></i></button>\
          <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button>\
          </div>",
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

  $(document).on('click', '#btnagregar', function () {
    orden = $('#folioorden').val()
    nombre = $('#nombrefrente').val()
    area = $('#area').val()
    areacol = $('#areacol').val()
    supervisor = $('#supervisor').val()
    colocador = $('#colocador').val()

    opcion = 1

    if (
      orden.length != 0 &&
      nombre.length != 0 &&
      area.length != 0 &&
      areacol.length != 0 &&
      supervisor.length != 0 &&
      colocador.length != 0
    ) {
      $.ajax({
        type: 'POST',
        url: 'bd/frentesobra.php',
        dataType: 'json',
        //async: false,
        data: {
          orden: orden,
          nombre: nombre,
          area: area,
          areacol: areacol,
          supervisor: supervisor,
          colocador: colocador,
          opcion: opcion,
        },
        success: function (data) {
          console.log(data)
          id_frente = data[0].id_frente
          nombre = data[0].nom_frente
          area = data[0].area_frente
          areacol = data[0].areacol_frente
          supervisor = data[0].supervisor_frente
          colocador = data[0].colocador_frente

          tablaDet.row
            .add([id_frente, nombre, area, supervisor, colocador, areacol])
            .draw()
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
   
    event.preventDefault();

    fila = $(this)
    id =  parseInt($(this).closest("tr").find("td:eq(0)").text());
    opcion=2;

    swal
    .fire({
        title: "Borrar",
        text: "¿Realmente desea borrar este elemento?",

        showCancelButton: true,
        icon: "warning",
        focusConfirm: true,
        confirmButtonText: "Aceptar",

        cancelButtonText: "Cancelar",
    })
    .then(function(isConfirm) {
        if (isConfirm.value) {
            $.ajax({
                url: "bd/complementoorden.php",
                type: "POST",
                dataType: "json",
                async: false,
                data: { id: id, opcion: opcion },
                success: function(data) {
                
                    if (data == 1) {
                      
                        tablaD.row(fila.parents("tr")).remove().draw();
                        
                    }
                },
            });
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {}
    });
  })

  

  $(document).on('click', '.btnDetalleFrente', function (event)  {
    event.preventDefault();

    fila = $(this);
    
    id =  parseInt($(this).closest("tr").find("td:eq(0)").text());
    window.location.href = "detallefrente.php?id="+ id;
    
   

})
  $(document).on('click', '#btnAddcom', function ()  {
    //window.location.href = "prospecto.php";
    $('#formCom').trigger('reset')
   
    $('#modalCom').modal('show')

})

  $(document).on('click', '#btnGuardarcom', function () {
    orden = $('#folioorden').val()
    cantidad = $('#cantcom').val()
    umedida = $('#umedida').val()
    concepto = $('#concepto').val()
    opcion=1;

    if (orden.length != 0 && cantidad.length != 0 && umedida.length != 0 && concepto.length!=0) {
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
          umedida= data[0].nom_umedida
          

          tablaD.row
            .add([
              id_reg,
              concepto,
              cantidad,
              umedida,
            ])
            .draw()
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



  $(document).on('click', '#btnagregar', function () {
    folio = $('#folioorden').val()

    idmat = $('#clavemat').val()

    cantidad = $('#cantidad').val()
    cantidaddis = $('#cantidaddis').val()
    opcion = 1

    if (parseFloat(cantidad) > parseFloat(cantidaddis)) {
      nomensaje()
      return 0
    }

    console.log(idmat)

    if (folio.length != 0 && idmat.length != 0 && cantidad.length != 0) {
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
          console.log(data)
          id_reg = data[0].id_reg
          id_mat = data[0].id_mat
          id_item = data[0].id_item
          clave_item = data[0].clave_item
          nom_item = data[0].nom_item
          formato = data[0].formato
          largo_mat = data[0].largo_mat
          ancho_mat = data[0].ancho_mat
          alto_mat = data[0].alto_mat
          id_umedida = data[0].id_umedida
          nom_umedida = data[0].nom_umedida
          m2_mat = data[0].m2_mat
          ubi_mat = data[0].ubi_mat
          cant_mat = data[0].cant_mat

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
            .draw()
          limpiar()
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


  function limpiar() {
    $('#nombre').val('')
    $('#area').val('')
    $('#areacol').val('')
    $('#supervisor').val('')
    $('#colocador').val('')
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
