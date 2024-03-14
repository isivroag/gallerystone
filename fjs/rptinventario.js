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
  var tipousuario = $('#tipousuario').val()
    var id, opcion
    opcion = 4
  
    var textcolumnas = permisos()
  
    function permisos() {
      
      var columnas = ''
  
      if (tipousuario == 5) {
        columnas =
          "<div class='text-center'><button class='btn btn-sm btn-primary  btnEdit' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm btn-success  btnEditar' data-toggle='tooltip' data-placement='top' title='Abrir Insumo'><i class='fas fa-box-open'></i></button>\
        <button class='btn btn-sm bg-gradient-info text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Cerrado'><i class='fas fa-box'></i></button>\
        <button class='btn btn-sm bg-gradient-orange text-light btnMova' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Abierto'><i class='fas fa-fill-drip'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
        </div>"
      } else {
        columnas =
          "<div class='text-center'><button class='btn btn-sm btn-primary  btnEdit' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm btn-success  btnEditar' data-toggle='tooltip' data-placement='top' title='Abrir Insumo'><i class='fas fa-box-open'></i></button>\
        <button class='btn btn-sm bg-gradient-info text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Cerrado'><i class='fas fa-box'></i></button>\
        <button class='btn btn-sm bg-gradient-orange text-light btnMova' data-toggle='tooltip' data-placement='top' title='Movimientos Insumo Abierto'><i class='fas fa-fill-drip'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
         <button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-trash-alt'></i></button></div>"
      }
      return columnas
    }
  
    tablaVis1 = $('#tablaV1').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Reorden de Insumos',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7, 8, 9, 10, 11,14] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Reorden de Insumos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7, 8, 9, 10, 11,14] },
        },
      ],
  
      columnDefs: [
     
        { className: 'hide_column', targets: [4] },
        { className: 'text-right', targets: [5] },
        { className: 'text-right', targets: [6] },
        { className: 'text-right', targets: [7] },
        { className: 'text-right', targets: [8] },
        { className: 'text-right', targets: [9] },
        { className: 'hide_column', targets: [12] },
        { className: 'hide_column', targets: [13] },
        { className: 'text-right', targets: [14] },
        { className: 'text-right', targets: [15] },
          { className: 'hide_column', targets: [16] },
          {
            targets: 2,
            render: function (data, type, full, meta) {
                return "<div class='text-wrap width-200'>" + data + '</div>'
                //return "<div class='text-wrap width-200'>" + data + '</div>'
            },
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
      
  
      rowCallback: function (row, data) {
         
        valor=parseFloat(data[9])
        min=parseFloat(data[15])
        if (valor == min) {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('PENDIENTE')
        } else if (valor < min) {
          //$($(row).find("td")[9]).css("background-color", "blue");
          $($(row).find('td')).addClass('bg-gradient-danger')
          //$($(row).find('td')['9']).text('ENVIADO')
        } else{
          $($(row).find('td')).removeClass('bg-gradient-warning')
          $($(row).find('td')).removeClass('bg-gradient-danger')
        }
      },
      paging:false,
    })

    tablaVis2 = $('#tablaV2').DataTable({
         
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
          exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7, 8,9 ] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Inventario de Insumos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7, 8,9] },
        },
      ],
      paging:false,
  
      columnDefs: [
       
        { className: 'hide_column', targets: [4] },
        { className: 'text-right', targets: [5] },
        { className: 'text-right', targets: [6] },
        { className: 'text-right', targets: [7] },
        { className: 'text-right', targets: [8] },
        { className: 'text-right', targets: [9] },
        { className: 'hide_column', targets: [10] },
        { className: 'hide_column', targets: [11] },
        { className: 'text-right', targets: [12] },
        { className: 'hide_column', targets: [13] },
       
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
       
        valor=parseFloat(data[5])
        min=parseFloat(data[12])
        if (valor == min) {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('PENDIENTE')
        } else if (valor < min) {
          //$($(row).find("td")[9]).css("background-color", "blue");
          $($(row).find('td')).addClass('bg-gradient-danger')
          //$($(row).find('td')['9']).text('ENVIADO')
        } else{
          $($(row).find('td')).removeClass('bg-gradient-warning')
          $($(row).find('td')).removeClass('bg-gradient-danger')
        }
      },
      
    })
  
  
  
  
    var fila //capturar la fila para editar o borrar el registro
  
 

  
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
  