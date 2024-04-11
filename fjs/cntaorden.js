$(document).ready(function () {
  var id, opcion
  opcion = 4


  var operacion=$('#tipousuario').val();

  var textopermiso=permisos();

  function permisos() {
 
    if ( operacion==2 || operacion==3 ) {
      columnas = "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fas fa-search'></i></button>\
      <button class='btn btn-sm bg-warning btnMedir' data-toggle='tooltip' data-placement='top' title='Medir'><i class='fas fa-ruler text-light'></i></button>\
      <button class='btn btn-sm btn-secondary btnCortar' data-toggle='tooltip' data-placement='top' title='Cortar'><i class='fas fa-cut'></i></button>\
      <button class='btn btn-sm bg-lightblue btnEnsamblar' data-toggle='tooltip' data-placement='top' title='Ensamblar'><i class='fas fa-puzzle-piece'></i></button>\
      <button class='btn btn-sm bg-purple btnPulir' data-toggle='tooltip' data-placement='top' title='Pulir'><i class='fas fa-tint'></i></button>\
      <button class='btn btn-sm bg-orange btnColocar' data-toggle='tooltip' data-placement='top' title='Colocar'><i class='fas fa-truck-pickup text-light'></i></button>\
      <button class='btn btn-sm bg-success btnLiberar' data-toggle='tooltip' data-placement='top' title='Liberar'><i class='fas fa-check-circle'></i></button>\
      </div>"
        
    } else {
      columnas ="<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fas fa-search'></i></button>\
      <button class='btn btn-sm bg-warning btnMedir' data-toggle='tooltip' data-placement='top' title='Medir'><i class='fas fa-ruler text-light'></i></button>\
      <button class='btn btn-sm btn-secondary btnCortar' data-toggle='tooltip' data-placement='top' title='Cortar'><i class='fas fa-cut'></i></button>\
      </div>"
    }
    return columnas
  }


  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:textopermiso,

            //
      },
      { className: "btfecha editable", "targets": [7] },
      { className: "btFolio editable", "targets": [2] },
      { targets: [8], type: 'num-html' },{
        targets: 5,
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
          //return "<div class='text-wrap width-200'>" + data + '</div>'
        },

      },
    {
        targets: 6,
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
    stateSave: true,
    orderCellsTop: true,
    fixedHeader: true,
    paging: false,

    rowCallback: function (row, data) {
      $($(row).find('td')['10']).css('color', 'white')
      $($(row).find('td')['10']).addClass('text-center')
      $($(row).find('td')['9']).addClass('text-center')
      fecha = new Date(data[7]).getTime()
      fechaactual = new Date().getTime()
      

      dias = parseInt(fecha - fechaactual) / (1000 * 60 * 60 * 24)
      avance = data[9]

      barra =
        "<div class='progress mb-3 ' style='width:120px' > \
              <div class='progress-bar bg-success' role='progressbar' aria-valuenow='" +
        avance +
        "' aria-valuemin='0' aria-valuemax='100' style='width:" +
        avance +
        "%'> \
              <span class='text-light text-center'>" +
        avance +
        '%</span> \
              </div> \
              </div>'

      $($(row).find('td')[9]).html(barra)
      estadoord=data[10];

      if (dias < 3 && estadoord!='LIBERADO') {
        $($(row).find('td')).addClass('bg-gradient-warning blink_me')
        $($(row).find('td')[7]).addClass('text-danger text-bold ')
        
      }

      if (data[10] == 'MEDICION') {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find('td')[10]).addClass('bg-gradient-warning')
        //$($(row).find('td')['10']).text('PENDIENTE')
      } else if (data[10] == 'CORTE') {
        //$($(row).find("td")[10]).css("background-color", "blue");
        $($(row).find('td')[10]).addClass('bg-gradient-secondary')
        //$($(row).find('td')['10']).text('ENVIADO')
      } else if (data[10] == 'ENSAMBLE') {
        //$($(row).find("td")[10]).css("background-color", "success");
        $($(row).find('td')[10]).addClass('bg-lightblue')
        //$($(row).find('td')['10']).text('ACEPTADO')
      } else if (data[10] == 'PULIDO') {
        //$($(row).find("td")[10]).css("background-color", "purple");
        $($(row).find('td')[10]).addClass('bg-gradient-purple')
        //$($(row).find('td')['10']).text('EN ESPERA')
      } else if (data[10] == 'COLOCACION') {
        //$($(row).find("td")[5]).css("background-color", "light-blue");

        $($(row).find('td')[10]).addClass('bg-gradient-orange')
        //$($(row).find('td')['10']).text('EDITADO')
      } else if (data[10] == 'PROCESANDO'){
        //$($(row).find("td")[5]).css("background-color", "red");
        $($(row).find('td')[10]).addClass('bg-gradient-warning')
        //$($(row).find('td')['10']).text('RECHAZADO')
      }
      else if(data[10]=="LIBERADO") {
        $($(row).find('td')[10]).addClass('bg-gradient-success')
      }
      else if(data[10]=="ACTIVO") {
        $($(row).find('td')[10]).addClass('bg-gradient-primary')
      }
    },
  })

  var fila //capturar la fila para editar o borrar el registro
  
  //Boton Cambiar Fecha
  $(document).on('dblclick', '.btfecha', function () {
    tipousuario=$('#tipousuario').val()
    
    if (tipousuario!=5){
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
      fecha = fila.find('td:eq(7)').text();
     
     
      $('#formFecha').trigger('reset');
  
      $('#modalFecha').modal('show');
   
      $('#fechaf').val(fecha);
      $('#folioordenf').val(id);
    }
    
 
    
  })


  $(document).on('dblclick', '.btFolio', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    fol = fila.find('td:eq(2)').text();
   
   
    $('#formdocumento').trigger('reset');

    $('#modaldocumento').modal('show');
 
    
    $('#folioordend').val(id);
    $('#foliofis').val(fol);
 
    
  })
