$(document).ready(function() {
    var id, opcion;
    opcion = 4;



    tablaB1 = $("#tablalls").DataTable({

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
    tablaC1 = $("#tablallps").DataTable({

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
        "order": [[ 3, 'asc' ]],
        paging:false,
        info:false,
        "searching": false
    });

    tablaVis = $("#tablaV").DataTable({
        rowCallback: function (row, data) {
            $($(row).find('td')['4']).css('color', 'white')
            $($(row).find('td')['4']).addClass('text-center')
            $($(row).find('td')['3']).addClass('text-right')
            $($(row).find('td')['3']).addClass('currency')
      
            if (data[4] == 'PENDIENTE') {
              //$($(row).find("td")[6]).css("background-color", "warning");
              $($(row).find('td')[4]).addClass('bg-gradient-warning')
              //$($(row).find('td')['4']).text('PENDIENTE')
            } else if (data[4] == 'ENVIADO') {
              //$($(row).find("td")[4]).css("background-color", "blue");
              $($(row).find('td')[4]).addClass('bg-gradient-primary')
              //$($(row).find('td')['4']).text('ENVIADO')
            } else if (data[4] == 'ACEPTADO') {
              //$($(row).find("td")[4]).css("background-color", "success");
              $($(row).find('td')[4]).addClass('bg-gradient-success')
              //$($(row).find('td')['4']).text('ACEPTADO')
            } else if (data[4] == 'SEGUIMIENTO') {
              //$($(row).find("td")[4]).css("background-color", "purple");
              $($(row).find('td')[4]).addClass('bg-gradient-purple')
              //$($(row).find('td')['4']).text('EN ESPERA')
            } else if (data[4] == 'MODIFICADO') {
              //$($(row).find("td")[5]).css("background-color", "light-blue");
              $($(row).find('td')[4]).addClass('bg-lightblue')
              //$($(row).find('td')['4']).text('EDITADO')
            } else {
              //$($(row).find("td")[5]).css("background-color", "red");
              $($(row).find('td')[4]).addClass('bg-gradient-danger')
              //$($(row).find('td')['8']).text('RECHAZADO')
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
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button></div></div>"
        }],
        stateSave: true,
        info: false,

    },
    );


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

    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "pres.php?folio=" + id;


    });

    $(document).on("click", "#btncalmedir", function() {
     

      window.location.href = "citaorden.php" ;


  });


  $(document).on("click", "#btinstalacion", function() {
  

    window.location.href = "citasventa.php" ;


});
    
    

    $(document).on("click", "#btnHome", function() {
      fecha = $("#fechahome").val();
       

      window.location.href = "inicio.php?fecha=" + fecha;


  });


    tablaC = $("#tablaC").DataTable({




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
        stateSave: true,
        info: false,
          
    });

    tablaIN = $("#tablaIN").DataTable({




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
        searching:false,
        stateSave: true,
        orderCellsTop: true,
      fixedHeader: true,
      paging:false,
      info:false,
        "order": [[ 1, "desc" ]]
    });

});