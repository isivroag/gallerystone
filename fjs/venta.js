$(document).ready(function() {
    var id, opcion;





    tablaVis = $("#tablaV").DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,


        "columnDefs": [
            { className: "text-center", "targets": [4] },
            { className: "text-center", "targets": [5] },
            { className: "text-right", "targets": [6] },
            { className: "text-right", "targets": [7] }
        ],


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

    $(document).on("click", "#btnCal", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalCita").modal("show");

    });

    $(document).on("click", "#btnGuardarcita", function() {

        var folio_vta = $.trim($("#folior").val());

        var concepto = $.trim($("#concepto").val());
        var fecha = $.trim($("#fechac").val());
        var obs = $.trim($("#obs").val());


        opcion = 1;

        $.ajax({
            url: "bd/citasv.php",
            type: "POST",
            dataType: "json",
            data: { folio_vta: folio_vta, fecha: fecha, obs: obs, concepto: concepto, opcion: opcion },
            success: function(res) {

                mensaje();
            }
        });

        $("#modalCita").modal("hide");
    });

    function mensaje() {
        swal.fire({

            text: "Cita Guardada",


            icon: 'success',
            focusConfirm: true,
            confirmButtonText: "Aceptar",


        })
    }


})