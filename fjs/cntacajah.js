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

  tabladc=$('#tabladc').DataTable({
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

  $('#btnNuevo').click(function () {
    //window.location.href = "prospecto.php";
    $('#formDatos').trigger('reset')

    $('#modalCRUD').modal('show')
    id = null
    opcion = 1 //alta
  })

  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    //window.location.href = "actprospecto.php?id=" + id;
    nombre = fila.find('td:eq(2)').text()
    clave = fila.find('td:eq(1)').text()

    $('#id').val(id)
    $('#nombre').val(nombre)
    $('#clave').val(clave)

    opcion = 2 //editar

    $('.modal-title').text('Editar Caja')
    $('#modalCRUD').modal('show')
  })
  //boton movimiento bancario
  $(document).on('click', '.btnMov', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

  

    $('#idcaja').val(id)
    buscarherramienta(id)
 

    
   
    $('#modalMOV').modal('show')
  })





  function buscarherramienta(id) {
    tabladc.clear()
    tabladc.draw()
   opc=1
    $.ajax({
      type: 'POST',
      url: 'bd/buscarherramienta.php',
      dataType: 'json',

      data: {id:id, opc: opc},

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


  $(document).on('click', '#btnAgregar', function () {
    fila = $(this).closest('tr')
    id = $('#idcaja').val()
    $('#idcajah').val(id)
    $('#modalBuscarh').modal('show')
  })

  
  $(document).on('click', '.btnSelHerramienta', function () {
    fila = $(this).closest('tr')
    id_her = fila.find('td:eq(0)').text()
    clave = fila.find('td:eq(1)').text()
    nombre = fila.find('td:eq(2)').text()
    id = $('#idcajah').val()
    opc=2
  
    $.ajax({
      url: 'bd/buscarherramienta.php',
      type: 'POST',
      dataType: 'json',
      data: {
        id: id,
        id_her: id_her,
        clave: clave,
        nombre: nombre,
        opc: opc
      },
      success: function (data) {
        
        reg = data[0].id_reg
        id = data[0].id_her
        clave = data[0].clave_her
        nombre = data[0].nom_her

      
          tabladc.row.add([reg,id, clave, nombre,]).draw()
          $('#modalBuscarh').modal('hide')
      },
    })
 
   
   
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
