$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass-dollar'></i></button>\
              </div>",
  
              //
        },
       
        { targets: [7], type: 'num-html' },{
          targets: 5,
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
    

    $("#btnBuscar").click(function () {
        window.location.href =
          "cntaordencto.php?inicio=" + $("#inicio").val() + "&fin=" + $("#fin").val();
      });
  

  //Modificar la Fecha de la Orden
 
  
  
  
  
    //botón EDITAR
    $(document).on('click', '.btnVer', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(1)').text())
  
      window.location.href = 'ordencto.php?folio=' + id
    })
  
  
    //NUEVO MEDIR
  

  
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
  