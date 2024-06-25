$(document).ready(function () {
  //  Obtener el tipo de docente y establecer el data table a partir de este identificador
  var tipoDocente = document.getElementById("dataTableAlumnosDocente").dataset
    .tipoDocente;
  var listaIdentificadores = document.getElementById("dataTableAlumnosDocente")
    .dataset.identificadores;
  listaIdentificadores = JSON.parse(listaIdentificadores);

  //  Identificar el tipo de usuario y en base a este valor se le muestra un datatable u otro.
  if (tipoDocente === "1" || tipoDocente === "2") {
    // Titulo dataTableAlumnosDocente
    $(".tituloCursosDocente").text("Todos mis Alumnos");

    var columnDefsAlumnosDocente = [
      { data: "nombresAlumno" },
      { data: "apellidosAlumno" },
      { data: "acciones" },
    ];
    var tablaAlumnosDocente = $("#dataTableAlumnosDocente").DataTable({
      columns: columnDefsAlumnosDocente,
    });
    //Solicitud inicial de dataTableAlumnosDocente
    var data = new FormData();
    data.append("todosLosAlumnosDocente", true);
    data.append("idCurso", listaIdentificadores[0]["idCurso"]);
    data.append("idGrado", listaIdentificadores[0]["idGrado"]);
    data.append("idPersonal", listaIdentificadores[0]["idPersonal"]);

    $.ajax({
      url: "ajax/alumnosDocente.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (response) {
        tablaAlumnosDocente.clear();
        tablaAlumnosDocente.rows.add(response);
        tablaAlumnosDocente.draw();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });

    //Estructura de dataTableAlumnosDocente
    $("#dataTableAlumnosDocente thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

    tablaAlumnosDocente.destroy();

    columnDefsAlumnosDocente = [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "nombresAlumno" },
      { data: "apellidosAlumno" },
      { data: "acciones" },
    ];
    tablaAlumnosDocente = $("#dataTableAlumnosDocente").DataTable({
      columns: columnDefsAlumnosDocente,
    });
  } else if (tipoDocente === "3" || tipoDocente === "4") {
    // Titulo dataTableAlumnosDocente
    $(".tituloCursosDocente").text("Todos mis Cursos");

    var columnDefsAlumnosDocente = [
      { data: "descripcionCurso" },
      { data: "descripcionGrado" },
      { data: "acciones" },
    ];
    var tablaAlumnosDocente = $("#dataTableAlumnosDocente").DataTable({
      columns: columnDefsAlumnosDocente,
    });
    //Solicitud inicial de dataTableAlumnosDocente
    var data = new FormData();
    data.append("todosLosGrados", true);

    $.ajax({
      url: "ajax/alumnosDocente.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (response) {
        tablaAlumnosDocente.clear();
        tablaAlumnosDocente.rows.add(response);
        tablaAlumnosDocente.draw();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });

    //Estructura de dataTableAlumnosDocente
    $("#dataTableAlumnosDocente thead").html(`
  <tr>
    <th scope="col">#</th>
    <th scope="col">Nivel</th>
    <th scope="col">Grado</th>
    <th scope="col">Acciones</th>
  </tr>
  `);

    tablaAlumnosDocente.destroy();

    columnDefsAlumnosDocente = [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "descripcionCurso" },
      { data: "descripcionGrado" },
      { data: "acciones" },
    ];
    tablaAlumnosDocente = $("#dataTableAlumnosDocente").DataTable({
      columns: columnDefsAlumnosDocente,
    });
  }
});
