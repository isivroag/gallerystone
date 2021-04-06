

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
                    columns: [0, 1, 2, 3,4,5],
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
                exportOptions: { columns: [0, 1, 2, 3,4,5] },
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
            $($(row).find('td')['4']).addClass('text-center')
            $($(row).find('td')['5']).addClass('text-center')
            $($(row).find('td')['3']).addClass('text-right')
            $($(row).find('td')['3']).addClass('currency')


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
        var banco = $('#tcuenta').val()
        



        tablaVis.clear()
        tablaVis.draw()


        if (banco != '' ) {
            $.ajax({
                type: 'POST',
                url: 'bd/buscarbanco.php',
                dataType: 'json',
                data: { banco:banco },
                success: function (data) {
                    $("#saldocuenta").val(data);
                    }
                },
            );

            $.ajax({
                type: 'POST',
                url: 'bd/buscarmovb.php',
                dataType: 'json',
                data: { banco:banco },
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                       
                        tablaVis.row
                            .add([
                                data[i].id_movb,
                                data[i].fecha_movb,
                                data[i].tipo_movb,
                                data[i].monto,
                                data[i].folio_pagocxc,
                                data[i].folio_pagocxp
                                
                            ])
                            .draw()

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                },
            });
        } else {
            alert('Selecciona una cuenta')
        }
    })
})


