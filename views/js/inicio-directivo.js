$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  // Verificar si el último segmento es "inicio"
  if (ultimoSegmento === "inicio") {
    const datos = document.getElementById("datos");
    let tipoUsuario = datos.getAttribute("data-tipo-usuario");
    if (tipoUsuario === "5") {
      docentes = [];
      tipoDocentes = [];
      var pieChart;
      var grados = [];
      var masculinos = [];
      var femeninos = [];

      var nuevosAlumnos = [];
      var antiguosAlumnos = [];
      var nivelGrados = [];

      // Función para obtener y manejar los datos de alumnos por grados
      function obtenerDocentesCursosPorGrados() {
        var data = new FormData();
        data.append("docentesCursosporGrado", true);

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
            var docentes = [];
            var cursos = [];

            response.forEach(function (fila) {
              grados.push(fila.descripcionGrado);
              docentes.push(fila.docentes);
              cursos.push(fila.cursos);
            });

            // Actualizar gráfico con los datos obtenidos
            actualizarGrafico(grados, docentes, cursos);
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
      // Función para actualizar el gráfico
      function actualizarGrafico(grados, docentes, cursos) {
        new ApexCharts(document.querySelector("#reportsChartDocentesCursos"), {
          series: [
            {
              name: "Docentes",
              data: docentes,
            },
            {
              name: "Cursos",
              data: cursos,
            },
          ],
          chart: {
            height: 560, // Aumentar la altura del gráfico
            type: "bar",
            toolbar: {
              show: false,
            },
          },
          plotOptions: {
            bar: {
              horizontal: true,
              barHeight: "150%", // Ajustar la altura de las barras para que sean más gruesas
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
                return val;
              },
            },
          },
          grid: {
            padding: {
              left: 20,
              right: 50,
              top: 20,
              bottom: 20,
            },
          },
          yaxis: {
            labels: {
              style: {
                fontSize: "12px", // Ajustar el tamaño de fuente para mejorar el espaciado entre grados
              },
            },
          },
        }).render();
      }
      // Función para obtener los nombres de los docentes y cursos por grados
      function obtenerNombreDocentesCursosPorGrados() {
        var data = new FormData();
        data.append("nombreDocenteyCurso", true);

        $.ajax({
          url: "ajax/inicio.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            // Objeto para almacenar la estructura de datos organizada por grado y docente
            var grados = {};

            // Organizar los datos en el objeto grados
            response.forEach(function (fila) {
              var grado = fila.descripcionGrado;
              var docente = fila.docente || "Sin Asignar"; // Asignar "Sin Asignar" si docente es null
              var descripcionCurso = fila.descripcionCurso || "Sin Asignar"; // Asignar "Sin Asignar" si descripcionCurso es null

              if (!grados[grado]) {
                grados[grado] = {};
              }

              if (!grados[grado][docente]) {
                grados[grado][docente] = [];
              }

              grados[grado][docente].push(descripcionCurso);
            });

            // Construir el tree view dinámico
            var treeHTML =
              '<div class="accordion" id="accordionTree" style="width: 100%;">'; // Ajustar el ancho aquí

            // Recorrer el objeto grados para construir el HTML
            Object.keys(grados).forEach(function (grado, index) {
              treeHTML += '<div class="accordion-item">';
              treeHTML +=
                '<h2 class="accordion-header" id="heading' + index + '">';
              treeHTML +=
                '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' +
                index +
                '" aria-expanded="true" aria-controls="collapse' +
                index +
                '">';
              treeHTML += grado;
              treeHTML += "</button>";
              treeHTML += "</h2>";
              treeHTML +=
                '<div id="collapse' +
                index +
                '" class="accordion-collapse collapse" aria-labelledby="heading' +
                index +
                '" data-bs-parent="#accordionTree">';
              treeHTML += '<div class="accordion-body">';

              Object.keys(grados[grado]).forEach(function (
                docente,
                docenteIndex
              ) {
                treeHTML +=
                  '<button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' +
                  index +
                  "_docente" +
                  docenteIndex +
                  '" aria-expanded="true" aria-controls="collapse' +
                  index +
                  "_docente" +
                  docenteIndex +
                  '">';
                treeHTML +=
                  '<i class="bi bi-person-workspace"></i>&nbsp; ' + docente; // Icono y texto del docente con espacio
                treeHTML += "</button>";
                treeHTML +=
                  '<div id="collapse' +
                  index +
                  "_docente" +
                  docenteIndex +
                  '" class="accordion-collapse collapse" aria-labelledby="heading' +
                  index +
                  "_docente" +
                  docenteIndex +
                  '" data-bs-parent="#collapse' +
                  index +
                  '">';

                // Insertar cursos con margen y espacio arriba y abajo
                treeHTML +=
                  '<div style="margin-left: 30px; margin-top: 15px; margin-bottom: 10px;">'; // Ajustar los márgenes aquí
                grados[grado][docente].forEach(function (curso) {
                  treeHTML +=
                    '<p class="mb-0" style="margin-bottom: 5px;"><i class="bi bi-journal-text"></i>&nbsp; ' +
                    curso +
                    "</p>"; // Icono y texto del curso con espacio
                });
                treeHTML += "</div>"; // Cierre del div con márgenes

                treeHTML += "</div>"; // Cierre de collapse para docente
              });

              treeHTML += "</div>"; // Cierre de accordion-body para grado
              treeHTML += "</div>"; // Cierre de accordion-collapse para grado
              treeHTML += "</div>"; // Cierre de accordion-item
            });

            treeHTML += "</div>"; // Cierre de accordion

            // Insertar el tree view en el elemento con id informacionCursos
            document.querySelector("#informacionCursos").innerHTML = treeHTML;
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
      // Función para obtener los docentes por tipo
      function obtenerDocentesporTipo() {
        var data = new FormData();
        data.append("totalDocenteporTipo", true);

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
              docentes.push(fila.total_docentes);
              tipoDocentes.push(fila.descripcionTipo);
            });

            // Inicializar el dropdown y mostrar datos del primer año
            poblarTipoDocenteDropdown(tipoDocentes);
            if (tipoDocentes.length > 0) {
              actualizarDatosDocentesTipo(0);
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
      // Función para poblar el dropdown de tipo de docentes
      function poblarTipoDocenteDropdown(tipoDocentes) {
        var dropdown = $("#tipoDocenteDropdown");
        dropdown.empty(); // Vaciar el dropdown antes de poblarlo

        tipoDocentes.forEach(function (tipoDocentes, index) {
          dropdown.append(
            '<li><a class="dropdown-item" href="#" onclick="filtrarDocenteTipo(\'' +
              tipoDocentes +
              "', " +
              index +
              ')">' +
              tipoDocentes +
              "</a></li>"
          );
        });
      }

      // Función para actualizar los datos de docente por tipo
      function actualizarDatosDocentesTipo(indice) {
        const filtroSeleccionado = $(".filtro-seleccionado-tipo-docente");
        const totalDocentes = $(".total-docentes-tipo");

        filtroSeleccionado.text("| " + tipoDocentes[indice]);
        totalDocentes.text(docentes[indice].toLocaleString() + " Asignados");
      }

      // Función para filtrar por tipo docente
      window.filtrarDocenteTipo = function (tipoDocentes, indice) {
        actualizarDatosDocentesTipo(indice);
      };
      // Función para obtener los datos de alumnos por sexo y grado
      function obtenerTotalMasculinoFemenino() {
        var data = new FormData();
        data.append("totalMasculinoFemenino", true);

        $.ajax({
          url: "ajax/inicio.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            // Procesar la respuesta para obtener los datos del gráfico
            response.forEach(function (fila) {
              grados.push(fila.grado_nivel);
              masculinos.push(fila.total_masculinos);
              femeninos.push(fila.total_femeninos);
            });

            // Poblar el dropdown con los grados
            poblarGradoSexoDropdown(grados);

            // Inicializar el gráfico de pastel con los datos del primer grado
            crearGraficoPastel(masculinos[0], femeninos[0], grados[0]);
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
      function poblarGradoSexoDropdown(grados) {
        var dropdown = $("#gradoSexoDropdown");
        dropdown.empty(); // Vaciar el dropdown antes de poblarlo

        grados.forEach(function (grado, index) {
          dropdown.append(
            '<li><a class="dropdown-item" href="#" onclick="filtrarGrado(' +
              index +
              ')">' +
              grado +
              "</a></li>"
          );
        });
      }

      // Función para crear el gráfico de pastel
      function crearGraficoPastel(masculinos, femeninos, gradosindice) {
        const filtroSeleccionado = $(".filtro-seleccionado-grado-sexo");
        filtroSeleccionado.text("| " + gradosindice);
        var ctx = document.getElementById("pieChart").getContext("2d");

        pieChart = new Chart(ctx, {
          type: "pie",
          data: {
            labels: ["Masculino", "Femenino"],
            datasets: [
              {
                data: [masculinos, femeninos],
                backgroundColor: ["#36A2EB", "#FF6384"],
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
          },
        });
      }

      // Función para actualizar el gráfico de pastel
      function actualizarGraficoPastel(masculinos, femeninos) {
        pieChart.data.datasets[0].data = [masculinos, femeninos];
        pieChart.update();
      }

      // Función para filtrar por grado
      window.filtrarGrado = function (indice) {
        const filtroSeleccionado = $(".filtro-seleccionado-grado-sexo");
        filtroSeleccionado.text("| " + grados[indice]);
        actualizarGraficoPastel(masculinos[indice], femeninos[indice]);
      };

      // Función para obtener los alumnos nuevos y antiguos
      function obtenerAlumnosNuevosAntiguos() {
        var data = new FormData();
        data.append("alumnosNuevosAntiguos", true);

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
              nuevosAlumnos.push(fila.nuevos);
              antiguosAlumnos.push(fila.antiguos);
              nivelGrados.push(fila.grado_nivel);
            });

            // Inicializar el dropdown y mostrar datos del primer año
            poblarGradoAlumnoNuevoAntiguoDropdown(nivelGrados);
            if (nivelGrados.length > 0) {
              actualizarDatosAlumnosNuevosAntiguos(0);
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
      // Función para poblar el dropdown de tipo de docentes
      function poblarGradoAlumnoNuevoAntiguoDropdown(nivelGrados) {
        var dropdown = $("#gradoNivelDropdown");
        dropdown.empty(); // Vaciar el dropdown antes de poblarlo

        nivelGrados.forEach(function (nivelGrados, index) {
          dropdown.append(
            '<li><a class="dropdown-item" href="#" onclick="filtrarGradoNivelAlumnoNuevoAntiguo(\'' +
              nivelGrados +
              "', " +
              index +
              ')">' +
              nivelGrados +
              "</a></li>"
          );
        });
      }

      // Función para actualizar los datos de docente por tipo
      function actualizarDatosAlumnosNuevosAntiguos(indice) {
        const filtroSeleccionado = $(
          ".filtro-seleccionado-alumnos-nuevo-antiguo"
        );
        const totalnuevos = $(".total-alumnos-nuevos");
        const totalantiguos = $(".total-alumnos-antiguos");

        filtroSeleccionado.text("| " + nivelGrados[indice]);
        totalnuevos.text(nuevosAlumnos[indice].toLocaleString() + " Nuevos");
        totalantiguos.text(
          antiguosAlumnos[indice].toLocaleString() + " Antiguos"
        );
      }

      // Función para filtrar por tipo docente
      window.filtrarGradoNivelAlumnoNuevoAntiguo = function (
        nivelGrados,
        indice
      ) {
        actualizarDatosAlumnosNuevosAntiguos(indice);
      };

      // Llamar a la función para obtener los datos al cargar la página
      obtenerTotalMasculinoFemenino();
      obtenerDocentesCursosPorGrados();
      obtenerNombreDocentesCursosPorGrados();
      obtenerDocentesporTipo();
      obtenerAlumnosNuevosAntiguos();
    }
  }
});
