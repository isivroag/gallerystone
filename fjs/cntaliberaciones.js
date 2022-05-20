
    tablalibproyantes = $('.tablasdetalles').DataTable({
        "columnDefs": [
          { "width": "10%", "targets":5 },
          { "width": "20%", "targets":3 },
          { "width": "10%", "targets":6 },
          { "width": "10%", "targets":7 },
        ],
          
        searching:false,
        stateSave: true,
        orderCellsTop: true,
      fixedHeader: true,
      paging:false,
      info:false,
        
    
        
    
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
    
      
  
  
        "footerCallback": function ( row, data, start, end, display ) {
          var api = this.api(), data;
  
          // Remove the formatting to get integer data for summation
          var intVal = function ( i ) {
              return typeof i === 'string' ?
                  i.replace(/[\$,]/g, '')*1 :
                  typeof i === 'number' ?
                      i : 0;
          };
  
          // Total over all pages
          total = api
              .column( 6 )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
  
              saldo = api
              .column( 7 )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );
  
          // Update footer
          $( api.column( 6 ).footer() ).html(
              '$'+ new Intl.NumberFormat('es-MX').format(Math.round((total + Number.EPSILON) * 100) / 100) 
          );
          $( api.column( 7 ).footer() ).html(
            '$'+ new Intl.NumberFormat('es-MX').format(Math.round((saldo + Number.EPSILON) * 100) / 100) 
        );
          }
      });
  