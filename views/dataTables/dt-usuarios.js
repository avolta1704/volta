// Definición inicial de dataTableUsuarios
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

var table = $("#dataTableUsuarios").DataTable({
  columns: columnDefs,
});

// Titulo dataTableUsuarios
var data = new FormData();
$(".tituloUsuarios").text("Usuarios");

//Solicitud inicial de dataTableUsuarios
var data = new FormData();
data.append("todosLosUsuarios", true);

$.ajax({
  url: "ajax/usuarios.ajax.php",
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

//Estructura de dataTableUsuarios
$("#dataTableUsuarios thead").html(`
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
table = $("#dataTableUsuarios").DataTable({
  columns: columnDefs,
});

});
