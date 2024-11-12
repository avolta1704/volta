$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  // Verificar si el último segmento es "inicio"
  if (ultimoSegmento === "inicio") {
    const datos = document.getElementById("datos");
    let tipoUsuario = datos.getAttribute("data-tipo-usuario");
    if (tipoUsuario === "2") {
      // Variables globales para almacenar los datos
      var globalDatos = [];
      // Variables globales para almacenar los datos de la consulta
      var alumnosPorGrado = [];
      var gradosDocentes = [];

      var cursosPorDocente = [];
      var nombreDocente = [];

      // Función para obtener y manejar los datos de asistencia por meses
      function obtenerAsistenciaPorMeses() {
        var data = new FormData();
        data.append("idUsuarioAsistenciaporMeses", true);

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
            } else {
              // Mostrar mensaje de no datos
              document.querySelector("#asistenciaChart").innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
              <span class="badge rounded-pill bg-warning">No se ha registrado asistencia</span>
            </div>`;
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
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
        var porcentajeAsistencias = datosFiltrados.map(
          (d) => d.porcentajeAsistio
        );
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

        // Verificar si no hay datos o todos los valores son nulos
        var noDatos =
          datosFiltrados.length === 0 ||
          (porcentajeAsistencias.every((val) => val === null) &&
            porcentajeFaltas.every((val) => val === null) &&
            porcentajeInasistenciasInjustificadas.every(
              (val) => val === null
            ) &&
            porcentajeFaltasJustificadas.every((val) => val === null) &&
            porcentajeTardanzasJustificadas.every((val) => val === null));

        var chartElement = document.querySelector("#asistenciaChart");

        if (!chartElement) {
          console.log("Error: Elemento #asistenciaChart no encontrado.");
          return;
        }

        if (noDatos) {
          chartElement.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
          <span class="badge rounded-pill bg-warning">No se ha registrado asistencia</span>
        </div>`;
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
                parseFloat(value ? value.toFixed(1) : 0)
              ),
            },
            {
              name: "Porcentaje Faltas",
              data: porcentajeFaltas.map((value) =>
                parseFloat(value ? value.toFixed(1) : 0)
              ),
            },
            {
              name: "Porcentaje Inasistencias Injustificadas",
              data: porcentajeInasistenciasInjustificadas.map((value) =>
                parseFloat(value ? value.toFixed(1) : 0)
              ),
            },
            {
              name: "Porcentaje Faltas Justificadas",
              data: porcentajeFaltasJustificadas.map((value) =>
                parseFloat(value ? value.toFixed(1) : 0)
              ),
            },
            {
              name: "Porcentaje Tardanzas Justificadas",
              data: porcentajeTardanzasJustificadas.map((value) =>
                parseFloat(value ? value.toFixed(1) : 0)
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

      // Función para obtener los Alumnos asignados al docente
      function obtenerAlumnosAsignadosDocente() {
        var data = new FormData();
        data.append("idUsuarioAlumnosAsignadosDocentes", true);

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
              alumnosPorGrado.push(fila.alumnos_asignados);
              gradosDocentes.push(fila.descripcionGrado);
            });

            // Inicializar el dropdown y mostrar datos del primer año
            poblarGradoDocenteDropdown(gradosDocentes);
            if (gradosDocentes.length > 0) {
              actualizarDatosAlumnosDocentes(0);
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
          },
        });
      }
      // Función para poblar el dropdown de grados
      function poblarGradoDocenteDropdown(gradosDocentes) {
        var dropdown = $("#gradoDropdownDocente");
        dropdown.empty(); // Vaciar el dropdown antes de poblarlo

        gradosDocentes.forEach(function (gradosDocentes, index) {
          dropdown.append(
            '<li><a class="dropdown-item" href="#" onclick="filtrarAlumnosDocente(\'' +
              gradosDocentes +
              "', " +
              index +
              ')">' +
              gradosDocentes +
              "</a></li>"
          );
        });
      }

      // Función para actualizar los datos de alumnos por grado
      function actualizarDatosAlumnosDocentes(indice) {
        const filtroSeleccionado = $(".filtro-seleccionado-Docente");
        const totalAlumnos = $(".total-alumnos-docentes");

        filtroSeleccionado.text("| " + gradosDocentes[indice]);
        totalAlumnos.text(
          alumnosPorGrado[indice].toLocaleString() + " Asignados"
        );
      }

      // Función para filtrar por grados
      window.filtrarAlumnosDocente = function (gradosDocentes, indice) {
        actualizarDatosAlumnosDocentes(indice);
      };

      // Función para obtener los Alumnos asignados al docente
      function obtenerCursosAsignadosDocente() {
        var data = new FormData();
        data.append("idUsuarioCursosAsignadosDocentes", true);

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
              cursosPorDocente.push(fila.cursos_asignados);
              nombreDocente.push(fila.nombreCompleto);
            });

            actualizarDatosCursosDocentes(0);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
          },
        });
      }

      // Función para actualizar los datos de alumnos por grado
      function actualizarDatosCursosDocentes(indice) {
        const filtroSeleccionado = $(".filtro-seleccionado-Cursos");
        const totalCursos = $(".total-cursos-docentes");

        filtroSeleccionado.text("| " + nombreDocente[indice]);
        totalCursos.text(
          cursosPorDocente[indice].toLocaleString() + " Asignados"
        );
      }

      obtenerAsistenciaPorMeses();
      obtenerAlumnosAsignadosDocente();
      obtenerCursosAsignadosDocente();
    }
  }
});
