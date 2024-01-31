//  Create a new order
$("#btnAgregarNuevoAlumno").on("click", function () {
  window.location = "index.php?route=nuevoAlumno";
});

//  Add material to list
$(".formNuevoApoderado").on("click", ".btnAgregarApoderado", function () {
  var nombres = $("#nombreApoderado").val();
  var apellidos = $("#apellidoApoderado").val();
  var correo = $("#correoApoderado").val();
  var celular = $("#celularApoderado").val();
  var tipoApoderado = $("#tipoApoderado").val();

  $(".nuevoApoderado").append(
    '<div class="container row" style="padding:5px 15px">' +
        '<!-- Nombres -->' +
        '<div class="col-lg-3 nombres">' +
          '<input type="text" class="form-control nombreApoderado" name="nombreApoderado" value="' + nombres + '" readonly>' +
        '</div>' +
        '<!-- Apellidos -->' +
        '<div class="col-lg-3 apellidos">' +
          '<input type="text" class="form-control apellidosApoderado" name="apellidosApoderado" value="' + apellidos + '" readonly>' +
        '</div>' +
        '<!-- Correo -->' +
        '<div class="col-lg-3 correo">' +
          '<input type="text" class="form-control correoApoderado" name="correoApoderado" value="' + correo + '" readonly>' +
        '</div>' +
        '<!-- Celular -->' +
        '<div class="col-lg-3 celular">' +
          '<input type="text" class="form-control celularApoderado" name="celularApoderado" value="' + celular + '" readonly>' +
        '</div>' +
        '<!-- Tipo Apoderado -->' +
        '<div class="col-lg-3 tipo">' +
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

