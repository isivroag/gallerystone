$(document).ready(function() {
    var id, opcion;
    opcion = 4;

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

    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "pres.php?folio=" + id;


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



});