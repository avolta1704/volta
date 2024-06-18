$(document).ready(function () {
  var pagosPorMes = {};
  var porcentajePorMes = {};
  var totalPensiones = 0;
  var meses = [];
  var descripcionesAnio = [];
  var estadosAnio = [];
  var totalesAlumnos = [];
  var mesesRecaudado = [];
  var totalRecaudadoPorMes = {};
  var idUsuarioElement = document.getElementById("idUsuario");

  // Obtiene el contenido del elemento
  var idUsuario = idUsuarioElement.textContent;
  // Variables globales para almacenar los datos
  var globalDatos = [];

  // Función para obtener y manejar los datos de alumnos por grados
  function obtenerAlumnosPorGrados() {
    var data = new FormData();
    data.append("AlumnosporGrandos", true);

    $.ajax({
      url: "ajax/inicio.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        var grados = [];
        var alumnos = [];

        response.forEach(function (fila) {
          grados.push(fila.descripcionGrado);
          alumnos.push(fila.Alumnos);
        });

        // Actualizar gráfico con los datos obtenidos
        actualizarGrafico(grados, alumnos);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }

  // Función para obtener y manejar los datos de pensiones pendientes
  function obtenerPensionesPendientes() {
    var data = new FormData();
    data.append("PensionesPendientes", true);

    $.ajax({
      url: "ajax/inicio.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        response.forEach(function (fila) {
          var mes = fila.mesPago;
          if (!meses.includes(mes)) {
            meses.push(mes);
            pagosPorMes[mes] = [];
          }
          pagosPorMes[mes].push(fila.pagos_vencidos);
          porcentajePorMes[mes] = fila.porcentaje_vencidas;
          totalPensiones = fila.total_pensiones;
        });

        // Inicializar el dropdown y mostrar datos del primer mes
        poblarMesesDropdown(meses);
        if (meses.length > 0) {
          updatePagosVencidos(meses[0]);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }

  // Función para obtener y manejar los datos de alumnos por año
  function obtenerAlumnosPorAnio() {
    var data = new FormData();
    data.append("AlumnosporAnio", true);

    $.ajax({
      url: "ajax/inicio.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        response.forEach(function (fila) {
          descripcionesAnio.push(fila.descripcionAnio);
          estadosAnio.push(fila.estadoAnio);
          totalesAlumnos.push(fila.total_alumno);
        });

        // Inicializar el dropdown y mostrar datos del primer año
        poblarAniosDropdown(descripcionesAnio);
        if (descripcionesAnio.length > 0) {
          actualizarDatosAnio(0);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
  function obtenerMontoRecaudadoPorMeses() {
    var data = new FormData();
    data.append("MontoRecaudadoporMeses", true);

    $.ajax({
      url: "ajax/inicio.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        response.forEach(function (fila) {
          var mes = fila.mes;
          var totalPagado = fila.totalPagado;
          mesesRecaudado.push(mes);
          totalRecaudadoPorMes[mes] = totalPagado;
        });

        poblarMesesRecaudadoDropdown(mesesRecaudado);
        if (mesesRecaudado.length > 0) {
          actualizarDatosRecaudado(mesesRecaudado[0]);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
  // Función para actualizar los datos del monto recaudado por mes
  function actualizarDatosRecaudado(mes) {
    const filtroSeleccionado = $(".filtro-seleccionado-recaudado");
    const totalRecaudado = $(".total-recaudado");

    filtroSeleccionado.text("| " + mes);
    totalRecaudado.text(
      "S/. " +
        totalRecaudadoPorMes[mes].toLocaleString("es-PE", {
          style: "currency",
          currency: "PEN",
        })
    );
  }

  // Función para poblar el dropdown de meses recaudados
  function poblarMesesRecaudadoDropdown(meses) {
    var dropdown = $("#mesesDropdownRecaudado");
    dropdown.empty(); // Vaciar el dropdown antes de poblarlo

    meses.forEach(function (mes) {
      dropdown.append(
        '<li><a class="dropdown-item" href="#" onclick="filtrarRecaudado(\'' +
          mes +
          "')\">" +
          mes +
          "</a></li>"
      );
    });
  }
  // Función para obtener y manejar los datos de asistencia por meses
  function obtenerAsistenciaPorMeses(idUsuario) {
    var data = new FormData();
    data.append("idUsuarioAsistenciaporMeses", idUsuario);

    $.ajax({
      url: "ajax/inicio.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        // Limpiar los datos anteriores
        globalDatos = [];

        response.forEach(function (fila) {
          // Validar que los datos no sean null
          if (
            fila.Mes !== null &&
            fila.Porcentaje_Asistio !== null &&
            fila.Porcentaje_Falto !== null &&
            fila.Porcentaje_Inasistencia_Injustificada !== null &&
            fila.Porcentaje_Falta_Justificada !== null &&
            fila.Porcentaje_Tardanza_Justificada !== null &&
            fila.descripcionGrado !== null
          ) {
            globalDatos.push({
              grado: fila.descripcionGrado,
              mes: fila.Mes,
              porcentajeAsistio: parseFloat(fila.Porcentaje_Asistio),
              porcentajeFalto: parseFloat(fila.Porcentaje_Falto),
              porcentajeInasistenciaInjustificada: parseFloat(
                fila.Porcentaje_Inasistencia_Injustificada
              ),
              porcentajeFaltaJustificada: parseFloat(
                fila.Porcentaje_Falta_Justificada
              ),
              porcentajeTardanzaJustificada: parseFloat(
                fila.Porcentaje_Tardanza_Justificada
              ),
            });
          }
        });

        // Poblar el filtro de cursos
        poblarCursoFilterDropdown(globalDatos.map((d) => d.grado));

        // Actualizar el gráfico con los datos obtenidos del primer grado
        if (globalDatos.length > 0) {
          actualizarGraficoAsistencia(globalDatos[0].grado);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }

  // Función para actualizar el gráfico de asistencia por meses
  function actualizarGraficoAsistencia(gradoSeleccionado) {
    // Filtrar los datos por el grado seleccionado
    var datosFiltrados = globalDatos.filter(
      (d) => d.grado === gradoSeleccionado
    );

    // Extraer los datos filtrados en arrays separados
    var meses = datosFiltrados.map((d) => d.mes);
    var porcentajeAsistencias = datosFiltrados.map((d) => d.porcentajeAsistio);
    var porcentajeFaltas = datosFiltrados.map((d) => d.porcentajeFalto);
    var porcentajeInasistenciasInjustificadas = datosFiltrados.map(
      (d) => d.porcentajeInasistenciaInjustificada
    );
    var porcentajeFaltasJustificadas = datosFiltrados.map(
      (d) => d.porcentajeFaltaJustificada
    );
    var porcentajeTardanzasJustificadas = datosFiltrados.map(
      (d) => d.porcentajeTardanzaJustificada
    );

    // Verificar que el elemento existe antes de renderizar el gráfico
    var chartElement = document.querySelector("#asistenciaChart");
    if (!chartElement) {
      console.log("Error: Elemento #asistenciaChart no encontrado.");
      return;
    }

    // Destruir el gráfico existente si existe
    if (chartElement.chart) {
      chartElement.chart.destroy();
    }

    var chart = new ApexCharts(chartElement, {
      series: [
        {
          name: "Porcentaje Asistencias",
          data: porcentajeAsistencias.map((value) =>
            parseFloat(value.toFixed(1))
          ),
        },
        {
          name: "Porcentaje Faltas",
          data: porcentajeFaltas.map((value) => parseFloat(value.toFixed(1))),
        },
        {
          name: "Porcentaje Inasistencias Injustificadas",
          data: porcentajeInasistenciasInjustificadas.map((value) =>
            parseFloat(value.toFixed(1))
          ),
        },
        {
          name: "Porcentaje Faltas Justificadas",
          data: porcentajeFaltasJustificadas.map((value) =>
            parseFloat(value.toFixed(1))
          ),
        },
        {
          name: "Porcentaje Tardanzas Justificadas",
          data: porcentajeTardanzasJustificadas.map((value) =>
            parseFloat(value.toFixed(1))
          ),
        },
      ],
      chart: {
        height: 350,
        type: "area",
        toolbar: {
          show: false,
        },
      },
      markers: {
        size: 4,
      },
      colors: ["#4154f1", "#2eca6a", "#ff771d", "#a47bff", "#ffd05b"],
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.3,
          opacityTo: 0.4,
          stops: [0, 90, 100],
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: "smooth",
        width: 2,
      },
      xaxis: {
        categories: meses,
      },
      tooltip: {
        x: {
          format: "dd/MM/yy HH:mm",
        },
      },
    });

    chart.render();

    // Guardar el gráfico en el elemento para poder destruirlo luego
    chartElement.chart = chart;
  }

  // Función para poblar el dropdown de filtro de cursos
  function poblarCursoFilterDropdown(grados) {
    var dropdown = $("#gradoDropdown");
    dropdown.empty(); // Vaciar el dropdown antes de poblarlo

    // Crear un conjunto para almacenar grados únicos
    var gradosUnicos = new Set(grados);

    // Iterar sobre los grados únicos y agregarlos al dropdown
    gradosUnicos.forEach(function (grado) {
      dropdown.append(
        '<li><a class="dropdown-item" href="#">' + grado + "</a></li>"
      );
    });

    // Manejar el cambio de filtro
    $("#gradoDropdown").on("click", ".dropdown-item", function () {
      var gradoSeleccionado = $(this).text();
      // Actualizar el gráfico con los datos del grado seleccionado
      actualizarGraficoAsistencia(gradoSeleccionado);
    });
  }

  // Función para filtrar por mes recaudado
  window.filtrarRecaudado = function (mes) {
    actualizarDatosRecaudado(mes);
  };

  // Función para actualizar los pagos vencidos
  function updatePagosVencidos(mes) {
    const totalPagosVencidos = pagosPorMes[mes].reduce(
      (sum, current) => sum + current,
      0
    );
    const porcentajeVencidas =
      Math.round(parseFloat(porcentajePorMes[mes]) * 100) / 100;

    $("#filtroSeleccionado").text("| " + mes);
    $("#totalPagosVencidos").text(totalPagosVencidos);
    $("#porcentajeVencidas").text(porcentajeVencidas + "%");
    $("#totalPensiones").text(totalPensiones);
  }

  // Función para poblar el dropdown de meses
  function poblarMesesDropdown(meses) {
    var dropdown = $("#mesesDropdown");
    dropdown.empty(); // Vaciar el dropdown antes de poblarlo

    meses.forEach(function (mes) {
      dropdown.append(
        '<li><a class="dropdown-item" href="#" onclick="filtrarPagos(\'' +
          mes +
          "')\">" +
          mes +
          "</a></li>"
      );
    });
  }

  // Función para filtrar por pagos vencidos
  window.filtrarPagos = function (mes) {
    updatePagosVencidos(mes);
  };

  // Función para poblar el dropdown de años
  function poblarAniosDropdown(anios) {
    var dropdown = $("#aniosDropdown");
    dropdown.empty(); // Vaciar el dropdown antes de poblarlo

    anios.forEach(function (anio, index) {
      dropdown.append(
        '<li><a class="dropdown-item" href="#" onclick="filtrarAlumnos(\'' +
          anio +
          "', " +
          index +
          ')">' +
          anio +
          "</a></li>"
      );
    });
  }

  // Función para actualizar los datos de alumnos por año
  function actualizarDatosAnio(indice) {
    const filtroSeleccionado = $(".filtro-seleccionado");
    const totalAlumnos = $(".total-alumnos");

    filtroSeleccionado.text("| " + descripcionesAnio[indice]);
    totalAlumnos.text(
      totalesAlumnos[indice].toLocaleString() + " Matriculados"
    );
  }

  // Función para filtrar por año
  window.filtrarAlumnos = function (descripcionAnio, indice) {
    actualizarDatosAnio(indice);
  };

  // Función para actualizar el gráfico
  function actualizarGrafico(grados, alumnos) {
    new ApexCharts(document.querySelector("#reportsChart"), {
      series: [
        {
          name: "Alumnos",
          data: alumnos,
        },
      ],
      chart: {
        height: 350,
        type: "bar",
        toolbar: {
          show: false,
        },
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: "55%",
          endingShape: "rounded",
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
      },
      xaxis: {
        categories: grados,
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " alumnos";
          },
        },
      },
    }).render();
  }

  // Llama a las funciones para obtener los datos al cargar la página
  obtenerAlumnosPorGrados();
  obtenerPensionesPendientes();
  obtenerAlumnosPorAnio();
  obtenerMontoRecaudadoPorMeses();
  obtenerAsistenciaPorMeses(idUsuario);
});
