$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    var textcolumnas = permisos()

    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
     
      if (tipousuario == 5) {
        columnas = "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm bg-gradient-orange text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fas fa-exchange-alt'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
       </div>"
      } else {
        columnas =  "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm bg-gradient-orange text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fas fa-exchange-alt'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
        <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      }
      return columnas
    }

    tablaVis = $("#tablaV").DataTable({

        "columnDefs": [{
            targets: -1,
            data: null,
            defaultContent: textcolumnas,
        }, { className: "hide_column", "targets": [3] }, { className: "hide_column", "targets": [4] }],

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
        $(".modal-title").text("Nueva Herramienta");
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
        obs = fila.find('td:eq(6)').text();
        id_per = fila.find('td:eq(4)').text();
        nom_per = fila.find('td:eq(5)').text();

  
        $("#nom_her").val(hom_her);
        $("#cantidad").val(cantidad);
        $("#ubicacion").val(ubicacion);
        $("#responsable").val(id_per);
       
        $("#obs").val(obs);

        opcion = 2; //editar

       
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Herramienta");
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
        var responsable= $("#responsable").val();
      
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
                data: {   nom_her: nom_her, cantidad: cantidad, responsable: responsable, id: id, opcion: opcion, ubicacion: ubicacion, obs: obs },
                success: function(data) {
                    
                    id=data[0].id_her
                    nom_her = data[0].nom_her;
                    cantidad= data[0].cant_her;
                    ubicacion= data[0].ubi_her;
                    obs= data[0].obs_her;
                    obs= data[0].obs_her;
                    id_per= data[0].id_per;
                    nom_per= data[0].nom_per;
                    if (opcion == 1) {
                        tablaVis.row.add([id,nom_her,cantidad,ubicacion,id_per,nom_per,obs,]).draw();
                    } else {
                        tablaVis.row(fila).data([id,nom_her,cantidad,ubicacion,id_per,nom_per,obs,]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });



     //MOVIMIENTOS

  $(document).on('click', '.btnMov', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    nombre = fila.find('td:eq(1)').text()
    saldo = fila.find('td:eq(2)').text()
    

    

    $('#id').val(id)
    $('#nombrep').val(nombre)

    $('#extact').val(saldo)
    

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Movimiento de Inventario')
    $('#modalMOV').modal('show')
  })

  $('#formMov').submit(function (e) {
    e.preventDefault()
    var id = $.trim($('#id').val())
    var descripcion = $('#descripcion').val()
    var tipomov = $.trim($('#tipomov').val())
    var saldo = $('#extact').val()
    var montomov = $('#montomov').val()
    var saldofin = 0
    
    usuario = $('#nameuser').val()

    if (id.length == 0 || tipomov.length == 0 || montomov.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos de la cuenta',
        icon: 'warning',
      })
      return false
    } else {
      switch (tipomov) {
        case 'Entrada':
          saldofin = parseFloat(saldo) + parseFloat(montomov)
          $.ajax({
            url: 'bd/crudmovimientoher.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion,
              usuario: usuario
            },
            success: function (data) {
              if (data == 3) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
                $('#modalMOV').modal('hide')
                window.location.reload()
              } else {
                Swal.fire({
                  title: 'No fue posible cocluir la operacion',
                  text: 'Movimiento No Guardado',
                  icon: 'error',
                })
              }
            },
          })

          break
        case 'Salida':
          saldofin = parseFloat(saldo) - parseFloat(montomov)
          $.ajax({
            url: 'bd/crudmovimientoher.php',
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              tipomov: tipomov,
              saldo: saldo,
              saldofin: saldofin,
              montomov: montomov,
              descripcion: descripcion,
              usuario: usuario
            },
            success: function (data) {
              if (data == 3) {
                Swal.fire({
                  title: 'Operación Exitosa',
                  text: 'Movimiento Guardado',
                  icon: 'success',
                })
                window.location.reload()
                $('#modalMOV').modal('hide')
                window.location.reload()
              } else {
                Swal.fire({
                  title: 'No fue posible cocluir la operacion',
                  text: 'Movimiento No Guardado',
                  icon: 'error',
                })
              }
            },
          })
          break
        case 'Inventario Inicial':
          //Advertir y preguntar
          swal
            .fire({
              title: 'Inventario Inicial',
              text:
                'Este movimiento cambia las Existencias totales del Producto por la cantidad establecida sin importar los movimientos anteriores ¿Desea Continuar?',

              showCancelButton: true,
              icon: 'warning',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',

              cancelButtonText: 'Cancelar',
            })
            .then(function (isConfirm) {
              if (isConfirm.value) {
                saldofin = montomov

                $.ajax({
                  url: 'bd/crudmovimientoher.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    id: id,
                    tipomov: tipomov,
                    saldo: saldo,
                    saldofin: saldofin,
                    montomov: montomov,
                    descripcion: descripcion,
                    usuario: usuario
                  },
                  success: function (data) {
                    if (data == 3) {
                      Swal.fire({
                        title: 'Operación Exitosa',
                        text: 'Movimiento Guardado',
                        icon: 'success',
                      })
                      $('#modalMOV').modal('hide')
                      window.location.reload()
                    } else {
                      Swal.fire({
                        title: 'No fue posible cocluir la operacion',
                        text: 'Movimiento No Guardado',
                        icon: 'error',
                      })
                    }
                  },
                })
              } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
              }
            })

          break
      }
    }
  })

  $(document).on('click', '.btnKardex', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    window.location = 'cntamovh.php?id=' + id
  })
});