$(document).ready(function () {
    var id, opcion,foliocxp
    opcion = 4

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
                title: 'Reporte de Egresos',
                className: 'btn bg-success ',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] },
            },
            {
                extend: 'pdfHtml5',
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: 'Exportar a PDF',
                title: 'Reporte de Egresos',
                className: 'btn bg-danger',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] },
            },
        ],
        stateSave: true,

        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent:
                    "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm bg-purple  btnPagar'><i class='fas fa-dollar-sign'> </i></button><button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>",
            },
            {
                render: function (data, type, row) {
                    return commaSeparateNumber(data)
                },
                targets: [4, 5],
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

    tablaResumen = $("#tablaResumen").DataTable({
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
              sPrevious: "Anterior",
          },
          sProcessing: "Procesando...",
      },
  });
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2')
        }
        val = '$ ' + val
        return val
    }

    $('#btnAyuda').click(function () {
        var ancho = 1000
        var alto = 800
        var x = parseInt(window.screen.width / 2 - ancho / 2)
        var y = parseInt(window.screen.height / 2 - alto / 2)

        url = 'help/gscxp/'

        window.open(
            url,
            'AYUDA',
            'left=' +
            x +
            ',top=' +
            y +
            ',height=' +
            alto +
            ',width=' +
            ancho +
            'scrollbar=si,location=no,resizable=si,menubar=no',
        )
    })

    $('#btnBuscar').click(function () {
        var inicio = $('#inicio').val()
        var final = $('#final').val()
        console.log(inicio)
        console.log(final)
        tablaVis.clear()
        tablaVis.draw()

        if (inicio != '' && final != '') {
            $.ajax({
                type: 'POST',
                url: 'bd/buscarcxp.php',
                dataType: 'json',
                data: { inicio: inicio, final: final },
                success: function (data) {
                    console.log(data)
                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                data[i].folio_cxp,
                                data[i].fecha,
                                data[i].nombre,
                                data[i].concepto,
                                data[i].total,
                                data[i].saldo,
                                data[i].fecha_limite,
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

    $('#btnNuevo').click(function () {
        window.location.href = 'cxp.php'
        //$("#formDatos").trigger("reset");
        //$(".modal-header").css("background-color", "#28a745");
        //$(".modal-header").css("color", "white");
        //$(".modal-title").text("Nuevo Prospecto");
        //$("#modalCRUD").modal("show");
        //id = null;
        //opcion = 1; //alta
    })

    var fila //capturar la fila para editar o borrar el registro

    //botón EDITAR
    $(document).on('click', '.btnEditar', function () {
        fila = $(this).closest('tr')
        id = parseInt(fila.find('td:eq(0)').text())
        console.log(id)
        window.location.href = 'cxp.php?folio=' + id
    })

    $(document).on('click', '.btnPagar', function () {
        fila = $(this);

        folio = parseInt($(this).closest('tr').find('td:eq(0)').text());
        concepto=$(this).closest('tr').find('td:eq(3)').text()
        saldo = $(this).closest('tr').find('td:eq(5)').text();
        saldo=saldo.replace('$','');
        saldo=saldo.replace(',','');
        saldo=parseFloat(saldo);

        $('#foliovp').val(folio);
        $('#concepto').val(concepto);
        $('#obsvp').val('');
        $('#saldovp').val(saldo);
        $('#montpago').val('');
        $('#metodo').val('');

        $('.modal-header').css('background-color', '#007bff');
        $('.modal-header').css('color', 'white');
        $('#modalPago').modal('show');

      
    })

    //botón BORRAR
    $(document).on('click', '.btnBorrar', function () {
        fila = $(this)

        folio = parseInt($(this).closest('tr').find('td:eq(0)').text())
        opcion = 3 //borrar

        //agregar codigo de sweatalert2

        swal
            .fire({
                title: 'Egresos',
                text: '¿Desea eliminar el registro seleccionado?',
                showCancelButton: true,
                icon: 'question',
                focusConfirm: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#28B463',
                cancelButtonColor: '#d33',
            })
            .then(function (isConfirm) {
                if (isConfirm.value) {
                    $.ajax({
                        url: 'bd/crudcxp.php',
                        type: 'POST',
                        dataType: 'json',
                        data: { folio: folio, opcion: opcion },
                        success: function (data) {
                            tablaVis.row(fila.parents('tr')).remove().draw()
                        },
                    })
                } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
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
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        'formatted-num-pre': function (a) {
            a = a === '-' || a === '' ? 0 : a.replace(/[^\d\-\.]/g, '')
            return parseFloat(a)
        },

        'formatted-num-asc': function (a, b) {
            return a - b
        },

        'formatted-num-desc': function (a, b) {
            return b - a
        },
    })

    $(document).on('click', '#btnGuardarvp', function () {
         foliocxp = $('#foliovp').val()
        var fechavp = $('#fechavp').val()
        var conceptovp = $('#concepto').val()
        var obsvp = $('#obsvp').val()
        var saldovp = parseFloat($('#saldovp').val())
        var monto = $('#montopago').val()
        var metodo = $('#metodo').val()
        var usuario = $('#nameuser').val()
        var banco = $('#banco').val()
    
     
    
      
        if (
            foliocxp.length == 0 ||
          fechavp.length == 0 ||
          conceptovp.length == 0 ||
          monto.length == 0 ||
          metodo.length == 0 ||
          banco.length == 0 ||
          usuario.length == 0
        ) {
          swal.fire({
            title: 'Datos Incompletos',
            text: 'Verifique sus datos',
            icon: 'warning',
            focusConfirm: true,
            confirmButtonText: 'Aceptar',
          })
        } else {
          $.ajax({
            url: 'bd/buscarsaldocxp.php',
            type: 'POST',
            dataType: 'json',
            async: false,
            data: {
              foliocxp: foliocxp,
            },
            success: function (res) {
              saldovp = res;
              
            },
          })
    
          if (parseFloat(saldovp) < parseFloat(monto)) {
            swal.fire({
              title: 'Pago Excede el Saldo',
              text:
                'El pago no puede exceder el sado de la cuenta, Verifique el monto del Pago',
              icon: 'warning',
              focusConfirm: true,
              confirmButtonText: 'Aceptar',
            })
            $('#saldovp').val(saldovp)
           
          } else {
            saldofin = saldovp - monto;
            opcion = 1;
            console.log(foliocxp);
            console.log(fechavp);
            console.log(obsvp);
            console.log(monto);
            console.log(conceptovp);
            console.log(saldovp);
            console.log(monto);
            console.log(saldofin);
            console.log(metodo);
            console.log(usuario);
            console.log(banco);
            console.log(opcion);
            $.ajax({
              url: 'bd/pagocxp.php',
              type: 'POST',
              dataType: 'json',
              async: false,
              data: {
                foliocxp: foliocxp,
                fechavp: fechavp,
                obsvp: obsvp,
                conceptovp: conceptovp,
                saldovp: saldovp,
                monto: monto,
                saldofin: saldofin,
                metodo: metodo,
                usuario: usuario,
                banco: banco,
                opcion: opcion,
              },
              success: function (res) {
               // if (res == 2) {
                 console.log(res);
                 fpago=res;
                  buscartotal()
                  //Funcion para registrar el movimiento de ingreso en bancos
    
                  $('#modalPago').modal('hide')
               /* } else {
                  swal.fire({
                    title: 'Error',
                    text: 'La operacion no puedo completarse',
                    icon: 'warning',
                    focusConfirm: true,
                    confirmButtonText: 'Aceptar',
                  })
                }*/
              },
            })
          }
        }
      })

      function buscartotal() {
        folio = $('#foliovp').val()
        monto = $('#montopago').val()
        $.ajax({
          type: 'POST',
          url: 'bd/actualizarsaldocxp.php',
          dataType: 'json',
          data: { folio: folio, monto: monto },
          success: function (res) {
           
            mensajepago()
            window.location.reload();
            
          },
        })
      }

      function mensajepago() {
        swal.fire({
          title: 'Pago Guardado',
          icon: 'success',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
      }

      $(document).on("click", ".btnResumen", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());
        buscarpagos(id);
        $("#modalResumen").modal("show");


        //window.location.href = "presupuesto.php";
        //$("#formDatos").trigger("reset");
        //$(".modal-header").css("background-color", "#28a745");
        //$(".modal-header").css("color", "white");
        //$(".modal-title").text("Nuevo Prospecto");

        //id = null;
        //opcion = 1; //alta
    });

    function buscarpagos(folio) {
      tablaResumen.clear();
      tablaResumen.draw();

      $.ajax({
          type: "POST",
          url: "bd/buscarpagocxp.php",
          dataType: "json",

          data: { folio: folio },

          success: function(res) {
              for (var i = 0; i < res.length; i++) {
                  tablaResumen.row
                      .add([
                          res[i].folio_pagocxp,
                          res[i].fecha,
                          res[i].concepto,
                          res[i].monto,
                          res[i].metodo,
                      ])
                      .draw();

                  //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
              }
          },
      });
  }

})
