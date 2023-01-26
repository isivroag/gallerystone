$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    var textcolumnas = permisos()
  
   
  
    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
  
      if (tipousuario == 5) {
        columnas =
          "<div class='text-center'>\
          <button class='btn btn-sm bg-gradient-green text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fa-solid fa-boxes-packing'></i></button>\
          <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
         </div>"
      } else {
        columnas =
          "<div class='text-center'>\
          <button class='btn btn-sm bg-gradient-green text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fa-solid fa-boxes-packing'></i></button>\
          <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
         </div>"
      }
      return columnas
    }
  
    tablaVis = $('#tablaV').DataTable({
      stateSave: true,
      orderCellsTop: true,
      fixedHeader: true,
      paging: false,
      ordering: false,
      searching:false,
     
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textcolumnas,
        },
        { className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [3] },
        { className: 'hide_column', targets: [5] },
        { className: 'text-right', targets: [9] },
        { className: 'text-right', targets: [10] },
        { className: 'text-right', targets: [11] },
        { className: 'text-right', targets: [12] },
        { className: 'text-right', targets: [13] },
        { className: 'text-right', targets: [14] },
        { className: 'text-right', targets: [15] },
        { className: 'text-right', targets: [16] },
        { className: 'text-right', targets: [17] },
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
  
    $('#btnNuevo').click(function () {
      //window.location.href = "prospecto.php";
      $('#formDatos').trigger('reset')
      $('.modal-header').css('background-color', '#28a745')
      $('.modal-header').css('color', 'white')
      $('.modal-title').text('Nuevo Material')
      $('#modalCRUD').modal('show')
      id = null
      opcion = 1 //alta
    })
  
  
  
 

    var fila //capturar la fila para editar o borrar el registro
  

  


  
    //MOVIMIENTOS
  
    $(document).on('click', '.btnMov', function () {
      fila = $(this).closest('tr')
      idreg = parseInt(fila.find('td:eq(0)').text())
      id = parseInt(fila.find('td:eq(1)').text())
      clave = fila.find('td:eq(2)').text()
      nombre = fila.find('td:eq(4)').text()
     
      largo = fila.find('td:eq(9)').text()
      alto = fila.find('td:eq(10)').text()
      ancho = fila.find('td:eq(11)').text()
      costo = fila.find('td:eq(8)').text()
      saldo = fila.find('td:eq(12)').text()
      nmaterial = fila.find('td:eq(7)').text()
  
  
      
      $('#idreg').val(idreg)
      $('#id').val(id)
      $('#nombrep').val(nombre)
      $('#costo').val(costo)
      $('#extact').val(saldo)
      $('#nmaterial').val(nmaterial)
      $('#largoact').val(largo)
      $('#altoact').val(alto)
      $('#anchoact').val(ancho)
      $('#claveact').val(clave)
  
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
      
      $('#modalMOV').modal('show')
    })
  
    $('#formMov').submit(function (e) {
      e.preventDefault()
      var idreg = $.trim($('#idreg').val())
      var folio=$('#foliocorte').val()
      
      
      var nalto = $('#alton').val()
      var nancho = $('#anchon').val()
      var nlargo = $('#largon').val()
      var m2=$('#extact').val()
      var nm2=$('#metrosn').val()
      dcosto=round((nm2-m2)*(costo/m2),2)
     
      usuario = $('#nameuser').val()
  
      if (idreg.length == 0 || folio.length == 0 ) {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos de la cuenta',
          icon: 'warning',
        })
        return false
      } else {
        
     
          
            //Advertir y preguntar
            swal
              .fire({
                title: 'Corte',
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
                    
                    console.log(nlargo)
                    console.log(nalto)
                    console.log(nancho)
                    console.log(nm2)
                    console.log(dcosto)
               
                  $.ajax({
                    url: 'bd/cortemat.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                      idreg: idreg,
                      nlargo: nlargo,
                      nalto: nalto,
                      nancho: nancho,
                      nm2: nm2,
                      dcosto: dcosto,
                    },
                    success: function (data) {
                      if (data == 1) {
                        Swal.fire({
                          title: 'Operación Exitosa',
                          text: 'Movimiento Guardado',
                          icon: 'success',
                        })
                        $('#modalMOV').modal('hide')
                        window.location.reload()
                      } else {
                        Swal.fire({
                          title: 'No fue posible concluir la operacion',
                          text: 'Movimiento No Guardado',
                          icon: 'error',
                        })
                      }
                    },
                  })
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
                }
              })
  
           
            } 
      
    })
  
    $(document).on('click', '.btnKardex', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
      window.location = 'cntamovp.php?id=' + id
    })
  
    $('#largon').on('change keyup paste click', function () {
      calculo()
    })
  
    $('#alton').on('change keyup paste click', function () {
      calculo()
    })
  
    function calculo() {
      alto = $('#alton').val()
      largo = $('#largon').val()
      if (parseFloat(alto) > 0 && parseFloat(largo) > 0) {
        metros = parseFloat(alto) * parseFloat(largo)
      } else {
        metros = 0
      }
  
      $('#metrosn').val(metros)
    }

    function round(value, decimals) {
      return Number(Math.round(value + "e" + decimals) + "e-" + decimals);
  }
  })
  