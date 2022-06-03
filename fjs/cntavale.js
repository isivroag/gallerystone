$(document).ready(function () {
  var id, opcion,folio
  opcion = 4

  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,

        render: function (data, type, row) {
          'use strict'

          return "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass'></i></button>\
              <button class='btn btn-sm btn-info btnentregar' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Entregado'><i class='fa-solid fa-person-arrow-down-to-line'></i></button>\
              <button class='btn btn-sm btn-success btnrecibir' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Recibido'><i class='fa-solid fa-person-arrow-up-from-line'></i></button>\
              <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
                </div>"
        },
      },

      {
        targets: 5,
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
          //return "<div class='text-wrap width-200'>" + data + '</div>'
        },
      },
      { className: 'hide_column', targets: [4] },
      { className: 'hide_column', targets: [5] },
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
      $($(row).find('td')['6']).css('color', 'white')
      $($(row).find('td')['6']).addClass('text-center')
    
      if (data[6] == 'INICIADO') {
        //$($(row).find("td")[6]).css("background-color", "warning");
       $($(row).find('td')[6]).addClass('bg-gradient-warning')
       
        //$($(row).find('td')['6']).text('PENDIENTE')
      } else if (data[6] == 'ENTREGADO') {
        //$($(row).find("td")[6]).css("background-color", "blue");
        $($(row).find('td')[6]).addClass('bg-gradient-info')
      
        //$($(row).find('td')['6']).text('ENVIADO')
      } else if (data[6] == 'RECIBIDO') {
        //$($(row).find("td")[6]).css("background-color", "success");
        $($(row).find('td')[6]).addClass('bg-gradient-success')
      
        //$($(row).find('td')['6']).text('ACEPTADO')
      }
    },
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,
  
     
  })

  tablac = $('#tablac').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'>\
                <button class='btn btn-sm btn-info btentregado'><i class='fa-solid fa-check-circle'></i></button>\
                </div></div>",
      },
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
    rowCallback: function (row, data) {
      if (data[6] == '0') {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find('td')[6]).addClass('bg-gradient-warning')
        $($(row).find('td')[6]).addClass('text-white')
        $($(row).find('td')[6]).addClass('text-center')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[6]).text('PENDIENTE')
      } else if (data[6] == '1') {
        $($(row).find('td')[6]).addClass('bg-gradient-info')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[6]).text('ENTREGADO')
        $($(row).find('td')[6]).addClass('text-center')
      } else if (data[6] == '2') {
        $($(row).find('td')[6]).addClass('bg-gradient-success')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[6]).text('RECIBIDO')
        $($(row).find('td')[6]).addClass('text-center')
      }
    },
  })


  tablad = $('#tablad').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'>\
                <button class='btn btn-sm btn-info btnrecibido'><i class='fa-solid fa-check-circle'></i></button>\
                </div></div>",
      },
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
    rowCallback: function (row, data) {
      if (data[6] == '0') {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find('td')[6]).addClass('bg-gradient-warning')
        $($(row).find('td')[6]).addClass('text-white')
        $($(row).find('td')[6]).addClass('text-center')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[6]).text('PENDIENTE')
      } else if (data[6] == '1') {
        $($(row).find('td')[6]).addClass('bg-gradient-info')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[6]).text('ENTREGADO')
        $($(row).find('td')[6]).addClass('text-center')
      } else if (data[6] == '2') {
        $($(row).find('td')[6]).addClass('bg-gradient-success')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[6]).text('RECIBIDO')
        $($(row).find('td')[6]).addClass('text-center')
      }
    },
  })
  var fila //capturar la fila para editar o borrar el registro

  //Boton Cambiar Fecha

  $(document).on('click', '.btnentregar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    buscarherramienta(folio)
    $('#modalentrega').modal('show')
  })

  $(document).on('click', '.btentregado', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    estado=fila.find('td:eq(6)').text()
    if (estado=="PENDIENTE"){
      opcion = 4
      $.ajax({
        type: 'POST',
        url: 'bd/detallevale.php',
        dataType: 'json',
  
        data: { id: id, opcion: opcion },
  
        success: function (res) {
          if (res==1){
            location.reload()
          }
         
        },
      })
    }else{
      swal.fire({
        title: 'La Herramienta ya ha sido entregada ',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
   
  })


  $(document).on('click', '.btnrecibir', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    buscarherramienta2(folio)
    $('#modalrecepcion').modal('show')
  })

  $(document).on('click', '.btnrecibido', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    estado=fila.find('td:eq(6)').text()
    if (estado=="ENTREGADO"){
      opcion = 5
      $.ajax({
        type: 'POST',
        url: 'bd/detallevale.php',
        dataType: 'json',
  
        data: { id: id, opcion: opcion },
  
        success: function (res) {
          if (res==1){
            location.reload()
          }
         
        },
      })
    }else{
      swal.fire({
        title: 'La Herramienta ya ha sido recibida ',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
   
  })

  $(document).on('click', '.btnVer', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    window.location.href = 'vale.php?folio=' + folio
  })


  function buscarherramienta(folio) {
    tablac.clear()
    tablac.draw()
    opcion = 3
    console.log(folio)

    $.ajax({
      type: 'POST',
      url: 'bd/detallevale.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablac.row
            .add([
              res[i].id_reg,
              res[i].id_her,
              res[i].clave_her,
              res[i].nom_her,
              res[i].cantidad_her,
              res[i].obs,
              res[i].estado,
            ])
            .draw()
        }
      },
    })
  }


  function buscarherramienta2(folio) {
    tablad.clear()
    tablad.draw()
    opcion = 3
    console.log(folio)

    $.ajax({
      type: 'POST',
      url: 'bd/detallevale.php',
      dataType: 'json',

      data: { folio: folio, opcion: opcion },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablad.row
            .add([
              res[i].id_reg,
              res[i].id_her,
              res[i].clave_her,
              res[i].nom_her,
              res[i].cantidad_her,
              res[i].obs,
              res[i].estado,
            ])
            .draw()
        }
      },
    })
  }

  //botón EDITAR
  $(document).on('click', '#btnNuevo', function () {
    window.location.href = 'vale.php'
  })

  function mensaje() {
    swal.fire({
      title: 'Orden de Servicio Actualizada',
      icon: 'success',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }
  function nomensaje() {
    swal.fire({
      title: 'No fue posible actualizar la Orden',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

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

  $(document).on("click", ".btnPdf", function() {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    var ancho = 1000;
    var alto = 800;
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    url = "formatos/pdfvale.php?folio=" + folio;

    window.open(url, "Vale", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

});
})
