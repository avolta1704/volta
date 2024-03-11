
// Definición inicial de dataTableAdmisionAlumnos
$(document).ready(function () {
  var columnDefsAdmisionAlumno = [
    { data: "idAlumno" },
    { data: "nombresAlumno" },
    { data: "apellidosAlumno" },
    { data: "sexoAlumno" },
    { data: "stateAlumno" },
    { data: "descripcionGrado" },
    { data: "descripcionNivel" },
    { data: "buttonsAlumno" },
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
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Sexo</th>
        <th scope="col">Estado</th>
        <th scope="col">Nivel</th>
        <th scope="col">Grado</th>
        <th scope="col">Acciones</th>
      </tr>
    `);

  tableAdmisionAlumno.destroy();

  columnDefsAdmisionAlumno = [
    { data: "idAlumno" },
    { data: "nombresAlumno" },
    { data: "apellidosAlumno" },
    { data: "sexoAlumno" },
    { data: "stateAlumno" },
    { data: "descripcionGrado" },
    { data: "descripcionNivel" },
    { data: "buttonsAlumno" },
  ];
  tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable({
    columns: columnDefsAdmisionAlumno,
  });
});
