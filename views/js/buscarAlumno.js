// Guarda la respuesta de la solicitud AJAX para reutilizarla
$(document).ready(function () {
  // Inicializa alumnos como null
  var alumnos = null;

  // Inicializa los selectores con las opciones por defecto
  $(document).ready(function () {
    //filtro para nivel
    //filtro para nivel
    $("#nivAlBusq").html(`
      <option>Ninguna opción</option>
      <option value="1">Inicial</option>
      <option value="2">Primaria</option>
      <option value="3">Secundaria</option>
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

    // Actualizar las opciones de grado basándose en el nivel seleccionado
    let opcionesGrado = "<option value='0'>Ninguna opción</option>";

    if (nivelSeleccionado === 1) {
      // Inicial
      opcionesGrado += `
          <option value="1">3 Años</option>
          <option value="2">4 Años</option>
          <option value="3">5 Años</option>
      `;
    } else if (nivelSeleccionado === 2) {
      // Primaria
      opcionesGrado += `
          <option value="4">1er Grado</option>
          <option value="5">2do Grado</option>
          <option value="6">3er Grado</option>
          <option value="7">4to Grado</option>
          <option value="8">5to Grado</option>
          <option value="9">6to Grado</option>
      `;
    } else if (nivelSeleccionado === 3) {
      // Secundaria
      opcionesGrado += `
          <option value="10">1er Año</option>
          <option value="11">2do Año</option>
          <option value="12">3er Año</option>
          <option value="13">4to Año</option>
          <option value="14">5to Año</option>
      `;
    }

    $("#gradAlBusq").html(opcionesGrado);
    // Si la opción seleccionada en el selector de nivel es "Ninguna opción" o NaN, mantenerla seleccionada
    if (isNaN(nivelSeleccionado) || Number(nivelSeleccionado) === 0) {
      $("#gradAlBusq").val("0");
    } else {
      // Si el nivel ha cambiado, seleccionar "Ninguna opción" en el selector de grado
      $("#gradAlBusq").val(gradoSeleccionado);
    }

    let opciones = "<option>Ninguna opción</option>";

    // Objeto para rastrear los idAlumno que ya se han agregado
    let idAlumnosAgregados = {};

    for (let i = 0; i < alumnos.length; i++) {
      let alumno = alumnos[i];

      // Si se seleccionó un nivel y el alumno no está en ese nivel, salta a la siguiente iteración
      if (!isNaN(nivelSeleccionado) && alumno.idNivel !== nivelSeleccionado) {
        continue;
      }

      // Si se seleccionó un grado y el alumno no está en ese grado, y el grado seleccionado no es "Ninguna opción", salta a la siguiente iteración
      if (
        !isNaN(gradoSeleccionado) &&
        alumno.idGrado !== gradoSeleccionado &&
        gradoSeleccionado !== 0
      ) {
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
  obtenerAlumnosPorAnioEscolar();
  function obtenerAlumnosPorAnioEscolar() {
    var idAnioEscolar = $("#selectAnioEscolarAlumnoBusqueda").val();
    var data = new FormData();
    data.append("buscarAlumnos", idAnioEscolar);

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
        actualizarOpciones();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }

  // Llamar a la función cuando se cambia el valor del select
  $("#selectAnioEscolarAlumnoBusqueda").on("change", function () {
    limpiarCampos();
    obtenerAlumnosPorAnioEscolar();
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
  // Asignar controladores de eventos
  $("#nivAlBusq").on("change", function () {
    var valorSeleccionado = Number($(this).val());

    limpiarCampos();

    if (isNaN(valorSeleccionado) || valorSeleccionado === 0) {
      $("#gradAlBusq").val("Ninguna Opcion");
    } else {
      // Restablecer gradoSeleccionado a 0
      gradoSeleccionado = 0;
      actualizarOpciones();
    }
  });

  $("#gradAlBusq").on("change", function () {
    var valorSeleccionado = Number($(this).val());

    limpiarCampos();

    if (isNaN(valorSeleccionado) || valorSeleccionado === 0) {
      $(this).val("0");
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
    $("#estadoAlBusqueda").val(alumno["estadoAdmisionAlumno"]);
    $("#ingVoltaBusqueda").val(alumno["fechaIngresoVolta"]);
    $("#direccionBusqueda").val(alumno["direccionAlumno"]);
    $("#distritoBusqueda").val(alumno["distritoAlumno"]);
    $("#numeroEmergBusqueda").val(alumno["numeroEmergencia"]);
    $("#siagieBusqueda").val(alumno["estadoSiagie"]);
    $("#apoderado1Busqueda").val(alumno["apoderado1Busqueda"]);
    $("#numero1ApoBusqueda").val(alumno["celularApoderado1"]);
    $("#apoderado2Busqueda").val(alumno["apoderado2Busqueda"]);
    $("#numero2ApoBusqueda").val(alumno["celularApoderado2"]);
    $("#dni1ApoBusqueda").val(alumno["dni1ApoBusqueda"]);
    $("#convive1Busqueda").val(alumno["convive1Busqueda"]);
    $("#email1ApoBusqueda").val(alumno["email1ApoBusqueda"]);
    $("#dni2ApoBusqueda").val(alumno["dni2ApoBusqueda"]);
    $("#convive2ApoBusqueda").val(alumno["convive2ApoBusqueda"]);
    $("#email2ApoBusqueda").val(alumno["email2ApoBusqueda"]);
    $("#estadoAlBusquedaNA").val(alumno["nuevoAlumno"]);
    $("#edadBusqueda").val(alumno["edad"]);
    $("#montoPagoMatricula").val(alumno["montoPagoMatricula"]);
    $("#numeroComprobanteMatricula").val(alumno["numeroComprobanteMatricula"]);
    $("#cuotaBusqueda").val(alumno["montoPagoCuota"]);
    $("#comprobanteCuotaBusqueda").val(alumno["numeroComprobanteCuota"]);
    $("#pensionBusqueda").val(alumno["montoPagoPension"]);
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
    $("#dni1ApoBusqueda").val("");
    $("#convive1Busqueda").val("");
    $("#email1ApoBusqueda").val("");
    $("#dni2ApoBusqueda").val("");
    $("#convive2ApoBusqueda").val("");
    $("#email2ApoBusqueda").val("");
    $("#estadoAlBusquedaNA").val("");
    $("#edadBusqueda").val("");
    $("#montoPagoMatricula").val("");
    $("#numeroComprobanteMatricula").val("");
    $("#cuotaBusqueda").val("");
    $("#comprobanteCuotaBusqueda").val("");
    $("#pensionBusqueda").val("");
    $("#contenedorPrincipal").empty();
  }
  //mostrar los datos de los pagos  y comunicado de los alumnos que se estan guandando en la variable alumnos
  function llenarPestanas(alumnos, alumno) {
    // Seleccionar los elementos donde se agregarán las pestañas y su contenido
    let tabList = document.getElementById("myTabComunicadosCronograma");
    let tabContent = document.getElementById(
      "myTabContentComunicadosCronogramaContenido"
    );
    let contenedorPrincipal = document.getElementById("contenedorPrincipal");

    // Limpiar las pestañas existentes
    while (tabList.firstChild) {
      tabList.removeChild(tabList.firstChild);
    }
    while (tabContent.firstChild) {
      tabContent.removeChild(tabContent.firstChild);
    }
    while (contenedorPrincipal.firstChild) {
      contenedorPrincipal.removeChild(contenedorPrincipal.firstChild);
    }

    let datosFiltrados = alumnos.filter((a) => a.idAlumno === alumno.idAlumno);

    // Crear contenedor principal
    let contenedor = document.createElement("div");
    contenedor.style.width = "100%";
    contenedor.style.margin = "20px 0";
    contenedor.style.fontSize = "14px";
    contenedor.style.borderRadius = "8px";
    contenedor.style.overflowX = "auto"; // Agregado para permitir desplazamiento horizonta
    contenedor.style.textAlign = "center"; // Centrar contenido

    // Crear fila de encabezados
    let filaEncabezados = document.createElement("div");
    filaEncabezados.style.display = "flex";
    filaEncabezados.style.color = "black";
    filaEncabezados.style.fontWeight = "bold";
    filaEncabezados.style.textTransform = "uppercase";
    filaEncabezados.style.borderBottom = "1px solid #ddd";

    let encabezadoMesPago = document.createElement("div");
    encabezadoMesPago.style.flex = "1";
    encabezadoMesPago.style.padding = "12px";
    encabezadoMesPago.style.borderRight = "1px solid #ddd";
    encabezadoMesPago.textContent = "Pagos Programados";

    let encabezadoMontoPago = document.createElement("div");
    encabezadoMontoPago.style.flex = "1";
    encabezadoMontoPago.style.padding = "12px";
    encabezadoMontoPago.style.borderRight = "1px solid #ddd";
    encabezadoMontoPago.textContent = "Monto del Pago";

    let encabezadoEstadoCronograma = document.createElement("div");
    encabezadoEstadoCronograma.style.flex = "1";
    encabezadoEstadoCronograma.style.padding = "12px";
    encabezadoEstadoCronograma.style.borderRight = "1px solid #ddd";
    encabezadoEstadoCronograma.textContent = "Estado de los Pagos";

    let encabezadoFechaPago = document.createElement("div");
    encabezadoFechaPago.style.flex = "1";
    encabezadoFechaPago.style.padding = "12px";
    encabezadoFechaPago.style.borderRight = "1px solid #ddd";
    encabezadoFechaPago.textContent = "Fecha de Pago";

    let encabezadoAcciones = document.createElement("div");
    encabezadoAcciones.style.flex = "1";
    encabezadoAcciones.style.padding = "12px";
    encabezadoAcciones.textContent = "Acciones";

    filaEncabezados.appendChild(encabezadoMesPago);
    filaEncabezados.appendChild(encabezadoMontoPago);
    filaEncabezados.appendChild(encabezadoEstadoCronograma);
    filaEncabezados.appendChild(encabezadoFechaPago);
    filaEncabezados.appendChild(encabezadoAcciones);
    contenedor.appendChild(filaEncabezados);

    // Crear contenedor de filas de datos
    let filaDatos = document.createElement("div");
    filaDatos.style.display = "flex";
    filaDatos.style.flexDirection = "column"; // Cambiado para mostrar los datos verticalmente

    datosFiltrados.forEach((dato, index) => {
      let datoDiv = document.createElement("div");
      datoDiv.style.display = "flex";
      datoDiv.style.flexDirection = "row"; // Cambiado para mostrar los datos horizontalmente dentro de cada div

      let mesPago = document.createElement("div");
      mesPago.style.flex = "1"; // Asegura que ocupa el mismo espacio que su encabezado correspondiente
      mesPago.style.padding = "10px";
      mesPago.style.borderRight = "1px solid #ddd";
      mesPago.textContent = dato.mesPago;

      let montoPago = document.createElement("div");
      montoPago.style.flex = "1"; // Asegura que ocupa el mismo espacio que su encabezado correspondiente
      montoPago.style.padding = "10px";
      montoPago.style.borderRight = "1px solid #ddd";
      montoPago.textContent = `S/. ${dato.montoPago}`;

      let estadoCronograma = document.createElement("div");
      estadoCronograma.style.flex = "1"; // Asegura que ocupa el mismo espacio que su encabezado correspondiente
      estadoCronograma.style.padding = "10px";
      estadoCronograma.style.borderRight = "1px solid #ddd";
      estadoCronograma.style.padding = "10px";

      // Aplicar insignia según el estado
      if (dato.estadoCronograma === "Cancelado") {
        estadoCronograma.innerHTML =
          '<span class="badge rounded-pill bg-success">Cancelado</span>';
      } else if (dato.estadoCronograma === "Pendiente") {
        estadoCronograma.innerHTML =
          '<span class="badge rounded-pill bg-warning">Pendiente</span>';
      } else {
        estadoCronograma.textContent = dato.estadoCronograma;
      }

      let fechaPago = document.createElement("div");
      fechaPago.style.flex = "1"; // Asegura que ocupa el mismo espacio que su encabezado correspondiente
      fechaPago.style.padding = "10px";
      fechaPago.style.borderRight = "1px solid #ddd";
      // Validación para mostrar "No registrado" si la fecha de pago es nula
      fechaPago.textContent = dato.fechaPago ? dato.fechaPago : "No registrado";

      let acciones = document.createElement("div");
      acciones.style.flex = "1"; // Ajusta el ancho para contener los botones
      acciones.style.padding = "10px";
      acciones.innerHTML = dato.botones; // Así se obtienen los botones generados por la función getBtnUsuarios

      datoDiv.appendChild(mesPago);
      datoDiv.appendChild(montoPago);
      datoDiv.appendChild(estadoCronograma);
      datoDiv.appendChild(fechaPago);
      datoDiv.appendChild(acciones);
      filaDatos.appendChild(datoDiv);
    });
    contenedor.appendChild(filaDatos);

    // Agregar el contenedor al DOM antes de las pestañas
    contenedorPrincipal.appendChild(contenedor);

    datosFiltrados.forEach((dato) => {
      // Si dato.mesPago es "Matricula" o "Cuota Inicial", no generar el contenido
      if (dato.mesPago === "Matricula" || dato.mesPago === "Cuota Inicial") {
        return;
      }
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
              <label for="fechaComunicacion" class="form-label">Fecha Comunicado</label>
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

// visualizar dato pago de alumno
$("#contenedorPrincipal ").on("click", ".btnVisualizarPago", function () {
  var codPago = $(this).attr("codPago");
  var data = new FormData();
  data.append("codPago", codPago);

  $.ajax({
    url: "ajax/pagos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      $("#nombresDetalleBuscar").val(response.nombresAlumno);
      $("#apellidosDetalleBuscar").val(response.apellidosAlumno);
      $("#gradoDetalleBuscar").val(response.descripcionGrado);
      $("#nivelDertalleBuscar").val(response.nivelAlumno);
      $("#codigoCajaDetalleBuscar").val(response.codAlumnoCaja);
      $("#mesDetalleBuscar").val(response.mesPago);
      $("#LimitePagoDetalleBuscar").val(response.fechaLimite);

      // Abre el modal después de recibir la respuesta
      $("#modalDetallePagoBuscar").modal("show");
    },
  });
});
