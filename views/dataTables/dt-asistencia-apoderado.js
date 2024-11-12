$(document).ready(function () {
    // Obtener la ruta actual de la URL
    var rutaActual = window.location.pathname;
    // Obtener el último segmento de la ruta
    var ultimoSegmento = rutaActual.split("/").pop();

  // Verificar si la rutaActual contiene "volta/inicio"
  if (ultimoSegmento==="asistenciaApoderado") {
    // Variables para los selectores
    var selectAlumno = $("#selectAlumno");
    var selectMes = $("#selectMes");
    // Variables para el grafico de Asistencia
    var mesesAsistencia = [];
    var totalAsistio = [];
    var totalFalto = [];
    var totalInasistenciaInjustificada = [];
    var totalFaltaJustificada = [];
    var totalTardanzaJustificada = [];
    var totalRegistro = [];
    // Inicializar el gráfico de asistencia
    let asistenciaChart;

    // Evento cuando se selecciona un alumno o un mes
    selectAlumno.add(selectMes).change(function () {
      // Obtener el valor seleccionado del select de alumno y del select de mes
      var idAlumno = selectAlumno.val();
      var mes = selectMes.find("option:selected").text().trim(); // Asegurarse de que el texto del mes no tenga espacios en blanco al inicio o al final

      // Verificar que tanto idAlumno como mes estén seleccionados y no sean valores predeterminados
      if (
        idAlumno &&
        idAlumno !== "0" &&
        mes &&
        mes !== "1" &&
        mes !== "Ninguna Opción"
      ) {
        // Caso especial para el mes "13" o "Total Anual"
        if (mes === "13" || mes === "Total Anual") {
          obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno, mes);
          var asistenciaContainer = $("#asistenciaContainer");
          asistenciaContainer.empty(); // Limpiar el contenedor
        } else {
          // Caso normal
          obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno, mes);
          obtenerAsistencia(idAlumno, mes);
        }
      } else {
        var asistenciaContainer = $("#asistenciaContainer");
        asistenciaContainer.empty(); // Limpiar el contenedor
        asistenciaChart.destroy(); // Destruir el gráfico de asistencia
        asistenciaChart = null; // Reiniciar la variable
        // Establecer los selectores a las opciones predeterminadas
        selectAlumno.val("0");
        selectMes.val("1");
      }
    });
    // Funcion para obtener el registro de asistencia del alumno en base al select de alumno y al select de mes
    function obtenerAsistencia(idAlumno, mes) {
      var data = new FormData();
      data.append("idUsuarioAsistenciaApoderado", ipConfirmacion);
      data.append("idAlumno", idAlumno);
      data.append("mes", mes);

      $.ajax({
        url: "ajax/asistenciaAlumnos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          generarTabla(response, idAlumno, mes);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // Procedencia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
    // Función para obtener días en el mes seleccionado
    function obtenerDiasEnMes(mes, año) {
      var meses = {
        Enero: 1,
        Febrero: 2,
        Marzo: 3,
        Abril: 4,
        Mayo: 5,
        Junio: 6,
        Julio: 7,
        Agosto: 8,
        Septiembre: 9,
        Octubre: 10,
        Noviembre: 11,
        Diciembre: 12,
      };
      var mesNum = meses[mes];
      return new Date(año, mesNum, 0).getDate();
    }

    function generarTabla(data, idAlumno, mes) {
      // Obtener el año actual
      var añoActual = new Date().getFullYear();
      var diasEnMes = obtenerDiasEnMes(mes, añoActual); // Obtener días en el mes seleccionado
      var asistenciaContainer = $("#asistenciaContainer");
      asistenciaContainer.empty(); // Limpiar el contenedor antes de agregar la nueva tabla

      // Crear la tabla con estilo en línea
      var tabla = $(
        '<table style="border: 1px solid black; border-collapse: collapse; width: 100%;"></table>'
      );
      var encabezadoMes = $("<tr></tr>");
      var encabezadoDiasSemana = $("<tr></tr>");
      var encabezadoDias = $("<tr></tr>");
      var filaAsistencia = $("<tr></tr>");

      // Fila del mes
      encabezadoMes.append(
        '<td colspan="' +
          (diasEnMes + 1) +
          '" style="text-align: center; font-weight: bold; background-color: #00bfbf;">' +
          mes +
          "</td>"
      );
      tabla.append(encabezadoMes);

      // Fila de los nombres de los días de la semana
      encabezadoDiasSemana.append(
        '<td rowspan="2" style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center;">Días</td>'
      );
      // Iterar sobre los días de la semana
      for (var dia = 1; dia <= diasEnMes; dia++) {
        var nombreDia = obtenerNombreDiaSemana(dia, mes, añoActual);
        encabezadoDiasSemana.append(
          '<td style="border: 1px solid black; text-align: center;">' +
            nombreDia +
            "</td>"
        );
      }
      tabla.append(encabezadoDiasSemana);
      // Fila de los números de los días
      for (var dia = 1; dia <= diasEnMes; dia++) {
        encabezadoDias.append(
          '<td style="border: 1px solid black; text-align: center; ">' +
            dia +
            "</td>"
        );
      }
      tabla.append(encabezadoDias);

      // Fila de la asistencia
      filaAsistencia.append(
        '<td style="border: 1px solid black; font-weight: bold; background-color: #00bfbf; text-align: center">Asistencia</td>'
      );

      var asistenciaPorDia = {}; // Objeto para guardar la asistencia por día
      // Iterar sobre los datos para obtener la asistencia por día
      data.forEach(function (entry) {
        if (entry.idAlumno == idAlumno && entry.Mes == mes) {
          var dia = entry["Día"];
          var estado = entry.estadoAsistencia;

          asistenciaPorDia[dia] = estado;
        }
      });
      // Agregar celdas de estado a la fila de asistencia
      for (var dia = 1; dia <= diasEnMes; dia++) {
        var celdaEstado = $(
          '<td style="border: 1px solid black; text-align: center; width: 45px; font-weight: bold"></td>'
        ); // Celda de estado sin estilo
        if (asistenciaPorDia[dia]) {
          var estado = asistenciaPorDia[dia];
          // Aplicar color según el estado
          switch (estado) {
            case "A":
              celdaEstado.css("color", "green").text("A");
              break;
            case "F":
              celdaEstado.css("color", "red").text("F");
              break;
            case "T":
              celdaEstado.css("color", "orange").text("T");
              break;
            case "J":
              celdaEstado.css("color", "blue").text("J");
              break;
            case "U":
              celdaEstado.css("color", "purple").text("U");
              break;
          }
        }
        filaAsistencia.append(celdaEstado);
      }

      tabla.append(filaAsistencia);
      asistenciaContainer.append(tabla);
    }
    // Función para obtener el nombre del día de la semana
    function obtenerNombreDiaSemana(dia, nombreMes, año) {
      var mesNumerico = obtenerNumeroMes(nombreMes); // Obtener el número del mes a partir del nombre
      var fecha = new Date(año, mesNumerico - 1, dia); // mesNumerico - 1 porque en JavaScript los meses son de 0 a 11
      var diasSemana = ["DO", "LU", "MA", "MI", "JU", "VI", "SA"]; // Array de días de la semana
      var nombreDia = diasSemana[fecha.getDay()]; // getDay() devuelve el día de la semana (0 para Domingo, 1 para Lunes, ..., 6 para Sábado)
      return nombreDia;
    }
    // Función para obtener el número del mes a partir del nombre
    function obtenerNumeroMes(nombreMes) {
      var meses = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ];
      return meses.indexOf(nombreMes) + 1; // Sumar 1 porque los meses en JavaScript van de 0 a 11
    }

    // Función para obtener el registro de asistencia por alumno
    function obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno, mes) {
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
          inicializarGraficoAsistencia(mes); // Ejemplo inicial con "Enero"
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }

    // Función para inicializar el gráfico de asistencia
    function inicializarGraficoAsistencia(mes) {
      const indice = mesesAsistencia.indexOf(mes); // Buscar el índice del mes en el array
      const filtroSeleccionado = $(".filtro-seleccionado-asistencia-mes");

      // Si no hay registro de asistencia para el mes, mostrar un mensaje
      if (indice === -1 || mesesAsistencia[indice] == null) {
        if (asistenciaChart) {
          asistenciaChart.destroy();
          asistenciaChart = null; // Reiniciar la variable
        }
        filtroSeleccionado.text("| No hay registro de Asistencia para " + mes);
        return;
      } else {
        filtroSeleccionado.text("| " + mesesAsistencia[indice]);
      }

      const ctx = document
        .getElementById("asistenciaApoderadoChart")
        .getContext("2d");
      let data;

      // Verificar si el mes es "Total Anual" para usar porcentajes
      if (mes === "Total Anual") {
        data = {
          labels: [
            "Porcentaje Asistió",
            "Porcentaje Faltó",
            "Porcentaje Inasistencia Injustificada",
            "Porcentaje Falta Justificada",
            "Porcentaje Tardanza Justificada",
          ],
          datasets: [
            {
              label: "Porcentajes de Asistencia",
              data: [
                Math.round(totalAsistio[indice]),
                Math.round(totalFalto[indice]),
                Math.round(totalInasistenciaInjustificada[indice]),
                Math.round(totalFaltaJustificada[indice]),
                Math.round(totalTardanzaJustificada[indice]),
              ],
              backgroundColor: [
                "rgba(0, 128, 0, 0.8)",
                "rgba(255, 0, 0, 0.8)",
                "rgba(255, 165, 0, 0.8)",
                "rgba(0, 0, 255, 0.8)",
                "rgba(128, 0, 128, 0.8)",
              ],
              borderColor: [
                "rgba(0, 128, 0, 1)",
                "rgba(255, 0, 0, 1)",
                "rgba(255, 165, 0, 1)",
                "rgba(0, 0, 255, 1)",
                "rgba(128, 0, 128, 1)",
              ],
              borderWidth: 2,
            },
          ],
        };
      } else {
        // Datos para otros meses (mantener el comportamiento existente)
        data = {
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
                "rgba(0, 128, 0, 0.8)",
                "rgba(255, 0, 0, 0.8)",
                "rgba(255, 165, 0, 0.8)",
                "rgba(0, 0, 255, 0.8)",
                "rgba(128, 0, 128, 0.8)",
              ],
              borderColor: [
                "rgba(0, 128, 0, 1)",
                "rgba(255, 0, 0, 1)",
                "rgba(255, 165, 0, 1)",
                "rgba(0, 0, 255, 1)",
                "rgba(128, 0, 128, 1)",
              ],
              borderWidth: 2,
            },
          ],
        };
      }

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
                if (mes === "Total Anual") {
                  label += "%";
                } else {
                  label += " días";
                }
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
  }
});
