$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'>\
              <button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Ver Ot'><i class='fas fa-search'></i></button>\
              </div>",
  
              //
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
  
    
    })
  
    var fila //capturar la fila para editar o borrar el registro
    
    $('#btnNuevo').click(function () {
        window.location.href = 'nomina.php'
      
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
  
  })
  