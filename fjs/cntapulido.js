$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,

          

          render: function (data, type, row){
            'use strict';
         
              return "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-regular fa-pen-to-square'></i></button>\
                </div>"
         
            
        }

        },
      
  
     
      {
          targets: 5,
          render: function (data, type, full, meta) {
            return "<div class='text-wrap width-200'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
          },
  
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
      stateSave: true,
      orderCellsTop: true,
      fixedHeader: true,
      paging: false,
  /*
      rowCallback: function (row, data) {
        $($(row).find('td')['8']).css('color', 'white')
        $($(row).find('td')['8']).addClass('text-center')
      
        if (data[8] == 'DESCARGA') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          //$($(row).find('td')[8]).addClass('bg-gradient-warning')
          $($(row).find('td')[8]).css('background-color','#810305');
          //$($(row).find('td')['8']).text('PENDIENTE')
        } else if (data[8] == 'PROTECCION') {
          //$($(row).find("td")[8]).css("background-color", "blue");
          //$($(row).find('td')[8]).addClass('bg-gradient-secondary')
          $($(row).find('td')[8]).css('background-color','#F7BEF9');
          //$($(row).find('td')['8']).text('ENVIADO')
        } else if (data[8] == 'COLOCADO') {
          //$($(row).find("td")[8]).css("background-color", "success");
          //$($(row).find('td')[8]).addClass('bg-lightblue')
          $($(row).find('td')[8]).css('background-color','#3581FD');
          //$($(row).find('td')['8']).text('ACEPTADO')
        }
        else if(data[8]=="LIMPIEZA") {
          //$($(row).find('td')[8]).addClass('bg-gradient-success')
          $($(row).find('td')[8]).css('background-color','#97B870');
        }
        else if(data[8]=="ENTREGA") {
            
          //$($(row).find('td')[8]).addClass('bg-gradient-primary')
          $($(row).find('td')[8]).css('background-color','#22AA0C');
          
        }
        else{
           $($(row).find('td')[8]).addClass('bg-gradient-orange')
           $($(row).find('td')[8]).text("INICIO")
        }
        
      },*/
 
    })


    tablapiezas = $('#tablapiezas').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'>\
            <button class='btn btn-sm bg-primary btncolocado' data-toggle='tooltip' data-placement='top' title='Colocado'><i class='fas fa-check-circle'></i></button>\
              </div>",
        },
        { className: "hide_column", targets: [0] },
        { className: "hide_column", targets: [1] },

    
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
      stateSave: true,
      orderCellsTop: true,
      fixedHeader: true,
      paging: false,
      scrollY:        "400px",
      scrollCollapse: true,
  
      rowCallback: function (row, data) {
  
        $($(row).find('td')['4']).css('color', 'white')
        $($(row).find('td')['4']).addClass('text-center')
      
        if (data[4] == 'ENSAMBLADO') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[4]).addClass('bg-gradient-warning')
          //$($(row).find('td')[4]).css('background-color','#EEA447');
          //$($(row).find('td')['4']).text('PENDIENTE')
        } else if (data[4] == 'PULIDO') {
          //$($(row).find("td")[4]).css("background-color", "blue");
          $($(row).find('td')[4]).addClass('bg-gradient-success')
          //$($(row).find('td')[2]).css('background-color','#0CBC09');
          //$($(row).find('td')['8']).text('ENVIADO')
        }
      },
    })
  
    var fila //capturar la fila para editar o borrar el registro
    
    //Boton Cambiar Fecha
    
    
    $(document).on('click','.btncolocado',function(){
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(0)').text())
     
      estado = fila.find('td:eq(4)').text()
    
      forden =fila.find('td:eq(1)').text()
      opcion=4
      usuario=$('#nameuser').val()

      descripcion='ENSAMBLE PIEZA: ' + fila.find('td:eq(2)').text()+' ' + fila.find('td:eq(3)').text()
    
      if (estado == "PULIDO"){
        Swal.fire({
          title: 'La pieza ya ha sido Pulida',
          icon: 'warning',
        })

      }else{
        $.ajax({
          type: "POST",
          url: "bd/estadopieza.php",
          dataType: "json",
          async:false,
          data: { id: id, forden: forden,opcion: opcion, usuario: usuario, descripcion: descripcion  },

          success: function(res) {
              if (res == 1){
                buscarpiezas(forden)
              }
              else if(res==2)
              {
                window.location.reload()
              }
          },
      });
      }

    })
    $(document).on('click','#etapa',function(){
   
      orden=$('#foliolorden').val()
      console.log(orden)
      var str = "";
      $( "select option:selected" ).each(function() {
        str += $( this ).text() ;
      });
      console.log(str)
      if (str == "COLOCACION"){
        $('#modalEtapa').modal('hide');
        buscarpiezas(orden)
      }

    })
  
    function buscarpiezas(folio) {
      tablapiezas.clear();
      tablapiezas.draw();
      $('#modalpiezas').modal('show')
    

      $.ajax({
          type: "POST",
          url: "bd/buscardetalleot.php",
          dataType: "json",
          data: { folio: folio },

          success: function(res) {
              for (var i = 0; i < res.length; i++) {
                tablapiezas.row.add([res[i].id_reg,res[i].id_ot, res[i].concepto,res[i].medida,res[i].estado,]).draw();

             
              }
          },
      });
  }

  //Modificar la Fecha de la Orden
    $(document).on('click', '#btnGuardarf', function (event) {
      event.preventDefault()
  
      folio = $('#folioordenf').val()
     
      fecha = $('#fechaf').val()
      
  
      if (folio.length == 0 ||  fecha.length == 0) {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos',
          icon: 'warning',
        })
        return false
      } else {
        $.ajax({
          url: 'bd/cambiarfecha.php',
          type: 'POST',
          dataType: 'json',
          data: {
            folio: folio,    
            fecha: fecha,
  
          },
          success: function (res) {
            if (res == 1) {
              $('#modalFecha').modal('hide')
              mensaje()
              window.location.href = 'cntaorden.php'
            } else {
              nomensaje()
            }
          },
        })
      }
    })
  
  
    $(document).on('click', '#btnGuardard', function (event) {
      event.preventDefault()
  
      folio = $('#folioordend').val()
     
      foliofis = $('#foliofis').val()
      
  
      
      if (folio.length == 0 ||  foliofis.length == 0) {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos',
          icon: 'warning',
        })
        return false
      } else {
        $.ajax({
          url: 'bd/cambiarfoliofis.php',
          type: 'POST',
          dataType: 'json',
          data: {
            folio: folio,    
            foliofis: foliofis,
  
          },
          success: function (res) {
            if (res == 1) {
              $('#modaldocumento').modal('hide')
              mensaje()
              window.location.href = 'cntaorden.php'
            } else {
              nomensaje()
            }
          },
        })
      }
    })
  
    //botón EDITAR
    $(document).on('click', '.btnVer', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(0)').text())
      buscarpiezas(folio)
     
  
    
    })
  
    
 
  
    $(document).on('click','#btnguardaestapa',function(){
      folio = $('#foliolorden').val();  
      estado = $('#etapa').val();
    /*  switch(estado){
        case 'DESCARGA':

        break;
        case 'PROTECCION':
            
        break;
        case 'DESCARGA':
            
        break;
        case 'INICIO':
            
        break;
        case 'PERFORACIONES':
            
        break;
        case 'ZOCLOS':
            
        break;
        case 'LAMBRIN':
            
        break;
        case 'LIMPIEZA':
            
        break;
        case 'ENTREGA':
            
        break;

      }*/
     
  
      $.ajax({
        url: 'bd/estadocolocacion.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
          estado: estado,

        },
        success: function (res) {
          if (res == 1) {
            mensaje()
            window.location.reload()
          } else {
            nomensaje()
          }
        },
      })
    })

    $(document).on('click', '.btnLiberar', function () {
        fila = $(this).closest('tr')
        folio = parseInt(fila.find('td:eq(0)').text())
        venta= parseInt(fila.find('td:eq(1)').text())
        
        
        folio = parseInt(fila.find('td:eq(0)').text());
        venta = parseInt(fila.find('td:eq(1)').text());
        
        $('#formOrden').trigger('reset');
    
        $('#modalOrden').modal('show');
        
        $('#fechal').val($('#fechasys').val());
        $('#foliolorden').val(folio);
        $('#foliolventa').val(venta);
      })
    
      $(document).on('click','#btngliberar',function(){
        folio = $('#foliolorden').val();
        venta= $('#foliolventa').val();
        
        
        fechalib=$('#fechal').val();
        estado = 'LIBERADO'
        porcentaje=100;
    
        $.ajax({
          url: 'bd/estadoorden.php',
          type: 'POST',
          dataType: 'json',
          data: {
            folio: folio,
            estado: estado,
            venta:venta,
            fechalib: fechalib,
            porcentaje: porcentaje
          },
          success: function (res) {
            if (res == 1) {
              mensaje()
              window.location.reload()
            } else {
              nomensaje()
            }
          },
        })
      })
  
    function mensaje() {
      swal.fire({
        title: 'Orden de Servicio Actualizada',
        icon: 'success',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
    function nomensaje() {
      swal.fire({
        title: 'No fue posible actualizar la Orden',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
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
  
  })
  