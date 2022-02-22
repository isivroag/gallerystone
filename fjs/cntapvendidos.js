$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
     
  
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
    
    //Boton Cambiar Fecha
  
  

  
  })
  