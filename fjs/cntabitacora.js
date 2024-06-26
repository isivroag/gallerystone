

$(document).ready(function () {
    var id, opcion
    opcion = 4

    $('#tablaV thead tr').clone(true).appendTo('#tablaV thead');
    $('#tablaV thead tr:eq(1) th').each(function (i) {


        var title = $(this).text();


        $(this).html('<input class="form-control form-control-sm" type="text" placeholder="' + title + '" />');

        $('input', this).on('keyup change', function () {

            if (i == 3) {


                valbuscar = this.value;
            } else {
                valbuscar = this.value;

            }

            if (tablaVis.column(i).search() !== valbuscar) {
                tablaVis
                    .column(i)
                    .search(valbuscar, true, true)
                    .draw();
            }
        });
    });


    tablaVis = $('#tablaV').DataTable({
        dom:
            "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
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
                    columns: [0, 1, 2, 3,4,5,6,7,8],
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
                exportOptions: { columns: [0, 1, 2, 3,4,5,6,7,8] },
                format: {
                    body: function (data, row, column, node) {
                        if (column === 3) {

                            return data
                        } else {
                            return data
                        }
                    },
                },
            },
        ],
        stateSave: false,
        orderCellsTop: true,
        fixedHeader: true,
        paging: false,
        order: [[ 1, "desc" ]],



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

        rowCallback: function (row, data) {
            $($(row).find('td')['7']).addClass('text-center')
            $($(row).find('td')['8']).addClass('text-center')
            $($(row).find('td')['4']).addClass('text-right')
            $($(row).find('td')['5']).addClass('text-right')
            $($(row).find('td')['6']).addClass('text-right')
            $($(row).find('td')['4']).addClass('currency')
            $($(row).find('td')['5']).addClass('currency')
            $($(row).find('td')['6']).addClass('currency')
           
            if (data[2] == 'Ingreso') {
                //$($(row).find("td")[6]).css("background-color", "warning");
                $($(row).find('td')[2]).addClass('bg-gradient-green')
                //$($(row).find('td')['2']).text('PENDIENTE')
              } else if (data[2] == 'Egreso') {
                //$($(row).find("td")[2]).css("background-color", "blue");
                $($(row).find('td')[2]).addClass('bg-gradient-purple')
                //$($(row).find('td')['2']).text('ENVIADO')
              } else if (data[2] == 'Saldo Inicial') {
                //$($(row).find("td")[2]).css("background-color", "success");
                $($(row).find('td')[2]).addClass('bg-gradient-primary')
                //$($(row).find('td')['6']).text('ACEPTADO')
              }


            
        },


    });



    var fila //capturar la fila para editar o borrar el registro





    function startTime() {
        var today = new Date()
        var hr = today.getHours()
        var min = today.getMinutes()
        var sec = today.getSeconds()
        //Add a zero in front of numbers<10
        min = checkTime(min)
        sec = checkTime(sec)
        document.getElementById('clock').innerHTML = hr + ' : ' + min + ' : ' + sec
        var time = setTimeout(function () {
            startTime()
        }, 500)
    }

    function checkTime(i) {
        if (i < 10) {
            i = '0' + i
        }
        return i
    }

    

    $('#btnBuscar').click(function () {
        inicio=$('#inicio').val()
        fin=$('#fin').val()
        window.location.href='cntabitacora.php?inicio='+inicio+'&fin='+fin
    })
})


