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
    tablaDet = $('#tablaDet').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        
         { className: 'hide_column', targets: [1] },
        //{ className: 'hide_column', targets: [2] },
        { className: 'hide_column', targets: [6] },
        { className: 'hide_column', targets: [7] },
        { className: 'hide_column', targets: [8] },
        { className: 'hide_column', targets: [9] },
        { className: 'hide_column', targets: [10] },
        //{ className: 'hide_column', targets: [12] },
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
       
       // { className: 'hide_column', targets: [1] },
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
  
    $(document).on('click', '#btncalculartar', function () {
      valor = $('#mlbase1').val()
      if (valor.length > 0) {
        calculartarjeta()
      }
    })
  
    function calculartarjeta() {
      tablatarin.clear()
      tablatarin.draw()
      valor = $('#mlbase1').val()
      tipo = 1
      $.ajax({
        type: 'POST',
        url: 'bd/calculartarjeta.php',
        dataType: 'json',
        data: { tipo: tipo },
  
        success: function (res) {
          for (var i = 0; i < res.length; i++) {
            idcons = res[i].id_cons
            nomcons = res[i].nom_cons
            valortar = res[i].valortarjeta
            idumedida = res[i].id_umedida
            umedida = res[i].nom_umedida
            valorcal = round(res[i].valortarjeta * valor, 2)
            disponible = res[i].contenidoa
            tablatarin.row
              .add([
                idcons,
                nomcons,
                valortar,
                idumedida,
                umedida,
                valorcal,
                disponible,
              ])
              .draw()
  
            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
          }
        },
      })
    }
  
    $(document).on('click', '#btncalculartar2', function () {
      valor = $('#mlbase2').val()
      if (valor.length > 0) {
        calculartarjeta2()
      }
    })
  
    function calculartarjeta2() {
      tablatardes.clear()
      tablatardes.draw()
      valor = $('#mlbase2').val()
      tipo = 2
      $.ajax({
        type: 'POST',
        url: 'bd/calculartarjeta.php',
        dataType: 'json',
        data: { tipo: tipo },
  
        success: function (res) {
          for (var i = 0; i < res.length; i++) {
            idcons = res[i].id_des
            nomcons = res[i].nom_des
            valortar = res[i].valortarjeta
            valorcal = round(res[i].valortarjeta * valor, 2)
            disponible = res[i].totalusos
            tablatardes.row
              .add([idcons, nomcons, valortar, valorcal, disponible])
              .draw()
  
            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
          }
        },
      })
    }
  
    $(document).on('click', '.btndirecto', function (e) {
      e.preventDefault()
  
      fila = $(this).closest('tr')
  
      folio = $('#folioorden').val()
  
      tipo = 1
      idcons = fila.find('td:eq(0)').text()
      cantidadi = fila.find('td:eq(5)').text()
      cantidaddisi = fila.find('td:eq(6)').text()
      usuario = $('#nameuser').val()
      opcion = 1
  
      if (parseFloat(cantidadi) > parseFloat(cantidaddisi)) {
        nomensaje()
        return 0
      }
  
      if (folio.length != 0 && idcons.length != 0 && cantidadi.length != 0) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleordeninsumo.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            idcons: idcons,
            cantidadi: cantidadi,
            opcion: opcion,
            usuario: usuario,
          },
          success: function (data) {
            if (data != 0) {
              id_reg = data[0].id_reg
              id_cons = data[0].id_cons
              nom_cons = data[0].nom_cons
              nom_umedida = data[0].nom_umedida
              cantidad = data[0].cantidad
  
              tablaDetIn.row
                .add([id_reg, id_cons, nom_cons, nom_umedida, cantidad])
                .draw()
              $('#modalconfirmar').modal('hide')
            } else {
              Swal.fire({
                title: 'Item Duplicado',
                text: 'El Item ya se encuentra en la lista',
                icon: 'warning',
              })
              return false
            }
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
  
    $(document).on('click', '.btnElegir', function (e) {
      e.preventDefault()
      $('#formconfirmar').trigger('reset')
  
      fila = $(this).closest('tr')
      idtar = fila.find('td:eq(0)').text()
      constar = fila.find('td:eq(1)').text()
      cantidadtar = fila.find('td:eq(5)').text()
      idumedidatar = fila.find('td:eq(3)').text()
      umedidatar = fila.find('td:eq(4)').text()
      existencias = fila.find('td:eq(6)').text()
      tipo = 1
  
      $('#idconstar').val(idtar)
      $('#tipoconstar').val(tipo)
      $('#conceptotar').val(constar)
      $('#cantidadtar').val(cantidadtar)
      $('#idunidadtar').val(idumedidatar)
      $('#unidadtar').val(umedidatar)
      $('#existenciastar').val(existencias)
      $('#modalconfirmar').modal('show')
    })
  
    $(document).on('click', '.btnElegirdes', function (e) {
      e.preventDefault()
      $('#formconfirmar2').trigger('reset')
  
      fila = $(this).closest('tr')
      idtar = fila.find('td:eq(0)').text()
      constar = fila.find('td:eq(1)').text()
      cantidadtar = fila.find('td:eq(3)').text()
      idumedidatar = 0
      umedidatar = 'USOS'
      existencias = fila.find('td:eq(4)').text()
      tipo = 2
  
      $('#idconstar2').val(idtar)
      $('#tipoconstar2').val(tipo)
      $('#conceptotar2').val(constar)
      $('#cantidadtar2').val(cantidadtar)
      $('#idunidadtar2').val(idumedidatar)
      $('#unidadtar2').val(umedidatar)
      $('#existenciastar2').val(existencias)
      $('#modalconfirmar2').modal('show')
    })
  
    $(document).on('click', '#btnguardarconfirmacion', function () {
      folio = $('#folioorden').val()
  
      idcons = $('#idconstar').val()
  
      cantidadi = $('#cantidadtar').val()
      cantidaddisi = $('#existenciastar').val()
      usuario = $('#nameuser').val()
      opcion = 1
  
      if (parseFloat(cantidadi) > parseFloat(cantidaddisi)) {
        nomensaje()
        return 0
      }
  
      if (folio.length != 0 && idcons.length != 0 && cantidadi.length != 0) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleordeninsumo.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            idcons: idcons,
            cantidadi: cantidadi,
            opcion: opcion,
            usuario: usuario,
          },
          success: function (data) {
            if (data != 0) {
              id_reg = data[0].id_reg
              id_cons = data[0].id_cons
              nom_cons = data[0].nom_cons
              nom_umedida = data[0].nom_umedida
              cantidad = data[0].cantidad
  
              tablaDetIn.row
                .add([id_reg, id_cons, nom_cons, nom_umedida, cantidad])
                .draw()
              $('#modalconfirmar').modal('hide')
            } else {
              Swal.fire({
                title: 'Item Duplicado',
                text: 'El Item ya se encuentra en la lista',
                icon: 'warning',
              })
              return false
            }
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
  
    $(document).on('click', '#btnguardarconfirmacion2', function () {
      folio = $('#folioorden').val()
  
      idcons = $('#idconstar2').val()
  
      cantidadi = $('#cantidadtar2').val()
      cantidaddisi = $('#existenciastar2').val()
      usuario = $('#nameuser').val()
      opcion = 1
  
      if (parseFloat(cantidadi) > parseFloat(cantidaddisi)) {
        nomensaje()
        return 0
      }
  
      if (folio.length != 0 && idcons.length != 0 && cantidadi.length != 0) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleordendesechable.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            idcons: idcons,
            cantidadi: cantidadi,
            opcion: opcion,
            usuario: usuario,
          },
          success: function (data) {
            if (data != 0) {
              id_reg = data[0].id_reg
              id_cons = data[0].id_des
              nom_cons = data[0].nom_des
              nom_umedida = data[0].nom_umedida
              cantidad = data[0].cantidad
  
              tablaDetIndes.row
                .add([id_reg, id_cons, nom_cons, nom_umedida, cantidad])
                .draw()
                $('#modalconfirmar2').modal('hide')
            } else {
              Swal.fire({
                title: 'Item Duplicado',
                text: 'El Item ya se encuentra en la lista',
                icon: 'warning',
              })
              return false
            }
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
  
  
    $(document).on('click', '.btndirectodes', function (e) {
      e.preventDefault()
  
      fila = $(this).closest('tr')
  
      folio = $('#folioorden').val()
  
      tipo = 1
      idcons = fila.find('td:eq(0)').text()
      cantidadi = fila.find('td:eq(3)').text()
      cantidaddisi = fila.find('td:eq(4)').text()
      usuario = $('#nameuser').val()
      opcion = 1
  
      if (parseFloat(cantidadi) > parseFloat(cantidaddisi)) {
        nomensaje()
        return 0
      }
  
      if (folio.length != 0 && idcons.length != 0 && cantidadi.length != 0) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleordendesechable.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            idcons: idcons,
            cantidadi: cantidadi,
            opcion: opcion,
            usuario: usuario,
          },
          success: function (data) {
            if (data != 0) {
              id_reg = data[0].id_reg
              id_cons = data[0].id_des
              nom_cons = data[0].nom_des
              nom_umedida = data[0].nom_umedida
              cantidad = data[0].cantidad
  
              tablaDetIndes.row
                .add([id_reg, id_cons, nom_cons, nom_umedida, cantidad])
                .draw()
              limpiar()
            } else {
              Swal.fire({
                title: 'Item Duplicado',
                text: 'El Item ya se encuentra en la lista',
                icon: 'warning',
              })
              return false
            }
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
  
    $(document).on('click', '#btnMaterial', function () {
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
  
      $('#modalMat').modal('show')
    })
    //BOTON BUSCAR INSUMO
    $(document).on('click', '#btnInsumo', function () {
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
  
      $('#modalIns').modal('show')
    })
  
    //BOTON BUSCAR DESECHABLE
    $(document).on('click', '#btnInsumodes', function () {
      $('#modalDes').modal('show')
    })
    //BOTON SELECCIONAR MATERIAL
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
      largo = fila.find('td:eq(5)').text()
      
      alto = fila.find('td:eq(6)').text()
      ancho = fila.find('td:eq(7)').text()
      
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
    //BOTON BUSCAR INSUMO
    $(document).on('click', '.btnSelInsumo', function () {
      fila = $(this).closest('tr')
      idinsumo = fila.find('td:eq(0)').text()
      nominsumo = fila.find('td:eq(1)').text()
      nomumedida = fila.find('td:eq(2)').text()
      cantidaddisin = fila.find('td:eq(3)').text()
  
      /*
       */
      $('#idinsumo').val(idinsumo)
  
      $('#insumo').val(nominsumo)
  
      $('#nom_umedidain').val(nomumedida)
  
      $('#cantidaddisi').val(cantidaddisin)
      $('#cantidadi').prop('disabled', false)
  
      $('#modalIns').modal('hide')
    })
  
    //BOTON BUSCAR DESECHABLE
    $(document).on('click', '.btnSelDesechable', function () {
      fila = $(this).closest('tr')
      idinsumo = fila.find('td:eq(0)').text()
      nominsumo = fila.find('td:eq(1)').text()
      nomumedida = 'USO'
      cantidaddisin = fila.find('td:eq(3)').text()
  
      /*
       */
      $('#idinsumodes').val(idinsumo)
  
      $('#insumodes').val(nominsumo)
  
      $('#nom_umedidaindes').val(nomumedida)
  
      $('#cantidaddisides').val(cantidaddisin)
      $('#cantidadides').prop('disabled', false)
  
      $('#modalDes').modal('hide')
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
    //BOTON ELIMINAR COMPLEMENTO
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
              //async: false,
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
  
    //BOTON AGREGAR COMPLEMENTO
    $(document).on('click', '#btnAddcom', function () {
      //window.location.href = "prospecto.php";
      $('#formCom').trigger('reset')
  
      $('#modalCom').modal('show')
    })
    //BOTON GUARDAR COMPLEMENTO
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
  
    // AGREGAR MATERIAL
    $(document).on('click', '#btnagregar', function () {
      folio = $('#folioorden').val()
  
      idmat = $('#clavemat').val()
  
      cantidad = $('#cantidad').val()
  
      //cambios agregar alto ancho y largo al detalle de orden
      largo = $('#largo').val()
      alto = $('#alto').val()
      ancho = $('#ancho').val()
  
      cantidaddis = $('#cantidaddis').val()
      usuario = $('#nameuser').val()
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
            largo: largo,
            alto: alto,
            ancho: ancho,
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
                alto_mat,
                ancho_mat,
                m2_mat,
                id_umedida,
                nom_umedida,
                ubi_mat,
                cant_mat,
              ])
              .draw()
            limpiar()
            redimensionar(id_mat, 2)
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
  
    function redimensionar(id, tipo) {
      $.ajax({
        type: 'POST',
        url: 'bd/buscarmedidasmat.php',
        dataType: 'json',
        //async: false,
        data: {
          id: id,
        },
        success: function (data) {
          largo = data[0].largo_mat
          alto = data[0].alto_mat
          m2 = data[0].m2_mat
  
          $('#idmatred').val(id)
          $('#tipored').val(tipo)
          if (tipo == 2) {
            $('input.group1').attr('disabled', false)
          } else {
            $('input.group1').attr('disabled', true)
          }
  
          $('#largoant').val(largo)
          $('#altoant').val(alto)
          $('#m2restantes').val(m2)
  
          $('#largonuevo').val(0)
          $('#altonuevo').val(0)
          $('#validador').val(0)
  
          $('#modalredimensionar').modal({ backdrop: 'static', keyboard: false })
          $('#modalredimensionar').modal('show')
        },
        error: function (error) {
          console.log('ERROR DE FUNCION')
        },
      })
    }
  
    //AGREGAR INSUMO
  
    $(document).on('click', '#btnagregari', function () {
      folio = $('#folioorden').val()
  
      idcons = $('#idinsumo').val()
  
      cantidadi = $('#cantidadi').val()
      cantidaddisi = $('#cantidaddisi').val()
      usuario = $('#nameuser').val()
      opcion = 1
  
      if (parseFloat(cantidadi) > parseFloat(cantidaddisi)) {
        nomensaje()
        return 0
      }
  
      if (folio.length != 0 && idcons.length != 0 && cantidadi.length != 0) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleordeninsumo.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            idcons: idcons,
            cantidadi: cantidadi,
            opcion: opcion,
            usuario: usuario,
          },
          success: function (data) {
            if (data != 0) {
              id_reg = data[0].id_reg
              id_cons = data[0].id_cons
              nom_cons = data[0].nom_cons
              nom_umedida = data[0].nom_umedida
              cantidad = data[0].cantidad
  
              tablaDetIn.row
                .add([id_reg, id_cons, nom_cons, nom_umedida, cantidad])
                .draw()
              $('#modalconfirmar').modal('hide')
            } else {
              Swal.fire({
                title: 'Item Duplicado',
                text: 'El Item ya se encuentra en la lista',
                icon: 'warning',
              })
              return false
            }
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
  
    //AGREGAR DESECHABLE
    $(document).on('click', '#btnagregarides', function () {
      folio = $('#folioorden').val()
  
      idcons = $('#idinsumodes').val()
  
      cantidadi = $('#cantidadides').val()
      cantidaddisi = $('#cantidaddisides').val()
      usuario = $('#nameuser').val()
      opcion = 1
  
      if (parseFloat(cantidadi) > parseFloat(cantidaddisi)) {
        nomensaje()
        return 0
      }
  
      if (folio.length != 0 && idcons.length != 0 && cantidadi.length != 0) {
        $.ajax({
          type: 'POST',
          url: 'bd/detalleordendesechable.php',
          dataType: 'json',
          //async: false,
          data: {
            folio: folio,
            idcons: idcons,
            cantidadi: cantidadi,
            opcion: opcion,
            usuario: usuario,
          },
          success: function (data) {
            id_reg = data[0].id_reg
            id_cons = data[0].id_des
            nom_cons = data[0].nom_des
            nom_umedida = data[0].nom_umedida
            cantidad = data[0].cantidad
  
            tablaDetIndes.row
              .add([id_reg, id_cons, nom_cons, nom_umedida, cantidad])
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
        url: 'bd/detalleorden.php',
        dataType: 'json',
        data: { id: id, opcion: opcion, usuario: usuario },
        success: function (data) {
          console.log(data)
          if (data == 1) {
            tablaDet.row(fila.parents('tr')).remove().draw()
            redimensionar(mat, 1)
          } else {
            mensajeerror()
          }
        },
      })
    })
    //BORRAR INSUMO
    $(document).on('click', '.btnBorrarIn', function () {
      fila = $(this).closest('tr')
  
      id = fila.find('td:eq(0)').text()
      usuario = $('#nameuser').val()
      console.log(id)
      opcion = 2
  
      $.ajax({
        type: 'POST',
        url: 'bd/detalleordeninsumo.php',
        dataType: 'json',
        data: { id: id, opcion: opcion, usuario: usuario },
        success: function (data) {
          console.log(data)
          if (data == 1) {
            tablaDetIn.row(fila.parents('tr')).remove().draw()
          } else {
            mensajeerror()
          }
        },
      })
    })
  
    //BORRAR DESECHABLE
    $(document).on('click', '.btnBorrarDes', function () {
      fila = $(this).closest('tr')
  
      id = fila.find('td:eq(0)').text()
      usuario = $('#nameuser').val()
      console.log(id)
      opcion = 2
  
      $.ajax({
        type: 'POST',
        url: 'bd/detalleordendesechable.php',
        dataType: 'json',
        data: { id: id, opcion: opcion, usuario: usuario },
        success: function (data) {
          console.log(data)
          if (data == 1) {
            tablaDetIndes.row(fila.parents('tr')).remove().draw()
          } else {
            mensajeerror()
          }
        },
      })
    })
  
    $(document).on('click', '#btnguardarredimensionar', function () {
      id = $('#idmatred').val()
      largoant = $('#largoant').val()
      altoant = $('#altoant').val()
      m2ant= $('#m2restantes').val()
  
      largo = $('#largonuevo').val()
      alto = $('#altonuevo').val()
      m2 = $('#validador').val()
      tipored = $('#tipored').val()
      $usuario = $('#nameuser').val()
      pedaceria = 0
      if ($('#chpedaceria').prop('checked')) {
        pedaceria = 1
      }
    if (pedaceria==1 || ( largo!=0 && alto !=0 && m2!=0)){
      $.ajax({
        type: 'POST',
        url: 'bd/redimensionar.php',
        dataType: 'json',
        data: {
          id: id,
          largoant : largoant,
          altoant: altoant,
          m2ant: m2ant,
          largo: largo,
          alto: alto,
          m2: m2,
          tipored: tipored,
          usuario: usuario,
          pedaceria: pedaceria,
        },
        success: function (data) {
          if (data == 1) {
            window.location.reload()
          } else {
           
          }
        },
      })
    }else{
      mensajeerror()
    }
  
    })
  
    function limpiar() {
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
  
    function limpiarin() {
      $('#idinsumo').val('')
      $('#insumo').val('')
  
      $('#cantidadi').val('')
      $('#cantidaddisi').val('')
  
      $('#nom_umedidain').val('')
      $('#cantidadi').prop('disabled', true)
    }
  
    function limpiardes() {
      $('#idinsumodes').val('')
      $('#insumodes').val('')
  
      $('#cantidadides').val('')
      $('#cantidaddisides').val('')
  
      $('#nom_umedidaindes').val('')
      $('#cantidadides').prop('disabled', true)
    }
    function mensajeerror() {
      swal.fire({
        title: 'Operacion No exitosa',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
    document.getElementById('altonuevo').onblur = function () {
      calcularvalidador()
    }
  
    document.getElementById('largonuevo').onblur = function () {
      calcularvalidador()
    }
  
    function calcularvalidador(valor) {
      alto = $('#altonuevo').val().replace(/,/g, '')
      largo = $('#largonuevo').val().replace(/,/g, '')
      valor = alto * largo
      m2 = $('#m2restantes').val().replace(/,/g, '')
      if (valor <= m2) {
        $('#validador').val(valor)
        $('#validador').removeClass('bg-warning')
        $('#validador').addClass('bg-success')
      } else {
        $('#validador').val(valor)
        $('#validador').removeClass('bg-sucess')
        $('#validador').addClass('bg-warning')
      }
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
  