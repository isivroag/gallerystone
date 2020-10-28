$(document).ready(function () {
    var id_concepto, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        keys: true,
        stateSave: true,
        "paging": true,


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        },
        { className: "hide_column", "targets": [2] },
        { className: "hide_column", "targets": [4] },
        { className: "hide_column", "targets": [6] },
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

    $("#btnNuevo").click(function () {

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");

        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Concepto");
        $("#modalCRUD").modal("show");
        id_subtipo = 0;
        listar();

        id_concepto = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        id_concepto = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        concepto = fila.find('td:eq(1)').text();
        id_tipo = fila.find('td:eq(2)').text();
        tipo = fila.find('td:eq(3)').text();
        id_subtipo = fila.find('td:eq(4)').text();
        subtipo = fila.find('td:eq(5)').text();
        id_umedida = fila.find('td:eq(6)').text();
        umedida = fila.find('td:eq(7)').text();
        uso = fila.find('td:eq(8)').text();

        /*console.log(id_concepto);
        console.log(concepto);
        console.log(id_tipo);
        console.log(tipo);
        console.log(id_subtipo);
        console.log(subtipo);*/

        $("#tipo").val(id_tipo);

        $("#subtipo").val(id_subtipo);
        listar();

        $("#nombre").val(concepto);
        $("#umedida").val(id_umedida);
        $("#uso").val(uso);


        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Concepto");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);


        id_concepto = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar


        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id_concepto + "?");

        console.log(id_concepto);

        if (respuesta) {
            $.ajax({

                url: "bd/crudconcepto.php",
                type: "POST",
                dataType: "json",
                data: { id_concepto: id_concepto, opcion: opcion },

                success: function (data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#tipo").change(function () {
        listar();
    });


    function listar() {
        id = $('#tipo').val();
        var stipo = $("#subtipo");
        stipo.empty();


        $.ajax({
            type: "POST",
            url: "bd/buscarsubtipo.php",
            dataType: "json",
            data: { id: id },
            success: function (res) {

                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {

                        idsub = res[i].id_subt_concepto;
                        sub = res[i].nom_subt_concepto;

                        stipo.append('<option id="' + idsub + '" value="' + idsub + '">' + sub + '</option>');

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                } else {
                    stipo.empty();
                }
                stipo.val(id_subtipo);
            }

        });
    }

    $("#formDatos").submit(function (e) {
        e.preventDefault();
        var concepto = $.trim($("#nombre").val());
        var id_tipo = $.trim($("#tipo").val());
        var id_subtipo = $.trim($("#subtipo").val());
        var id_umedida = $.trim($("#umedida").val());
        var uso = $.trim($("#uso").val());
        if (id_subtipo.length == 0) {
            id_subtipo = 0;

        }






        if (concepto.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudconcepto.php",
                type: "POST",
                dataType: "json",
                data: { concepto: concepto, id_umedida: id_umedida, id_tipo: id_tipo, id_subtipo: id_subtipo, uso: uso, id_concepto: id_concepto, opcion: opcion },
                success: function (data) {
                    console.log(data);

                    //tablaPersonas.ajax.reload(null, false);
                    id_tipo = data[0].id_t_concepto;
                    tipo = data[0].nom_tipo;
                    id_subtipo = data[0].id_subt_concepto;
                    subtipo = data[0].nom_subtipo;
                    id_concepto = data[0].id_concepto;
                    concepto = data[0].nom_concepto;
                    id_umedida = data[0].id_umedida;
                    umedida = data[0].nom_umedida;
                    uso = data[0].tipo;

                    if (opcion == 1) {
                        tablaVis.row.add([id_concepto, concepto, id_tipo, tipo, id_subtipo, subtipo, id_umedida, umedida, uso]).draw();
                    } else {
                        tablaVis.row(fila).data([id_concepto, concepto, id_tipo, tipo, id_subtipo, subtipo, id_umedida, umedida, uso]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});