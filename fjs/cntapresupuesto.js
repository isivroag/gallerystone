$(document).ready(function () {
  var id, opcion
  opcion = 4
  /*
  $('#tablaV thead tr').clone(true).appendTo( '#tablaV thead' );
    $('#tablaV thead tr:eq(1) th').each( function (i) {


        var title = $(this).text();


        $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
          
          if (i==6){
            switch(this.value){
              case 'rechazado':
              case 'Rechazado':
              case 'RECHAZADO':
                valbuscar="0";
              break;
              case 'pendiente':
              case 'Pendiente':
              case 'PENDIENTE':
                valbuscar="1";
              break;
              case 'enviado':
              case 'Enviado':
              case 'ENVIADO':
                  valbuscar="2";
                break;
              case 'aceptado':
              case 'Aceptado':
              case 'ACEPTADO':
                  valbuscar="3";
                break;
              case 'en espera':
              case 'En espera':
              case 'en Espera':
              case 'En Espera':
              case 'EN ESPERA':
              case 'Espera':
              case 'espera':
              case 'ESPERA':
                  valbuscar="4";
                break;
              case 'editado':
              case 'Editado':
              case 'EDITADO':
                valbuscar="5";
                break; 
              default:
                valbuscar="";
            }
            
            
          }else{
            valbuscar=this.value;

          }
          
            if ( tablaVis.column(i).search() !== valbuscar ) {
                tablaVis
                    .column(i)
                    .search( valbuscar,true,true )
                    .draw();
            }
        } );
    } );*/

  tablaVis = $('#tablaV').DataTable({
    stateSave: false,
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
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
        exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
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
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-success btnLlamar'><i class='fas fa-phone'></i></button><button class='btn btn-sm bg-lightblue btnEnviar'><i class='fas fa-paper-plane text-light'></i></button><button class='btn btn-sm bg-orange  btnhistory'><i class='fas fa-history text-light'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>",
      },
      {
        targets: 3,
        render: function (data, type, full, meta) {
          return "<div class='text-wrap width-200'>" + data + '</div>'
          //return "<div class='text-wrap width-200'>" + data + '</div>'
        },
      },
      {
        targets: 4,
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
      $($(row).find('td')['8']).css('color', 'white')
      $($(row).find('td')['8']).addClass('text-center')
      $($(row).find('td')['7']).addClass('text-right')
      $($(row).find('td')['7']).addClass('currency')

      if (data[8] == 'PENDIENTE') {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find('td')[8]).addClass('bg-gradient-warning')
        //$($(row).find('td')['8']).text('PENDIENTE')
      } else if (data[8] == 'ENVIADO') {
        //$($(row).find("td")[8]).css("background-color", "blue");
        $($(row).find('td')[8]).addClass('bg-gradient-primary')
        //$($(row).find('td')['8']).text('ENVIADO')
      } else if (data[8] == 'ACEPTADO') {
        //$($(row).find("td")[8]).css("background-color", "success");
        $($(row).find('td')[8]).addClass('bg-gradient-success')
        //$($(row).find('td')['8']).text('ACEPTADO')
      } else if (data[8] == 'SEGUIMIENTO') {
        //$($(row).find("td")[8]).css("background-color", "purple");
        $($(row).find('td')[8]).addClass('bg-gradient-purple')
        //$($(row).find('td')['8']).text('EN ESPERA')
      } else if (data[8] == 'MODIFICADO') {
        //$($(row).find("td")[5]).css("background-color", "light-blue");
        $($(row).find('td')[8]).addClass('bg-lightblue')
        //$($(row).find('td')['8']).text('EDITADO')
      } else {
        //$($(row).find("td")[5]).css("background-color", "red");
        $($(row).find('td')[8]).addClass('bg-gradient-danger')
        //$($(row).find('td')['8']).text('RECHAZADO')
      }
    },

    /*
    "initComplete": function () {
      var api = this.api();
      api.$('td').dblclick( function () {
        console.log(this);
          api.search( this.innerHTML ).draw();
      } );
  }*/
  })

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
    id = parseInt(fila.find('td:eq(0)').text())

    window.location.href = 'pres.php?folio=' + id
  })
  //BOTON ENVIAR
  $(document).on('click', '.btnEnviar', function () {
    fila = $(this).closest('tr');
    folio = fila.find('td:eq(0)').text();
    estado = fila.find('td:eq(8)').text();
    //CONDICION PARA PRESUPUESTOS NUEVOS Y MODIFICADOS
    if (estado.trim() === 'PENDIENTE') {
      swal.fire({
          title: '<strong>EL PRESUPUESTO SERA MARCADO COMO ENVIADO</strong>',
          html:
            'El presupuesto será programado para realizar el seguimiento correspondiente.<br><b>¿Desea agregar un comentario o editar la informacion para seguimiento?</b>',

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
                fecha_llamada = new Date($('#fechasys').val())

                id_llamada = 0
                desc_llamada = ''

                for (var i = 0; i < data.length; i++) {
                  id_llamada = data[i].id_llamada
                  desc_llamada = data[i].desc_llamada
                  fecha_llamada = data[i].fecha_llamada
                }

                switch (id_llamada) {
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

                $('#formSegumiento').trigger('reset')
                $('#idllamada').val(id_llamada)
                $('#folio_pres').val(folio)
                $('#descllamada').val(desc_llamada)

                var mes = fecha.getMonth() + 1 //obteniendo mes
                var dia = fecha.getDate() //obteniendo dia
                var ano = fecha.getFullYear() //obteniendo año
                if (dia < 10) dia = '0' + dia //agrega cero si el menor de 10
                if (mes < 10) mes = '0' + mes //agrega cero si el menor de 10
                document.getElementById('fechallamada').value =
                  ano + '-' + mes + '-' + dia
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
                fecha_llamada = new Date($('#fechasys').val())

                id_llamada = 0
                desc_llamada = ''

                for (var i = 0; i < data.length; i++) {
                  id_llamada = data[i].id_llamada
                  desc_llamada = data[i].desc_llamada
                  fecha_llamada = data[i].fecha_llamada
                }

                switch (id_llamada) {
                  case 0:
                    id_llamada = 1
                    desc_llamada = 'LLAMADA 1'
                    dias = 3
                    fecha = new Date()
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
    else if (estado.trim() === 'MODIFICADO' ||estado.trim() === 'SEGUIMIENTO') {
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
          if (id_llamada == 0) {
            swal.fire({
              title: '<strong>EL PRESUPUESTO SERA MARCADO COMO ENVIADO</strong>',
              html:'El presupuesto será programado para realizar el seguimiento correspondiente.<br><b>¿Desea agregar un comentario o editar la informacion para seguimiento?</b>',
              showCancelButton: true,
              icon: 'question',
              focusConfirm: true,
              confirmButtonText: 'Editar Programación',
              cancelButtonText: 'Programación Automatica',
            }).then(function (isConfirm) {
              //GENERAR DATOS DEL FORMULARIO PARA PRIMERA LLAMADA
              if (isConfirm.value) {
                    switch (id_llamada) {
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
    
                    switch (id_llamada) {
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
  })

  $(document).on('click', '.btnGuardarllamada', function () {
    $.ajax({
      url: 'bd/buscarllamada.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
      },
      success: function (data) {
        fecha_llamada = new Date($('#fechasys').val())

        id_llamada = 0
        desc_llamada = ''

        for (var i = 0; i < data.length; i++) {
          id_llamada = data[i].id_llamada
          desc_llamada = data[i].desc_llamada
          fecha_llamada = data[i].fecha_llamada
        }

        switch (id_llamada) {
          case 0:
            id_llamada = 1
            desc_llamada = 'LLAMADA 1'
            dias = 3
            fecha = new Date()
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
                  title: 'Se programo la llamada, se actualizo el presupuesto',

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
  })

  //BOTON LLAMAR
  $(document).on('click', '.btnLlamar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    $('#formllamada').trigger('reset')
    $('.modal-header').css('background-color', '#28a745')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Llamada de seguimiento')
    $('#modalcall').modal('show')
  })

  //BOTON HISTORIAL
  $(document).on('click', '.btnhistory', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    window.location.href = 'verhistorialpres.php?folio=' + id
  })

  //botón BORRAR
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this).closest('tr')
    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opcion = 3 //borrar
    //agregar codigo de sweatalert2
    var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')
    folio = id
    estado = 0
    nota = 'CANCELACIÓN'
    fecha = $('#fechasys').val()
    usuario = $('#nameuser').val()
    if (respuesta) {
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
        success: function (data) {
          if (data == 1) {
            window.location.reload(true)
          }
        },
      })
    }
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
