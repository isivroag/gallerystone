$(document).ready(function () {
    var id, opcion
    opcion = 4

    $('#tablaV thead tr').clone(true).appendTo('#tablaV thead');
    $('#tablaV thead tr:eq(1) th').each(function (i) {


        var title = $(this).text();


        $(this).html('<input class="form-control form-control-sm" type="text" placeholder="' + title + '" />');

        $('input', this).on('keyup change', function () {

            if (i == 6) {


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

        columnDefs: [

            {
                targets: 4,
                render: function (data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + '</div>'
                    //return "<div class='text-wrap width-200'>" + data + '</div>'
                },
            },
            {
                targets: 5,
                render: function (data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + '</div>'
                    //return "<div class='text-wrap width-200'>" + data + '</div>'
                },
            },
            {
                "targets": 3,
                "render": function ( data, type, row, meta ) {
                  return '<a href=rptvtaclie.php?id_clie='+row[2]+'>'+data+'</a>';    }
             },
             { "width": "50px", "targets": 2 },
             {
                targets: -1,
                data: null,
                defaultContent: "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button>\
               </div>",
            },
             

        ],

        buttons: [
            {
                extend: 'excelHtml5',
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: 'Exportar a Excel',
                title: 'Reporte de Presupuestos',
                className: 'btn bg-success ',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
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
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] },
                format: {
                    body: function (data, row, column, node) {
                        if (column === 6) {

                            return data
                        } else {
                            return data
                        }
                    },
                },
            },
        ],
        stateSave: true,
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

            $($(row).find('td')['6']).addClass('text-right')
            $($(row).find('td')['6']).addClass('currency')


        },


        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(6, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(6).footer()).html(
                '$' + new Intl.NumberFormat('es-MX').format(Math.round((pageTotal + Number.EPSILON) * 100) / 100)
            );
        }
    });

    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());

        window.location.href = "ventac.php?folio=" + id;
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
        var inicio = $('#inicio').val()
        var final = $('#final').val()
        var tipo_proy = 1;



        tablaVis.clear()
        tablaVis.draw()


        if (inicio != '' && final != '') {
            $.ajax({
                type: 'POST',
                url: 'bd/buscarventas.php',
                dataType: 'json',
                data: { inicio: inicio, final: final,tipo_proy: tipo_proy },
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        estado = data[i].estado_vta
                        total = data[i].gtotal

                        tablaVis.row
                            .add([
                                data[i].folio_vta,
                                data[i].fecha_vta,
                                data[i].id_clie,
                                data[i].nombre,
                                data[i].concepto_vta,
                                data[i].ubicacion,
                                data[i].gtotal,

                                data[i].vendedor,
                            ])
                            .draw()

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                },
            })
        } else {
            alert('Selecciona ambas fechas')
        }
    })
})


