$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    var textcolumnas = permisos()

    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
     
      if (tipousuario == 5) {
        columnas =   "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm bg-gradient-orange text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fas fa-exchange-alt'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
        </div>"
      } else {
        columnas =    "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm bg-gradient-orange text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fas fa-exchange-alt'></i></button>\
        <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
        <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      }
      return columnas
    }
  
  
    tablaVis = $('#tablaV').DataTable({
         
        dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Inventario de Insumos',
          className: 'btn bg-success ',
          exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7, 8,9 ] },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Inventario de Insumos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 5, 6, 7, 8,9] },
        },
      ],
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textcolumnas,
        },
        { className: 'hide_column', targets: [4] },
        { className: 'text-right', targets: [5] },
        { className: 'text-right', targets: [6] },
        { className: 'text-right', targets: [7] },
        { className: 'text-right', targets: [8] },
        { className: 'text-right', targets: [9] },
        { className: 'hide_column', targets: [10] },
        { className: 'hide_column', targets: [11] },
        { className: 'text-right', targets: [12] },
        { className: 'hide_column', targets: [13] },
       
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

      rowCallback: function (row, data) {
       
        valor=parseFloat(data[5])
        min=parseFloat(data[12])
        if (valor == min) {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('PENDIENTE')
        } else if (valor < min) {
          //$($(row).find("td")[9]).css("background-color", "blue");
          $($(row).find('td')).addClass('bg-gradient-danger')
          //$($(row).find('td')['9']).text('ENVIADO')
        } else{
          $($(row).find('td')).removeClass('bg-gradient-warning')
          $($(row).find('td')).removeClass('bg-gradient-danger')
        }
      },
    })
  
    $('#btnNuevo').click(function () {
      //window.location.href = "prospecto.php";
      $('#formDatos').trigger('reset')
  
      $('.modal-header').css('color', 'white')
      $('.modal-title').text('Nuevo Insumo')
      $('#modalCRUD').modal('show')
      id = null
      opcion = 1 //alta
    })
  
    var fila //capturar la fila para editar o borrar el registro
  
    //botón EDITAR
    $(document).on('click', '.btnEditar', function () {
      fila = $(this).closest('tr')
      $('#formDatos').trigger('reset')
      id = parseInt(fila.find('td:eq(0)').text())
      clave = fila.find('td:eq(1)').text()
      id_umedida = fila.find('td:eq(4)').text()
      nom_cons = fila.find('td:eq(2)').text() //window.location.href = "actprospecto.php?id=" + id;
      cantidad = fila.find('td:eq(5)').text()
      usos = fila.find('td:eq(6)').text()
      totalusos = fila.find('td:eq(7)').text()
      ubicacion = fila.find('td:eq(8)').text()
      obs = fila.find('td:eq(9)').text()

      tarjeta=fila.find('td:eq(10)').text()
      valortarjeta=fila.find('td:eq(11)').text()
      cmin=fila.find('td:eq(12)').text()
      cmax=fila.find('td:eq(13)').text()

      if (tarjeta==0){
        $("#tarjeta").prop('checked', false);
        $("#valortarjeta").val(0)
        $('#valortarjeta').prop('disabled', true)
      }
      else{
        $("#tarjeta").prop('checked', true);
        $("#valortarjeta").val(valortarjeta)
        $('#valortarjeta').prop('disabled', true)
      }

      
      $('#iddes').val(id)
      $('#clave_des').val(clave)
      $('#umedida').val(id_umedida)
      $('#nom_cons').val(nom_cons)
      $('#cantidad').val(cantidad)
      $('#uso').val(usos)
      $('#totalusos').val(totalusos)
      $('#ubicacion').val(ubicacion)
      $('#obs').val(obs)
      $('#cmin').val(cmin)
      $('#cmax').val(cmax)

      opcion = 2 //editar
  
      $('.modal-header').css('color', 'white')
      $('.modal-title').text('Editar Insumo')
      $('#modalCRUD').modal('show')
    })
  
    //botón BORRAR
    $(document).on('click', '.btnBorrar', function () {
      fila = $(this)
  
      id = parseInt($(this).closest('tr').find('td:eq(0)').text())
      opcion = 3 //borrar
  
      //agregar codigo de sweatalert2
      var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')
  
      if (respuesta) {
        $.ajax({
          url: 'bd/cruddesechable.php',
          type: 'POST',
          dataType: 'json',
          data: { id: id, opcion: opcion },
  
          success: function (data) {
            tablaVis.row(fila.parents('tr')).remove().draw()
          },
        })
      }
    })
  
    $('#formDatos').submit(function (e) {
      e.preventDefault()
       

      var clave = $.trim($('#clave_des').val())
      var nom_cons = $.trim($('#nom_cons').val())
      var cantidad = $.trim($('#cantidad').val())
  
      var umedida = $.trim($('#umedida').val())
      var ubicacion = $.trim($('#ubicacion').val())
  
      var obs = $.trim($('#obs').val())
  
      var totalusos = $('#totalusos').val()

      var uso = $('#uso').val()
      if ($("#tarjeta").prop("checked")) {
        var tarjeta =1
      }
      else{
        var tarjeta =0
      }
     
      var valortarjeta = $('#valortarjeta').val()
      var cmin = $('#cmin').val()
      var cmax = $('#cmax').val()
  
  
      if (
        nom_cons.length == 0 ||
        umedida.length == 0 ||
        uso.length == 0 ||
        clave.length == 0 ||
        cantidad.length == 0 ||
        cmin.length == 0 ||
        cmax.length == 0
        
      ) {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Prospecto',
          icon: 'warning',
        })
        return false
      } else {
        $.ajax({
          url: 'bd/cruddesechable.php',
          type: 'POST',
          dataType: 'json',
          data: {
            umedida: umedida,
            clave: clave,
            nom_cons: nom_cons,
            cantidad: cantidad,
            id: id,
            opcion: opcion,
            ubicacion: ubicacion,
            obs: obs,
            uso: uso,
            tarjeta: tarjeta,
            valortarjeta: valortarjeta,
            totalusos: totalusos,
            cmin: cmin,
            cmax: cmax
         
          },
          success: function (data) {
            id = data[0].id_des
            clave = data[0].clave_des
            umedida = data[0].id_umedida
            nom_umedida = data[0].nom_umedida
            nom_cons = data[0].nom_des
            cantidad = data[0].cant_des
            ubicacion = data[0].ubi_des
            obs = data[0].obs_des
  
            uso = data[0].usos
            totalusos = data[0].totalusos

            tarjeta = data[0].tarjeta
            valortarjeta = data[0].valortarjeta
            cmin = data[0].minimo
            cmax = data[0].maximo
            
            if (opcion == 1) {
              tablaVis.row
                .add([
                  id,
                  clave,
                  nom_cons,
                  nom_umedida,
                  umedida,
                  cantidad,
                  uso,
                  totalusos,
                  ubicacion,
                  obs,
                  tarjeta,
                  valortarjeta,
                  cmin,
                  cmax,
                ])
                .draw()
            } else {
              tablaVis
                .row(fila)
                .data([
                  id,
                  clave,
                  nom_cons,
                  nom_umedida,
                  umedida,
                  cantidad,
                  uso,
                  totalusos,
                  ubicacion,
                  obs,
                  tarjeta,
                  valortarjeta,
                  cmin,
                  cmax,
                ])
                .draw()
            }
          },
        })
        $('#modalCRUD').modal('hide')
      }
    })
  
    //MOVIMIENTOS DE INVENTARIO CERRADO
  
    $(document).on('click', '.btnMov', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
  
      nombre = fila.find('td:eq(2)').text()
      saldo = fila.find('td:eq(5)').text()
  
      presentacion = fila.find('td:eq(6)').text()
      totalusomov = fila.find('td:eq(7)').text()
  
      $('#id').val(id)
      $('#nmaterial').val(nombre)
  
      $('#extact').val(saldo)
      $('#usomov').val(presentacion)
      $('#totalusomov').val(totalusomov)
  
      $('.modal-header').css('background-color', '#007bff')
      $('.modal-header').css('color', 'white')
      $('.modal-title').text('Movimiento de Inventario')
      $('#modalMOV').modal('show')
    })
  
  // GUARDAR MOVIMIENTO DE INVENTARIO
    $(document).on('click', '#btnGuardarM', function () {
    
      
      var id = $.trim($('#id').val())
      var descripcion = $('#descripcion').val()
      var tipomov = $.trim($('#tipomov').val())
      var saldo = $('#extact').val()
      var montomov = $('#montomov').val()
      var saldofin = 0
      var usuario = $('#nameuser').val()
  
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
              url: 'bd/crudmovimientodes.php',
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
                if (data == 1) {
                  Swal.fire({
                    title: 'Operación Exitosa',
                    text: 'Movimiento Guardado',
                    icon: 'success',
                  })
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
  
            break
          case 'Salida':
            saldofin = parseFloat(saldo) - parseFloat(montomov)
            $.ajax({
              url: 'bd/crudmovimientodes.php',
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
                if (data == 1) {
                  Swal.fire({
                    title: 'Operación Exitosa',
                    text: 'Movimiento Guardado',
                    icon: 'success',
                  })
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
                    url: 'bd/crudmovimientodes.php',
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
                      if (data == 1) {
                        Swal.fire({
                          title: 'Operación Exitosa',
                          text: 'Movimiento Guardado',
                          icon: 'success',
                        })
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
  
            break
        }
      }
    })
  
   
  
  

  
    $(document).on('click', '.btnKardex', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
      window.location = 'cntamovdes.php?id=' + id
    })
  
    $('#uso').on('change keyup paste click', function () {
      calculo()
    })
  
    $('#cantidad').on('change keyup paste click', function () {
      calculo()
    })

  

    $('#tarjeta').on('click', function () {
      if ($('#tarjeta').prop('checked')) {
        $('#valortarjeta').prop('disabled', true)
        $('#valortarjeta').val('1')
      } else {
        $('#valortarjeta').prop('disabled', true)
        $('#valortarjeta').val('0')
      }
      
    })

    function calculo() {
      uso = $('#uso').val()
      
  
      cantidad = $('#cantidad').val()
      
  
      
  
      totalusos = parseFloat(uso) * parseFloat(cantidad)
      
  
      
      $('#totalusos').val(totalusos)
    }
  
    function round(value, decimals) {
      return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals)
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
    return preg.test(__val__) === true
  }
  
