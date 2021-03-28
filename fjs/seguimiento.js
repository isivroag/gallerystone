$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaA = $("#tablaA").DataTable({
     

        rowCallback: function (row, data) {
            
      
            if (data[6] == 'LLAMADA 1') {
              //$($(row).find("td")[6]).css("background-color", "warning");
              $($(row).find("td")[6]).addClass('bg1')
              //$($(row).find('td')['6']).text('PENDIENTE')
            } else if (data[6] == 'LLAMADA 2') {
              //$($(row).find("td")[6]).css("background-color", "blue");
              $($(row).find("td")[6]).addClass('bg2')
              //$($(row).find('td')['6']).text('ENVIADO')
            } else if (data[6] == 'LLAMADA 3') {
              //$($(row).find("td")[6]).css("background-color", "success");
              $($(row).find("td")[6]).addClass('bg3')
              //$($(row).find('td')['6']).text('ACEPTADO')
            } 
          },


        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        "ordering": false,
        "order": [[ 5, 'asc' ], [ 0, 'asc' ]],
       
        paging:false,
        info:false,
        "searching": false
    },
    );


    tablaB = $("#tablaB").DataTable({

      rowCallback: function (row, data) {
            
      
        if (data[6] == 'LLAMADA 1') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find("td")[6]).addClass('bg1')
          //$($(row).find('td')['6']).text('PENDIENTE')
        } else if (data[6] == 'LLAMADA 2') {
          //$($(row).find("td")[6]).css("background-color", "blue");
          $($(row).find("td")[6]).addClass('bg2')
          //$($(row).find('td')['6']).text('ENVIADO')
        } else if (data[6] == 'LLAMADA 3') {
          //$($(row).find("td")[6]).css("background-color", "success");
          $($(row).find("td")[6]).addClass('bg3')
          //$($(row).find('td')['6']).text('ACEPTADO')
        } 
      },


        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        "ordering": false,
        "order": [[ 5, 'asc' ], [ 0, 'asc' ]],
        paging:false,
        info:false,
        "searching": false
    });

    tablaC = $("#tablaC").DataTable({

      rowCallback: function (row, data) {
            
      
        if (data[6] == 'LLAMADA 1') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find("td")[6]).addClass('bg1')
          //$($(row).find('td')['6']).text('PENDIENTE')
        } else if (data[6] == 'LLAMADA 2') {
          //$($(row).find("td")[6]).css("background-color", "blue");
          $($(row).find("td")[6]).addClass('bg2')
          //$($(row).find('td')['6']).text('ENVIADO')
        } else if (data[6] == 'LLAMADA 3') {
          //$($(row).find("td")[6]).css("background-color", "success");
          $($(row).find("td")[6]).addClass('bg3')
          //$($(row).find('td')['6']).text('ACEPTADO')
        } 
      },


        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        },
        "ordering": false,
        "order": [[ 5, 'asc' ], [ 0, 'asc' ]],
        paging:false,
        info:false,
        "searching": false
    });

});