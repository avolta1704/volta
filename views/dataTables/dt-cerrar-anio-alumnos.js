// Redireccionar a la vista de registrarNotas
$(".dataTableCerrarAnioGrados").on(
  "click",
  ".btnAsignarAlumnosNuevoAnio",
  function (e) {
    var idGrado = $(this).attr("idGrado");
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
  data.append("cambiarEstadoFinalAnioAlumno", JSON.stringify(dataEstadoFinalAnioEscolar));

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
