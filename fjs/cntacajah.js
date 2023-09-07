$(document).ready(function () {
  var id, opcion
  opcion = 4

  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
          <button class='btn btn-sm bg-gradient-orange text-light btnMov'><i class='fas fa-exchange-alt'></i></button>\
          <button class='btn btn-sm bg-gradient-info text-light btnMovIns'><i class='fas fa-exchange-alt'></i></button>\
       </div>",
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

  //TABLA DESECHABLE
  tablah = $('#tablah').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelHerramienta'><i class='fas fa-hand-pointer'></i></button></div></div>",
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

  tablain = $('#tablain').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelInsumo'><i class='fas fa-hand-pointer'></i></button></div></div>",
      },{ className: 'text-center', targets: [3] },
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

  tabladc = $('#tabladc').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnBorrarh'><i class='fas fa-trash-alt'></i></button></div></div>",
      },
      { className: 'hide_column', targets: [0] },
      { className: 'hide_column', targets: [1] },
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

  tabladc2 = $('#tabladc2').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnBorrarins'><i class='fas fa-trash-alt'></i></button></div></div>",
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

  $('#btnNuevo').click(function () {
    $('#formDatos').trigger('reset')

    $('#modalCRUD').modal('show')
    id = null
    opcion = 1
  })

  var fila

  //botón EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    nombre = fila.find('td:eq(2)').text()
    clave = fila.find('td:eq(1)').text()

    $('#id').val(id)
    $('#nombre').val(nombre)
    $('#clave').val(clave)

    opcion = 2 //editar

    $('.modal-title').text('Editar Caja')
    $('#modalCRUD').modal('show')
  })

  $(document).on('click', '.btnMov', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    $('#idcaja').val(id)
    buscarherramienta(id)

    $('#modalMOV').modal('show')
  })

  $(document).on('click', '.btnMovIns', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    $('#idcajains').val(id)
    console.log(id)
    buscarinsumo(id)
    $('#modalMOVINS').modal('show')
  })

  function buscarherramienta(id) {
    tabladc.clear()
    tabladc.draw()
    opc = 1
    $.ajax({
      type: 'POST',
      url: 'bd/buscarherramienta.php',
      dataType: 'json',

      data: { id: id, opc: opc },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tabladc.row
            .add([
              res[i].id_reg,
              res[i].id_her,
              res[i].clave_her,
              res[i].nom_her,
            ])
            .draw()
        }
      },
    })
  }

  function buscarinsumo(id) {
    tabladc2.clear()
    tabladc2.draw()
    opc = 1
    $.ajax({
      type: 'POST',
      url: 'bd/buscarinsumo.php',
      dataType: 'json',

      data: { id: id, opc: opc },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tabladc2.row
            .add([
              res[i].id_reg,
              res[i].id_des,
              res[i].clave_des,
              res[i].nom_des,
              res[i].cantidad_des,
            ])
            .draw()
        }
      },
    })
  }

  $(document).on('click', '#btnAgregar', function () {
    fila = $(this).closest('tr')
    id = $('#idcaja').val()
    $('#idcajah').val(id)
    $('#modalBuscarh').modal('show')
  })

  $(document).on('click', '#btnAgregarins', function () {
    fila = $(this).closest('tr')
    id = $('#idcajains').val()
    $('#idcajains2').val(id)
    $('#modalBuscarin').modal('show')
  })

  $(document).on('click', '.btnSelHerramienta', function () {
    fila = $(this).closest('tr')
    id_her = fila.find('td:eq(0)').text()
    clave = fila.find('td:eq(1)').text()
    nombre = fila.find('td:eq(2)').text()
    id = $('#idcajah').val()
    opc = 2

    $.ajax({
      url: 'bd/buscarherramienta.php',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
        id_her: id_her,
        clave: clave,
        nombre: nombre,
        opc: opc,
      },
      success: function (data) {
        reg = data[0].id_reg
        id = data[0].id_her
        clave = data[0].clave_her
        nombre = data[0].nom_her

        tabladc.row.add([reg, id, clave, nombre]).draw()
        $('#modalBuscarh').modal('hide')
      },
    })
  })

  $(document).on('click', '.btnSelInsumo', function () {
    fila = $(this).closest('tr')
    id_des = fila.find('td:eq(0)').text()
    clave = fila.find('td:eq(1)').text()
    nombre = fila.find('td:eq(2)').text()

    id = $('#idcajains2').val()
    opc = 2

    $('#modalCRUDins').modal('show')
    $('#formInsumo').trigger('reset')

    $('#idcajains3').val(id)
    $('#idins').val(id_des)
    $('#claveins').val(clave)
    $('#nomins').val(nombre)
    $('#modalBuscarin').modal('hide')
    /*
    $.ajax({
      url: 'bd/buscarinsumo.php',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
        id_des: id_des,
        clave: clave,
        nombre: nombre,
        cantidad: cantidad,
        opc: opc
      },
      success: function (data) {
        
        reg = data[0].id_reg
        id = data[0].id_des
        clave = data[0].clave_des
        nombre = data[0].nom_des
        cantidad = data[0].cantidad_des

      
          tabladc2.row.add([reg,id, clave, nombre,cantidad,]).draw()
          $('#modalBuscarin').modal('hide')
      },
    })

*/
  })

  $(document).on('click', '#btnGuardarIns', function () {
    id = $('#idcajains3').val()
    id_des = $('#idins').val()
    clave = $('#claveins').val()
    nombre = $('#nomins').val()
    cantidad = $('#cantidadins').val()
   

    if (id_des.length == 0 || id.length == 0 || cantidad.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos',
        icon: 'warning',
      })
      return false
    } else {
   
    $.ajax({
      url: 'bd/buscarinsumo.php',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
        id_des: id_des,
        clave: clave,
        nombre: nombre,
        cantidad: cantidad,
        opc: opc
      },
      success: function (data) {
        
        reg = data[0].id_reg
        id = data[0].id_des
        clave = data[0].clave_des
        nombre = data[0].nom_des
        cantidad = data[0].cantidad_des

      
          tabladc2.row.add([reg,id, clave, nombre,cantidad,]).draw()
          $('#modalCRUDins').modal('hide')
      },
    })
  }
  })
  //botón BORRAR
  $(document).on('click', '.btnBorrarh', function () {
    fila = $(this)

    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opc = 3 //borrar

    //agregar codigo de sweatalert2
    var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')

    if (respuesta) {
      $.ajax({
        url: 'bd/buscarherramienta.php',
        type: 'POST',
        dataType: 'json',
        data: { id: id, opc: opc },

        success: function (data) {
          tabladc.row(fila.parents('tr')).remove().draw()
        },
      })
    }
  })

  $(document).on('click', '.btnBorrarins', function () {
    fila = $(this)

    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opc = 3 //borrar

    //agregar codigo de sweatalert2
    var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')

    if (respuesta) {
      $.ajax({
        url: 'bd/buscarinsumo.php',
        type: 'POST',
        dataType: 'json',
        data: { id: id, opc: opc },

        success: function (data) {
          tabladc2.row(fila.parents('tr')).remove().draw()
        },
      })
    }
  })

  $('#formDatos').submit(function (e) {
    e.preventDefault()
    var id = $.trim($('#id').val())
    var nombre = $.trim($('#nombre').val())
    var clave = $('#clave').val()

    if (nombre.length == 0 || clave.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos de la cuenta',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudcajah.php',
        type: 'POST',
        dataType: 'json',
        data: {
          nombre: nombre,
          id: id,
          clave: clave,
          opcion: opcion,
        },
        success: function (data) {
          //tablaPersonas.ajax.reload(null, false);
          id = data[0].id_cajah
          nombre = data[0].nom_cajah
          clave = data[0].clave_cajah

          if (opcion == 1) {
            tablaVis.row.add([id, clave, nombre]).draw()
          } else {
            tablaVis.row(fila).data([id, clave, nombre]).draw()
          }
        },
      })
      $('#modalCRUD').modal('hide')
    }
  })
})
