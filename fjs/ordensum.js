$(document).ready(function () {
    jQuery.ajaxSetup({
      beforeSend: function () {
        $('.div_carga').show()
      },
      complete: function () {
        $('.div_carga').hide()
      },
      success: function () {},
    })
  
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
  
    tablatarin = $('#tablatarin').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        { className: 'text-center', targets: [0] },
        { className: 'text-right', targets: [2] },
        { className: 'text-right', targets: [5] },
        { className: 'hide_column', targets: [3] },
        { className: 'text-center', targets: [4] },
        { className: 'text-right', targets: [6] },
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-primary btnElegir'><i class='fa-solid fa-check'></i></button>\
            <button class='btn btn-sm bg-green btndirecto'><i class='fa-solid fa-check-double'></i></button>\
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
  
    tablatardes = $('#tablatardes').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        { className: 'text-center', targets: [0] },
        { className: 'text-right', targets: [2] },
        { className: 'text-right', targets: [3] },
        { className: 'text-center', targets: [4] },
  
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm bg-primary btnElegirdes'><i class='fa-solid fa-check'></i></button>\
            <button class='btn btn-sm bg-green btndirectodes'><i class='fa-solid fa-check-double'></i></button>\
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
    //TABLA DETALLED DE MATERIAL
    tablaDetp = $('#tablaDetp').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>",
        },
        // { className: 'hide_column', targets: [1] },
        //{ className: 'hide_column', targets: [2] },
        { className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [1] },
        { className: 'hide_column', targets: [9] },
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
  
    //TABLA DETALLE DE INSUMOS
    tablaDetIn = $('#tablaDetIn').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrarIn'><i class='fas fa-trash-alt'></i></button></div>",
        },
        { className: 'hide_column', targets: [1] },
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
  
    //TABLA DETALLE DE desechables
    tablaDetIndes = $('#tablaDetIndes').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrarDes'><i class='fas fa-trash-alt'></i></button></div>",
        },
        { className: 'hide_column', targets: [1] },
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
  
    //TABLA MATERIAL
    tablaMat = $('#tablaMat').DataTable({
      ordering: false,
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
  

     //TABLA MATERIAL PIEZA
     tablaMat = $('#tablaMatp').DataTable({
        ordering: false,
        columnDefs: [
          {
            targets: -1,
            data: null,
            defaultContent:
              "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelMaterialp'><i class='fas fa-hand-pointer'></i></button></div></div>",
          },
    
          { className: 'hide_column', targets: [0] },
          { className: 'hide_column', targets: [6] },
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
    //TABLA INSUMO
    tablaIns = $('#tablaIns').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelInsumo'><i class='fas fa-hand-pointer'></i></button></div></div>",
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
    tablaDes = $('#tablaDes').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelDesechable'><i class='fas fa-hand-pointer'></i></button></div></div>",
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
    //BOTON BUSCAR MATERIAL

   
  
 

 
  
 
  
  



    $(document).on('click', '#btnMaterialp', function () {
        $('.modal-header').css('background-color', '#007bff')
        $('.modal-header').css('color', 'white')
    
        $('#modalMatp').modal('show')
      })
 


    $(document).on('click', '.btnSelMaterialp', function () {
        fila = $(this).closest('tr')
        iditem = fila.find('td:eq(0)').text()
        idMaterial = fila.find('td:eq(1)').text()
        ClaveMaterial = fila.find('td:eq(2)').text()
        NomMaterial = fila.find('td:eq(3)').text()
    
        formato = fila.find('td:eq(4)').text()
        idumedida = fila.find('td:eq(6)').text()
        nomumedida = fila.find('td:eq(7)').text()
    
        m2 = fila.find('td:eq(5)').text()
       
        
        
        cantidaddis = fila.find('td:eq(9)').text()
        console.log(cantidaddis)
    
        /*
         */
        $('#iditemp').val(iditem)
        $('#clavematp').val(idMaterial)
        $('#materialp').val(NomMaterial)
        $('#clavep').val(ClaveMaterial)
        $('#id_umedidap').val(idumedida)
        $('#nom_umedidap').val(nomumedida)
        $('#m2p').val(m2)
        
        $('#ubicacionmp').val(ubicacion)
        $('#formatop').val(formato)
        $('#cantidaddisp').val(cantidaddis)
        $('#cantidadp').prop('disabled', false)
        $('#fechap').prop('disabled', false)
        $('#entregado').prop('disabled', false)
        $('#recibido').prop('disabled', false)
        $('#modalMatp').modal('hide')
      })

  
 
  
    //BOTON LIMPIAR MATERIAL
    $(document).on('click', '#btlimpiar', function () {
      limpiar()
    })
  
    //BOTON LIMPIAR INSUMO
    $(document).on('click', '#btlimpiari', function () {
      limpiarin()
    })
    $(document).on('click', '#btlimpiarides', function () {
      limpiardes()
    })
 
  

  
    // AGREGAR MATERIAL
    $(document).on('click', '#btnagregarp', function () {
      folio = $('#folioorden').val()
  
      idmat = $('#clavematp').val()
  
      cantidad = $('#cantidadp').val()
  
      //cambios agregar alto ancho y largo al detalle de orden
      fecha = $('#fechap').val()
      entregado = $('#entregado').val()
      recibido = $('#recibido').val()
  
      cantidaddis = $('#cantidaddisp').val()
      usuario = $('#nameuser').val()
      opcion = 1
  
      if (parseFloat(cantidad) > parseFloat(cantidaddis)) {
        nomensaje()
        return 0
      }
  
    
  
      if (folio.length != 0 && idmat.length != 0 && cantidad.length != 0 && fecha.length != 0 && entregado.length != 0 && recibido.length != 0) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleordensum.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            idmat: idmat,
            cantidad: cantidad,
            fecha: fecha,
            entregado: entregado,
            recibido: recibido,
            opcion: opcion,
            usuario: usuario,
          },
          success: function (data) {
            id_reg = data[0].id_reg
            id_mat = data[0].id_mat
            id_item = data[0].id_item
            clave_item = data[0].clave_item
            nom_item = data[0].nom_item
            formato = data[0].formato
            entregado = data[0].entregado
            fecha = data[0].fecha
            recibido = data[0].recibido
            id_umedida = data[0].id_umedida
            nom_umedida = data[0].nom_umedida
            
            ubi_mat = data[0].ubi_mat
            cant_mat = data[0].cant_mat
  
            tablaDetp.row
              .add([
                id_reg,
                id_item,
                id_mat,
                clave_item,
                nom_item,
                formato,
                fecha,
                entregado,
                recibido,
                id_umedida,
                nom_umedida,
                cant_mat,
              ])
              .draw()
            limpiar()
            //redimensionar(id_mat, 2)
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
  
    // BORRAR MATERIAL
    $(document).on('click', '.btnBorrar', function (e) {
      e.preventDefault()
  
      fila = $(this).closest('tr')
  
      id = fila.find('td:eq(0)').text()
      mat = fila.find('td:eq(2)').text()
      usuario = $('#nameuser').val()
      console.log(id)
      opcion = 2
  
      $.ajax({
        type: 'POST',
        url: 'bd/detalleordensum.php',
        dataType: 'json',
        data: { id: id, opcion: opcion, usuario: usuario },
        success: function (data) {
          console.log(data)
          if (data == 1) {
            tablaDetp.row(fila).remove().draw()
            
          } else {
            mensajeerror()
          }
        },
      })
    })


  
  
  
    function limpiar() {
      $('#clavematp').val('')
      $('#materialp').val('')
      $('#clavep').val('')
      $('#formatop').val('')
      $('#id_umedidap').val('')
      $('#recibido').val('')
      $('#entregado').val('')
      $('#fechap').val('')
      $('#cantidadp').val('')
      $('#cantidaddisp').val('')
    
      $('#nom_umedidap').val('')
      $('#cantidadp').prop('disabled', true)
      $('#entregado').prop('disabled', true)
      $('#recibido').prop('disabled', true)
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
    return preg.te
    st(__val__) === true
  }
  
  function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
  }
  