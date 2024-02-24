//  Create a new order
$("#btnAgregarNuevoAlumno").on("click", function () {
  window.location = "index.php?ruta=admisionExtraordinaria";
});

//  Visualizar alumno
$("#btnAgregarNuevoAlumno").on("click", function () {
  window.location = "index.php?ruta=admisionExtraordinaria";
});
btnVisualizarAlumno

//  Add material to list
$(".formNuevoApoderado").on("click", ".btnAgregarApoderado", function () {
  var nombres = $("#nombreApoderado").val();
  var apellidos = $("#apellidoApoderado").val();
  var correo = $("#correoApoderado").val();
  var celular = $("#celularApoderado").val();
  var tipoApoderado = $("#tipoApoderado").val();

  $(".nuevoApoderado").append(
    '<div class="row">' +
        '<!-- Nombres -->' +
        '<div class="col-lg-3">' +
          '<label for="nombreApoderado" class="col-form-label">Nombres</label>' +
          '<input type="text" class="form-control nombreApoderado" name="nombreApoderado" value="' + nombres + '" readonly>' +
        '</div>' +

        '<!-- Apellidos -->' +
        '<div class="col-lg-3 apellidos">' +
          '<label for="apellidosApoderado" class="col-form-label">Apellidos</label>' +
          '<input type="text" class="form-control apellidosApoderado" name="apellidosApoderado" value="' + apellidos + '" readonly>' +
        '</div>' +

        '<!-- Correo -->' +
        '<div class="col-lg-2 correo">' +
          '<label for="correoApoderado" class="col-form-label">Correo</label>' +
          '<input type="text" class="form-control correoApoderado" name="correoApoderado" value="' + correo + '" readonly>' +
        '</div>' +

        '<!-- Celular -->' +
        '<div class="col-lg-2 celular">' +
          '<label for="celularApoderado" class="col-form-label">Celular</label>' +
          '<input type="text" class="form-control celularApoderado" name="celularApoderado" value="' + celular + '" readonly>' +
        '</div>' +
        
        '<!-- Tipo Apoderado -->' +
        '<div class="col-lg-2 tipo">' +
          '<label for="tipoApoderado" class="col-form-label">Tipo</label>' +
          '<input type="text" class="form-control tipoApoderado" name="tipoApoderado" value="' + tipoApoderado + '" readonly>' +
        '</div>' +
    '</div>'
  );
  listarApoderados();
  document.getElementById("nombreApoderado").value="";
  document.getElementById("apellidoApoderado").value="";
  document.getElementById("correoApoderado").value="";
  document.getElementById("celularApoderado").value="";
  document.getElementById("tipoApoderado").value="";
});

function listarApoderados() {
    var listaApoderados = [];
    var nombres = $(".nombreApoderado");
    var apellidos = $(".apellidosApoderado");
    var correos = $(".correoApoderado");
    var celular = $(".celularApoderado");
    var tipoApoderado = $(".tipoApoderado");
    
    for(var i = 0; i < nombres.length; i++)
    {
        listaApoderados.push({
        "nombreApoderado" : $(nombres[i]).val(),
        "apellidoApoderado" : $(apellidos[i]).val(),
        "correoApoderado" : $(correos[i]).val(),
        "numeroApoderado" : $(celular[i]).val(),
        "tipoApoderado" : $(tipoApoderado[i]).val()
        });
    }

    $("#listaApoderados").val(JSON.stringify(listaApoderados));
}

