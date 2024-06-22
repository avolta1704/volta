$(document).ready(function () {
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
        response.forEach(function (fila) {
          fechaLimitePago.push(fila.proximaFechaPago);
          mesPago.push(fila.mesPago);
        });
        actualizarDatosProximaFechaPago(0);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
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
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }

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
        inicializarGraficoAsistencia(index); // Llamar a la función aquí también
      }
    });
  }

  let asistenciaChart;
  function inicializarGraficoAsistencia(indice) {
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
            "rgba(54, 162, 235, 0.8)",  // Azul
            "rgba(255, 99, 132, 0.8)",  // Rojo
            "rgba(255, 205, 86, 0.8)",  // Amarillo
            "rgba(75, 192, 192, 0.8)",  // Verde agua
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

  obtenerProximaFechaPagoApoderado(idAlumno);
  obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno);

  $(".alumno-item").click(function () {
    // Obtener el idAlumno del elemento clickeado
    var idAlumno = $(this).data("id-alumno");
    /*   datos.setAttribute('data-primer-id-alumno', idAlumno);
    // Recargar la página
    location.reload(); */
    // Actualizar la tabla con el nuevo idAlumno
    actualizarTablaConNuevoIdAlumno(idAlumno);
    obtenerProximaFechaPagoApoderado(idAlumno);
    obtenerRegistroAsistenciaPorAlumnoApoderado(idAlumno);
  });
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
