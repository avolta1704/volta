$(".dataTableCerrarAnioGrados").on(
  "click",
  ".btnAsignarAlumnosNuevoAnio",
  function (e) {
    var idGrado = $(this).attr("idGrado");
    $(".btnCerrarAnioAlumnosGrado").attr("idGradoCerrarAnio", idGrado);
    $("#btnGuardarEleccionAnioEscolarNuevo").attr(
      "idGradoElegirAnioBtnElegir",
      idGrado
    );
    var columnDefsAsignarCursos = [
      { data: "apellidosAlumno" },
      { data: "nombresAlumno" },
      { data: "descripcionGrado" },
      { data: "acciones" },
    ];

    var tableAsignarCursos = $("#dataTableCerrarAnioAlumnos").DataTable({
      columns: columnDefsAsignarCursos,
      retrieve: true,
      paging: false,
    });

    //Solicitud ajx inicial de dataTableAsignarCursosAdmin
    var data = new FormData();
    data.append("idGradoCerrarAnioAlumnos", idGrado);

    $.ajax({
      url: "ajax/anioEscolar.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (response) {
        tableAsignarCursos.clear();
        tableAsignarCursos.rows.add(response);
        tableAsignarCursos.draw();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // procendecia de error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });

    //Estructura de dataTableAsignarCursos
    $("#dataTableCerrarAnioAlumnos thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Apellido</th>
      <th scope="col">Nombre</th>
      <th scope="col">Grado</th>
      <th scope="col">Opciones</th>
    </tr>
    `);

    tableAsignarCursos.destroy();

    columnDefsAsignarCursos = [
      {
        data: "null",
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "apellidosAlumno" },
      { data: "nombresAlumno" },
      { data: "descripcionGrado" },
      { data: "acciones" },
    ];
    tableAsignarCursos = $("#dataTableCerrarAnioAlumnos").DataTable({
      columns: columnDefsAsignarCursos,
      language: {
        url: "views/dataTables/Spanish.json",
      },
    });
  }
);
$(document).on("change", ".selectAlumnoCerrarAnio", function () {
  var idGrado = $(this).attr("idGrado");
  var idAlumno = $(this).attr("idAlumno");
  var idAnioEscolar = $(this).attr("idAnioEscolar");
  var estadoFinal = $(this).val();

  const dataEstadoFinalAnioEscolar = {
    idGrado: idGrado,
    idAlumno: idAlumno,
    idAnioEscolar: idAnioEscolar,
    estadoFinal: estadoFinal,
  };

  var data = new FormData();
  data.append(
    "cambiarEstadoFinalAnioAlumno",
    JSON.stringify(dataEstadoFinalAnioEscolar)
  );

  $.ajax({
    url: "ajax/anioEscolar.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response == "ok") {
        Swal.fire({
          position: "top-end",
          toast: true,
          icon: "success",
          text: "Estado registrado!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});
$("#modalCerrarAnioAlumnos").on(
  "click",
  ".btnCerrarAnioAlumnosGrado",
  function (e) {
    Swal.fire({
      title: "¿Estás seguro de cerrar el Año Escolar de este grado ?",
      text: "¡Si no lo está, puede cancelar la acción!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "¡Sí, cerrar Año Escolar !",
    }).then((result) => {
      var idGrado = $(this).attr("idGradoCerrarAnio");
      var data = new FormData();
      data.append("idGradoValidarDatosAlumnosCerrarAnio", idGrado);
      $.ajax({
        url: "ajax/anioEscolar.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response == "errorNota") {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Existen alumnos sin notas!",
            });
          } else if (response == "errorEstadoFinal") {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Existen alumnos con estado pendiente!",
            });
          } else if (response == "errorPago") {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Existen alumnos con pagos pendientes!",
            });
          } else if (response == "ok") {
            $("#modalCerrarAnioAlumnos").modal("hide");
            $("#modalCerrarAnioValidacionCorrecta").modal("show");
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // procendecia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    });
  }
);
$("#modalCerrarAnioValidacionCorrecta").on(
  "click",
  "#btnCerrarModalEleccionAnioEscolarNuevo",
  function (e) {
    $("#modalCerrarAnioValidacionCorrecta").modal("hide");
    $("#modalCerrarAnioAlumnos").modal("show");
  }
);
$(document).on("change", "#selectAnioSiguiente", function () {
  $("#modalCerrarAnioValidacionCorrecta").on(
    "click",
    "#btnGuardarEleccionAnioEscolarNuevo",
    function (e) {
      var selectedAnio = $("#selectAnioSiguiente").val();
      var idGrado = $(this).attr("idGradoElegirAnioBtnElegir");
      var data = new FormData();
      data.append("idGradoCrearAlumnoAnioEscolarNuevo", idGrado);
      data.append("idAnioEscolarNuevo", selectedAnio);
      $.ajax({
        url: "ajax/anioEscolar.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (response == "ok") {
            Swal.fire({
              position: "top-end",
              toast: true,
              icon: "success",
              text: "Año escolar asignado!",
              showConfirmButton: false,
              timer: 1500,
            });
            $("#modalCerrarAnioValidacionCorrecta").modal("hide");
            location.reload();
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // procendecia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
  );
});
