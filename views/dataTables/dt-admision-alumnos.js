// Definición inicial de dataTableAdmisionAlumnos
$(document).ready(function () {
  var columnDefsAdmisionAlumno = [
    { data: "idAdmisionAlumno" },
    { data: "dniAlumno" },
    { data: "apellidosAlumno" },
    { data: "nombresAlumno" },
    { data: "tipoAdmision" },
    { data: "fechaAdmision" },
    { data: "estadoAdmisionAlumno" },
    { data: "estadoAlumno" },
    { data: "estadoSiagie" },
    { data: "estadoMatricula" },
    { data: "codAlumnoCaja" },
    { data: "fechaIngresoVolta" },
    /* { data: "buttonsAdmisionAlumno" }, */
  ];

  var tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable({
    columns: columnDefsAdmisionAlumno,
  });

  // Titulo dataTableAdmisionAlumnos
  var data = new FormData();
  $(".tituloAdmisionAlumnos").text("Registros Admision Alumnos");

  //Solicitud ajx inicial de dataTableAdmisionAlumnosAdmin
  var data = new FormData();
  data.append("registrosAdmisionAlumnos", true);

  $.ajax({
    url: "ajax/admisionAlumnos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      tableAdmisionAlumno.clear();
      tableAdmisionAlumno.rows.add(response);
      tableAdmisionAlumno.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  //Estructura de dataTableAdmisionAlumnos
  $("#dataTableAdmisionAlumnos thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Dni</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Admision</th>
        <th scope="col">Fecha Admision</th>
        <th scope="col">Estado Admision</th>
        <th scope="col">Estado Alumno</th>
        <th scope="col">Siagie</th>
        <th scope="col">Matricula</th>
        <th scope="col">Codigo Alumno Caja</th>
        <th scope="col">Ingreso Volta</th>

      </tr>
    `);

  tableAdmisionAlumno.destroy();

  columnDefsAdmisionAlumno = [
    { data: "idAdmisionAlumno" },
    { data: "dniAlumno" },
    { data: "apellidosAlumno" },
    { data: "nombresAlumno" },
    { data: "tipoAdmision" },
    { data: "fechaAdmision" },
    { data: "estadoAdmisionAlumno" },
    { data: "estadoAlumno" },
    { data: "estadoSiagie" },
    { data: "estadoMatricula" },
    { data: "codAlumnoCaja" },
    { data: "fechaIngresoVolta" },
    /* { data: "buttonsAdmisionAlumno" }, */
  ];
  tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable({
    columns: columnDefsAdmisionAlumno,
  });
});
