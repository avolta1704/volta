// Guarda la respuesta de la solicitud AJAX para reutilizarla
$(document).ready(function () {
  // Inicializa alumnos como null
  var alumnos = null;

  // Inicializa los selectores con las opciones por defecto
  $(document).ready(function () {
    //filtro para nivel
    $("#nivAlBusq").html(`
        <option>Ninguna opción</option>
        <option value="1">Inicial</option>
        <option value="2">Primaria</option>
        <option value="3">Secundaria</option>
    `);
    //filtro para grado
    $("#gradAlBusq").html(`
        <option>Ninguna opción</option>
        <option value="1">3 Años</option>
        <option value="2">4 Años</option>
        <option value="3">5 Años</option>
        <option value="4">1er Grado</option>
        <option value="5">2do Grado</option>
        <option value="6">3er Grado</option>
        <option value="7">4to Grado</option>
        <option value="8">5to Grado</option>
        <option value="9">6to Grado</option>
        <option value="10">1er Año</option>
        <option value="11">2do Año</option>
        <option value="12">3er Año</option>
        <option value="13">4to Año</option>
        <option value="14">5to Año</option>
    `);
    //filtro para apellidos y nombre
    $("#apellAlBusq").html("<option>Ninguna opción</option>");
    $(".busqueda").select2();
  });
  //tdoos los datos de busqueda por apellidos
  // Controlador de eventos para cambios en el selector de nivel
  $("#nivAlBusq").on("change", function () {
    actualizarOpciones();
  });

  // Controlador de eventos para cambios en el selector de grado
  $("#gradAlBusq").on("change", function () {
    actualizarOpciones();
  });

  function actualizarOpciones() {
    if (alumnos === null) {
      return;
    }

    // Obtén los valores seleccionados en los selectores de nivel y grado
    let nivelSeleccionado = Number($("#nivAlBusq").val());
    let gradoSeleccionado = Number($("#gradAlBusq").val());

    let opciones = "<option>Ninguna opción</option>";
    for (let i = 0; i < alumnos.length; i++) {
      let alumno = alumnos[i];

      // Si se seleccionó un nivel y el alumno no está en ese nivel, salta a la siguiente iteración
      if (!isNaN(nivelSeleccionado) && alumno.idNivel !== nivelSeleccionado) {
        continue;
      }

      // Si se seleccionó un grado y el alumno no está en ese grado, salta a la siguiente iteración
      if (!isNaN(gradoSeleccionado) && alumno.idGrado !== gradoSeleccionado) {
        continue;
      }

      let nombreCompleto = alumno.apellidosAlumno + " " + alumno.nombresAlumno;
      opciones += `<option>${nombreCompleto}</option>`;
    }
    $("#apellAlBusq").html(opciones);
  }

  $(".busqueda").on("select2:opening", function (e) {
    // Si alumnos no es null, no hacer nada
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
        console.log(response);
        actualizarOpciones();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // procedencia de error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  });

  // Controlador de eventos para cambios en el selector de apellidos
  $("#apellAlBusq").on("change", function () {
    let apellidoSeleccionado = $(this).val();

    if (apellidoSeleccionado === "Ninguna opción") {
      limpiarCampos();
      return;
    }

    for (let i = 0; i < alumnos.length; i++) {
      let alumno = alumnos[i];
      let nombreCompleto = alumno.apellidosAlumno + " " + alumno.nombresAlumno;

      if (nombreCompleto === apellidoSeleccionado) {
        llenarCampos(alumno);
        return;
      }
    }
  });
  // Controlador de eventos para cambios en el selector de nivel
  $("#nivAlBusq").on("change", function () {
    if ($(this).val() === "Ninguna opción") {
      limpiarCampos();
    } else {
      actualizarOpciones();
    }
  });

  // Controlador de eventos para cambios en el selector de grado
  $("#gradAlBusq").on("change", function () {
    if ($(this).val() === "Ninguna opción") {
      limpiarCampos();
    } else {
      actualizarOpciones();
    }
  });
  //campos de visualizaión de todos los datos del json escojido aprtir del apllido
  function llenarCampos(alumno) {
    $("#nombreBusqueda").val(alumno["nombresAlumno"]);
    $("#apellidoBusqueda").val(alumno["apellidosAlumno"]);
    $("#dniBusqueda").val(alumno["dniAlumno"]);
    $("#CodCajaBusqueda").val(alumno["codAlumnoCaja"]);
    $("#gradoBusqueda").val(alumno["descripcionGrado"]);
    $("#nivelBusqueda").val(alumno["descripcionNivel"]);
    $("#generoBusqueda").val(alumno["sexoAlumno"]);
    $("#nacimientoBusqueda").val(alumno["fechaNacimiento"]);
    $("#seguroBusqueda").val(alumno["seguroSalud"]);
    $("#enfermedadBusqueda").val(alumno["enfermedades"]);
    $("#ieProceBusqueda").val(alumno["IEPProcedencia"]);
    $("#estadoAlBusqueda").val(alumno["estadoAlumno"]);
    $("#ingVoltaBusqueda").val(alumno["fechaIngresoVolta"]);
    $("#direccionBusqueda").val(alumno["direccionAlumno"]);
    $("#distritoBusqueda").val(alumno["distritoAlumno"]);
    $("#numeroEmergBusqueda").val(alumno["numeroEmergencia"]);
    $("#siagieBusqueda").val(alumno["estadoSiagie"]);
    $("#matriculaBusqueda").val(alumno["estadoMatricula"]);
    $("#apoderado1Busqueda").val(alumno.nombreApoderado1 + " " + alumno.apellidoApoderado1);
    $("#numero1ApoBusqueda").val(alumno["celularApoderado1"]);
    $("#apoderado2Busqueda").val(alumno.nombreApoderado2 + " " + alumno.apellidoApoderado2);
    $("#numero2ApoBusqueda").val(alumno["celularApoderado2"]);
  }
  //limpiar los registros al selecionar otro apellido o ninguna opción
  function limpiarCampos() {
    $("#nombreBusqueda").val("");
    $("#apellidoBusqueda").val("");
    $("#dniBusqueda").val("");
    $("#CodCajaBusqueda").val("");
    $("#gradoBusqueda").val("");
    $("#nivelBusqueda").val("");
    $("#generoBusqueda").val("");
    $("#nacimientoBusqueda").val("");
    $("#seguroBusqueda").val("");
    $("#enfermedadBusqueda").val("");
    $("#ieProceBusqueda").val("");
    $("#estadoAlBusqueda").val("");
    $("#ingVoltaBusqueda").val("");
    $("#direccionBusqueda").val("");
    $("#distritoBusqueda").val("");
    $("#numeroEmergBusqueda").val("");
    $("#siagieBusqueda").val("");
    $("#matriculaBusqueda").val("");
    $("#apoderado1Busqueda").val("");
    $("#numero1ApoBusqueda").val("");
    $("#apoderado2Busqueda").val("");
    $("#numero2ApoBusqueda").val("");
  }
});
