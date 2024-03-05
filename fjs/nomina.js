$(document).ready(function () {
  $(document).ajaxStart(function () {
    // Se ejecuta cuando comienza cualquier solicitud AJAX
    $("#div_carga").show();
  });
  $(document).ajaxStop(function () {
    // Se ejecuta cuando se completan todas las solicitudes AJAX
    $("#div_carga").hide();
  });
  jQuery.ajaxSetup({
    /*beforeSend: function () {
      $("#div_carga").show();
    },
    complete: function () {
      $("#div_carga").hide();
    },*/
    success: function () {},
  });

  var operacion = $('#opcion').val()

  var textopermiso = permisos()
  var textopermiso2 = permisos2()

  function permisos() {
    if (operacion==1) {
      columnas =
      "<div class='text-center'>\
      <button class='btn btn-sm btn-primary btnEditNom' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-hand-pointer'></i></button>\
      <button class='btn btn-sm btn-danger btnBorrarNom' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash'></i></button>\
    </div>"
    } else {
      columnas = ''
    }
    return columnas
  }

  function permisos2() {
    if (operacion==1) {
      columnas ="<div class='text-center'>\
      <button class='btn btn-sm btn-primary btnEditPer' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-search'></i></button>\
      <button class='btn btn-sm btn-danger btnBorrarPer' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash'></i></button>\
    </div>"
    } else {
      columnas = ''
    }
    return columnas
  }

  var id, opcion;
  opcion = 4;

  tablaPer = $("#tablaPer").DataTable({
    stateSave: false,
    paging: false,
    ordering: false,
    searching: false,
    info: false,
    autoWidth: false,
    responsive: true,
    processing: true,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'>\
              <button class='btn btn-sm btn-primary btnSelPer' data-toggle='tooltip' data-placement='top' title='Seleccionar'>\
              <i class='fas fa-hand-pointer'></i>\
              </button>\
          </div>",

        //
      },
    ],

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

  tablaOrd = $("#tablaOrd").DataTable({
    stateSave: false,
    paging: false,
    ordering: false,
    searching: false,
    info: false,
    autoWidth: false,
    responsive: true,
    processing: true,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'>\
              <button class='btn btn-sm btn-primary btnSelOrd' data-toggle='tooltip' data-placement='top' title='Seleccionar'><i class='fas fa-hand-pointer'></i></button>\
                </div>",

        //
      },
    ],

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
    rowCallback: function (row, data) {
      $($(row).find("td")["5"]).addClass("text-center");
      $($(row).find("td")["6"]).addClass("text-center");
      $($(row).find("td")["7"]).addClass("text-right");
      $($(row).find("td")["8"]).addClass("text-right");
      $($(row).find("td")["9"]).addClass("text-right");
      $($(row).find("td")["10"]).addClass("text-right");
      $($(row).find("td")["11"]).addClass("text-right");

      avance = data[5];

      estadoord = data[6];

      if (data[6] == "MEDICION") {
        //$($(row).find("td")[6]).css("background-color", "warning");
        $($(row).find("td")[6]).addClass("bg-gradient-warning");
        $($(row).find("td")[5]).addClass("bg-gradient-warning");
        //$($(row).find('td')['6']).text('PENDIENTE')
      } else if (data[6] == "CORTE") {
        //$($(row).find("td")[6]).css("background-color", "blue");
        $($(row).find("td")[6]).addClass("bg-gradient-secondary");
        $($(row).find("td")[5]).addClass("bg-gradient-secondary");
        //$($(row).find('td')['6']).text('ENVIADO')
      } else if (data[6] == "ENSAMBLE") {
        //$($(row).find("td")[6]).css("background-color", "success");
        $($(row).find("td")[6]).addClass("bg-lightblue");
        $($(row).find("td")[5]).addClass("bg-lightblue");
        //$($(row).find('td')['6']).text('ACEPTADO')
      } else if (data[6] == "PULIDO") {
        //$($(row).find("td")[6]).css("background-color", "purple");
        $($(row).find("td")[6]).addClass("bg-gradient-purple");
        $($(row).find("td")[5]).addClass("bg-gradient-purple");
        //$($(row).find('td')['6']).text('EN ESPERA')
      } else if (data[6] == "COLOCACION") {
        //$($(row).find("td")[6]).css("background-color", "light-blue");

        $($(row).find("td")[6]).addClass("bg-gradient-orange");
        $($(row).find("td")[5]).addClass("bg-gradient-orange");
        //$($(row).find('td')['6']).text('EDITADO')
      } else if (data[6] == "PROCESANDO") {
        //$($(row).find("td")[6]).css("background-color", "red");
        $($(row).find("td")[6]).addClass("bg-gradient-warning");
        $($(row).find("td")[5]).addClass("bg-gradient-warning");
        //$($(row).find('td')['6']).text('RECHAZADO')
      } else if (data[6] == "LIBERADO") {
        $($(row).find("td")[6]).addClass("bg-gradient-success");
        $($(row).find("td")[5]).addClass("bg-gradient-success");
      } else if (data[6] == "ACTIVO") {
        $($(row).find("td")[6]).addClass("bg-gradient-primary");
        $($(row).find("td")[5]).addClass("bg-gradient-primary");
      } else {
        if (avance == 90) {
          $($(row).find("td")[6]).addClass("bg-gradient-orange");
          $($(row).find("td")[5]).addClass("bg-gradient-orange");
          $($(row).find("td")[6]).text("COLOCACION");
        }
      }
    },
  });

  tablaNomper = $("#tablaNomper").DataTable({
    paging: false,
    ordering: false,
    searching: false,
    info: false,
    //scrollX: true,
    fixedHeader: true,

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:textopermiso2
         
      },
      { className: "hide_column", targets: [0, 1, 21] },
    ],

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
    rowCallback: function (row, data) {
      $($(row).find("td")["3"]).addClass("text-center");
      $($(row).find("td")["4"]).addClass("text-center");
      $($(row).find("td")["5"]).addClass("text-right");
      $($(row).find("td")["6"]).addClass("text-right");
      $($(row).find("td")["7"]).addClass("text-right");
      $($(row).find("td")["8"]).addClass("text-right");
      $($(row).find("td")["9"]).addClass("text-right");
      $($(row).find("td")["10"]).addClass("text-right");
      $($(row).find("td")["11"]).addClass("text-right");
      $($(row).find("td")["12"]).addClass("text-right");
      $($(row).find("td")["13"]).addClass("text-right");
      $($(row).find("td")["14"]).addClass("text-right");
      $($(row).find("td")["15"]).addClass("text-right");
      $($(row).find("td")["16"]).addClass("text-right");
      $($(row).find("td")["17"]).addClass("text-right");
      $($(row).find("td")["18"]).addClass("text-right");
      $($(row).find("td")["19"]).addClass("text-right");
      $($(row).find("td")["20"]).addClass("text-right");
    },
  });

  tablaNomord = $("#tablaNomord").DataTable({
    paging: false,
    ordering: false,
    searching: false,
    info: false,
    //scrollX: true,
    sScrollX: "100%",

    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:textopermiso
        ,
      },
      { targets: [0, 6], className: "hide_column" },
      {
        targets: 3,
        render: function (data, type, full, meta) {
            return "<div class='text-wrap width-200'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
        },
    },
    ],

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

    rowCallback: function (row, data) {
      $($(row).find("td")["4"]).addClass("text-center");
      $($(row).find("td")["5"]).addClass("text-center");
      $($(row).find("td")["7"]).addClass("text-right");
      $($(row).find("td")["8"]).addClass("text-right");
      $($(row).find("td")["9"]).addClass("text-right");
      $($(row).find("td")["10"]).addClass("text-right");
      $($(row).find("td")["11"]).addClass("text-right");

      $($(row).find("td")["12"]).addClass("text-right");

      avance = data[6];

      estadoord = data[5];

      if (data[5] == "MEDICION") {
        //$($(row).find("td")[5]).css("background-color", "warning");
        $($(row).find("td")[5]).addClass("bg-gradient-warning");

        //$($(row).find('td')['5']).text('PENDIENTE')
      } else if (data[5] == "CORTE") {
        //$($(row).find("td")[5]).css("background-color", "blue");
        $($(row).find("td")[5]).addClass("bg-gradient-secondary");

        //$($(row).find('td')['5']).text('ENVIADO')
      } else if (data[5] == "ENSAMBLE") {
        //$($(row).find("td")[5]).css("background-color", "success");
        $($(row).find("td")[5]).addClass("bg-lightblue");
        //$($(row).find('td')['5']).text('ACEPTADO')
      } else if (data[5] == "PULIDO") {
        //$($(row).find("td")[5]).css("background-color", "purple");
        $($(row).find("td")[5]).addClass("bg-gradient-purple");

        //$($(row).find('td')['5']).text('EN ESPERA')
      } else if (data[5] == "COLOCACION") {
        //$($(row).find("td")[5]).css("background-color", "light-blue");

        $($(row).find("td")[5]).addClass("bg-gradient-orange");

        //$($(row).find('td')['5']).text('EDITADO')
      } else if (data[5] == "PROCESANDO") {
        //$($(row).find("td")[5]).css("background-color", "red");
        $($(row).find("td")[5]).addClass("bg-gradient-warning");

        //$($(row).find('td')['5']).text('RECHAZADO')
      } else if (data[5] == "LIBERADO") {
        $($(row).find("td")[5]).addClass("bg-gradient-success");
      } else if (data[5] == "ACTIVO") {
        $($(row).find("td")[5]).addClass("bg-gradient-primary");
      } else {
        if (avance == 90) {
          $($(row).find("td")[5]).addClass("bg-gradient-orange");

          $($(row).find("td")[5]).text("COLOCACION");
        }
      }
    },

    //SUMA DE LA COLUMNA ML TOMADOS
  });

  tablaasi = $("#tablaasi").DataTable({
    searching: false,
    info: false,
    fixedHeader: true,
    paging: false,
    ordering: false,

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

  function calcular() {
    tablaNomper.clear();
    tablaNomper.draw();
    folio = $("#folio").val();
    extra=$("#extra").val();
    obs=$("#obs").val();
    retencion=$("#retencion2").val();
    retencionu = $("#retencionu").val();
    console.log(retencion)

    $.ajax({
      type: "POST",
      url: "bd/nomcalcular.php",
      dataType: "json",
      async: true,
      data: { folio: folio, extra: extra, obs: obs, retencion: retencion, retencionu: retencionu},
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaNomper.row
            .add([
              res[i].id_reg,
              res[i].id_per,
              res[i].nom_per,
              res[i].diasp,
              res[i].diast,
              res[i].salariodf,
              res[i].salariobf,
              res[i].descuentof,
              res[i].bonof,
              res[i].salariofijo,
              res[i].porcentaje,
              res[i].participacion,
              res[i].salariodd,
              res[i].sanciones,
              res[i].retardo,
              res[i].reparto,
              res[i].salariobd,
              res[i].descuentod,
              res[i].bonod,
              res[i].salariodestajo,
              res[i].salariototal,
              res[i].tipo,
            ])
            .draw();
        }
        buscarimportes();
        window.location.reload();
      },
      error: function () {
        swal.fire({
          title: "ERROR FUNCION",
          icon: "error",
          focusConfirm: true,
          confirmButtonText: "Aceptar",
        });
      },
    });
  }

  function buscarimportes() {
    $.ajax({
      type: "POST",
      url: "bd/buscarimportenom.php",
      dataType: "json",
      async: true,
      data: { folio: folio },
      success: function (res) {
        console.log(res);
       
        var eleimporte = document.getElementById("importeg");
        var eleretenido = document.getElementById("retencion");
        var elefijo = document.getElementById("fijog");
        var eleneto = document.getElementById("netog");

        eleimporte.value = res[0].importe;
        eleretenido.value = res[0].retenido;
        elefijo.value = res[0].fijo;
        eleneto.value = res[0].neto;
/*
        $("#importeg").val("");
        $("#retenido").val("");
        $("#fijog").val("");
        $("#netog").val("");
      
        $("#importeg").val(data[0].importe);
        $("#retenido").val(data[0].retenido);
        $("#fijog").val(data[0].fijo);
        $("#netog").val(data[0].neto);*/
      },
    
    });
  }

  var fila; //capturar la fila para editar o borrar el registro
  $("#btnCalcularnom").click(function (e) {
    e.preventDefault();
    calcular();
  });

  $("#bntGuardarNom").click(function () {
    folio=$("#folio").val();
    inicio = $("#periodoini").val();
    fin = $("#periodofin").val();
    

    $.ajax({
      type: "POST",
      url: "bd/nomguardar.php",
      dataType: "json",
      data: {folio:folio, inicio:inicio, fin:fin},
      success: function (res) {
       if (res!=0){
        window.location.href ="cntanomina.php";
       }
        }
      });
  })

  $("#btnVer").click(function () {
   

    $("#modalRet").modal("show");
  });

  $("#btnAgregarPer").click(function () {
    tablaPer.clear();
    tablaPer.draw();
    $.ajax({
      type: "POST",
      url: "bd/buscarpersonal.php",
      dataType: "json",
      data: {},
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaPer.row
            .add([res[i].id_per, res[i].nom_per, res[i].salariod])
            .draw();

          //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
        }
      },
    });

    $("#modalPer").modal("show");
  });
  $("#bntretencionu").click(function () {
    acumret=$('#acumret').val();
    usarret=$('#usarret').val();
    if(parseFloat(usarret) <= parseFloat(acumret)){
      $('#retencionu').val(usarret)
      $("#modalRet").modal("hide");

    }else{
      swal.fire({
        title: "El importe es mayor que las Retenciones Acumuladas",
        icon: "error",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
      });
    }
  })
  

  $("#btnAgregarOrd").click(function () {
    tablaOrd.clear();
    tablaOrd.draw();
    $.ajax({
      type: "POST",
      url: "bd/buscarorden.php",
      dataType: "json",
      data: {},
      success: function (res) {
        for (var i = 0; i < res.length; i++) {
          tablaOrd.row
            .add([
              res[i].folio_ord,
              res[i].folio_vta,

              res[i].nombre,
              res[i].concepto_vta,
              res[i].tipop,
              res[i].avance,
              res[i].edo_ord,
              res[i].mlfinal,
              res[i].gtotal,
              res[i].importenom,
              res[i].tnomina,
              res[i].nomtomado,
            ])
            .draw();

          //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
        }
      },
    });

    $("#modalOrd").modal("show");
  });

  $(document).on("click", ".btnBorrarNom", function (e) {
    e.preventDefault();
    fila = $(this);

    id = parseInt($(this).closest("tr").find("td:eq(0)").text());
    folio = $("#folio").val();
    importeorden = fila.find("td:eq(12)").text();
    importeorden = parseFloat(importeorden);

    opcion = 3;

    swal
      .fire({
        title: "ELIMINAR",
        text: "¿Desea eliminar el registro seleccionado?",
        showCancelButton: true,
        icon: "question",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#28B463",
        cancelButtonColor: "#d33",
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            type: "POST",
            url: "bd/nomorden.php",
            async: true,
            dataType: "json",

            data: {
              id: id,
              folio: folio,
              importeorden: importeorden,
              opcion: opcion,
            },
            success: function (res) {
              if (res == 1) {
                tablaNomord.row(fila.parents("tr")).remove().draw();
                calcular();
                /* $.ajax({
                  url: "bd/buscarimportenom.php",
                  type: "POST",
                  async: true,
                  data: { folio: folio },
                  success: function (data) {
                    console.log(data);
                    importenom = data[0].importe;
                    retenido = data[0].retenido;
                    fijo = data[0].fijo;
                    neto = data[0].neto;

                    //var myNumeral = numeral(importenom);
                    //var valor = myNumeral.format("0,0.00");

                    $("#importe").val(importenom);
                    $("#retenido").val(retenido);
                    $("#fijo").val(fijo);
                    $("#neto").val(neto);
                 
                  },
                  error: function (error) {
                    console.log(error);
                  },
                });*/
              }
            },
            error: function (error) {
              console.log(error);
            },
          });
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      });
  });

  $(document).on("click", ".btnBorrarPer", function (e) {
    e.preventDefault();
    fila = $(this);

    id = parseInt($(this).closest("tr").find("td:eq(0)").text());
    folio = $("#folio").val();

    opcion = 3;

    swal
      .fire({
        title: "ELIMINAR",
        text: "¿Desea eliminar el registro seleccionado?",
        showCancelButton: true,
        icon: "question",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#28B463",
        cancelButtonColor: "#d33",
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            type: "POST",
            url: "bd/nompersonal.php",
            async: true,
            dataType: "json",

            data: {
              id: id,
              folio: folio,
              opcion: opcion,
            },
            success: function (res) {
              tablaNomper.row(fila.parents("tr")).remove().draw();
              calcular();
              /* $.ajax({
                url: "bd/buscarimportenom.php",
                type: "POST",
                dataType: "json",
                async: true,
                data: { folio: folio },
                success: function (data) {
                  importenom = data[0].importe;
                  retenido = data[0].retenido;
                  fijo = data[0].fijo;
                  neto = data[0].neto;

                  //var myNumeral = numeral(importenom);
                  //var valor = myNumeral.format("0,0.00");

                  $("#importe").val(importenom);
                  $("#retenido").val(retenido);
                  $("#fijo").val(fijo);
                  $("#neto").val(neto);
                 
                },
                error: function (error) {
                  console.log(error);
                },
              });*/
              //window.location.reload();
            },
            error: function (error) {
              console.log(error);
            },
          });
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      });
  });

  $(document).on("click", ".btnSelPer1", function () {
    fila = $(this).closest("tr");

    $("#formCalculo").trigger("reset");
    $("#id_per").val(fila.find("td:eq(0)").text());
    $("#empleado").val(fila.find("td:eq(1)").text());
    $("#salariodf").val(fila.find("td:eq(2)").text());
    $("#modalPer").modal("hide");
    $("#modalCalculo").modal("show");
    opcion = 1;
  });

  $(document).on("click", ".btnSelPer", function () {
    fila = $(this).closest("tr");

    folio = $("#folio").val();
    id_per = fila.find("td:eq(0)").text();
    diasp = 0;
    diast = 0;
    salariodf = 0;
    salariobf = 0;
    descuentof = 0;
    bonof = 0;
    salariofijo = 0;
    porcentaje = 0;
    participacion = 0;
    salariodd = 0;
    sanciones = 0;
    salariobd = 0;
    descuentod = 0;
    bonod = 0;
    salariodestajo = 0;
    salariototal = 0;

    opcion = 1;

    $.ajax({
      url: "bd/nompersonal.php",
      type: "POST",
      dataType: "json",
      data: {
        opcion: opcion,
        folio: folio,
        id_per: id_per,
        diasp: diasp,
        diast: diast,
        salariodf: salariodf,
        salariobf: salariobf,
        descuentof: descuentof,
        bonof: bonof,
        salariofijo: salariofijo,
        porcentaje: porcentaje,
        participacion: participacion,
        salariodd: salariodd,
        sanciones: sanciones,
        salariobd: salariobd,
        descuentod: descuentod,
        bonod: bonod,
        salariodestajo: salariodestajo,
        salariototal: salariototal,
      },

      success: function (data) {
        //tablaPersonas.ajax.reload(null, false);
        if (data != 0) {
          window.location.reload();
        } else {
          swal.fire({
            title: "El personal ya se encuentra en la lista",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
          });
        }
      },
    });

    $("#modalPer").modal("hide");

    opcion = 1;
  });

  $(document).on("click", ".btnEditPer", function (e) {
    e.preventDefault();
    fila = $(this).closest("tr");

    $("#formCalculo").trigger("reset");
    $("#id_per").val(fila.find("td:eq(1)").text());
    $("#empleado").val(fila.find("td:eq(2)").text());
    $("#diasp").val(fila.find("td:eq(3)").text());
    $("#diast").val(fila.find("td:eq(4)").text());
    $("#salariodf").val(fila.find("td:eq(5)").text());
    $("#salariobf").val(fila.find("td:eq(6)").text());
    $("#descuentof").val(fila.find("td:eq(7)").text());
    $("#bonof").val(fila.find("td:eq(8)").text());
    $("#salariofijo").val(fila.find("td:eq(9)").text());
    $("#porcentaje").val(fila.find("td:eq(10)").text());
    $("#participacion").val(fila.find("td:eq(11)").text());
    $("#salariodd").val(fila.find("td:eq(12)").text());
    $("#sanciones").val(fila.find("td:eq(13)").text());
    $("#retardo").val(fila.find("td:eq(14)").text());
    $("#reparto").val(fila.find("td:eq(15)").text());
    $("#salariobd").val(fila.find("td:eq(16)").text());
    $("#descuentod").val(fila.find("td:eq(17)").text());
    $("#bonod").val(fila.find("td:eq(18)").text());
    $("#salariodestajo").val(fila.find("td:eq(19)").text());
    $("#salariototal").val(fila.find("td:eq(20)").text());
    tipoemp = fila.find("td:eq(21)").text();
    console.log(tipoemp);
    if (tipoemp == "DESTAJO") {
      var divd = document.getElementById("carddestajo");
      divd.style.display = "block";
      var divf = document.getElementById("cardfijo");
      divf.style.display = "none";
    } else {
      var divd = document.getElementById("carddestajo");
      divd.style.display = "none";
      var divf = document.getElementById("cardfijo");
      divf.style.display = "block";
    }

    opcion = 2;
    $("#modalCalculo").modal("show");
  });

  $(document).on("click", "#btnAddPer", function () {
    folio = $("#folio").val();
    id_per = $("#id_per").val();
    diasp = $("#diasp").val();
    diast = $("#diast").val();
    salariodf = $("#salariodf").val();
    salariobf = $("#salariobf").val();
    descuentof = $("#descuentof").val();
    bonof = $("#bonof").val();
    salariofijo = $("#salariofijo").val();
    porcentaje = $("#porcentaje").val();
    participacion = $("#participacion").val();
    salariodd = $("#salariodd").val();
    sanciones = $("#sanciones").val();
    retardo = $("#retardo").val();
    reparto = $("#reparto").val();
    salariobd = $("#salariobd").val();
    descuentod = $("#descuentod").val();
    bonod = $("#bonod").val();
    salariodestajo = $("#salariodestajo").val();
    salariototal = $("#salariototal").val();

    if (
      folio.length != 0 &&
      id_per.length != 0 &&
      diasp.length != 0 &&
      diast.length != 0 &&
      salariodf.length != 0 &&
      salariobf.length != 0 &&
      descuentof.length != 0 &&
      bonof.length != 0 &&
      salariofijo.length != 0 &&
      porcentaje.length != 0 &&
      participacion.length != 0 &&
      salariodd.length != 0 &&
      sanciones.length != 0 &&
      retardo.length != 0 &&
      reparto.length != 0 &&
      salariobd.length != 0 &&
      descuentod.length != 0 &&
      bonod.length != 0 &&
      salariodestajo.length != 0 &&
      salariototal.length != 0
    ) {
      $.ajax({
        url: "bd/nompersonal.php",
        type: "POST",
        dataType: "json",
        data: {
          opcion: opcion,
          folio: folio,
          id_per: id_per,
          diasp: diasp,
          diast: diast,
          salariodf: salariodf,
          salariobf: salariobf,
          descuentof: descuentof,
          bonof: bonof,
          salariofijo: salariofijo,
          porcentaje: porcentaje,
          participacion: participacion,
          salariodd: salariodd,
          sanciones: sanciones,
          retardo: retardo,
          reparto: reparto,
          salariobd: salariobd,
          descuentod: descuentod,
          bonod: bonod,
          salariodestajo: salariodestajo,
          salariototal: salariototal,
        },

        success: function (data) {
          //tablaPersonas.ajax.reload(null, false);
          reg = data[0].id_reg;
          id_per = data[0].id_per;
          personal = data[0].nom_per;
          diasp = data[0].diasp;
          diast = data[0].diast;
          salariodf = data[0].salariodf;
          salariobf = data[0].salariobf;
          descuentof = data[0].descuentof;
          bonof = data[0].bonof;
          salariofijo = data[0].salariofijo;
          porcentaje = data[0].porcentaje;
          participacion = data[0].participacion;
          salariodd = data[0].salariodd;
          sanciones = data[0].sanciones;
          retardo = data[0].retardo;
          reparto = data[0].reparto;
          salariobd = data[0].salariobd;
          descuentod = data[0].descuentod;
          bonod = data[0].bonod;
          salariodestajo = data[0].salariodestajo;
          salariototal = data[0].salariototal;
          tipoper = data[0].tipo;

          if (opcion == 1) {
            tablaNomper.row
              .add([
                reg,
                id_per,
                personal,
                diasp,
                diast,
                salariodf,
                salariobf,
                descuentof,
                bonof,
                salariofijo,
                porcentaje,
                participacion,
                salariodd,
                sanciones,
                retardo,
                reparto,
                salariobd,
                descuentod,
                bonod,
                salariodestajo,
                salariototal,
                tipoper,
              ])
              .draw();
          } else {
            tablaNomper
              .row(fila)
              .data([
                reg,
                id_per,
                personal,
                diasp,
                diast,
                salariodf,
                salariobf,
                descuentof,
                bonof,
                salariofijo,
                porcentaje,
                participacion,
                salariodd,
                sanciones,
                retardo,
                reparto,
                salariobd,
                descuentod,
                bonod,
                salariodestajo,
                salariototal,
                tipoper,
              ])
              .draw();
          }
          mensaje();
          $("#modalCalculo").modal("hide");
          calcular();
        },
      });
    } else {
      swal.fire({
        title: "Error",
        text: "Es necesario llenar todos los campos",
        icon: "warning",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
      });
    }
  });

  $(document).on("change", "#porcentajesug", function () {
    metros = $("#metros").val();
    importenom = $("#importenom").val();
    importetomado = $("#tnomina").val();
    porcentaje = $("#porcentajesug").val();
    mltomados= $("#mlnomord").val();
    console.log(metros, importenom, porcentaje);
    sugeridoml = round((porcentaje / 100) * (metros-mltomados),4);
    sugerido = round((porcentaje / 100) * (importenom-importetomado),4);
    $("#mlnom").val(sugeridoml);
    $("#importeorden").val(sugerido);
  });

  $(document).on("click", "#btnestablecer", function () {
    inicio = $("#periodoini").val();
    fin = $("#periodofin").val();
    folio = $("#folio").val();

    swal
      .fire({
        title: "¿Desea establecer el periodo de la nomina?",
        text: "Este proceso bloqueara las asistencias del periodo",
        icon: "question",
        focusConfirm: true,
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No",
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          $.ajax({
            url: "bd/nomperiodo.php",
            type: "POST",
            data: { folio: folio, inicio: inicio, fin: fin },
            success: function (response) {
              window.location.reload();
            },
            error: function (error) {
              // Manejar errores aquí
              console.error("Error en la llamada a AJAX:", error);
            },
          });
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
          console.log("El usuario eligió no establecer el periodo.");
        }
      });
  });

  $(document).on("click", ".btnSelOrd", function () {
    fila = $(this).closest("tr");
    folioord = fila.find("td:eq(0)").text();
    folio = $("#folio").val();
    valor = 2;
    console.log(folio);
    console.log(folioord);
    console.log(valor);

    $.ajax({
      url: "bd/nomorden.php",
      type: "POST",
      dataType: "json",
      data: {
        opcion: valor,
        folio: folio,
        folioord: folioord,
      },

      success: function (data) {
        console.log(data);
        if (parseInt(data) == 0) {
          $("#formOrdenes").trigger("reset");
          $("#folio_ord").val(fila.find("td:eq(0)").text());
          $("#folio_vta").val(fila.find("td:eq(1)").text());
          $("#metros").val(fila.find("td:eq(7)").text());
          metros = fila.find("td:eq(7)").text();
          $("#importevta").val(fila.find("td:eq(8)").text());
          $("#importenom").val(fila.find("td:eq(9)").text());
          importenom = fila.find("td:eq(9)").text();
          $("#tnomina").val(fila.find("td:eq(10)").text());
          $("#nomtomado").val(fila.find("td:eq(11)").text());
          //$("#nomtomado").val(fila.find("td:eq(12)").text());
          nomtomado = fila.find("td:eq(11)").text();
          nomtomado = nomtomado / 100;

          $("#edo_ord").val(fila.find("td:eq(6)").text());
          
          estado = fila.find("td:eq(6)").text();
          porcentaje = 0;
          switch (estado) {
            case "ENSAMBLE":
              porcentaje = 0.25;
              break;
            case "PULIDO":
              porcentaje = 0.5;
              break;
            case "COLOCACION":
              porcentaje = 0.75;
              break;
            case "LIBERADO":
              porcentaje = 1;
              break;
          }
          sugerido = porcentaje - nomtomado;
          var select = document.getElementById("porcentajesug");
          select.innerHTML = "";

          if (porcentaje * 100 > 0) {
            for (var i = nomtomado * 100; i <= porcentaje * 100; i += 25) {
              // Crear una opción
              var option = document.createElement("option");
              // Establecer el valor y texto de la opción
              option.value = i;
              option.text = i;
              // Agregar la opción al select
              select.appendChild(option);
            }
            select.remove(0);
          } else {
            swal.fire({
              title: "No fue posible tomar esta orden",
              icon: "error",
              focusConfirm: true,
              confirmButtonText: "Aceptar",
            });
            return;
          }

          $("#porcentajesug").val((sugerido+nomtomado) * 100);
          $("#importeorden").val(sugerido * importenom);
          $("#mlnomord").val(nomtomado*metros);
          $("#mlnom").val(sugerido * metros)-(nomtomado *metros);

          $("#modalOrd").modal("hide");
          $;
          $("#modalOrdenes").modal("show");
          opcion = 1;
        } else {
          swal.fire({
            title: "La orden ya se encuentra en la lista",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
          });
        }
      },
    });
  });

  $(document).on("click", "#btnAddOrd", function () {
    folio = $("#folio").val();
    folioord = $("#folio_ord").val();
    porcentaje = $("#porcentajesug").val();
    importeorden = $("#importeorden").val();
    mlnom = $("#mlnom").val();

    importenommina = 0;

    if (
      folio.length != 0 &&
      folioord.length != 0 &&
      porcentaje.length != 0 &&
      importeorden.length != 0 &&
      mlnom.length != 0
    ) {
      $.ajax({
        url: "bd/nomorden.php",
        type: "POST",
        dataType: "json",
        data: {
          opcion: opcion,
          folio: folio,
          folioord: folioord,
          porcentaje: porcentaje,
          mlnom: mlnom,
          importeorden: importeorden,
        },

        success: function (data) {
          //tablaPersonas.ajax.reload(null, false);
          reg = data[0].id_reg;
          folio_ord = data[0].folio_ord;
          nombre = data[0].nombre;
          concepto = data[0].concepto_vta;
          tipop = data[0].tipop;
          edo_ord = data[0].edo_ord;
          avance = data[0].avance;
          metros = data[0].metros;
          tnomina = data[0].tnomina;
          nomtomado = data[0].nomtomado;
          porcentaje = data[0].porcentaje;
          ml = data[0].ml;
          importeorden = data[0].importe;

          if (opcion == 1) {
            tablaNomord.row
              .add([
                reg,
                folio_ord,
                nombre,
                concepto,
                tipop,
                edo_ord,
                avance,
                metros,
                tnomina,
                nomtomado,
                porcentaje,
                ml,
                importeorden,
              ])
              .draw();
          } else {
            tablaNomord
              .row(fila)
              .data([
                reg,
                folio_ord,
                nombre,
                concepto,
                tipop,
                edo_ord,
                avance,
                metros,
                tnomina,
                nomtomado,
                porcentaje,
                ml,
                importeorden,
              ])
              .draw();
          }
          mensaje();
          $("#modalOrdenes").modal("hide");
          calcular();
          /*
          $.ajax({
            url: "bd/buscarimportenom.php",
            type: "POST",
            dataType: "json",
            async: true,
            data: { folio: folio },
            success: function (data) {
              importenom = data[0].importe;
              retenido = data[0].retenido;
              fijo = data[0].fijo;
              neto = data[0].neto;

              //var myNumeral = numeral(importenom);
              //var valor = myNumeral.format("0,0.00");

              $("#importe").val(importenom);
              $("#retenido").val(retenido);
              $("#fijo").val(fijo);
              $("#neto").val(neto);
            
            },
          });*/
        },
      });
    } else {
      swal.fire({
        title: "Error",
        text: "Es necesario llenar todos los campos",
        icon: "warning",
        focusConfirm: true,
        confirmButtonText: "Aceptar",
      });
    }
  });

 

  function mensaje() {
    swal.fire({
      title: "Nomina Actualizada",
      icon: "success",
      focusConfirm: true,
      confirmButtonText: "Aceptar",
    });
  }
  function nomensaje() {
    swal.fire({
      title: "No fue posible actualizar la Orden",
      icon: "error",
      focusConfirm: true,
      confirmButtonText: "Aceptar",
    });
  }
  function round(value, decimals) {
    return Number(Math.round(value + "e" + decimals) + "e-" + decimals);
}
});

function filterFloat(evt, input) {
  // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
  var key = window.Event ? evt.which : evt.keyCode;
  var chark = String.fromCharCode(key);
  var tempValue = input.value + chark;
  var isNumber = key >= 48 && key <= 57;
  var isSpecial = key == 8 || key == 13 || key == 0 || key == 46;
  if (isNumber || isSpecial) {
    return filter(tempValue);
  }

  return false;
}
function filter(__val__) {
  var preg = /^([0-9]+\.?[0-9]{0,2})$/;
  return preg.test(__val__) === true;
}
