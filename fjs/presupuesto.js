$(document).ready(function() {
    var id, opcion;





    tablaVis = $("#tablaV").DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,


        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
            },
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
        }, { className: "hide_column", "targets": [2] }],

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

    tablaMat = $("#tablaMat").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelMaterial'><i class='fas fa-hand-pointer'></i></button></div></div>"
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

    tablaPre = $("#tablaP").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelPrecio'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }, { className: "text-right", "targets": [2] }],

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

    $(document).on("click", "#bcliente", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalProspecto").modal("show");

    });

    $(document).on("click", "#bconcepto", function() {

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

    $(document).on("click", "#bmaterial", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalMaterial").modal("show");




        $("#clavemat").val("");
        $("#material").val("");
        $("#clave").val("");
        $("#idprecio").val("");
        $("#unidad").val("");

        $("#precio").val("");
        $("#cantidad").val("");
        $("#cantidad").prop('disabled', true);

    });

    $(document).on("click", "#bprecio", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalPrecio").modal("show");




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

        IdCliente = fila.find('td:eq(0)').text();
        NomCliente = fila.find('td:eq(1)').text();
        correo = fila.find('td:eq(2)').text();
        tokenid = $('#tokenid').val();
        folio = $('#folio').val();
        opcion = 1;



        $("#id_pros").val(IdCliente);
        $("#nombre").val(NomCliente);
        $("#correo").val(correo);


        $.ajax({

            type: "POST",
            url: "bd/tmppres.php",
            dataType: "json",
            data: { IdCliente: IdCliente, tokenid: tokenid, folio: folio, opcion: opcion },
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

    $(document).on("click", "#btnGuardar", function() {




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
                console.log("Guardo el Head");
                if (res == 0) {
                    Swal.fire({
                        title: 'Error al Guardar',
                        text: "No se puedo guardar los datos del cliente",
                        icon: 'error',
                    })
                } else {

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
                                console.log("Guardo traslado a ventas");
                                Swal.fire({
                                    title: 'Operación Exitosa',
                                    text: "Presupuesto Guardado",
                                    icon: 'success',
                                })
                                folio = res;

                                estado = "1";
                                nota = "Creacion";
                                fecha = $("#fecha").val();
                                usuario = $("#nameuser").val();
                                console.log(folio);
                                $.ajax({
                                    type: "POST",
                                    url: "bd/estadopres.php",
                                    dataType: "json",

                                    data: { folio: folio, usuario: usuario, estado: estado, nota: nota, fecha: fecha },
                                    success: function() {
                                        console.log("Guardo la nota");
                                        window.setTimeout(function() {
                                            window.location.href = "pres.php?folio=" + folio;
                                        }, 1000);
                                    }

                                });


                            }
                        }
                    });

                }
            }
        });










    });



    $(document).on("click", "#btnGuardarHead", function() {

        guardarhead();

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

        idConcepto = fila.find('td:eq(0)').text();
        NomConcepto = fila.find('td:eq(1)').text();
        id_umedida = fila.find('td:eq(2)').text();
        usomat = fila.find('td:eq(4)').text();
        nom_umedida = fila.find('td:eq(3)').text();


        $("#claveconcepto").val(idConcepto);
        $("#concepto").val(NomConcepto);
        $("#id_umedida").val(id_umedida);
        $("#usomat").val(usomat);
        $("#nom_umedida").val(nom_umedida);



        listarmat();
        $("#bmaterial").prop('disabled', false);




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

    $(document).on("click", ".btnSelPrecio", function() {
        fila = $(this).closest("tr");

        idPrecio = fila.find('td:eq(0)').text();
        unidad = fila.find('td:eq(1)').text();
        PrecioMaterial = fila.find('td:eq(2)').text();

        /*
            
                            */
        $("#idprecio").val(idPrecio);
        $("#unidad").val(unidad);

        $("#precio").val(PrecioMaterial);

        $("#cantidad").prop('disabled', false);
        $("#modalPrecio").modal("hide");


    });

    $(document).on("click", "#btlimpiar", function() {


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
        //$('#cantidad').attr('disabled', 'disabled');

    });

    $(document).on("click", "#btnagregar", function() {

        folio = $("#folio").val();
        idconcepto = $("#claveconcepto").val();
        NomConcepto = $("#concepto").val();

        id_item = $("#clavemat").val();
        claveMat = $("#clave").val();
        NomMaterial = $("#material").val();

        id_precio = $("#idprecio").val();
        formato = $("#unidad").val();
        precio = $("#precio").val();

        idmedida = $("#idumedida").val();
        umedida = $("#nom_umedida").val();

        cantidad = $("#cantidad").val();

        unidad = $("#unidad").val();
        total = cantidad * PrecioMaterial;
        opcion = 1;



        if (folio.length != 0 && idconcepto.length != 0 && id_item.length != 0 &&
            idprecio.length != 0 && precio.length != 0 &&
            cantidad.length != 0) {
            $.ajax({

                type: "POST",
                url: "bd/detalletemp.php",
                dataType: "json",
                data: { folio: folio, idconcepto: idconcepto, id_item: id_item, id_precio: id_precio, precio: precio, cantidad: cantidad, total: total, opcion: opcion },
                success: function(data) {

                    id_reg = data[0].id_reg;
                    nom_concepto = data[0].nom_concepto;
                    nom_item = data[0].nom_item;
                    formato = data[0].formato;
                    nom_umedida = data[0].nom_umedida;
                    precio = data[0].precio;
                    cantidad = data[0].cantidad;
                    total = data[0].total;



                    tablaVis.row.add([id_reg, nom_concepto, nom_item, formato, cantidad, nom_umedida, precio, total]).draw();
                    buscartotal();

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

    function guardarhead() {
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


    };

    function listar() {
        id = $('#clavemat').val();
        id_umedida = $('#id_umedida').val();
        tablaPre.clear();
        tablaPre.draw();



        $.ajax({
            type: "POST",
            url: "bd/buscarprecio.php",
            dataType: "json",
            data: { id: id, id_umedida: id_umedida },
            success: function(res) {


                for (var i = 0; i < res.length; i++) {

                    tablaPre.row.add([res[i].id_precio, res[i].formato, res[i].monto, res[i].nom_umedida]).draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }

            }
        });


    };


    function buscartotal() {
        folio = $('#folio').val();


        $.ajax({
            type: "POST",
            url: "bd/buscartotal.php",
            dataType: "json",
            data: { folio: folio },
            success: function(res) {


                $("#subtotal").val(res[0].subtotal);


                $("#iva").val(res[0].iva);
                $("#total").val(res[0].total);
                $("#descuento").val(res[0].descuento);
                $("#gtotal").val(res[0].gtotal);

            }
        });
    };


    function listarmat() {

        tablaMat.clear();
        tablaMat.draw();
        tipoitem = $("#usomat").val();



        $.ajax({
            type: "POST",
            url: "bd/buscaritem.php",
            dataType: "json",
            data: { tipoitem: tipoitem },

            success: function(res) {


                for (var i = 0; i < res.length; i++) {

                    tablaMat.row.add([res[i].id_item, res[i].clave_item, res[i].nom_item]).draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }

            }
        });

    };

})