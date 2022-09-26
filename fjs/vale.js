$(document).ready(function() {

$('[data-toggle="tooltip"]').tooltip()

  var id, opcion;
  var operacion=$('#opcion').val();

  var textopermiso=permisos();

  function permisos() {
   
   
   
    if (operacion == 1) {
      columnas = "<div class='text-center'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        
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
      },],

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

  tablaOrden = $("#tablaOrden").DataTable({



    columnDefs: [{
        targets: -1,
        data: null,
        defaultContent: "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success bntSelOrden'><i class='fas fa-hand-pointer'></i></button></div></div>"
    }],

    //Para cambiar el lenguaje a español
    language: {
        lengthMenu: "Mostrar _MENU_ registros",
        zeroRecords: "No se encontraron resultados",
        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        infoFiltered: "(filtrado de un total de _MAX_ registros)",
        sSearch: "Buscar:",
        oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior"
        },
       sProcessing: "Procesando...",
    }
});

  


 //TABLA DETALLE DE desechables
 tablaDetIndes = $('#tablaDetIndes').DataTable({
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
    { className: 'text-center', targets: [4] },
    { className: 'text-center', targets: [5] },

   
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

  //TABLA DESECHABLE
  tablaDes = $('#tablaDes').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelDesechable'><i class='fas fa-hand-pointer'></i></button></div></div>",
        },
      
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
          sPrevious: 'Anterior'
        },
        sProcessing: 'Procesando...',
      },
    })

 


    tablaCaja=$('#tablaCaja').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><button class='btn btn-sm btn-success  btnSelcaja'><i class='fas fa-edit'></i></button>\
         </div>",
        },
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
  





  $(document).on("click", "#btnGuardar", function() {
      folio = $("#folio").val();
      fecha = $("#fecha").val();
     
      creador = $("#creador").val();
      receptor = $("#receptor").val();
      obs = $("#obs").val();
      orden=$("#folioord").val();
      opcion = 1

    


      if (creador.length != 0 && receptor.length !=0 && orden) {
          $.ajax({

              type: "POST",
              url: "bd/crudvale.php",
              dataType: "json",
              data: { fecha: fecha, folio: folio, creador: creador,orden: orden, receptor: receptor, 
                obs: obs,  opcion: opcion },
              success: function(res) {

                  if (res == 0) {
                      Swal.fire({
                          title: 'Error al Guardar',
                          text: "No se puedo guardar los datos",
                          icon: 'error',
                      })
                  } else {
                      Swal.fire({
                          title: 'Operación Exitosa',
                          text: "Vale Guardado",
                          icon: 'success',
                      })

                      window.setTimeout(function() {
                          window.location.href = "cntavale.php";
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

//BOTON BUSCAR DESECHABLE
$(document).on('click', '#btnInsumodes', function () {
 

  $('#modalDes').modal('show')
})



$(document).on('click', '#borden', function () {
 

  $('#modalOrden').modal('show')
})

$(document).on('click', '#btncaja', function () {
 

  $('#modalCaja').modal('show')
})


  


// SELECCIONAR  DESECHABLE
$(document).on('click', '.btnSelDesechable', function () {
  fila = $(this).closest('tr')
  idinsumo = fila.find('td:eq(0)').text()
  nominsumo = fila.find('td:eq(2)').text()
  clave = fila.find('td:eq(1)').text()
  cantidad = fila.find('td:eq(3)').text()

  /*
   */
  $('#idinsumodes').val(idinsumo)
   $('#insumodes').val(nominsumo)
   $('#clavedes').val(clave)
   $('#cantidaddisponible').val(cantidad)
   $('#costou').prop('disabled', false)
  $('#cantidadides').prop('disabled', false)

  $('#modalDes').modal('hide')
})


$(document).on('click', '.bntSelOrden', function () {
  fila = $(this).closest('tr')
  orden = fila.find('td:eq(0)').text()

   $('#folioord').val(orden)
 
  $('#modalOrden').modal('hide')
})

//BOTON LIMPIAR DESECHABLE
$(document).on('click', '#btlimpiarides', function () {
  limpiardes()
})



//AGREGAR DESECHABLE
$(document).on('click', '#btnagregarides', function () {
  folio = $('#folio').val()

  iddes = $('#idinsumodes').val()

  cantidadi = $('#cantidadides').val()

  
  
  usuario = $('#nameuser').val()
  opcion = 1


  if (folio.length != 0 && iddes.length != 0 && cantidadi.length != 0 ) {
    $.ajax({
      type: 'POST',
      url: 'bd/detallevale.php',
      dataType: 'json',
      //async: false,
      data: {
        folio: folio,
        iddes: iddes,
        cantidadi: cantidadi,
        opcion: opcion,
        usuario: usuario,
      
      },
      success: function (data) {
        
        id_reg = data[0].id_reg
        id_des = data[0].id_her
        clave_des = data[0].clave_her
        nom_des = data[0].nom_her
        cantidad = data[0].cantidad_her
        obs = data[0].obs
        

        tablaDetIndes.row
          .add([
            id_reg,
            id_des,
            clave_des,
            nom_des,
            cantidad,
            obs,
            
            
          ])
          .draw()
      
        limpiardes()
      },
    })
  } else {
    Swal.fire({
      title: 'Datos Faltantes',
      text: 'Debe ingresar todos los datos del Item',
      icon: 'warning',
    })
    return false
  }
})

//AGREGAR CAJA

$(document).on('click', '.btnSelcaja', function () {
  folio = $('#folio').val()
  fila = $(this).closest('tr')
  caja = fila.find('td:eq(0)').text()
  
 
  opc = 4


  if (folio.length != 0 && caja.length != 0) {
    $.ajax({
      type: 'POST',
      url: 'bd/buscarherramienta.php',
      dataType: 'json',
      //async: false,
      data: {
        folio: folio,
        caja: caja,
        opc: opc,
 
      },
      success: function (data) {
        
      window.location.reload()
      },
    })
  } else {
    Swal.fire({
      title: 'Datos Faltantes',
      text: 'Debe ingresar todos los datos del Item',
      icon: 'warning',
    })
    return false
  }
})




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

  function limpiardes() {
      $('#idinsumodes').val('')
      $('#insumodes').val('')
      
      $('#cantidadides').val('')
      $('#costou').val('')
      $('#costou').prop('disabled', true)
      $('#cantidadides').prop('disabled', true)
    }
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
    url: 'bd/detallevale.php',
    dataType: 'json',
    data: { id: id, opcion: tipooperacion },
    success: function (data) {
   
      if (data == 1) {
        tablaDetIndes.row(fila.parents('tr')).remove().draw();
                
           
        
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
