$(document).ready(function() {
    var id, opcion;







    tablaC = $("#tablaC").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

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

    tablaCon = $("#tablaCon").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

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





    $(document).on("click", "#bproveedor", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalProspecto").modal("show");

    });

    
    $(document).on("click", "#bproveedorplus", function() {

        window.location.href = "cntaproveedor.php";
        

    });

    
    $(document).on("click", "#bpartidaplus", function() {

        window.location.href = "cntapartida.php" ;

    });

    $(document).on("click", "#bpartida", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalConcepto").modal("show");

        $("#claveconcepto").val("");
        $("#concepto").val("");
        $("#id_umedida").val("");
        $("#usomat").val("");
        $("#nom_umedida").val("");
        $("#bmaterial").prop('disabled', true);
        $("#clavemat").val("");
        $("#material").val("");
        $("#clave").val("");
        $("#idprecio").val("");
        $("#unidad").val("");

        $("#precio").val("");
        $("#cantidad").val("");
        $("#cantidad").prop('disabled', true);




    });



    $(document).on("click", ".btnSelCliente", function() {
        fila = $(this).closest("tr");

        idprov = fila.find('td:eq(0)').text();
        nomprov = fila.find('td:eq(2)').text();

        opcion = 1;

        $("#id_prov").val(idprov);
        $("#nombre").val(nomprov);
        $("#modalProspecto").modal("hide");

    });

    $(document).on("click", "#btnGuardar", function() {
        folio = $("#folio").val();
        fecha = $("#fecha").val();
        fechal = $("#fechal").val();
        id_prov = $("#id_prov").val();
        id_partida = $("#id_partida").val();
        concepto = $("#concepto").val();
        facturado = $("#cfactura").val();
        referencia = $("#referencia").val();
        subtotal = $("#subtotal").val();
        iva = $("#iva").val();
        total = $("#total").val();
        tokenid = $("#tokenid").val();
        opcion = $("#opcion").val();;


        if (subtotal.length != 0 && iva.length != 0 && total.length != 0 &&
            concepto.length != 0 && id_partida.length != 0 &&
            id_prov.length != 0) {
            $.ajax({

                type: "POST",
                url: "bd/crudcxp.php",
                dataType: "json",
                data: { fecha: fecha, fechal: fechal, id_prov: id_prov, id_partida: id_partida, concepto: concepto, facturado: facturado, referencia: referencia, subtotal: subtotal, iva: iva, total: total, saldo: total, tokenid: tokenid, folio: folio, opcion: opcion },
                success: function(res) {

                    if (res == 0) {
                        Swal.fire({
                            title: 'Error al Guardar',
                            text: "No se puedo guardar los datos del cliente",
                            icon: 'error',
                        })
                    } else {
                        Swal.fire({
                            title: 'Operación Exitosa',
                            text: "Presupuesto Guardado",
                            icon: 'success',
                        })

                        window.setTimeout(function() {
                            window.location.href = "cntacxp.php";
                        }, 1500);

                    }
                }
            });
        } else {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Item",
                icon: 'warning',
            })
            return false;
        }
    });




    $(document).on("click", ".btnSelConcepto", function() {
        fila = $(this).closest("tr");
        idpartida = fila.find('td:eq(0)').text();
        partida = fila.find('td:eq(1)').text();
        $("#id_partida").val(idpartida);
        $("#partida").val(partida);
        $("#modalConcepto").modal("hide");

    });

    $(document).on("click", "#btnNuevo", function() {
        limpiar();
    });

    $(document).on("click", ".btnSelMaterial", function() {
        fila = $(this).closest("tr");

        idMaterial = fila.find('td:eq(0)').text();
        NomMaterial = fila.find('td:eq(2)').text();
        ClaveMaterial = fila.find('td:eq(1)').text();
        $("#clavemat").val(idMaterial);
        $("#material").val(NomMaterial);
        $("#clave").val(ClaveMaterial);

        $("#modalMaterial").modal("hide");
        listar();

    });


    $("#subtotal").on("change keyup paste click", function() {
        if ($('#cmanual').prop('checked')) {


        } else {
            if ($('#cinverso').prop('checked')) {

            } else {
                valor = $("#subtotal").val();
                calculo(valor);
            }
        }


    });

    $("#total").on("change keyup paste click", function() {
        if ($('#cmanual').prop('checked')) {


        } else {
            if ($('#cinverso').prop('checked')) {
                valor = $("#total").val();
                calculoinverso(valor);
            }
        }

    });

    $("#ccredito").on("click", function() {
        if ($('#ccredito').prop('checked')) {
            $("#fechal").prop('disabled', false);
        } else {
            $("#fechal").prop('disabled', true);
        }
        $("#fechal").val($("#fecha").val());


    });

    $("#cinverso").on("click", function() {
        if ($('#cinverso').prop('checked')) {
            $("#total").prop('disabled', false);
            $("#subtotal").prop('disabled', true);
        } else {
            $("#total").prop('disabled', true);
            $("#subtotal").prop('disabled', false);
        }


    });

    $("#cmanual").on("click", function() {
        if ($('#cmanual').prop('checked')) {
            $("#total").prop('disabled', false);
            $("#subtotal").prop('disabled', false);
            $("#iva").prop('disabled', false);
        } else {
            if ($('#cinverso').prop('checked')) {
                $("#total").prop('disabled', false);
                $("#subtotal").prop('disabled', true);
            } else {
                $("#total").prop('disabled', true);
                $("#subtotal").prop('disabled', false);
            }
            $("#iva").prop('disabled', true);
        }

    });


    function limpiar() {

        var today = new Date();
        var dd = today.getDate();

        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        today = yyyy + '-' + mm + '-' + dd;


        $("#id_prov").val('');
        $("#nombre").val('');
        $("#fecha").val(today);
        $("#folio").val('');
        $("#folior").val('');
        $("#id_partida").val('');
        $("#partida").val('');
        $("#ccredito").val(false);
        $("#fechal").val(today);
        $("#cfactura").val(false);
        $("#referencia").val('');
        $("#proyecto").val('');
        $("#subtotal").val('');
        $("#iva").val('');
        $("#total").val('');
        $("#cinverso").val(false);
    };


    function calculo(subtotal) {

        total = round(subtotal * 1.16, 2);

        iva = round(total - subtotal, 2);


        $("#iva").val(iva);
        $("#total").val(total);
    };

    function calculoinverso(total) {

        subtotal = round(total / 1.16, 2);
        iva = round(total - subtotal, 2);

        $("#subtotal").val(subtotal);
        $("#iva").val(iva);

    };

    function round(value, decimals) {
        return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    }






})