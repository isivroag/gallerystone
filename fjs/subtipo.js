$(document).ready(function() {
    var id_subtipo, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
            },
            { className: "hide_column", "targets": [2] }
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

    $("#btnNuevo").click(function() {

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Subtipo De Concepto");
        $("#modalCRUD").modal("show");
        id_subtipo = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id_tipo = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        tipo = fila.find('td:eq(1)').text();
        id_subtipo = fila.find('td:eq(2)').text();
        subtipo = fila.find('td:eq(3)').text();

        console.log(id_tipo);
        console.log(tipo);
        console.log(id_subtipo);

        console.log(subtipo);

        $("#tipo").val(id_tipo);
        $("#nombre").val(subtipo);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Subtipo de Concepto");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);


        id_subtipo = parseInt($(this).closest("tr").find('td:eq(2)').text());
        opcion = 3; //borrar


        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id_subtipo + "?");

        console.log(id_subtipo);

        if (respuesta) {
            $.ajax({

                url: "bd/crudsubtipo.php",
                type: "POST",
                dataType: "json",
                data: { id_subtipo: id_subtipo, opcion: opcion },

                success: function(data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



    $("#formDatos").submit(function(e) {
        e.preventDefault();
        var subtipo = $.trim($("#nombre").val());
        var id_tipo = $.trim($("#tipo").val());

        console.log(id_tipo);
        console.log(id_subtipo);
        console.log(subtipo);



        if (subtipo.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudsubtipo.php",
                type: "POST",
                dataType: "json",
                data: { subtipo: subtipo, id_subtipo: id_subtipo, id_tipo: id_tipo, opcion: opcion },
                success: function(data) {
                    console.log(data);
                    console.log(fila);
                    console.log(opcion);
                    //tablaPersonas.ajax.reload(null, false);
                    id_tipo = data[0].id_t_concepto;
                    tipo = data[0].nom_t_concepto;
                    id_subtipo = data[0].id_subt_concepto;
                    subtipo = data[0].nom_subt_concepto;

                    if (opcion == 1) {
                        tablaVis.row.add([id_tipo, tipo, id_subtipo, subtipo]).draw();
                    } else {
                        tablaVis.row(fila).data([id_tipo, tipo, id_subtipo, subtipo]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});