$(document).ready(function () {
  const MAXIMO_TAMANIO_BYTES = 12000000;
  var opcion;
 
  function extraer(texto) {
      

    // Expresión regular para extraer las variables
    var regex =/Desde Lado (\w+) CT: (.+?) DF: (.+)/;

    // Obtener coincidencias usando la expresión regular
    var matches = texto.match(regex);

    // Verificar si hay coincidencias
    if (matches) {
      // Asignar valores a las variables
       lado = matches[1];
       CT = matches[2];
       DF = matches[3];

      // Imprimir las variables
      console.log(lado);
      
      $("#lado2").val(lado);
      $("#medidacom21").val(CT);
      $("#medidacom22").val(DF);
    } else {
      console.log("No se encontraron coincidencias en el texto.");
    }
  }

  tablaVis = $("#tabladet").DataTable({
    paging: false,
    ordering: false,
    info: false,
    searching: false,

    columnDefs: [
      { className: "hide_column", targets: [0] },
      { className: "hide_column", targets: [3] },
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnMedida'><i class='fas fa-ruler'></i></button>\
          <button class='btn btn-sm btn-danger btnBorrardet'><i class='fas fa-trash-alt'></i></button>\
          </div></div>",
      },
    ],

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

  $(document).on("click", "#btnAddplano", function () {
    //window.location.href = "prospecto.php";
    $("#formMapa").trigger("reset");

    $("#modalMAPA").modal("show");
  });

  $(document).on("click", "#btnVer", function () {
    folio = $("#folioorden").val();
    var ancho = 1000;
    var alto = 800;
    var x = parseInt(window.screen.width / 2 - ancho / 2);
    var y = parseInt(window.screen.height / 2 - alto / 2);

    url = "formatos/pdforden.php?folio=" + folio;

    window.open(
      url,
      "Presupuesto",
      "left=" +
        x +
        ",top=" +
        y +
        ",height=" +
        alto +
        ",width=" +
        ancho +
        "scrollbar=si,location=no,resizable=si,menubar=no"
    );
  });

  $("#archivo").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

  $(document).on("click", "#btnGuardar", function () {
    orden = $("#folioorden").val();
    folio = orden;
    foliofis = $("#foliof").val();
    //material = $('#material').val()
    //moldura = $('#moldura').val()
    //zoclo = $('#zoclo').val()
    superficie = $("#superficie").val();
    tipo = $("#tipo").val();
    obs = $("#obs").val();
    idot = $("#idot").val();
    usuario = $("#nameuser").val();
    opcion = 1;
    $.ajax({
      url: "bd/crudot.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        orden: orden,
        foliofis: foliofis,
        // material: material,
        // moldura: moldura,
        // zoclo: zoclo,
        superficie: superficie,
        tipo: tipo,
        obs: obs,
        idot: idot,
        opcion: opcion,
        usuario: usuario,
      },
      success: function (data) {
        if (data == 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          estado = "CORTE";
          porcentaje = 5;

          $.ajax({
            url: "bd/estadoorden.php",
            type: "POST",
            dataType: "json",
            data: {
              folio: folio,
              estado: estado,
              usuario: usuario,
              porcentaje: porcentaje,
            },
            success: function (res) {
              if (res == 1) {
                window.location.href = "cntaorden.php";
              } else {
                Swal.fire({
                  title: "Registro No actualizado",
                  text: "La orden de Trabajo no ha sido actualizada",
                  icon: "error",
                });
              }
            },
          });
        }
      },
    });
  });

  $(document).on("click", "#upload", function () {
    orden = $("#folioorden").val();
    var formData = new FormData();
    var files = $("#archivo")[0].files[0];

    if (files.size > MAXIMO_TAMANIO_BYTES) {
      const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;

      Swal.fire({
        title: "El tamaño del archivo es muy grande",
        text: "El archivo no puede exceder los " + tamanioEnMb + "MB",
        icon: "warning",
      });
      // Limpiar
      $("#archivo").val();
    } else {
      formData.append("file", files);
      formData.append("orden", orden);
      $.ajax({
        url: "bd/uploadot.php",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response != 0) {
            Swal.fire({
              title: "Imagen Guardada",
              text: "Se anexo el documento a la Orden",
              icon: "success",
            });
            $("#modalMAPA").modal("hide");
            window.location.href = "ot.php?folio=" + orden;
            //respuesta exitosa
          } else {
            //swal incorrecto
            Swal.fire({
              title: "Formato de Imagen Incorrecto",
              text: "El archivo no es una imagen ",
              icon: "warning",
            });
          }
        },
      });
    }

    return false;
  });

  $(document).on("click", "#btnadetalle", function () {
    //window.location.href = "prospecto.php";
    $("#formCom").trigger("reset");

    $("#modalCom").modal("show");
    $(".tipoc").val("0");
  });
  $(document).on("click", "#btnadetallelam", function () {
    $("#formmed1").trigger("reset");

    $("#modalmed1").modal("show");
    $(".tipoc").val("1");
    opcion = 1;
  });
  $(document).on("click", "#btnadetalletar", function () {
    $("#formmed2").trigger("reset");

    $("#modalmed2").modal("show");
    $(".tipoc").val("2");
    opcion = 1;
  });
  $(document).on("click", "#btnadetalleesc", function () {
    $("#formmed3").trigger("reset");

    $("#modalmed3").modal("show");
    $(".tipoc").val("3");
    opcion = 1;
  });
  $(document).on("click", "#btnadetalleest", function () {
    $("#formmed4").trigger("reset");

    $("#modalmed4").modal("show");
    $(".tipoc").val("4");
    opcion = 1;
  });

  $(document).on("click", ".btnMedida", function (event) {
    event.preventDefault();
    fila = $(this).closest("tr");

    id = fila.find("td:eq(0)").text();
    concepto = fila.find("td:eq(1)").text();
    medida = fila.find("td:eq(2)").text();
    tipoc = parseInt(fila.find("td:eq(3)").text());

    opcion = 2;
    // switch para abrir el formulario correspondiente
    console.log(tipoc);
    switch (tipoc) {
      case 0:
        $("#formmed").trigger("reset");
        $(".idreg").val(id);
        $(".concepto").val(concepto);
        $(".medidacom").val(medida);
        $(".tipoc").val(tipoc);
        $("#modalmed").modal("show");
        break;
      case 1:
        $("#formmed1").trigger("reset");
        $(".idreg").val(id);
        $(".concepto").val(concepto);
        $(".medidacom").val(medida);
        $(".tipoc").val(tipoc);
        $("#modalmed1").modal("show");
        break;
      case 2:
        $("#formmed2").trigger("reset");
        $(".idreg").val(id);
        extraer(medida);
        $(".concepto").val(concepto);
       
        $(".tipoc").val(tipoc);
       

        $("#modalmed2").modal("show");
        break;
      case 3:
        $("#formmed3").trigger("reset");
        $(".idreg").val(id);
        $(".concepto").val(concepto);
        $(".medidacom").val(medida);
        $(".tipoc").val(tipoc);
        $("#modalmed3").modal("show");
        break;
      case 4:
        $("#formmed4").trigger("reset");
        $(".idreg").val(id);
        $(".concepto").val(concepto);
        $(".medidacom").val(medida);
        $(".tipoc").val(tipoc);
        $("#modalmed4").modal("show");
        break;
    }
  });

  $(document).on("click", ".btnBorrardet", function (event) {
    event.preventDefault();
    fila = $(this).closest("tr");

    id = fila.find("td:eq(0)").text();
    opcion = 3;
    $.ajax({
      url: "bd/otdetalle.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        id: id,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          window.location.reload();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de Operacion",
          text: "La orden de Trabajo no ha sido actualizada",
          icon: "error",
        });
      },
    });
  });

  $(document).on("click", "#btnGuardarcom", function () {
    orden = $("#folioorden").val();
    concepto = $("#conceptocom").val();
    cantidad = $("#cantcom").val();
    opcion = 1;
    $.ajax({
      url: "bd/otdetalle.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        orden: orden,
        concepto: concepto,
        cantidad: cantidad,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          window.location.reload();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de Operacion",
          text: "La orden de Trabajo no ha sido actualizada",
          icon: "error",
        });
      },
    });
  });

  $(document).on("click", "#btnGuardarmed0", function () {
    id = $("#idreg0").val();
    orden = $("#folioorden").val();

    tipoc = $("#tipoc0").val();
    console.log(tipoc);

    concepto = $("#conceptocom0").val();
    medida = $("#medidacom0").val();

    console.log(concepto);
    $.ajax({
      url: "bd/otdetalle.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        id: id,
        concepto: concepto,
        orden: orden,
        medida: medida,
        tipoc: tipoc,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          window.location.reload();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de Operacion",
          text: "La orden de Trabajo no ha sido actualizada",
          icon: "error",
        });
      },
    });
  });

  $(document).on("click", "#btnGuardarmed1", function () {
    id = $("#idreg1").val();
    orden = $("#folioorden").val();

    tipoc = $("#tipoc1").val();
    console.log(tipoc);
    console.log(opcion);

    concepto = $("#conceptocom1").val();
    medida = $("#medidacom1").val();

    console.log(concepto);

    $.ajax({
      url: "bd/otdetalle.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        id: id,
        concepto: concepto,
        orden: orden,
        medida: medida,
        tipoc: tipoc,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          window.location.reload();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de Operacion",
          text: "La orden de Trabajo no ha sido actualizada",
          icon: "error",
        });
      },
    });
  });

  $(document).on("click", "#btnGuardarmed2", function () {
    id = $("#idreg1").val();
    orden = $("#folioorden").val();

    tipoc = $("#tipoc2").val();
    console.log(tipoc);
    console.log(opcion);

    concepto = $("#conceptocom2").val();
    medida =
      "Desde Lado " +
      $("#lado2").val() +
      " CT: " +
      $("#medidacom21").val() +
      " DF: " +
      $("#medidacom22").val();

    console.log(medida);

    $.ajax({
      url: "bd/otdetalle.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        id: id,
        concepto: concepto,
        orden: orden,
        medida: medida,
        tipoc: tipoc,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          window.location.reload();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de Operacion",
          text: "La orden de Trabajo no ha sido actualizada",
          icon: "error",
        });
      },
    });

  
  });

  $(document).on("click", "#btnGuardarmed3", function () {
    id = $("#idreg3").val();
    orden = $("#folioorden").val();

    tipoc = $("#tipoc3").val();
    console.log(tipoc);
    console.log(opcion);

    concepto = $("#conceptocom3").val();
    medida = $("#medidacom3").val();

    console.log(concepto);

    $.ajax({
      url: "bd/otdetalle.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        id: id,
        concepto: concepto,
        orden: orden,
        medida: medida,
        tipoc: tipoc,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          window.location.reload();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de Operacion",
          text: "La orden de Trabajo no ha sido actualizada",
          icon: "error",
        });
      },
    });
  });3
  $(document).on("click", "#btnGuardarmed4", function () {
    id = $("#idreg4").val();
    orden = $("#folioorden").val();

    tipoc = $("#tipoc4").val();
    console.log(tipoc);
    console.log(opcion);

    concepto = $("#conceptocom4").val();
    medida = $("#medidacom4").val();

    console.log(concepto);

    $.ajax({
      url: "bd/otdetalle.php",
      type: "POST",
      dataType: "json",
      async: false,
      data: {
        id: id,
        concepto: concepto,
        orden: orden,
        medida: medida,
        tipoc: tipoc,
        opcion: opcion,
      },
      success: function (data) {
        if (data >= 1) {
          Swal.fire({
            title: "Registro Actualizado",
            text: "La orden de Trabajo ha sido actualizada",
            icon: "success",
          });
          window.location.reload();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de Operacion",
          text: "La orden de Trabajo no ha sido actualizada",
          icon: "error",
        });
      },
    });
  });
});
