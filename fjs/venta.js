$(document).ready(function() {
    var id, opcion;



    tablaVis = $("#tablaV").DataTable({
        paging: false,
        ordering: false,
        info: false,
        searching: false,

        columnDefs: [
            { className: "text-center", targets: [4] },
            { className: "text-center", targets: [5] },
            { className: "text-right", targets: [6] },
            { className: "text-right", targets: [7] },
        ],

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

    $(document).on("click", "#btnVer", function() {

        folio = $('#foliopres').val();
        var ancho = 1000;
        var alto = 800;
        var x = parseInt((window.screen.width / 2) - (ancho / 2));
        var y = parseInt((window.screen.height / 2) - (alto / 2));

        url = "formatos/pdf.php?folio=" + folio;

        window.open(url, "Presupuesto", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

    });

    $(document).on("click", "#btnCal", function() {
        opcion = 3;
        var folio_vta = $.trim($("#folior").val());
        $.ajax({
            url: "bd/citasv.php",
            type: "POST",
            dataType: "json",
            data: { folio_vta: folio_vta, opcion: opcion },
            success: function(res) {
                if (res == 1) {
                    swal.fire({
                        tittle: "Cita Programada",
                        text: "La cita ya ha sido programada, para consultar o reagendarla, revise el modulo de Citas de Instalación",
                        icon: "warning",
                        focusConfirm: true,
                        confirmButtonText: "Aceptar",
                    });
                } else {
                    $(".modal-header").css("background-color", "#007bff");
                    $(".modal-header").css("color", "white");
                    $("#modalCita").modal("show");
                }
            },
        });
    });

    $(document).on("click", "#btnPagar", function() {
        opcion = 3;
        var folio_vta = $.trim($("#folior").val());
        $("#conceptovp").val("");
        $("#obsvp").val("");
        $("#saldovp").val($("#saldo").val());
        $("#montpago").val("");
        $("#metodo").val("")


        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $("#modalPago").modal("show");
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
            data: {
                folio_vta: folio_vta,
                fecha: fecha,
                obs: obs,
                concepto: concepto,
                opcion: opcion,
            },
            success: function(res) {
                mensaje();
            },
        });

        $("#modalCita").modal("hide");
    });

    $(document).on("click", "#btnGuardarvp", function() {
        var folio_vta = $("#foliovp").val();
        var fechavp = $("#fechavp").val();
        var conceptovp = $("#conceptovp").val();
        var obsvp = $("#obsvp").val();
        var saldovp = parseFloat($("#saldovp").val());
        var monto = $("#montopago").val();
        var metodo = $("#metodo").val();
        var usuario = $("#nameuser").val();

        if (folio_vta.length == 0 || fechavp.length == 0 || conceptovp.length == 0 || monto.length == 0 || metodo.length == 0 || usuario.length == 0) {
            swal.fire({
                title: "Datos Incompletos",
                text: "Verifique sus datos",
                icon: "warning",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        } else {

            $.ajax({
                url: "bd/buscarsaldo.php",
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                    folio_vta: folio_vta,
                },
                success: function(res) {
                    saldovp = res;

                },
            });


            if (parseFloat(saldovp) < parseFloat(monto)) {
                swal.fire({
                    title: "Pago Excede el Saldo",
                    text: "El pago no puede exceder el sado de la cuenta, Verifique el monto del Pago",
                    icon: "warning",
                    focusConfirm: true,
                    confirmButtonText: "Aceptar",
                });
                $("#saldovp").val(saldovp);
                $("#saldo").val(saldovp);
            } else {
                saldofin = saldovp - monto;
                opcion = 1;
                $.ajax({
                    url: "bd/pagoventa.php",
                    type: "POST",
                    dataType: "json",
                    async = false,
                    data: {
                        folio_vta: folio_vta,
                        fechavp: fechavp,
                        obsvp: obsvp,
                        conceptovp: conceptovp,
                        saldovp: saldovp,
                        monto: monto,
                        saldofin: saldofin,
                        metodo: metodo,
                        usuario: usuario,
                        opcion: opcion,
                    },
                    success: function(res) {
                        if (res == 1) {
                            buscartotal();
                            $("#modalPago").modal("hide");
                        } else {
                            swal.fire({
                                title: "Error",
                                text: "La operacion no puedo completarse",
                                icon: "warning",
                                focusConfirm: true,
                                confirmButtonText: "Aceptar",
                            });
                        }

                    },
                });

            }

        }



    });

    function mensaje() {
        swal.fire({
            title: "Cita Guardada",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function mensajepago() {
        swal.fire({
            title: "Pago Guardado",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function buscartotal() {
        folio = $('#foliovp').val();
        monto = $('#montopago').val();
        $.ajax({
            type: "POST",
            url: "bd/actualizarsaldo.php",
            dataType: "json",
            data: { folio: folio, monto: monto },
            success: function(res) {

                $("#saldo").val(res[0].saldo);
                mensajepago();

            }
        });

    }
});