//Modificar la Fecha de la Orden
  $(document).on('click', '#btnGuardarf', function (event) {
    event.preventDefault()

    folio = $('#folioordenf').val()
   
    fecha = $('#fechaf').val()
    

    if (folio.length == 0 ||  fecha.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/cambiarfecha.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,    
          fecha: fecha,

        },
        success: function (res) {
          if (res == 1) {
            $('#modalFecha').modal('hide')
            mensaje()
            window.location.href = 'cntaorden.php'
          } else {
            nomensaje()
          }
        },
      })
    }
  })


  $(document).on('click', '#btnGuardard', function (event) {
    event.preventDefault()

    folio = $('#folioordend').val()
   
    foliofis = $('#foliofis').val()
    

    
    if (folio.length == 0 ||  foliofis.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/cambiarfoliofis.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,    
          foliofis: foliofis,

        },
        success: function (res) {
          if (res == 1) {
            $('#modaldocumento').modal('hide')
            mensaje()
            window.location.href = 'cntaorden.php'
          } else {
            nomensaje()
          }
        },
      })
    }
  })

  //botón EDITAR
  $(document).on('click', '.btnVer', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(1)').text())

    window.location.href = 'orden.php?folio=' + id + '&tipoorg=1'
  })


  //NUEVO MEDIR

  $(document).on("click", ".btnMedir", function() {
    fila = $(this).closest('tr')
  
    id = parseInt(fila.find('td:eq(0)').text())
    estado=fila.find('td:eq(10)').text()
    if (estado=='ACTIVO'){

      $.ajax({
        url: 'bd/buscarcitam.php',
        type: 'POST',
        dataType: 'json',
        async:false,
        data: {
          id: id,    
         
        },
        success: function (res) {
          if (res == 0) {
            $('#formFecha2').trigger('reset');
            $('#modalFecha2').modal('show');
            $('#foliocita').val(0);
            $('#folioordenmed').val(id)
          } else {
            swal.fire({
              title: 'La orden ya tiene una cita Agendada',
              icon: 'warning',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
          }
        },
      })
    ;



    }
   else{
    swal.fire({
      title: 'El estado de la Orden es superior al solicitado',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
   }
});


$(document).on("click", "#btnGuardarf", function() {
  var folioorden = $("#folioordenmed").val();
  var foliocita = $("#foliocita").val();
  var fecha = $("#fechamed").val();
  var responsable = $("#responsable").val();
  if (foliocita==0){
      opcion=1
      id=0
  }else{
      opcion=2
      id=foliocita
  }

  $.ajax({
      url: "bd/citasmedir.php",
      type: "POST",
      dataType: "json",
      async:false,
      data: {
          id: id,
          folioorden: folioorden,
          fecha: fecha,
          responsable: responsable,
          opcion: opcion,
      },
      success: function(data) {
          if (data!=0){
              /*folio=data

              var ancho = 600;
              var alto = 600;
              var x = parseInt((window.screen.width / 2) - (ancho / 2));
              var y = parseInt((window.screen.height / 2) - (alto / 2));



              url = "formatos/enviarevento.php?folio=" + folio;

              window.open(url, "CITA DE TOMA DE PLANTILLA", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");*/
              swal.fire({
                title: 'Cita de Toma de Plantilla agendada',
                icon: 'success',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
              })
              window.location.reload()
              
          }
      },
  });
  $("#modalCRUD").modal("hide");
});

/*
  $(document).on('click', '.btnMedir', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    estado = 'MEDICION'
    porcentaje=0;

    $.ajax({
      url: 'bd/estadoorden.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        estado: estado,
        porcentaje: porcentaje
      },
      success: function (res) {
        if (res == 1) {
          mensaje()
          window.location.href = 'cntaorden.php'
        } else {
          nomensaje()
        }
      },
    })
  })*/


  //NUEVO CORTE
  $(document).on('click', '.btnCortar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    estado = fila.find('td:eq(10)').text()
    if(estado=="MEDICION"){
      window.location.href="ot.php?folio="+folio
    }else{
      swal.fire({
        title: 'El estado de la Orden es superior al solicitado',
        text:"La orden de trabajo se mostrará en modo de solo lectura",
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
      window.setTimeout(function() {
        window.location.href="otr.php?folio="+folio
    }, 2000);
     
    }
    
  })
/*
  $(document).on('click', '.btnCortar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    estado = 'CORTE'
    porcentaje=5;

    $.ajax({
      url: 'bd/estadoorden.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        estado: estado,
        porcentaje: porcentaje
      },
      success: function (res) {
        if (res == 1) {
          mensaje()
          window.location.href = 'cntaorden.php'
        } else {
          nomensaje()
        }
      },
    })
  })
*/

  $(document).on('click', '.btnEnsamblar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    estado = 'ENSAMBLE'
    usuario=$('#nameuser').val();
    porcentaje=45;

    $.ajax({
      url: 'bd/estadoorden.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        estado: estado,
        porcentaje: porcentaje,
        usuario: usuario
      },
      success: function (res) {
        if (res == 1) {
          mensaje()
          window.location.href = 'cntaorden.php'
        } else {
          nomensaje()
        }
      },
    })
  })
  $(document).on('click', '.btnPulir', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    estado = 'PULIDO'
    porcentaje=75;
    usuario=$('#nameuser').val();

    $.ajax({
      url: 'bd/estadoorden.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        estado: estado,
        porcentaje: porcentaje,
        usuario: usuario
      },
      success: function (res) {
        if (res == 1) {
          mensaje()
          window.location.href = 'cntaorden.php'
        } else {
          nomensaje()
        }
      },
    })

   
  })
  $(document).on('click', '.btnColocar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    estado = 'COLOCACION'
    porcentaje=90;
    usuario=$('#nameuser').val();

    $.ajax({
      url: 'bd/estadoorden.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        estado: estado,
        porcentaje: porcentaje,
        usuario: usuario
      },
      success: function (res) {
        if (res == 1) {
          mensaje()
          window.location.href = 'cntaorden.php'
        } else {
          nomensaje()
        }
      },
    })
  })

  $(document).on('click', '.btnLiberar', function () {
    fila = $(this).closest('tr')
    folio = parseInt(fila.find('td:eq(0)').text())
    venta= parseInt(fila.find('td:eq(1)').text())
    
    
    folio = parseInt(fila.find('td:eq(0)').text());
    venta = parseInt(fila.find('td:eq(1)').text());
    
    $('#formOrden').trigger('reset');

    $('#modalOrden').modal('show');
    
    $('#fechal').val($('#fechasys').val());
    $('#foliolorden').val(folio);
    $('#foliolventa').val(venta);
  })

  $(document).on('click','#btngliberar',function(){
    folio = $('#foliolorden').val();
    venta= $('#foliolventa').val();
    
     usuario=$('#nameuser').val();
    fechalib=$('#fechal').val();
    estado = 'LIBERADO'
    porcentaje=100;

    $.ajax({
      url: 'bd/estadoorden.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        estado: estado,
        venta:venta,
        fechalib: fechalib,
        porcentaje: porcentaje,
        usuario: usuario
      },
      success: function (res) {
        if (res == 1) {
          mensaje()
          window.location.href = 'cntaorden.php'
        } else {
          nomensaje()
        }
      },
    })
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

})
