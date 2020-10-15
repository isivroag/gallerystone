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


    /*
        $(document).on("change", "#folio", function() {
            folio = $("#folio").val();

            $.ajax({

                type: "POST",
                url: "bd/buscardetalletmp.php",
                dataType: "json",
                data: { folio: folio },
                success: function(res) {

                    for (var i = 0; i < res.length; i++) {
                        tablaVis.row.add([res[i].id_reg, res[i].nom_concepto, res[i].nom_item, res[i].formato, res[i].cantidad, res[i].nom_umedida, res[i].precio, res[i].total]).draw();
                    }
                }
            });
        });
    */
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
        folio = $('#folio').val();

        $.ajax({

            type: "POST",
            url: "bd/trasladopres.php",
            dataType: "json",
            data: { folio: folio },
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
                        window.location.href = "pres.php?folio=" + res;
                    }, 1000);

                }
            }
        });

    });



    $(document).on("click", "#btnGuardarHead", function() {

        IdCliente = $("#id_pros").val();
        fecha = $("#fecha").val();
        tokenid = $('#tokenid').val();
        folio = $('#folio').val();
        proyecto = $('#proyecto').val();
        ubicacion = $('#ubicacion').val();




        opcion = 2;




        $.ajax({

            type: "POST",
            url: "bd/tmppres.php",
            dataType: "json",
            data: { IdCliente: IdCliente, fecha: fecha, proyecto: proyecto, ubicacion: ubicacion, tokenid: tokenid, folio: folio, opcion: opcion },
            success: function(res) {

                if (res == 0) {
                    Swal.fire({
                        title: 'Error al Guardar',
                        text: "No se puedo guardar los datos del cliente",
                        icon: 'error',
                    })
                }
            }
        });

        $("#modalProspecto").modal("hide");

    });

    $(document).on("click", ".btnBorrar", function(event) {
        event.preventDefault();
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        total = $(this).closest("tr").find('td:eq(7)').text();
        folio = $("#folio").val();
        opcion = 2;

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro?");



        if (respuesta) {
            $.ajax({

                url: "bd/detalletemp.php",
                type: "POST",
                dataType: "json",
                data: { id: id, total: total, folio: folio, opcion: opcion },

                success: function() {


                    tablaVis.row(fila.parents('tr')).remove().draw();
                    buscartotal();
                }
            });
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

    $(document).on("click", ".btnSelMaterial", function() {
        fila = $(this).closest("tr");

        idMaterial = fila.find('td:eq(0)').text();
        NomMaterial = fila.find('td:eq(2)').text();
        ClaveMaterial = fila.find('td:eq(1)').text();

        /*
         */
        $("#clavemat").val(idMaterial);
        $("#material").val(NomMaterial);
        $("#clave").val(ClaveMaterial);

        $("#modalMaterial").modal("hide");
        listar();

    });











})