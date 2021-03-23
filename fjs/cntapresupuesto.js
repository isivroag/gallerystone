//falta hora y fecha de ejecucion de llamada
//falta que hacer cuando la llamada 3 es cerrada


$(document).ready(function () {
  var id, opcion
  opcion = 4

  tablaVis = $('#tablaV').DataTable({
    stateSave: true,
    info: false,
    //orderCellsTop: true,
    //fixedHeader: true,

    dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [
      {
        extend: 'excelHtml5',
        text: "<i class='fas fa-file-excel'> Excel</i>",
        titleAttr: 'Exportar a Excel',
        title: 'Reporte de Presupuestos',
        className: 'btn bg-success ',
        orthogonal: 'myExport',
        exportOptions: {
          columns: [ 1, 2, 3, 4, 5, 6, 7, 8,9],
          format: {
            body: function (data, row, column, node) {
              if (column === 5) {
                return data.replace(/[$,]/g, '')
              } else if (column === 8) {
                /*
                switch (data) {
                  case '0':
                    return data.replace(0, 'RECHAZADO')

                    break
                  case '1':
                    return data.replace('1', 'PENDIENTE')
                    break
                  case '2':
                    return data.replace('2', 'ENVIADO')
                    break
                  case '3':
                    return data.replace('3', 'ACEPTADO')
                    break
                  case '4':
                    return data.replace('4', 'EN ESPERA')
                    break
                  case '5':
                    return data.replace('5', 'EDITADO')
                    break
                }
                */
                return data
              } else if (column === 4 || column === 3) {
                x = data.replace("<div class='text-wrap width-200'>", '')
                x = x.replace('</div>', '')
                return x
              } else {
                return data
              }
            },
          },
        },
      },
      {
        extend: 'pdfHtml5',
        text: "<i class='far fa-file-pdf'> PDF</i>",
        titleAttr: 'Exportar a PDF',
        title: 'Reporte de Presupuestos',
        className: 'btn bg-danger',
        exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8,9] },
        footer: true,
        /*orthogonal: 'myExport',
        format: {
          body: function (data, row, column, node) {
            if (column === 8) {
              switch (data) {
                case '0':
                  return data.replace(0, 'RECHAZADO')

                  break
                case '1':
                  return data.replace('1', 'PENDIENTE')
                  break
                case '2':
                  return data.replace('2', 'ENVIADO')
                  break
                case '3':
                  return data.replace('3', 'ACEPTADO')
                  break
                case '4':
                  return data.replace('4', 'EN ESPERA')
                  break
                case '5':
                  return data.replace('5', 'EDITADO')
                  break
              }
            } else {
              return data
            }
          },
        },*/
      },
    ],

    columnDefs: [
      {
        targets:-1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>",
      },{
        targets:0,
        class: "details-control",
        orderable: false,
        data: null,
        defaultContent: ""
    },
      {
        targets: -2,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnLlamar'><i class='fas fa-phone'></i></button><button class='btn btn-sm bg-lightblue btnEnviar'><i class='fas fa-paper-plane text-light'></i></button><button class='btn btn-sm bg-orange  btnhistory'><i class='fas fa-history text-light'></i></button><button class='btn btn-sm btn-danger btnRechazar'><i class='fas fa-ban'></i></button></div></div>",
      },
      {
        targets: 4,
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
          //return "<div class='text-wrap width-200'>" + data + '</div>'
        },
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

    rowCallback: function (row, data) {
      $($(row).find('td')['9']).css('color', 'white')
      $($(row).find('td')['9']).addClass('text-center')
      $($(row).find('td')['8']).addClass('text-right')
      $($(row).find('td')['8']).addClass('currency')

      if (data[9] == 'PENDIENTE') {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find('td')[9]).addClass('bg-gradient-warning')
        //$($(row).find('td')['9']).text('PENDIENTE')
      } else if (data[9] == 'ENVIADO') {
        //$($(row).find("td")[9]).css("background-color", "blue");
        $($(row).find('td')[9]).addClass('bg-gradient-primary')
        //$($(row).find('td')['9']).text('ENVIADO')
      } else if (data[9] == 'ACEPTADO') {
        //$($(row).find("td")[9]).css("background-color", "success");
        $($(row).find('td')[9]).addClass('bg-gradient-success')
        //$($(row).find('td')['9']).text('ACEPTADO')
      } else if (data[9] == 'SEGUIMIENTO') {
        //$($(row).find("td")[9]).css("background-color", "purple");
        $($(row).find('td')[9]).addClass('bg-gradient-purple')
        //$($(row).find('td')['9']).text('EN ESPERA')
      } else if (data[9] == 'MODIFICADO') {
        //$($(row).find("td")[5]).css("background-color", "light-blue");
        $($(row).find('td')[9]).addClass('bg-lightblue')
        //$($(row).find('td')['9']).text('EDITADO')
      } else {
        //$($(row).find("td")[5]).css("background-color", "red");
        $($(row).find('td')[9]).addClass('bg-gradient-danger')
        //$($(row).find('td')['8']).text('RECHAZADO')
      }
    },

 
  })

  var detailRows = [];

    $('#tablaV tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = tablaVis.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);
        folio = parseInt($(this).closest("tr").find('td:eq(1)').text());


        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
        } else {
            tr.addClass('details');
            row.child(format(row.data(), folio)).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
        }
    });

    tablaVis.on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        })
    });

    function format(d, folio) {

        tabla = "";

        tabla = " <div class='container '><div class='row'>" +
            "<div class='col-lg-12'>" +
            "<div class='table-responsive'>" +
            "<table class='table table-sm table-striped  table-bordered table-condensed text-nowrap mx-auto ' style='width:100%'>" +
            "<thead class='text-center bg-white '>" +
            "<tr class='bg-white'>" +
            "<th>Id</th>" +
            "<th>Descripcion</th>" +
            "<th>Programada</th>" +
            "<th>Nota</th>" +
            "<th>Realizada</th>" +
            "<th>Respuesta</th>" +
            "</tr>" +
            "</thead>" +
            "<tbody>";

        $.ajax({

            url: "bd/detallellamadas.php",
            type: "POST",
            dataType: "json",
            data: { folio: folio },
            async: false,
            success: function(res) {
                
               
                for (var i = 0; i < res.length; i++) {
                  clase="";
                  console.log(parseInt(res[i].id_llamada));
                  switch(parseInt(res[i].id_llamada)){
                    case 1:
                      clase='class="bg1"';
                      break;
                    case 2:
                      clase='class="bg2"';
                      break;
                    case 3:
                      clase='class="bg3"';
                      break;
                  }

                    tabla += '<tr '+clase+'><td class="text-center">' + res[i].id_llamada + '</td><td class="text-center">' + res[i].desc_llamada + '</td><td class="text-center">' + res[i].fecha_llamada + '</td><td class=>' + res[i].nota_ant + '</td><td class="text-center">' + res[i].fecha_rea + '</td><td >' + res[i].nota_rea + '</td></tr>';
                }

            }
        });

        tabla += "</tbody>" +
            "</table>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

        return tabla;
    };

  $('#btnNuevo').click(function () {
    window.location.href = 'presupuesto.php'
    //$("#formDatos").trigger("reset");
    //$(".modal-header").css("background-color", "#28a745");
    //$(".modal-header").css("color", "white");
    //$(".modal-title").text("Nuevo Prospecto");
    //$("#modalCRUD").modal("show");
    //id = null;
    //opcion = 1; //alta
  })

  var fila //capturar la fila para editar o borrar el registro

  //BOTON EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(1)').text())

    window.location.href = 'pres.php?folio=' + id
  })
  //BOTON ENVIAR
  $(document).on('click', '.btnLlamar', function () {
    fila = $(this).closest('tr');
    folio = fila.find('td:eq(1)').text();
    estado = fila.find('td:eq(9)').text();
    //CONDICION PARA PRESUPUESTOS NUEVOS Y MODIFICADOS
    if (estado.trim() === 'PENDIENTE') {
      swal.fire({
          title: '<strong>EL ESTADO DEL PRESPUESTO SERA ACTUALIZADO</strong>',
          html:'El presupuesto será programado para realizar el seguimiento correspondiente.<br><b>¿Desea agregar un comentario o editar la informacion para seguimiento?</b>',
          customClass: 'swal-wide',
          showCancelButton: true,
          icon: 'question',
          focusConfirm: true,
          confirmButtonText: 'Editar Programación',

          cancelButtonText: 'Programación Automatica',
        }).then(function (isConfirm) {
          //GENERAR DATOS DEL FORMULARIO PARA PRIMERA LLAMADA
          if (isConfirm.value) {
            $.ajax({
              url: 'bd/buscarllamada.php',
              type: 'POST',
              dataType: 'json',
              data: {
                folio: folio,
              },
              success: function (data) {
                
                fecha_llamada = new Date();
                

                
                id_llamada = 0
                desc_llamada = ''
                
                for (var i = 0; i < data.length; i++) {
                  id_llamada = data[i].id_llamada;
                  desc_llamada = data[i].desc_llamada;
                 
                 
                }
                console.log(fecha_llamada);

                fecha = new Date()

                switch (parseInt(id_llamada)) {
                  case 0:
                    id_llamada = 1
                    desc_llamada = 'LLAMADA 1'
                    dias = 3
                   
                    //+3 dias
                    fecha.setDate(fecha_llamada.getDate() + dias)    
                    

                    break
                  case 1:
                    id_llamada = 2
                    desc_llamada = 'LLAMADA 2'
                    dias = 7
                    fecha.setDate(fecha_llamada.getDate() + dias)    
                    //7dias
                    break
                  case 2:
                    id_llamada = 3
                    desc_llamada = 'LLAMADA 3'
                    dias = 5
                    fecha.setDate(fecha_llamada.getDate() + dias)   
                    //+5dias
                    break
                  case 3:
                    //aceptar o cancelar
                    break
                }

                $('#formSegumiento').trigger('reset')
                $('#idllamada').val(id_llamada)
                $('#folio_pres').val(folio)
                $('#descllamada').val(desc_llamada)

                var mes = fecha.getMonth() + 1 //obteniendo mes
                var dia = fecha.getDate() //obteniendo dia
                var ano = fecha.getFullYear() //obteniendo año
                if (dia < 10) dia = '0' + dia //agrega cero si el menor de 10
                if (mes < 10) mes = '0' + mes //agrega cero si el menor de 10


                document.getElementById('fechallamada').value =ano + '-' + mes + '-' + dia
                $('#modalseguimiento').modal('show')
              }
            })
          } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
            //REGISTRO AUTOMATICO DE PRIMERA LLAMADA
            $.ajax({
              url: 'bd/buscarllamada.php',
              type: 'POST',
              dataType: 'json',
              data: {
                folio: folio,
              },
              success: function (data) {
                fecha_llamada = new Date()

                id_llamada = 0
                desc_llamada = ''

                for (var i = 0; i < data.length; i++) {
                  id_llamada = data[i].id_llamada
                  desc_llamada = data[i].desc_llamada
                 
                }
                fecha = new Date()
                switch (parseInt(id_llamada)) {
                  case 0:
                    id_llamada = 1
                    desc_llamada = 'LLAMADA 1'
                    dias = 3
                   
                    //+3 dias
                    fecha.setDate(fecha_llamada.getDate() + dias)
                    opcion = 1
                    break
                  case 1:
                    id_llamada = 2
                    desc_llamada = 'LLAMADA 2'
                    dias = 7
                    fecha.setDate(fecha_llamada.getDate() + dias)
                    opcion = 2
                    //7dias
                    break
                  case 2:
                    id_llamada = 3
                    desc_llamada = 'LLAMADA 3'
                    dias = 5
                    fecha.setDate(fecha_llamada.getDate() + dias)
                    opcion = 3
                    //+5dias
                    break
                  case 3:
                    //aceptar o cancelar
                    break
                }

                var mes = fecha.getMonth() + 1 //obteniendo mes
                var dia = fecha.getDate() //obteniendo dia
                var ano = fecha.getFullYear() //obteniendo año
                if (dia < 10) dia = '0' + dia //agrega cero si el menor de 10
                if (mes < 10) mes = '0' + mes //agrega cero si el menor de 10
                fecha_llamada = ano + '-' + mes + '-' + dia
                fecha = $('#fechasys').val()

                nota_ant = 'REGISTRO GENERADO POR EL SISTEMA'
                usuario = $('#nameuser').val()
                $.ajax({
                  url: 'bd/llamadaspres.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    folio: folio,
                    id_llamada: id_llamada,
                    desc_llamada: desc_llamada,
                    fecha_llamada: fecha_llamada,
                    nota_ant: nota_ant,
                    opcion: opcion,
                    usuario: usuario,
                    fecha: fecha,
                  },
                  success: function (data) {
                    switch (data) {
                      case 1:
                        swal.fire({
                          title: 'Se programo la llamada',

                          icon: 'success',
                          focusConfirm: true,
                          confirmButtonText: 'Aceptar',
                        })
                        break

                      case 2:
                        swal.fire({
                          title:
                            'Se programo la llamada, se actualizo el presupuesto',

                          icon: 'success',
                          focusConfirm: true,
                          confirmButtonText: 'Aceptar',
                        })
                        break
                      case 3:
                        swal.fire({
                          title:
                            'Se programo la llamada, se actualizo el presupuesto y se creo la nota',

                          icon: 'success',
                          focusConfirm: true,
                          confirmButtonText: 'Aceptar',
                        })
                        break
                    }
                  },
                })
              },
            })
          }
        })
    } 
    else if (estado.trim() === 'MODIFICADO' ||estado.trim() === 'SEGUIMIENTO' || estado.trim() === 'ENVIADO') {
      $.ajax({
        url: 'bd/buscarllamada.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
        },
        success: function (data) {
          fecha_llamada = new Date($('#fechasys').val());
          id_llamada = 0;
          desc_llamada ='';

          for (var i = 0; i < data.length; i++) {
            id_llamada = data[i].id_llamada
            desc_llamada = data[i].desc_llamada
            fecha_llamada = data[i].fecha_llamada
          }

          console.log(id_llamada);


          //TALVEZ SEA NECESARIO REVISAR SI LA LLAMADA FUE CERRADA
          if (id_llamada == 0) {
            swal.fire({
              title: '<strong>EL ESTADO DEL PRESPUESTO SERA ACTUALIZADO</strong>',
              html:'El presupuesto será programado para realizar el seguimiento correspondiente.<br><b>¿Desea agregar un comentario o editar la informacion para seguimiento?</b>',
              showCancelButton: true,
              customClass: 'swal-wide',
              icon: 'question',
              focusConfirm: true,
              confirmButtonText: 'Editar Programación',
              cancelButtonText: 'Programación Automatica',
            }).then(function (isConfirm) {
              //GENERAR DATOS DEL FORMULARIO PARA PRIMERA LLAMADA
              if (isConfirm.value) {
                    switch (parseInt(id_llamada)) {
                      case 0:
                        id_llamada = 1
                        desc_llamada = 'LLAMADA 1'
                        dias = 3
                        fecha = new Date()
                        //+3 dias
                        fecha.setDate(fecha_llamada.getDate() + dias)
    
                        break
                      case 1:
                        id_llamada = 2
                        desc_llamada = 'LLAMADA 2'
                        dias = 7
                        fecha.setDate(fecha_llamada.getDate() + dias)
                        //7dias
                        break
                      case 2:
                        id_llamada = 3
                        desc_llamada = 'LLAMADA 3'
                        dias = 5
                        fecha.setDate(fecha_llamada.getDate() + dias)
                        //+5dias
                        break
                      case 3:
                        //aceptar o cancelar
                        break
                    }
                    $('#formSegumiento').trigger('reset');
                    $('#idllamada').val(id_llamada);
                    $('#folio_pres').val(folio);
                    $('#descllamada').val(desc_llamada);
                    var mes = fecha.getMonth() + 1;//obteniendo mes
                    var dia = fecha.getDate(); //obteniendo dia
                    var ano = fecha.getFullYear(); //obteniendo año
                    if (dia < 10) dia = '0' + dia; //agrega cero si el menor de 10
                    if (mes < 10) mes = '0' + mes; //agrega cero si l menor de 10
                    document.getElementById('fechallamada').value =ano + '-' + mes + '-' + dia;
                    $('#modalseguimiento').modal('show');
              } 
              else if (isConfirm.dismiss === swal.DismissReason.cancel) 
              {
                //REGISTRO AUTOMATICO DE PRIMERA LLAMADA
                $.ajax({
                  url: 'bd/buscarllamada.php',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    folio: folio,
                  },
                  success: function (data) {
                    fecha_llamada = new Date($('#fechasys').val());
    
                    id_llamada = 0;
                    desc_llamada = '';
    
                    for (var i = 0; i < data.length; i++) {
                      id_llamada = data[i].id_llamada;
                      desc_llamada = data[i].desc_llamada;
                      fecha_llamada = data[i].fecha_llamada;
                    }
    
                    switch (parseInt(id_llamada)) {
                      case 0:
                        id_llamada = 1;
                        desc_llamada = 'LLAMADA 1';
                        dias = 3;
                        fecha = new Date();
                        //+3 dias
                        fecha.setDate(fecha_llamada.getDate() + dias);
                        opcion = 1;
                        break
                      case 1:
                        id_llamada = 2;
                        desc_llamada = 'LLAMADA 2';
                        dias = 7;
                        fecha.setDate(fecha_llamada.getDate() + dias);
                        opcion = 2;
                        //7dias
                        break
                      case 2:
                        id_llamada = 3;
                        desc_llamada = 'LLAMADA 3';
                        dias = 5;
                        fecha.setDate(fecha_llamada.getDate() + dias);
                        opcion = 3;
                        //+5dias
                        break
                      case 3:
                        //aceptar o cancelar
                        break
                    }
    
                    var mes = fecha.getMonth() + 1; //obteniendo mes
                    var dia = fecha.getDate(); //obteniendo dia
                    var ano = fecha.getFullYear(); //obteniendo año
                    if (dia < 10) dia = '0' + dia; //agrega cero si el menor de 10
                    if (mes < 10) mes = '0' + mes; //agrega cero si el menor de 10
                    fecha_llamada = ano + '-' + mes + '-' + dia;
                    fecha = $('#fechasys').val();
    
                    nota_ant = 'REGISTRO GENERADO POR EL SISTEMA';
                    usuario = $('#nameuser').val();
                    $.ajax({
                      url: 'bd/llamadaspres.php',
                      type: 'POST',
                      dataType: 'json',
                      data: {
                        folio: folio,
                        id_llamada: id_llamada,
                        desc_llamada: desc_llamada,
                        fecha_llamada: fecha_llamada,
                        nota_ant: nota_ant,
                        opcion: opcion,
                        usuario: usuario,
                        fecha: fecha,
                      },
                      success: function (data) {
                        switch (data) {
                          case 1:
                            swal.fire({
                              title: 'Se programo la llamada',
    
                              icon: 'success',
                              focusConfirm: true,
                              confirmButtonText: 'Aceptar',
                            })
                            break
    
                          case 2:
                            swal.fire({
                              title:
                                'Se programo la llamada, se actualizo el presupuesto',
    
                              icon: 'success',
                              focusConfirm: true,
                              confirmButtonText: 'Aceptar',
                            })
                            break
                          case 3:
                            swal.fire({
                              title:
                                'Se programo la llamada, se actualizo el presupuesto y se creo la nota',
    
                              icon: 'success',
                              focusConfirm: true,
                              confirmButtonText: 'Aceptar',
                            })
                            break
                        }
                        
                      window.location.reload();
                      }
                    })
                  }
                })
              }
            })}       
          else{
              swal.fire({
                title: 'El Presupuesto tiene registro de seguimiento',
                text: 'Es necesario cerrar la llamada anterior antes de continuar',
                icon: 'info',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
              }) .then(function (isConfirm) {
                if (isConfirm.value) {
                //traer formulario para cerrar la llamada correspondiente pero poner los datos en el nuevo formulario
                $('#formCierre').trigger('reset');
                $('#idllamadac').val(id_llamada);
                $('#folio_presc').val(folio);
                $('#descllamadac').val(desc_llamada);
                $('#fechallamadac').val($('#fechasys').val());
                $('#modalcierre').modal('show');
                }
              })
            }
        }
      });
          //si la llamada es 0 entonces hay que crear la llamada 1 y no es necesario poner nada en el registro de llamada
       
        }
      
 //EN CASO DE QUE EL PRESUPUESTO TENGA UN ESTADOS QUE NO SE PUEDA DAR SEGUIMIENTO 
    else {
      swal.fire({
        title: 'No es posible dar segumiento al presupuesto',
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  });

  $(document).on('click','#btnGllamada', function () {
   
    desc_llamada=$('#descllamada').val();
    id_llamada=$('#idllamada').val();
    folio=$('#folio_pres').val();
    desc_llamada=$('#descllamada').val();
    nota_ant=$('#notallamada').val();
    fecha_llamada=$('#fechallamada').val();
    opcion=id_llamada;
    fecha = $('#fechasys').val();
    usuario = $('#nameuser').val();

    $.ajax({
      url: 'bd/llamadaspres.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
                        id_llamada: id_llamada,
                        desc_llamada: desc_llamada,
                        fecha_llamada: fecha_llamada,
                        nota_ant: nota_ant,
                        opcion: opcion,
                        usuario: usuario,
                        fecha: fecha,
      },
      success: function (data) {
        switch (data) {
          case 1:
            swal.fire({
              title: 'Se programo la llamada',

              icon: 'success',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
            break

          case 2:
            swal.fire({
              title:
                'Se programo la llamada, se actualizo el presupuesto',

              icon: 'success',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
            break
          case 3:
            swal.fire({
              title:
                'Se programo la llamada, se actualizo el presupuesto y se creo la nota',

              icon: 'success',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
            break

            case 4:
              swal.fire({
                title:
                  'Se Cerro la llamada anterio, Se programo la llamada, se actualizo el presupuesto y se creo la nota',

                icon: 'success',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
              })
              break
        }
      
      window.location.reload();


      },
    })
  });

//BOTON CERRAR LLAMADA
  $(document).on('click','#btnGCierre', function () {

    
    id_llamada=$('#idllamadac').val();
    folio=$('#folio_presc').val();
    desc_llamada=$('#descllamadac').val();
    nota_ant=$('#notallamadac').val();
    fecha = $('#fechasys').val();
    usuario = $('#nameuser').val();

   
    $.ajax({
      url: 'bd/llamadascierre.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        id_llamada: id_llamada,
        nota_ant: nota_ant,
        usuario: usuario,
        desc_llamada:desc_llamada,
        fecha: fecha,
      },
      success: function (data) {
        Swal.fire({
          title: "Operación Exitosa",

          text: "Registro Guardado",
          icon: "success",
      });
      $.ajax({
        url: 'bd/buscarllamada.php',
        type: 'POST',
        dataType: 'json',
        data: {
          folio: folio,
        },
        success: function (data) {
          fecha_llamada = new Date();
          id_llamada = 0;
          desc_llamada ='';

          for (var i = 0; i < data.length; i++) {
            id_llamada = data[i].id_llamada;
            desc_llamada = data[i].desc_llamada;
            
          }


          swal.fire({
            title: '<strong>EL ESTADO DEL PRESPUESTO SERA ACTUALIZADO</strong>',
            html:'El presupuesto será programado para realizar el seguimiento correspondiente.<br><b>¿Desea agregar un comentario o editar la informacion para seguimiento?</b>',
            showCancelButton: true,
            customClass: 'swal-wide',
            icon: 'question',
            focusConfirm: true,
            confirmButtonText: 'Editar Programación',
            cancelButtonText: 'Programación Automatica',
          }).then(function (isConfirm) {
            //GENERAR DATOS DEL FORMULARIO PARA PRIMERA LLAMADA
            fecha=new Date();
            console.log(id_llamada);
            if (isConfirm.value) {
              fecha = new Date()
                  switch (parseInt(id_llamada)) {
                    case 0:
                      id_llamada = 1
                      desc_llamada = 'LLAMADA 1'
                      dias = 3
                      
                      //+3 dias
                      fecha.setDate(fecha_llamada.getDate() + dias)
    
                      break
                    case 1:
                      id_llamada = 2
                      desc_llamada = 'LLAMADA 2'
                      dias = 7
                      fecha.setDate(fecha_llamada.getDate() + dias)
                      //7dias
                      break
                    case 2:
                      id_llamada = 3
                      desc_llamada = 'LLAMADA 3'
                      dias = 5
                      fecha.setDate(fecha_llamada.getDate() + dias)
                      //+5dias
                      break
                    case 3:
                      //aceptar o cancelar
                      break
                  }
                  console.log(id_llamada);
                  $('#modalcierre').modal('hide');
                  
                  $('#formSegumiento').trigger('reset');
                  $('#idllamada').val(id_llamada);
                  $('#folio_pres').val(folio);
                  $('#descllamada').val(desc_llamada);
                  var mes = fecha.getMonth() + 1;//obteniendo mes
                  var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  if (dia < 10) dia = '0' + dia; //agrega cero si el menor de 10
                  if (mes < 10) mes = '0' + mes; //agrega cero si l menor de 10
                  document.getElementById('fechallamada').value =ano + '-' + mes + '-' + dia;
                  
                  $('#modalseguimiento').modal('show');
            } 
            else if (isConfirm.dismiss === swal.DismissReason.cancel) 
            {
              //REGISTRO AUTOMATICO DE PRIMERA LLAMADA
              $.ajax({
                url: 'bd/buscarllamada.php',
                type: 'POST',
                dataType: 'json',
                data: {
                  folio: folio,
                },
                success: function (data) {
                  fecha_llamada = new Date();
    
                  id_llamada = 0;
                  desc_llamada = '';
    
                  for (var i = 0; i < data.length; i++) {
                    id_llamada = data[i].id_llamada;
                    desc_llamada = data[i].desc_llamada;
                    fecha_llamada = data[i].fecha_llamada;
                   
                  }
                  fecha= new Date();
                  switch (parseInt(id_llamada)) {
                    case 0:
                      id_llamada = 1;
                      desc_llamada = 'LLAMADA 1';
                      dias = 3;
                     
                      //+3 dias
                      fecha.setDate(fecha_llamada.getDate() + dias);
                      opcion = 1;
                      break
                    case 1:
                      id_llamada = 2;
                      desc_llamada = 'LLAMADA 2';
                      dias = 7;
                      fecha.setDate(fecha_llamada.getDate() + dias);
                      opcion = 2;
                      //7dias
                      break
                    case 2:
                      id_llamada = 3;
                      desc_llamada = 'LLAMADA 3';
                      dias = 5;
                      fecha.setDate(fecha_llamada.getDate() + dias);
                      opcion = 3;
                      //+5dias
                      break
                    case 3:
                      //aceptar o cancelar
                      break
                  }
    
                  var mes = fecha.getMonth() + 1; //obteniendo mes
                  var dia = fecha.getDate(); //obteniendo dia
                  var ano = fecha.getFullYear(); //obteniendo año
                  if (dia < 10) dia = '0' + dia; //agrega cero si el menor de 10
                  if (mes < 10) mes = '0' + mes; //agrega cero si el menor de 10
                  fecha_llamada = ano + '-' + mes + '-' + dia;
                  fecha = $('#fechasys').val();
    
                  nota_ant = 'REGISTRO GENERADO POR EL SISTEMA';
                  usuario = $('#nameuser').val();
                  $.ajax({
                    url: 'bd/llamadaspres.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                      folio: folio,
                      id_llamada: id_llamada,
                      desc_llamada: desc_llamada,
                      fecha_llamada: fecha_llamada,
                      nota_ant: nota_ant,
                      opcion: opcion,
                      usuario: usuario,
                      fecha: fecha,
                    },
                    success: function (data) {
                      switch (data) {
                        case 1:
                          swal.fire({
                            title: 'Se programo la llamada',
    
                            icon: 'success',
                            focusConfirm: true,
                            confirmButtonText: 'Aceptar',
                          })
                          break
    
                        case 2:
                          swal.fire({
                            title:
                              'Se programo la llamada, se actualizo el presupuesto',
    
                            icon: 'success',
                            focusConfirm: true,
                            confirmButtonText: 'Aceptar',
                          })
                          break
                        case 3:
                          swal.fire({
                            title:
                              'Se programo la llamada, se actualizo el presupuesto y se creo la nota',
    
                            icon: 'success',
                            focusConfirm: true,
                            confirmButtonText: 'Aceptar',
                          })
                          break

                          case 4:
                            swal.fire({
                              title:
                                'Se Cerro la llamada anterio, Se programo la llamada, se actualizo el presupuesto y se creo la nota',
      
                              icon: 'success',
                              focusConfirm: true,
                              confirmButtonText: 'Aceptar',
                            })
                            break
                      }
                      
                    window.location.reload();
                    }
                  })
                }
              })
            }
          })
        }
      
      })
     
      
      },
    })

  });


  //BOTON RECHAZAR
  $(document).on('click', '.btnRechazar', function () {
    fila = $(this).closest('tr');
    id = parseInt(fila.find('td:eq(1)').text());
    estado=fila.find('td:eq(9)').text();
    console.log(estado.trim());
    if (estado.trim() !='ACEPTADO' && estado.trim() !='RECHAZADO')
    {
      $('#formllamada').trigger('reset')
  
      $('#modalcall').modal('show')
    }
    else{
      swal.fire({
        title: 'El Presupuesto NO peude ser marcado como RECHAZADO',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  });
//BOTON ENVIAR
  $(document).on('click', '.btnEnviar', function () {
    fila = $(this).closest('tr');
    id = parseInt(fila.find('td:eq(1)').text());
    estado = fila.find('td:eq(9)').text();

    if (estado.trim()=='PENDIENTE' || estado.trim()=='MODIFICADO'){
      swal.fire({
        title: 'El Presupuesto será marcado como ENVIADO',
        
        icon: 'info',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      }) .then(function (isConfirm) {
        if (isConfirm.value) {
          folio = id
          estado = 2;
          nota = "ENVIADO"
          fecha = $('#fechasys').val()
          usuario = $('#nameuser').val()
      
          $.ajax({
            type: 'POST',
            url: 'bd/estadopres.php',
            dataType: 'json',
      
            data: {
              folio: folio,
              usuario: usuario,
              estado: estado,
              nota: nota,
              fecha: fecha,
            },
            success: function () {

              swal.fire({
                title: 'El Presupuesto fue marcado como ENVIADO',
                
                icon: 'success',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
              })
              window.location.reload(true)
            },
          })

        
        }
      })

    }
    else{
      swal.fire({
        title: 'El Presupuesto NO puede ser marcado como ENVIADO',
        
        icon: 'warning',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
    
  });

  //BOTON HISTORIAL
  $(document).on('click', '.btnhistory', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(1)').text())
    window.location.href = 'verhistorialpres.php?folio=' + id
  })

  //botón BORRAR
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this).closest('tr')
    id = parseInt($(this).closest('tr').find('td:eq(1)').text())
    opcion = 3 //borrar
    //agregar codigo de sweatalert2
  
    Swal.fire({
      title: '¿Está seguro de eliminar el registro: ' + id + '?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Borrar'
    }).then(function (isConfirm) {
      if (isConfirm.value) {

        folio = id
      estado = 0
      nota = 'ELIMINACION'
      fecha = $('#fechasys').val()
      usuario = $('#nameuser').val()
      $.ajax({
        type: 'POST',
        url: 'bd/borrarpres.php',
        dataType: 'json',
        data: {
          folio: folio,
          usuario: usuario,
          estado: estado,
          nota: nota,
          fecha: fecha,
        },
        success: function (data) {
          if (data == 1) {
            Swal.fire(
              'Registro Borrado!',
              '',
              'success'
            )
            window.location.reload(true)
          }
        },
    })
        
      }
    })



    
 
  })

  function startTime() {
    var today = new Date()
    var hr = today.getHours()
    var min = today.getMinutes()
    var sec = today.getSeconds()
    //Add a zero in front of numbers<10
    min = checkTime(min)
    sec = checkTime(sec)
    document.getElementById('clock').innerHTML = hr + ' : ' + min + ' : ' + sec
    var time = setTimeout(function () {
      startTime()
    }, 500)
  }

  function checkTime(i) {
    if (i < 10) {
      i = '0' + i
    }
    return i
  }

  $('#formllamada').submit(function (e) {
    e.preventDefault()
    folio = id
    estado = $('#estado').val()
    nota = $('#nota').val()
    fecha = $('#fechasys').val()
    usuario = $('#nameuser').val()

    $.ajax({
      type: 'POST',
      url: 'bd/estadopres.php',
      dataType: 'json',

      data: {
        folio: folio,
        usuario: usuario,
        estado: estado,
        nota: nota,
        fecha: fecha,
      },
      success: function () {
        window.location.reload(true)
      },
    })
    $('#modalcall').modal('hide')
  })

  $('#btnBuscar').click(function () {
    var inicio = $('#inicio').val()
    var final = $('#final').val()

    if ($('#ctodos').prop('checked')) {
      opcion = 0
    } else {
      opcion = 1
    }

    tablaVis.clear()
    tablaVis.draw()

    console.log(opcion)

    if (inicio != '' && final != '') {
      $.ajax({
        type: 'POST',
        url: 'bd/buscarpresupuestos.php',
        dataType: 'json',
        data: { inicio: inicio, final: final, opcion: opcion },
        success: function (data) {
          for (var i = 0; i < data.length; i++) {
            estado = data[i].estado_pres
            total = data[i].gtotal

            tablaVis.row
              .add([
                ,
                data[i].folio_pres,
                data[i].fecha_pres,
                data[i].nombre,
                data[i].concepto_pres,
                data[i].ubicacion,
                data[i].vendedor,
                data[i].usuario,
                data[i].gtotal,

                data[i].estado_pres,
              ])
              .draw()

            //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
          }
        },
      })
    } else {
      alert('Selecciona ambas fechas')
    }
  })
})
