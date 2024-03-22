$(document).ready(function () {
    var id, opcion
    opcion = 4


    /*
    butones de avance
     <button class='btn btn-sm bg-warning btnMedir' data-toggle='tooltip' data-placement='top' title='Medir'><i class='fas fa-ruler text-light'></i></button>\
              <button class='btn btn-sm btn-secondary btnCortar' data-toggle='tooltip' data-placement='top' title='Cortar'><i class='fas fa-cut'></i></button>\
              <button class='btn btn-sm bg-lightblue btnEnsamblar' data-toggle='tooltip' data-placement='top' title='Ensamblar'><i class='fas fa-puzzle-piece'></i></button>\
              <button class='btn btn-sm bg-purple btnPulir' data-toggle='tooltip' data-placement='top' title='Pulir'><i class='fas fa-tint'></i></button>\
              <button class='btn btn-sm bg-orange btnColocar' data-toggle='tooltip' data-placement='top' title='Colocar'><i class='fas fa-truck-pickup text-light'></i></button>\
              <button class='btn btn-sm bg-success btnLiberar' data-toggle='tooltip' data-placement='top' title='Liberar'><i class='fas fa-check-circle'></i></button>\
    
    */
  
    tablaVis = $('#tablaV').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fas fa-search'></i></button>\
            <button class='btn btn-sm bg-warning btnGeneradores' data-toggle='tooltip' data-placement='top' title='Ver Generadores'><i class='fas fa-book text-light'></i></button>\
            <button class='btn btn-sm bg-primary btnMateriales' data-toggle='tooltip' data-placement='top' title='Detalle de Materiales'><i class='fas fa-boxes text-light'></i></button>\
            <button class='btn btn-sm bg-success btnLiberar' data-toggle='tooltip' data-placement='top' title='Liberar'><i class='fas fa-check-circle'></i></button>\
              </div>",
        },
        { targets: [7], type: 'num-html' },{
          targets: 4,
          render: function (data, type, full, meta) {
            return "<div class='text-wrap'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
          },
          
        },
        {
            targets: 5,
            render: function (data, type, full, meta) {
              return "<div class='text-wrap'>" + data + '</div>'
              //return "<div class='text-wrap width-200'>" + data + '</div>'
            },
            
          }
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
        $($(row).find('td')['9']).css('color', 'white')
        $($(row).find('td')['9']).addClass('text-center')
        $($(row).find('td')['8']).addClass('text-center')
        fecha = new Date(data[6]).getTime()
        fechaactual = new Date().getTime()
        
  
        dias = parseInt(fecha - fechaactual) / (1000 * 60 * 60 * 24)
        avance = data[8]
  
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
  
        $($(row).find('td')[8]).html(barra)
        estadoord=data[9];
  /*
        if (dias < 3 && estadoord!='LIBERADO') {
          $($(row).find('td')).addClass('bg-gradient-warning blink_me')
          $($(row).find('td')[6]).addClass('text-danger text-bold')
        }*/
  
        if (data[9] == 'MEDICION') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[9]).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('PENDIENTE')
        } else if (data[9] == 'CORTE') {
          //$($(row).find("td")[9]).css("background-color", "blue");
          $($(row).find('td')[9]).addClass('bg-gradient-secondary')
          //$($(row).find('td')['9']).text('ENVIADO')
        } else if (data[9] == 'ENSAMBLE') {
          //$($(row).find("td")[9]).css("background-color", "success");
          $($(row).find('td')[9]).addClass('bg-lightblue')
          //$($(row).find('td')['9']).text('ACEPTADO')
        } else if (data[9] == 'PULIDO') {
          //$($(row).find("td")[9]).css("background-color", "purple");
          $($(row).find('td')[9]).addClass('bg-gradient-purple')
          //$($(row).find('td')['9']).text('EN ESPERA')
        } else if (data[9] == 'COLOCACION') {
          //$($(row).find("td")[5]).css("background-color", "light-blue");
  
          $($(row).find('td')[9]).addClass('bg-gradient-orange')
          //$($(row).find('td')['9']).text('EDITADO')
        } else if (data[9] == 'PROCESANDO'){
          //$($(row).find("td")[5]).css("background-color", "red");
          $($(row).find('td')[9]).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('RECHAZADO')
        }
        else if(data[9]=="LIBERADO") {
          $($(row).find('td')[9]).addClass('bg-gradient-success')
        }
        else if(data[9]=="ACTIVO") {
          $($(row).find('td')[9]).addClass('bg-gradient-primary')
        }
      },
    })
  
    var fila //capturar la fila para editar o borrar el registro
  
    //botón EDITAR
    $(document).on('click', '.btnVer', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
  
      window.location.href = 'caratulaobra.php?folio=' + id
    })

    $(document).on('click', '.btnMateriales', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(1)').text())
  
      window.location.href = 'obra.php?folio=' + id
    })

  
    $(document).on('click', '.btnGeneradores', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(0)').text())
      window.location.href = 'cntagenerador.php?folio=' + folio
    })


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
    $(document).on('click', '.btnEnsamblar', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(0)').text())
      estado = 'ENSAMBLE'
      porcentaje=45;
  
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
    $(document).on('click', '.btnPulir', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(0)').text())
      estado = 'PULIDO'
      porcentaje=75;
  
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
    $(document).on('click', '.btnColocar', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(0)').text())
      estado = 'COLOCACION'
      porcentaje=90;
  
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
            porcentaje: porcentaje
          },
          success: function (res) {
            if (res == 1) {
              mensaje()
              window.location.reload();
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
  })
  