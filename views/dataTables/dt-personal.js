// Definición inicial de dataTablePersonal
$(document).ready(function() {

  var columnDefs = [
    { data: "idUsuario" },
    { data: "correoUsuario" },
    { data: "nombreUsuario" },
    { data: "apellidoUsuario" },
    { data: "state" },
    { data: "descripcionTipoUsuario" },
    { data: "ultimaConexion" },
    { data: "buttons" },
  ];

var table = $("#dataTablePersonal").DataTable({
  columns: columnDefs,
});

// Titulo dataTablePersonal
var data = new FormData();
$(".tituloPersonal").text("Personal");

//Solicitud inicial de dataTablePersonal
var data = new FormData();
data.append("todosLosPersonal", true);

$.ajax({
  url: "ajax/personal.ajax.php",
  method: "POST",
  data: data,
  cache: false,
  contentType: false,
  processData: false,
  dataType: "json",

  success: function (response) {
    table.clear();
    table.rows.add(response);
    table.draw();
  },
  error: function (jqXHR, textStatus, errorThrown) {
    console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
  },
});

//Estructura de dataTablePersonal
$("#dataTablePersonal thead").html(`
    <tr>
      <th scope="col">#</th>
      <th scope="col">Correo</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Nombres</th>
      <th scope="col">Estado</th>
      <th scope="col">Tipo Usuario</th>
      <th scope="col">Ultima Conexión</th>
      <th scope="col">Acciones</th>
    </tr>
    `);

table.destroy();

columnDefs = [
  { data: "idUsuario" },
  { data: "correoUsuario" },
  { data: "nombreUsuario" },
  { data: "apellidoUsuario" },
  { data: "state" },
  { data: "descripcionTipoUsuario" },
  { data: "ultimaConexion" },
  { data: "buttons" },
];
table = $("#dataTablePersonal").DataTable({
  columns: columnDefs,
});

});
