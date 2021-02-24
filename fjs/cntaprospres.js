$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({

        paging: false,

        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary btnVer'><i class='fas fa-search'></i></button></div>"
        }, { className: "text-center bg-primary", "targets": [2] }, { className: "text-center bg-success", "targets": [3] }, { className: "text-center bg-danger", "targets": [4] }, ],


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

    tablaD = $("#tablaD").DataTable({
        columnDefs: [{
                targets: -1,
                data: null,
                defaultContent: "<div class='text-center'><button class='btn btn-sm btn-primary btnVerPres'><i class='fas fa-search'></i></button></div>",
            },

        ],

        //Para cambiar el lenguaje a español
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
    });


    $(document).on("click", ".btnVer", function() {
        tablaD.clear();
        tablaD.draw();
        fila = $(this).closest("tr");

        id_pros = parseInt($(this).closest("tr").find('td:eq(0)').text());

        $.ajax({
            type: "POST",
            url: "bd/verpres.php",
            dataType: "json",
            data: { id_pros: id_pros },
            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    folio_pres = res[i].folio_pres;
                    fecha_pres = res[i].fecha_pres;
                    proyecto = res[i].concepto_pres;
                    total = res[i].gtotal;
                    estado = parseInt(res[i].estado_pres);
                    switch (estado) {
                        case 0:
                            estadoh = "<span class='bg-danger'> RECHAZADO </span>";
                            break;
                        case 1:
                            estadoh = "<span class='bg-warning'> PENDIENTE </span>";
                            break;
                        case 2:
                            estadoh = "<span class='bg-primary'> ENVIADO </span>";
                            break;
                        case 3:
                            estadoh = "<span class='bg-success'> ACEPTADO </span>";
                            break;
                        case 4:
                            estadoh = "<span class='bg-purple'> EN ESPERA </span>";
                            break;
                        case 5:
                            estadoh = "<span class='bg-lightblue'> EDITADO </span>";
                            break;
                    }
                    tablaD.row.add([folio_pres, fecha_pres, proyecto, total, estadoh, ]).draw();
                }
            },
        });

        $("#modaldetalle").modal("show");
    });

    $(document).on("click", ".btnVerPres", function() {

        fila = $(this).closest("tr");

        folio_pres = parseInt($(this).closest("tr").find('td:eq(0)').text());

        window.location.href = "pres.php?folio=" + folio_pres;
    });

});