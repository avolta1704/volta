// Guarda la respuesta de la solicitud AJAX para reutilizarla
var alumnos = null;

$(".busqueda").on("click", function () {
  if (alumnos !== null) {
    return;
  }

  var data = new FormData();
  data.append("buscarAlumnos", "");

  $.ajax({
    url: "ajax/buscarAlumno.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      alumnos = response;
      actualizarSelectores();
    },
  });
});

$("#nivAlBusq").on("change", function () {
  var nivelSeleccionado = $("#nivAlBusq").val();

  var grados = {
    "Ninguna opción": ["Ninguna opción"],
    "Inicial": ["Ninguna opción", "3 Años", "4 Años", "5 Años"],
    "Primaria": ["Ninguna opción", "1er Grado", "2do Grado", "3er Grado", "4to Grado", "5to Grado", "6to Grado"],
    "Secundaria": ["Ninguna opción", "1er Año", "2do Año", "3er Año", "4to Año", "5to Año"]
  };

  if (nivelSeleccionado in grados) {
    $("#gradAlBusq").html(grados[nivelSeleccionado].map(function (grado) {
      return '<option value="' + grado + '">' + grado + '</option>';
    }).join(''));
  } else {
    $("#gradAlBusq").html('<option>Ninguna opción</option>');
    $("#nivAlBusq").val('Ninguna opción');
  }

  actualizarSelectores();
});

$("#gradAlBusq").on("change", function () {
  if ($("#gradAlBusq").val() === "Ninguna opción") {
    $("#nivAlBusq").val('Ninguna opción');
  }
  actualizarSelectores();
});

function actualizarSelectores() {
  var nivelSeleccionado = $("#nivAlBusq").val();
  var gradoSeleccionado = $("#gradAlBusq").val();

  var alumnosFiltrados = alumnos;

  if (nivelSeleccionado !== "Ninguna opción") {
    alumnosFiltrados = alumnosFiltrados.filter(function (alumno) {
      return alumno["descripcionNivel"] === nivelSeleccionado;
    });
  }

  if (gradoSeleccionado !== "Ninguna opción") {
    alumnosFiltrados = alumnosFiltrados.filter(function (alumno) {
      return alumno["descripcionGrado"] === gradoSeleccionado;
    });
  }

  if (alumnosFiltrados.length > 0) {
    $("#apellAlBusq").html(alumnosFiltrados.map(function (alumno) {
      return '<option value="' + alumno["apellidosAlumno"] + '">' + alumno["apellidosAlumno"] + '</option>';
    }).join(''));
  } else {
    $("#apellAlBusq").html('<option>Ninguna opción coincidente</option>');
  }

  $("#apellAlBusq").select2();
}

// Inicializa los selectores con las opciones por defecto
$(document).ready(function() {
  $("#nivAlBusq").html('<option>Ninguna opción</option><option>Inicial</option><option>Primaria</option><option>Secundaria</option>');
  $("#gradAlBusq").html('<option>Ninguna opción</option>');
  $("#apellAlBusq").html('<option>Escriba Apellido</option>');
});

/* valores de nivAlBusq
 <option>Inicial</option>
<option>Primaria</option>
<option>Secundaria</option>
*/

/* valores de gradAlBusq
//Inicial
<option>3 Años</option>
<option>4 Años</option>
<option>5 Años</option>
//Primaria
<option>1er Grado</option>
<option>2do Grado</option>
<option>3er Grado</option>
<option>4to Grado</option>
<option>5to Grado</option>
<option>6to Grado</option>
//Secundaria
<option>1er Año</option>
<option>2do Año</option>
<option>3er Año</option>
<option>4to Año</option>
<option>5to Año</option>
*/

// Cuando se selecciona un valor, actualiza los otros selectores
$(".busqueda").on("change", function () {
  var apellidoSeleccionado = $("#apellAlBusq").val();

  for (var i = 0; i < alumnos.length; i++) {
    if (alumnos[i]["apellidosAlumno"] === apellidoSeleccionado) {
      $("#nivAlBusq").val(alumnos[i]["descripcionNivel"]);
      $("#gradAlBusq").val(alumnos[i]["descripcionGrado"]);

      // Llena los demás campos del formulario
      $("#nombreBusqueda").val(alumnos[i]["nombresAlumno"]);
      $("#apellidoBusqueda").val(alumnos[i]["apellidosAlumno"]);
      $("#dniBusqueda").val(alumnos[i]["dniAlumno"]);
      $("#CodCajaBusqueda").val(alumnos[i]["codAlumnoCaja"]);
      $("#gradoBusqueda").val(alumnos[i]["descripcionGrado"]);
      $("#nivelBusqueda").val(alumnos[i]["descripcionNivel"]);
      $("#generoBusqueda").val(alumnos[i]["sexoAlumno"]);
      $("#nacimientoBusqueda").val(alumnos[i]["fechaNacimiento"]);
      $("#seguroBusqueda").val(alumnos[i]["seguroSalud"]);
      $("#enfermedadBusqueda").val(alumnos[i]["enfermedades"]);
      $("#ieProceBusqueda").val(alumnos[i]["IEPProcedencia"]);
      $("#estadoAlBusqueda").val(alumnos[i]["estadoAlumno"]);
      $("#ingVoltaBusqueda").val(alumnos[i]["fechaIngresoVolta"]);
      $("#direccionBusqueda").val(alumnos[i]["direccionAlumno"]);
      $("#distritoBusqueda").val(alumnos[i]["distritoAlumno"]);
      $("#numeroEmergBusqueda").val(alumnos[i]["numeroEmergencia"]);
      $("#siagieBusqueda").val(alumnos[i]["estadoSiagie"]);
      $("#matriculaBusqueda").val(alumnos[i]["estadoMatricula"]);
      $("#apoderado1Busqueda").val(
        alumnos[i]["nombreApoderado1"] + ["apellidoApoderado1"]
      );
      $("#numero1ApoBusqueda").val(alumnos[i]["celularApoderado1"]);
      $("#apoderado2Busqueda").val(
        alumnos[i]["nombreApoderado2"] + ["apellidoApoderado2"]
      );
      $("#numero2ApoBusqueda").val(alumnos[i]["celularApoderado2"]);

      break;
    }
  }
});
