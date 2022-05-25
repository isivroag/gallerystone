$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,

          

          render: function (data, type, row){
            'use strict';
         
              return "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass'></i></button>\
              <button class='btn btn-sm btn-info btnentrega' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Entregado'><i class='fa-solid fa-person-arrow-down-to-line'></i></button>\
              <button class='btn btn-sm btn-success btnrecibir' data-toggle='tooltip' data-placement='top' title='Firma de Equipo Recibido'><i class='fa-solid fa-person-arrow-up-from-line'></i></button>\
                </div>"
         
            
        }

        },
      
  
     
      {
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
  /*
      rowCallback: function (row, data) {
        $($(row).find('td')['8']).css('color', 'white')
        $($(row).find('td')['8']).addClass('text-center')
      
        if (data[8] == 'DESCARGA') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          //$($(row).find('td')[8]).addClass('bg-gradient-warning')
          $($(row).find('td')[8]).css('background-color','#810305');
          //$($(row).find('td')['8']).text('PENDIENTE')
        } else if (data[8] == 'PROTECCION') {
          //$($(row).find("td")[8]).css("background-color", "blue");
          //$($(row).find('td')[8]).addClass('bg-gradient-secondary')
          $($(row).find('td')[8]).css('background-color','#F7BEF9');
          //$($(row).find('td')['8']).text('ENVIADO')
        } else if (data[8] == 'COLOCADO') {
          //$($(row).find("td")[8]).css("background-color", "success");
          //$($(row).find('td')[8]).addClass('bg-lightblue')
          $($(row).find('td')[8]).css('background-color','#3581FD');
          //$($(row).find('td')['8']).text('ACEPTADO')
        }
        else if(data[8]=="LIMPIEZA") {
          //$($(row).find('td')[8]).addClass('bg-gradient-success')
          $($(row).find('td')[8]).css('background-color','#97B870');
        }
        else if(data[8]=="ENTREGA") {
            
          //$($(row).find('td')[8]).addClass('bg-gradient-primary')
          $($(row).find('td')[8]).css('background-color','#22AA0C');
          
        }
        else{
           $($(row).find('td')[8]).addClass('bg-gradient-orange')
           $($(row).find('td')[8]).text("INICIO")
        }
        
      },*/
 
    })


    
  
    var fila //capturar la fila para editar o borrar el registro
    
    //Boton Cambiar Fecha
    

  



  
    //botón EDITAR
    $(document).on('click', '.btnVer', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(0)').text())
      buscarpiezas(folio)
     
  
    
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
  