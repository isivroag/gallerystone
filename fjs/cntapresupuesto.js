$(document).ready(function () {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-success btnVender'><i class='fas fa-check-square'></i></button><button class='btn btn-sm btn-info btnLlamar'><i class='fas fa-phone'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
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

    $("#btnNuevo").click(function () {

        window.location.href = "presupuesto.php";
        //$("#formDatos").trigger("reset");
        //$(".modal-header").css("background-color", "#28a745");
        //$(".modal-header").css("color", "white");
        //$(".modal-title").text("Nuevo Prospecto");
        //$("#modalCRUD").modal("show");
        //id = null;
        //opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        console.log(id);
        window.location.href = "pres.php?folio=" + id;


    });

    $(document).on("click", ".btnLlamar", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        console.log(id);
        window.location.href = "pres.php?folio=" + id;


    });



    //botón BORRAR
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");



        if (respuesta) {
            $.ajax({

                url: "",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function (data) {
                    console.log(fila);

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function () { startTime() }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    $("#formDatos").submit(function (e) {
        e.preventDefault();
        var nombre = $.trim($("#nombre").val());
        var calle = $.trim($("#calle").val());
        var col = $.trim($("#col").val());
        var num = $.trim($("#num").val());
        var cp = $.trim($("#cp").val());
        var cd = $.trim($("#cd").val());
        var edo = $.trim($("#edo").val());
        var tel = $.trim($("#tel").val());
        var cel = $.trim($("#cel").val());

        if (nombre.length == 0 || calle.length == 0 || col.length == 0 ||
            num.length == 0 || cp.length == 0 || cd.length == 0 || edo.length == 0 ||
            tel.length == 0 || cel.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudpros.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre, calle: calle, num: num, col: col, cp: cp, cd: cd, edo: edo, tel: tel, cel: cel, id: id, opcion: opcion },
                success: function (data) {
                    console.log(data);
                    console.log(fila);

                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_pros;
                    nombre = data[0].nombre;
                    calle = data[0].calle;
                    num = data[0].num;
                    col = data[0].col;
                    cp = data[0].cp;
                    cd = data[0].cd;
                    edo = data[0].edo;
                    tel = data[0].tel;
                    cel = data[0].cel;
                    if (opcion == 1) {
                        tablaVis.row.add([id, nombre, calle, num, col, cp, cd, edo, tel, cel]).draw();
                    } else {
                        tablaVis.row(fila).data([id, nombre, calle, num, col, cp, cd, edo, tel, cel]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});