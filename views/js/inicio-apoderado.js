$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  // Verificar si el último segmento es "inicio"
  if (ultimoSegmento === "inicio") {
    const datos = document.getElementById("datos");
    let tipoUsuario = datos.getAttribute("data-tipo-usuario");
    if (tipoUsuario === "4") {
      const datos = document.getElementById("datos");
      var idAlumno = datos.getAttribute("data-primer-id-alumno");
      var fechaLimitePago = [];
      var mesPago = [];
      var mesesAsistencia = [];
      var totalAsistio = [];
      var totalFalto = [];
      var totalInasistenciaInjustificada = [];
      var totalFaltaJustificada = [];
      var totalTardanzaJustificada = [];
      var totalRegistro = [];
      var totalCursosAlumno = [];
      var gradoAlumnoCurso = [];
      var notasPorCurso = {};

      // Función para obtener la fecha de pago próxima
      function obtenerProximaFechaPagoApoderado(idAlumno) {
        var data = new FormData();
        data.append("idAlumnoApoderadoFechaPago", idAlumno);

        $.ajax({
          url: "ajax/inicio.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            fechaLimitePago = [];
            mesPago = [];
            response.forEach(function (fila) {
              fechaLimitePago.push(fila.proximaFechaPago);
              mesPago.push(fila.mesPago);
            });
            actualizarDatosProximaFechaPago(0);
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

      // Función para actualizar los datos de fecha de pago
      function actualizarDatosProximaFechaPago(indice) {
        const filtroSeleccionado = $(".filtro-seleccionado-mes-pago-apoderado");
        const fechaPago = $(".proxima-fecha");

        filtroSeleccionado.text("| " + mesPago[indice]);

        // Parsear la fecha desde el formato yy-mm-dd
        const fecha = new Date(fechaLimitePago[indice]);
        const opciones = { year: "numeric", month: "long", day: "numeric" };
        const fechaFormateada = fecha.toLocaleDateString("es-ES", opciones);
        fechaPago.text(fechaFormateada);
      }
      // Función para obtener el registro de asistencia por alumno
      function obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno) {
        var data = new FormData();
        data.append("idAlumnoAsistenciaporMesesApoderado", idAlumno);

        $.ajax({
          url: "ajax/inicio.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            mesesAsistencia = [];
            totalAsistio = [];
            totalFalto = [];
            totalInasistenciaInjustificada = [];
            totalFaltaJustificada = [];
            totalTardanzaJustificada = [];
            totalRegistro = []; // Reiniciar el array de totalRegistro

            // Iterar sobre el response para obtener todos los valores
            response.forEach((item) => {
              // Omitir el elemento si el Mes es "Total Anual"
              if (item.Mes === "Total Anual") {
                return;
              }

              mesesAsistencia.push(item.Mes);
              totalAsistio.push(item.total_asistio);
              totalFalto.push(item.total_falto);
              totalInasistenciaInjustificada.push(
                item.total_inasistencia_injustificada
              );
              totalFaltaJustificada.push(item.total_falta_justificada);
              totalTardanzaJustificada.push(item.total_tardanza_justificada);

              // Agregar cada total_registro al array totalRegistro
              totalRegistro.push(item.total_registro);
            });

            // Llamar a las funciones para actualizar el gráfico y el dropdown de meses
            poblarDropdownMeses();
            inicializarGraficoAsistencia(0);
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
      // Función para poblar el dropdown de meses
      function poblarDropdownMeses() {
        const dropdown = document.getElementById(
          "mesesAsistenciaApoderadoDropdown"
        );
        dropdown.innerHTML = ""; // Limpiar el dropdown antes de poblar
        mesesAsistencia.forEach((mes, index) => {
          const li = document.createElement("li");
          li.innerHTML = `<a class="dropdown-item" href="#" data-index="${index}">${mes}</a>`;
          dropdown.appendChild(li);
        });

        $("#mesesAsistenciaApoderadoDropdown a").click(function (event) {
          event.preventDefault();
          const index = $(this).data("index");
          if (index !== null) {
            inicializarGraficoAsistencia(index); // Llamar a la función DE inicializacion grafico
          }
        });
      }
      // Inicializar el gráfico de asistencia
      let asistenciaChart;
      // Función para inicializar el gráfico de asistencia
      function inicializarGraficoAsistencia(indice) {
        const filtroSeleccionado = $(".filtro-seleccionado-asistencia-mes");
        // Si no hay registro de asistencia, mostrar un mensaje
        if (mesesAsistencia[indice] == null) {
          // Si ya existe un gráfico, destruirlo
          if (asistenciaChart) {
            asistenciaChart.destroy();
            asistenciaChart = null; // Reiniciar la variable
          }
          // Mostrar mensaje de no hay registro de asistencia
          filtroSeleccionado.text("| No hay registro de Asistencia");
          return;
        } else {
          filtroSeleccionado.text("| " + mesesAsistencia[indice]);
        }

        const ctx = document
          .getElementById("asistenciaApoderadoChart")
          .getContext("2d");
        const data = {
          labels: [
            "Asistió",
            "Faltó",
            "Inasistencia Injustificada",
            "Falta Justificada",
            "Tardanza Justificada",
          ],
          datasets: [
            {
              label: "Asistencia",
              data: [
                totalAsistio[indice],
                totalFalto[indice],
                totalInasistenciaInjustificada[indice],
                totalFaltaJustificada[indice],
                totalTardanzaJustificada[indice],
              ],
              backgroundColor: [
                "rgba(54, 162, 235, 0.8)", // Azul
                "rgba(255, 99, 132, 0.8)", // Rojo
                "rgba(255, 205, 86, 0.8)", // Amarillo
                "rgba(75, 192, 192, 0.8)", // Verde agua
                "rgba(153, 102, 255, 0.8)", // Púrpura
              ],
              borderColor: [
                "rgba(54, 162, 235, 1)",
                "rgba(255, 99, 132, 1)",
                "rgba(255, 205, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
              ],
              borderWidth: 2,
            },
          ],
        };

        const options = {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            tooltip: {
              callbacks: {
                label: function (context) {
                  let label = context.label || "";
                  if (label) {
                    label += ": ";
                  }
                  label += context.raw;
                  label += " días";
                  return label;
                },
              },
            },
          },
        };

        if (asistenciaChart) {
          asistenciaChart.destroy();
        }

        asistenciaChart = new Chart(ctx, {
          type: "pie",
          data: data,
          options: options,
        });
      }
      // Función para obtener todos los datos del alumno
      function obtenerTodoslosDatosAlumnoApoderado(idAlumno) {
        var data = new FormData();
        data.append("idAlumnoDetallesVistaApoderado", idAlumno);
        $.ajax({
          url: "ajax/inicio.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            $("#nombreAlumnoApoderado").val(response["nombre_completo"]);
            $("#gradoAlumnoApoderado").val(response["descripcionGrado"]);
            $("#nivelAlumnoApoderado").val(response["descripcionNivel"]);
            $("#fechaNacimientoAlumnoApoderado").val(
              response["fechaNacimiento"]
            );
            $("#dniAlumnoApoderado").val(response["dniAlumno"]);
            $("#direccionAlumnoApoderado").val(response["direccionAlumno"]);
            $("#fechaIngresoAlumnoApoderado").val(
              response["fechaIngresoVolta"]
            );
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
      // Función para obtener el total de cursos asignados al alumno
      function obtenerTodoslosCursosAsignadosAlumno(idUsuario) {
        var data = new FormData();
        data.append("idAlumnoCursosAsignados", idUsuario);

        $.ajax({
          url: "ajax/inicio.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            totalCursosAlumno = [];
            gradoAlumnoCurso = [];
            response.forEach(function (fila) {
              totalCursosAlumno.push(fila.total_cursos);
              gradoAlumnoCurso.push(fila.descripcionGrado);
            });
            actualizarDatosAlumnosDocentes(0);
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
      function actualizarDatosAlumnosDocentes(indice) {
        const filtroSeleccionado = $(".filtro-seleccionado-cursos-alumnos");
        const totalCursos = $(".total-cursos-alumnos");

        filtroSeleccionado.text("| " + gradoAlumnoCurso[indice]);
        totalCursos.text(
          totalCursosAlumno[indice].toLocaleString() + " Asignados"
        );
      }
      // Función para obtener todas las notas de los cursos asignados al alumno
      function obtenerTodasNotasBimestresporCursos(idAlumno) {
        var data = new FormData();
        data.append("idAlumnoNotasBimestrePorCurso", idAlumno);

        $.ajax({
          url: "ajax/inicio.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            notasPorCurso = {}; // Reiniciar el objeto de notas por curso
            // Procesar la respuesta y agrupar por curso
            response.forEach(function (fila) {
              if (!notasPorCurso[fila.descripcionCurso]) {
                notasPorCurso[fila.descripcionCurso] = [];
              }
              notasPorCurso[fila.descripcionCurso].push({
                bimestre: fila.descripcionBimestre,
                fecha: fila.fechaCreacion,
                nota: fila.notaCambiada,
              });
            });

            // Inicializar el dropdown y mostrar datos del primer curso
            var cursos = Object.keys(notasPorCurso);
            poblarCursosNotasApoderadoDropdown(cursos);
            actualizarDatosAlumnoNotasApoderado(cursos[0]);
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

      // Función para poblar el dropdown de cursos
      function poblarCursosNotasApoderadoDropdown(cursos) {
        var dropdown = $("#cursosNotasApoderadoDropdown");
        dropdown.empty(); // Vaciar el dropdown antes de poblarlo

        cursos.forEach(function (curso) {
          dropdown.append(
            '<li><a class="dropdown-item" href="#" onclick="filtrarCursoNotasApoderado(\'' +
              curso +
              "')\">" +
              curso +
              "</a></li>"
          );
        });
      }
      function actualizarDatosAlumnoNotasApoderado(curso) {
        const filtroSeleccionado = $(
          ".filtro-seleccionado-cursos-notas-apoderado"
        );
        const totalnuevos = $(".notaAsignada");

        var notas = notasPorCurso[curso];
        var notaMasReciente = null;

        if (notas && notas.length > 0) {
          notas.forEach(function (nota) {
            if (
              nota.fecha &&
              (!notaMasReciente ||
                new Date(nota.fecha) > new Date(notaMasReciente.fecha))
            ) {
              notaMasReciente = nota;
            }
          });

          filtroSeleccionado.text("| " + curso);
          if (notaMasReciente) {
            totalnuevos.html(
              notaMasReciente.bimestre + " - " + notaMasReciente.nota
            );
          } else {
            totalnuevos.html(
              '<span class="badge rounded-pill bg-warning">No hay registro de notas</span>'
            );
          }
        } else {
          // No hay notas para este curso
          filtroSeleccionado.text("| Sin Curso Asignado");
          totalnuevos.html(
            '<span class="badge rounded-pill bg-warning">No hay registro de notas</span>'
          );
        }
      }

      // Función para filtrar por curso
      window.filtrarCursoNotasApoderado = function (curso) {
        actualizarDatosAlumnoNotasApoderado(curso);
      };
      obtenerProximaFechaPagoApoderado(idAlumno);
      obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno);
      obtenerTodoslosDatosAlumnoApoderado(idAlumno);
      obtenerTodoslosCursosAsignadosAlumno(idAlumno);
      obtenerTodasNotasBimestresporCursos(idAlumno);

      // Cambio de alumno de acuerdo al alumno seleccionado en el navbar
      $(".alumno-item").click(function () {
        // Obtener el idAlumno del elemento clickeado
        var idAlumno = $(this).data("id-alumno");
        // Actualizar los datos de los dashboard
        actualizarTablaConNuevoIdAlumno(idAlumno);
        obtenerProximaFechaPagoApoderado(idAlumno);
        obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno);
        obtenerTodoslosDatosAlumnoApoderado(idAlumno);
        obtenerTodoslosCursosAsignadosAlumno(idAlumno);
        obtenerTodasNotasBimestresporCursos(idAlumno);
      });
    }
  }
});

function actualizarTablaConNuevoIdAlumno($idAlumno) {
  // Preparar los datos para la solicitud AJAX
  var data = new FormData();
  data.append("idAlumnoApoderadoPagosPendientes", $idAlumno);

  // Realizar la solicitud AJAX
  $.ajax({
    url: "ajax/inicio.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      // Obtener la instancia de DataTable
      var tablePostulantes = $(
        "#dataTablePagosPendientesApoderadoInicio"
      ).DataTable();
      // Limpiar los datos actuales de la tabla
      tablePostulantes.clear();
      // Añadir los nuevos datos a la tabla
      tablePostulantes.rows.add(response);
      // Redibujar la tabla con los nuevos datos
      tablePostulantes.draw();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // Procedencia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
}
