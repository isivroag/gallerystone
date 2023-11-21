$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        },
    
    
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
        $(".modal-title").text("Nuevo Personal");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        //window.location.href = "actprospecto.php?id=" + id;
        nombre = fila.find('td:eq(1)').text();
        cel = fila.find('td:eq(2)').text();
        salariod = fila.find('td:eq(3)').text();
       
        ingreso=fila.find('td:eq(4)').text();
        tipo=fila.find('td:eq(5)').text();

        



        $("#nombre").val(nombre);
        $("#cel").val(cel);
        $("#salariod").val(salariod);
       4
        $("#ingreso").val(ingreso);
        $("#tipo").val(tipo);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Personal");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");


        if (respuesta) {
            $.ajax({

                url: "bd/crudpersonal.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



    $("#formDatos").submit(function(e) {
        e.preventDefault();
        var nombre = $.trim($("#nombre").val());
        var cel = $.trim($("#cel").val());
        var ingreso = $.trim($("#ingreso").val());
        var salariod = $.trim($("#salariod").val());
        var tipo = $("#tipo").val();
      



       


        if (nombre.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudpersonal.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre, 
                    cel: cel, 
                    ingreso: ingreso, 
                    salariod: salariod, 
                    id: id, 
                    tipo: tipo,
                    opcion: opcion },
                success: function(data) {
                   
                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_per;
                    nombre = data[0].nom_per;
                    cel = data[0].cel_per;
                    ingreso = data[0].fechaing;
                    salariod = data[0].salariod;
                    tipo = data[0].tipo;
               

                    if (opcion == 1) {
                        tablaVis.row.add([id, nombre,cel,salariod,ingreso,tipo,]).draw();
                    } else {
                        tablaVis.row(fila).data([id, nombre,cel,salariod,ingreso,tipo, ]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});