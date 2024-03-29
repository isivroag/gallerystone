$(document).ready(function () {
  var id, opcion,folio,tipo,columnas
  opcion = 4


  var operacion=$('#tipousuario').val();

  var textopermiso=permisos();

  function permisos() {
 
    if (operacion == 1 || operacion==2 || operacion==3 ) {
      columnas = "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass'></i></button>\
      <button class='btn btn-sm btn-info btnentregar' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Entregado'><i class='fa-solid fa-person-arrow-down-to-line'></i></button>\
      <button class='btn btn-sm btn-success btnrecibir' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Recibido'><i class='fa-solid fa-person-arrow-up-from-line'></i></button>\
      <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
        </div>"
        
    } else if (operacion==4){
      columnas ="<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass'></i></button>\
      <button class='btn btn-sm btn-info btnentregar' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Entregado'><i class='fa-solid fa-person-arrow-down-to-line'></i></button>\
      <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
        </div>"
    }else if (operacion==5){
      columnas="<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass'></i></button>\
      <button class='btn btn-sm btn-info btnentregar' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Entregado'><i class='fa-solid fa-person-arrow-down-to-line'></i></button>\
      <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
        </div>"
    }else if (operacion==6){
      columnas="<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass'></i></button>\
      <button class='btn btn-sm btn-success btnrecibir' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Recibido'><i class='fa-solid fa-person-arrow-up-from-line'></i></button>\
      <button class='btn btn-sm bg-orange btnPdf' data-toggle='tooltip' data-placement='top' title='Imprimir'><i class='text-white fas fa-file-pdf'></i></button>\
        </div>"
    }
    return columnas
  }

  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,

        render: function (data, type, row) {
          'use strict'

          return permisos()
        },
      },

      {
        targets: 3,
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
          //return "<div class='text-wrap width-200'>" + data + '</div>'
        },
      },
      { className: 'hide_column', targets: [5] },
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

    rowCallback: function (row, data) {
      $($(row).find('td')['7']).css('color', 'white')
      $($(row).find('td')['7']).addClass('text-center')
    
      if (data[7] == 'INICIADO') {
        //$($(row).find("td")[7]).css("background-color", "warning");
       $($(row).find('td')[7]).addClass('bg-gradient-warning')
       
        //$($(row).find('td')['7']).text('PENDIENTE')
      } else if (data[7] == 'ENTREGADO') {
        //$($(row).find("td")[7]).css("background-color", "blue");
        $($(row).find('td')[7]).addClass('bg-gradient-info')
      
        //$($(row).find('td')['7']).text('ENVIADO')
      } else if (data[7] == 'RECIBIDO') {
        //$($(row).find("td")[7]).css("background-color", "success");
        $($(row).find('td')[7]).addClass('bg-gradient-success')
      
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
      if (data[7] == '0') {
        //$($(row).find("td")[7]).css("background-color", "warning");
        $($(row).find('td')[7]).addClass('bg-gradient-warning')
        $($(row).find('td')[7]).addClass('text-white')
        $($(row).find('td')[7]).addClass('text-center')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[7]).text('PENDIENTE')
      } else if (data[7] == '1') {
        $($(row).find('td')[7]).addClass('bg-gradient-info')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[7]).text('ENTREGADO')
        $($(row).find('td')[7]).addClass('text-center')
      } else if (data[7] == '2') {
        $($(row).find('td')[7]).addClass('bg-gradient-success')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[7]).text('RECIBIDO')
        $($(row).find('td')[7]).addClass('text-center')
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
                <button class='btn btn-sm bg-orange  btnajuste'><i class='text-white fa-solid fa-right-left'></i></button>\
                </div></div>",
      },
      { className: 'hide_column', targets: [1] },
      { className: 'hide_column', targets: [8] },
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
      if (data[7] == '0') {
        //$($(row).find("td")[7]).css("background-color", "warning");
        $($(row).find('td')[7]).addClass('bg-gradient-warning')
        $($(row).find('td')[7]).addClass('text-white')
        $($(row).find('td')[7]).addClass('text-center')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[7]).text('PENDIENTE')
      } else if (data[7] == '1') {
        $($(row).find('td')[7]).addClass('bg-gradient-info')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[7]).text('ENTREGADO')
        $($(row).find('td')[7]).addClass('text-center')
      } else if (data[7] == '2') {
        $($(row).find('td')[7]).addClass('bg-gradient-success')
        //$($(row).find('td')[4]).css('background-color','#EEA447');
        $($(row).find('td')[7]).text('RECIBIDO')
        $($(row).find('td')[7]).addClass('text-center')
      }
      if (data[2] === 'INSUMO') {
        $(row).find('.btnrecibido').show();
        $(row).find('.btnajuste').show();
      } else if (data[2] === 'HERRAMIENTA') {
        $(row).find('.btnrecibido').show();
        $(row).find('.btnajuste').hide();
      }
    },
  })


  $("#btnBuscar").click(function () {
    var inicio = $("#inicio").val();
    var final = $("#final").val();
    window.location.href =
      "cntavale.php?inicio=" + inicio + "&fin=" + final;
  });


  
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
    tipo = fila.find('td:eq(2)').text()
    estado=fila.find('td:eq(7)').text()
    if (estado=="PENDIENTE"){
      opcion = 4
      $.ajax({
        type: 'POST',
        url: 'bd/detallevale.php',
        dataType: 'json',
  
        data: { id: id, opcion: opcion, tipo: tipo },
  
        success: function (res) {
          if (res==1){
            buscarherramienta(folio)
          }else if (res==2){
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
    estado=fila.find('td:eq(7)').text()
    tipo = fila.find('td:eq(2)').text()
    if (estado=="ENTREGADO"){

     

      opcion = 5
      $.ajax({
        type: 'POST',
        url: 'bd/detallevale.php',
        dataType: 'json',
  
        data: { id: id, opcion: opcion, tipo: tipo },
  
        success: function (res) {
          if (res==1){
            buscarherramienta2(folio)
          }else if (res==2){
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
  
  $(document).on('click', '.btnajuste', function () {
    fila = $(this).closest('tr')
    registro = parseInt(fila.find('td:eq(0)').text())
    id = fila.find('td:eq(1)').text()
    estado=fila.find('td:eq(7)').text()
    tipo = fila.find('td:eq(2)').text()
    fvale = fila.find('td:eq(8)').text()
    cantidad = fila.find('td:eq(5)').text()
    if (estado=="ENTREGADO"){
      $("#formRegreso").trigger("reset");
      $("#fregistro").val(registro);
      $("#foliovale").val(fvale);
      $("#iditem").val(id);
      $("#tipoitem").val(tipo);
      $("#cantidad1").val(cantidad);
      $('#modalRegreso').modal({ backdrop: 'static', keyboard: false })
      $('#modalRegreso').modal('show')
     
/*
      opcion = 5
      $.ajax({
        type: 'POST',
        url: 'bd/detallevale.php',
        dataType: 'json',
  
        data: { id: id, opcion: opcion, tipo: tipo },
  
        success: function (res) {
          if (res==1){
            buscarherramienta2(folio)
          }else if (res==2){
            location.reload()
          }
         
        },
      })*/
    }else{
      swal.fire({
        title: 'La Herramienta ya ha sido recibida ',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
   
  })

  $("#cantidad2").on("change keyup paste click", function() {
    valor1=$('#cantidad1').val();
   
    valor2=$('#cantidad2').val();
    if (isNaN(valor2) == true || valor2.length==0){
      valor2=0
    }
    usado=$('#cantidad1').val();
    if (parseFloat(valor1)<parseFloat(valor2)){
      swal.fire({
        title: 'No es posible regresar mas elementos que los registrados en la orden',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }else{
      usado=parseFloat(valor1)-parseFloat(valor2)
    }
    $('#cantidadr').val(usado);
    
});

$(document).on('click', '#btnregresarcant', function () {
  vale=$("#foliovale").val();
  item=$("#iditem").val();
  tipo=$("#tipoitem").val();
  cantidadu=$("#cantidadr").val();
  cantidadr=$("#cantidad2").val();
  motivo=$("#motivor").val();
  id=$("#fregistro").val();

  opcion = 6
      $.ajax({
        type: 'POST',
        url: 'bd/detallevale.php',
        dataType: 'json',
  
        data: { id: id, opcion: opcion, tipo: tipo, vale: vale ,item: item,cantidadu: cantidadu, cantidadr: cantidadr,motivo: motivo},
  
        success: function (res) {
          if (res==1){
            buscarherramienta2(folio)
            $('#modalRegreso').modal('hide')
          }else if (res==2){
            location.reload()
          }
         
        },
      })
})


  $(document).on('click', '.btnVer', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    emisor = fila.find('td:eq(0)').text()
    receptor = fila.find('td:eq(0)').text()
    obs = fila.find('td:eq(0)').text()
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

      data: { folio: folio, opcion: opcion,tipo: tipo },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablac.row
            .add([
              res[i].id_reg,
              res[i].id_her,
              res[i].tipo,
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

      data: { folio: folio, opcion: opcion, tipo: tipo },

      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablad.row
            .add([
              res[i].id_reg,
              res[i].id_her,
              res[i].tipo,
              res[i].clave_her,
              res[i].nom_her,
              res[i].cantidad_her,
              res[i].obs,
              res[i].estado,
              res[i].folio_vale,
              res[i].cant_req,
           
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
