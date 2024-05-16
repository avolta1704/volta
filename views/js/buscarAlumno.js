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
  
/*   $(document).ready(function () {
    //filtro para nivel
    $("#nivAlBusq").html(`
        <option value="0">Ninguna opción</option>
        <option value="1">Inicial</option>
        <option value="2">Primaria</option>
        <option value="3">Secundaria</option>
    `);

    // Escucha el evento 'change' en el select de nivel
    $("#nivAlBusq")
      .change(function () {
        var nivelSeleccionado = $(this).val();

        // Define las opciones para cada nivel
        var opcionesInicial = `
        <option>Ninguna opción</option>
            <option value="1">3 Años</option>
            <option value="2">4 Años</option>
            <option value="3">5 Años</option>
        `;
        var opcionesPrimaria = `
        <option>Ninguna opción</option>
            <option value="4">1er Grado</option>
            <option value="5">2do Grado</option>
            <option value="6">3er Grado</option>
            <option value="7">4to Grado</option>
            <option value="8">5to Grado</option>
            <option value="9">6to Grado</option>
        `;
        var opcionesSecundaria = `
        <option>Ninguna opción</option>
            <option value="10">1er Año</option>
            <option value="11">2do Año</option>
            <option value="12">3er Año</option>
            <option value="13">4to Año</option>
            <option value="14">5to Año</option>
        `;

        // Verifica el nivel seleccionado y muestra las opciones correspondientes
        if (nivelSeleccionado == "1") {
          $("#gradAlBusq").html(opcionesInicial);
        } else if (nivelSeleccionado == "2") {
          $("#gradAlBusq").html(opcionesPrimaria);
        } else if (nivelSeleccionado == "3") {
          $("#gradAlBusq").html(opcionesSecundaria);
        } else {
          $("#gradAlBusq").html(`
                <option value="0">Ninguna opción</option>
                ${opcionesInicial}
                ${opcionesPrimaria}
                ${opcionesSecundaria}
            `);
        }
      })
      .change(); // Dispara el evento 'change' al cargar la página

    //filtro para apellidos y nombre
    $("#apellAlBusq").html("<option>Ninguna opción</option>");
    $("#apellAlBusq").change(); // Dispara el evento 'change' al cargar la página

    $(".busqueda").select2();
  }); */

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

    // Objeto para rastrear los idAlumno que ya se han agregado
    let idAlumnosAgregados = {};

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

      // Si el idAlumno ya se ha agregado, salta a la siguiente iteración
      if (idAlumnosAgregados[alumno.idAlumno]) {
        continue;
      }

      let nombreCompleto = alumno.apellidosAlumno + " " + alumno.nombresAlumno;
      opciones += `<option>${nombreCompleto}</option>`;

      // Marcar el idAlumno como agregado
      idAlumnosAgregados[alumno.idAlumno] = true;
    }
    $("#apellAlBusq").html(opciones);
  }

  /*   $(".busqueda").on("select2:opening", function (e) { */
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
        llenarPestanas(alumnos, alumno);
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
    $("#apoderado1Busqueda").val(
      alumno.nombreApoderado1 + " " + alumno.apellidoApoderado1
    );
    $("#numero1ApoBusqueda").val(alumno["celularApoderado1"]);
    $("#apoderado2Busqueda").val(
      alumno.nombreApoderado2 + " " + alumno.apellidoApoderado2
    );
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
  //mostrar los datos de los pagos  y comunicado de los alumnos que se estan guandando en la variable alumnos
  function llenarPestanas(alumnos, alumno) {
    // Seleccionar los elementos donde se agregarán las pestañas y su contenido
    let tabList = document.getElementById("myTabComunicadosCronograma");
    let tabContent = document.getElementById(
      "myTabContentComunicadosCronogramaContenido"
    );

    // Limpiar las pestañas existentes
    while (tabList.firstChild) {
      tabList.removeChild(tabList.firstChild);
    }
    while (tabContent.firstChild) {
      tabContent.removeChild(tabContent.firstChild);
    }
    let datosFiltrados = alumnos.filter((a) => a.idAlumno === alumno.idAlumno);

    datosFiltrados.forEach((dato) => {
      // Crear los elementos necesarios para la pestaña y su contenido
      let listItem = document.createElement("li");
      let link = document.createElement("a");
      let divTabPane = document.createElement("div");

      // Asignar las clases y atributos necesarios a los elementos
      listItem.className = "nav-item";
      listItem.setAttribute("role", "presentation");

      link.className = "nav-link";
      link.id = `${dato.mesPago.toLowerCase()}-tab`;
      link.setAttribute("data-bs-toggle", "tab");
      link.setAttribute("href", `#${dato.mesPago.toLowerCase()}`);
      link.setAttribute("role", "tab");
      link.setAttribute("aria-controls", `${dato.mesPago.toLowerCase()}`);
      link.setAttribute("aria-selected", "false");
      link.textContent = dato.mesPago;

      divTabPane.className = "tab-pane fade";
      divTabPane.id = dato.mesPago.toLowerCase();
      divTabPane.setAttribute("role", "tabpanel");
      divTabPane.setAttribute(
        "aria-labelledby",
        `${dato.mesPago.toLowerCase()}-tab`
      );

      // Crear el contenido HTML para la pestaña
      divTabPane.innerHTML = `
      <div class="mb-3 row">
          <h3 style="font-weight: bold; text-align: center; border-top: 2px solid #000; padding-top: 10px;">Cronograma Mensual de Pago</h3>
          <div class="col-md-12">
              <div class="row">
                  <div class="col-md-2">
                      <label for="montoPago" class="form-label">Monto Pago</label>
                      <input type="text" class="form-control" id="montoPago" value="${dato.montoPago}" readonly>
                  </div>
                  <div class="col-md-2">
                      <label for="mesPago" class="form-label">Mes pago</label>
                      <input type="text" class="form-control" id="mesPago" value="${dato.mesPago}" readonly>
                  </div>
                  <div class="col-md-2">
                      <label for="fechaLimite" class="form-label">Fecha limite Pago</label>
                      <input type="text" class="form-control" id="fechaLimite" value="${dato.fechaLimite}" readonly>
                  </div>
                  <div class="col-md-2">
                      <label for="estadoCronograma" class="form-label">Estado pago</label>
                      <input type="text" class="form-control" id="estadoCronograma" value="${dato.estadoCronograma}" readonly>
                  </div>
              </div>
          </div>

   
         <h3 style="font-weight: bold; text-align: center; border-top: 2px solid #000; padding-top: 10px;  margin-top: 20px;">Ultimo Comunicado</h3>
          <div class="col">
              <label for="tituloComunicacion" class="form-label">Asunto</label>
              <input type="text" class="form-control" id="tituloComunicacion" value="${dato.tituloComunicacion}" readonly>
          </div>
          <div class="col-md-2">
              <label for="fechaComunicacion" class="form-label">Fecha Comunciado</label>
              <input type="date" class="form-control" id="fechaComunicacion" value="${dato.fechaComunicacion}" readonly>
          </div>
          <div class="mb-3">
              <label for="detalleComunicacion" class="form-label">Comunicado</label>
              <textarea class="form-control" id="detalleComunicacion" rows="3" readonly>${dato.detalleComunicacion}</textarea >
          </div>
      </div>
  `;
      // Agregar los elementos al DOM
      listItem.appendChild(link);
      tabList.appendChild(listItem);
      tabContent.appendChild(divTabPane);
    });
  }
});
