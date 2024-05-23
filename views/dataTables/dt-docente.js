// Definición inicial de dataTableUsuarios
$(document).ready(function() {

  var columnDefsDocente = [
    { data: "idUsuario" },
    { data: "nombreUsuario" },
    { data: "apellidoUsuario" },
    { data: "state" },
    { data: "buttons" },
  ];

var tableDocente = $("#dataTableDocentes").DataTable({
  columns: columnDefsDocente,
});

// Titulo dataTableUsuarios
$(".tituloDocentes").text("Docentes");

//Solicitud inicial de dataTableUsuarios
var data = new FormData();
data.append("todosLosDocentes", true);

$.ajax({
  url: "ajax/docentes.ajax.php",
  method: "POST",
  data: data,
  cache: false,
  contentType: false,
  processData: false,
  dataType: "json",

  success: function (response) {
    tableDocente.clear();
    tableDocente.rows.add(response);
    tableDocente.draw();
  },
  error: function (jqXHR, textStatus, errorThrown) {
    console.log(jqXHR.responseText); // procendecia de error
    console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
  },
});

//Estructura de dataTableUsuarios
$("#dataTableDocentes thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Estado</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

    tableDocente.destroy();

columnDefsDocente = [
  { data: null,
    render: function (data, type, row, meta) {
      return meta.row + 1;
    },
  },
  { data: "nombreUsuario" },
  { data: "apellidoUsuario" },
  { data: "state" },
  { data: "buttons" },
];
tableDocente = $("#dataTableDocentes").DataTable({
  columns: columnDefsDocente,
});

});
