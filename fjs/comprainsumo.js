$(document).ready(function() {
    var id, opcion;



    var operacion=$('#opcion').val();

    var textopermiso=permisos();

    function permisos() {
     
     
     
      if (operacion == 1) {
        columnas =  "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
          
      } else {
        columnas =""
         
      }
      return columnas
    }




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


  //TABLA DETALLE DE INSUMOS
  tablaDetIn = $('#tablaDetIn').DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:textopermiso,
      },
      { className: 'hide_column', targets: [1] },
      { className: 'text-center', targets: [3] },
      { className: 'text-center', targets: [5] },
      { className: 'text-center', targets: [6] },
      { className: 'text-center', targets: [7] },
     
    ],

    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
  })

    //TABLA INSUMO
    tablaIns = $('#tablaIns').DataTable({
        columnDefs: [
          {
            targets: -1,
            data: null,
            defaultContent:
              "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelInsumo'><i class='fas fa-hand-pointer'></i></button></div></div>",
          },
          //{className: 'hide_column', targets: [5] }
         
        ],
    
        //Para cambiar el lenguaje a español
        language: {
          lengthMenu: 'Mostrar _MENU_ registros',
          zeroRecords: 'No se encontraron resultados',
          info:
            'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
          infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
          infoFiltered: '(filtrado de un total de _MAX_ registros)',
          sSearch: 'Buscar:',
          oPaginate: {
            sFirst: 'Primero',
            sLast: 'Último',
            sNext: 'Siguiente',
            sPrevious: 'Anterior',
          },
          sProcessing: 'Procesando...',
        },
      })
    

    $(document).on("click", "#bproveedor", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalProspecto").modal("show");

    });


    $(document).on("click", "#bproveedorplus", function() {

        window.location.href = "cntaproveedor.php";


    });


    $(document).on("click", "#bpartidaplus", function() {

        window.location.href = "cntapartida.php";

    });

    $("#btnAyuda").click(function() {
        var ancho = 1000;
        var alto = 800;
        var x = parseInt((window.screen.width / 2) - (ancho / 2));
        var y = parseInt((window.screen.height / 2) - (alto / 2));

        url = "help/gscxp/";

        window.open(url, "AYUDA", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");


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
                url: "bd/crudcxpinsumo.php",
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

//SELECCIONAR PARTIDA
    $(document).on("click", ".btnSelConcepto", function() {
        fila = $(this).closest("tr");
        idpartida = fila.find('td:eq(0)').text();
        partida = fila.find('td:eq(1)').text();
        $("#id_partida").val(idpartida);
        $("#partida").val(partida);
        $("#modalConcepto").modal("hide");

    });


//BOTON BUSCAR INSUMO
$(document).on('click', '#btnInsumo', function () {
    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')

    $('#modalIns').modal('show')
  })


 
//BOTON SELECCION INSUMO
$(document).on('click', '.btnSelInsumo', function () {
    fila = $(this).closest('tr')
    idinsumo = fila.find('td:eq(0)').text()
    nominsumo = fila.find('td:eq(1)').text()
    nomumedida = fila.find('td:eq(3)').text()
    cantidaddisin = fila.find('td:eq(4)').text()
    presentacionn = fila.find('td:eq(2)').text()
    costoant = fila.find('td:eq(5)').text()
    /*
     */
    $('#idinsumo').val(idinsumo)
  
    $('#insumo').val(nominsumo)
 
    $('#presentacion').val(presentacionn)
    $('#nom_umedidain').val(nomumedida)
 
    $('#cantidaddisi').val(cantidaddisin)
    $('#cantidadi').prop('disabled', false)
    $('#costou').prop('disabled', false)
    $('#costoant').val(costoant)
    $('#modalIns').modal('hide')
  })

  //BOTON LIMPIAR INSUMO
  $(document).on('click', '#btlimpiari', function () {
    limpiarin()
  })

  //AGREGAR INSUMO

  $(document).on('click', '#btnagregari', function () {
    folio = $('#folio').val()
    idcons = $('#idinsumo').val()
    cantidadi = $('#cantidadi').val()
    costo = $('#costou').val()
    subtotal=cantidadi*costo
    usuario = $('#nameuser').val()
    costoant=$('#costoant').val()
    opcion = 1
    actualizar=0

  

    if (folio.length != 0 && idcons.length != 0 && cantidadi.length != 0 && costo.length != 0) {
      
      if (costoant!=costo){
        swal
        .fire({
            title: "Costo",
            text: "El costo del insumo es diferente al registrado con anterioridad<br>,¿Desea Actualizarlo?",

            showCancelButton: true,
            icon: "warning",
            focusConfirm: true,
            confirmButtonText: "Si",
            cancelButtonText: "No",
        })
        .then(function(isConfirm) {
            if (isConfirm.value) {
             actualizar=1
             $.ajax({
              type: 'POST',
              url: 'bd/detallecxpinsumo.php',
              dataType: 'json',
              //async: false,
              data: {
                folio: folio,
                idcons: idcons,
                cantidadi: cantidadi,
                subtotal, subtotal,
                costo: costo,
                opcion: opcion,
                usuario: usuario,
                //ACTUALIZAR
                actualizar: actualizar,
              },
              success: function (data) {
               
                id_reg = data[0].id_reg
                id_cons = data[0].id_cons
                nom_cons = data[0].nom_cons
                presentacion=data[0].presentacion
                nom_umedida = data[0].nom_umedida
                cantidad = data[0].cant_cons
                costo = data[0].costo_cons
                subtotal = data[0].subtotal
      
                tablaDetIn.row
                  .add([
                    id_reg,
                    id_cons,
                    nom_cons,
                    presentacion,
                    nom_umedida,
                    cantidad,
                    costo,
                    subtotal,
                  ])
                  .draw()
                  tipo=2;
                  $.ajax({
                    url: "bd/sumadetalle.php",
                    type: "POST",
                    dataType: "json",
                    async: false,
                    data: { folio: folio, tipo: tipo },
                    success: function(data) {
                       total=data;
                       console.log(total)
                        $('#total').val(total)
                        calculoinverso(total)
                    }
                });
      
                limpiarin()
              },
            })
            } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
              $.ajax({
                type: 'POST',
                url: 'bd/detallecxpinsumo.php',
                dataType: 'json',
                //async: false,
                data: {
                  folio: folio,
                  idcons: idcons,
                  cantidadi: cantidadi,
                  subtotal, subtotal,
                  costo: costo,
                  opcion: opcion,
                  usuario: usuario,
                  //ACTUALIZAR
                  actualizar: actualizar,
                },
                success: function (data) {
                 
                  id_reg = data[0].id_reg
                  id_cons = data[0].id_cons
                  nom_cons = data[0].nom_cons
                  presentacion=data[0].presentacion
                  nom_umedida = data[0].nom_umedida
                  cantidad = data[0].cant_cons
                  costo = data[0].costo_cons
                  subtotal = data[0].subtotal
        
                  tablaDetIn.row
                    .add([
                      id_reg,
                      id_cons,
                      nom_cons,
                      presentacion,
                      nom_umedida,
                      cantidad,
                      costo,
                      subtotal,
                    ])
                    .draw()
                    tipo=2;
                    $.ajax({
                      url: "bd/sumadetalle.php",
                      type: "POST",
                      dataType: "json",
                      async: false,
                      data: { folio: folio, tipo: tipo },
                      success: function(data) {
                         total=data;
                         console.log(total)
                          $('#total').val(total)
                          calculoinverso(total)
                      }
                  });
        
                  limpiarin()
                },
              })
            }
        });
      }

     



    } else {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos del Item',
        icon: 'warning',
      })
      return false
    }
  })

  //LIMPIAR INSUMO
  function limpiarin() {
    $('#idinsumo').val('')
    $('#insumo').val('')
    $('#costoant').val('')
    $('#cantidadi').val('')
    $('#cantidaddisi').val('')
    
    $('#nom_umedidain').val('')
    $('#cantidadi').prop('disabled', true)

    $('#costou').val('')
    $('#presentacion').val('')
    $('#costou').prop('disabled', true)
  }
  
  
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



  // BORRAR MATERIAL
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this)
   
 
    id =  parseInt($(this).closest("tr").find('td:eq(0)').text());
    usuario = $('#nameuser').val()
   
    tipooperacion = 2

    $.ajax({
      type: 'POST',
      url: 'bd/detallecxpinsumo.php',
      dataType: 'json',
      data: { id: id, opcion: tipooperacion },
      success: function (data) {
     
        if (data == 1) {
            tablaDetIn.row(fila.parents('tr')).remove().draw()
            tipo=2;
            $.ajax({
              url: "bd/sumadetalle.php",
              type: "POST",
              dataType: "json",
              async: false,
              data: { folio: folio, tipo: tipo },
              success: function(data) {
                 total=data;
                 console.log(total)
                  $('#total').val(total)
                  calculoinverso(total)
              }
          });

        } else {
          mensajeerror()
        }
      },
    })
  })


  function mensajeerror() {
    swal.fire({
      title: 'Operacion No exitosa',
      icon: 'error',
      focusConfirm: true,
      confirmButtonText: 'Aceptar',
    })
  }

})



function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode
    var chark = String.fromCharCode(key)
    var tempValue = input.value + chark
    var isNumber = key >= 48 && key <= 57
    var isSpecial = key == 8 || key == 13 || key == 0 || key == 46
    if (isNumber || isSpecial) {
      return filter(tempValue)
    }
  
    return false
  }
  function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/
    return preg.te
    st(__val__) === true
  }