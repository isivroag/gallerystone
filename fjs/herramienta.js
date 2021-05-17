$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        }, { className: "hide_column", "targets": [3] }],

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
     
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Insumo");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        hom_her = fila.find('td:eq(1)').text(); //window.location.href = "actprospecto.php?id=" + id;
        cantidad = fila.find('td:eq(2)').text();
        ubicacion = fila.find('td:eq(3)').text();
        obs = fila.find('td:eq(4)').text();

  
        $("#nom_her").val(hom_her);
        $("#cantidad").val(cantidad);
        $("#ubicacion").val(ubicacion);
        $("#obs").val(obs);

        opcion = 2; //editar

       
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Insumo");
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

                url: "bd/crudherramienta.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



    $("#formDatos").submit(function(e) {
        e.preventDefault();
      
        var nom_her = $.trim($("#nom_her").val());
        var cantidad = $.trim($("#cantidad").val());
        var ubicacion = $.trim($("#ubicacion").val());
      
        var obs = $.trim($("#obs").val());
       

      
        


        if (nom_her.length == 0 || cantidad.length == 0  ) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
           
            $.ajax({
                url: "bd/crudherramienta.php",
                type: "POST",
                dataType: "json",
                data: {   nom_her: nom_her, cantidad: cantidad, id: id, opcion: opcion, ubicacion: ubicacion, obs: obs },
                success: function(data) {
                    
                    id=data[0].id_her
                    nom_her = data[0].nom_her;
                    cantidad= data[0].cant_her;
                    ubicacion= data[0].ubi_her;
                    obs= data[0].obs_her;
                    if (opcion == 1) {
                        tablaVis.row.add([id, nom_her,  cantidad,ubicacion,obs,]).draw();
                    } else {
                        tablaVis.row(fila).data([id, nom_her,  cantidad,ubicacion,obs,]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});