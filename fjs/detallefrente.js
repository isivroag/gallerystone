$(document).ready(function () {
    var id, opcion, fpago
  
 
  
    tablaD = $('#tablaD').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnEliminarcom'><i class='fas fa-trash'></i></button></div></div>",
        }, { className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [1] },
        { className: 'text-center', targets: [2] },
        { className: 'text-center', targets: [3] }
        
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
  


  
  


    function nomensaje() {
      swal.fire({
        title: 'No existen Inventario suficiente',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
  
    $(document).on('click', '.btnEliminarcom', function (event) {
     
      event.preventDefault();
  
      fila = $(this)
      id =  parseInt($(this).closest("tr").find("td:eq(0)").text());
      opcion=2;
  
      swal
      .fire({
          title: "Borrar",
          text: "¿Realmente desea borrar este elemento?",
  
          showCancelButton: true,
          icon: "warning",
          focusConfirm: true,
          confirmButtonText: "Aceptar",
  
          cancelButtonText: "Cancelar",
      })
      .then(function(isConfirm) {
          if (isConfirm.value) {
              $.ajax({
                  url: "bd/detallefrente.php",
                  type: "POST",
                  dataType: "json",
                  async: false,
                  data: { id: id, opcion: opcion },
                  success: function(data) {
                  
                      if (data == 1) {
                        
                          tablaD.row(fila.parents("tr")).remove().draw();
                          
                      }
                  },
              });
          } else if (isConfirm.dismiss === swal.DismissReason.cancel) {}
      });
    })
    $(document).on('click', '#btnAddcom', function ()  {
      //window.location.href = "prospecto.php";
      $('#formCom').trigger('reset')
     
      $('#modalCom').modal('show')
  
  })
  
    $(document).on('click', '#btnGuardarcom', function () {
      idconcepto=$('#concepto').val();
      frente=$('#idfrente').val();
      concepto=$('#concepto option:selected').text();
      cantidad=$('#cantcom').val();
      opcion=1;
       
      if (frente.length != 0 && cantidad.length != 0 && frente.length != 0 && idconcepto.length!=0 && concepto.length!=0) {
       
       
       
        $.ajax({
          type: 'POST',
          url: 'bd/detallefrente.php',
          dataType: 'json',
        
          data: {
            frente: frente,
            idconcepto: idconcepto,
            concepto: concepto,
            cantidad: cantidad,
            opcion: opcion,
          },
          success: function (data) {
            console.log(data);

            if (data==0){
                mensajeduplicado();
                return 0;
            }
            else{
                id_reg = data[0].id_reg
                idconcepto = data[0].id_concepto
                concepto = data[0].nom_concepto
                cantidad = data[0].cantidad
                tablaD.row
                  .add([
                    id_reg,
                    idconcepto,
                    concepto,
                    cantidad,
                    
                  ])
                  .draw()
                  $('#modalCom').modal('hide')
            }
           
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Complemento',
          icon: 'warning',
        })
        return false
      }
    })
  
  
  
    function mensajeduplicado() {
        swal.fire({
          title: 'El concepto ya se encuentra en la lista',
          icon: 'error',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
      }
  
  
    function limpiar() {
      $('#nombre').val('')
      $('#area').val('')
      $('#areacol').val('')
      $('#supervisor').val('')
      $('#colocador').val('')
    }
  
    function mensajeerror() {
      swal.fire({
        title: 'Operacion No exitosa',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  })
  