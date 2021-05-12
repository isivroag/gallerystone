$(document).ready(function() {
    var id, opcion;
    opcion = 4;


    tablaVis = $(".tablaV").DataTable({
        dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group text-center'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            {
              extend: 'excelHtml5',
              text: "<i class='fas fa-file-excel'> Excel</i>",
              titleAttr: 'Exportar a Excel',
              title: 'Reporte de Presupuestos',
              className: 'btn bg-success ',
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5,6],
                /*format: {
                  body: function (data, row, column, node) {
                    if (column === 5) {
                      return data.replace(/[$,]/g, '')
                    } else if (column === 6) {
                      return data
                    } else {
                      return data
                    }
                  },
                },*/
              },
            },
            {
              extend: 'pdfHtml5',
              text: "<i class='far fa-file-pdf'> PDF</i>",
              titleAttr: 'Exportar a PDF',
              title: 'Reporte de Presupuestos',
              className: 'btn bg-danger',
              exportOptions: { columns: [0, 1, 2, 3, 4, 5,6] },
              format: {
                  body: function (data, row, column, node) {
                    if (column === 6) {
                      /*switch (data) {
                        case '0':
                          return data.replace(0, 'RECHAZADO')
      
                          break
                        case '1':
                          return data.replace('1', 'PENDIENTE')
                          break
                        case '2':
                          return data.replace('2', 'ENVIADO')
                          break
                        case '3':
                          return data.replace('3', 'ACEPTADO')
                          break
                        case '4':
                          return data.replace('4', 'EN ESPERA')
                          break
                        case '5':
                          return data.replace('5', 'EDITADO')
                          break
                      }*/
                      return data
                    } else {
                      return data
                    }
                  },
                },
            },
          ],

       

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
        }
    });

   
 


 
});