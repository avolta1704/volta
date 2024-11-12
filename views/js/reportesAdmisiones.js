// Select de meses
$("#anioLectivo").select2({
  theme: "bootstrap-5",
  width: $(this).data("width")
    ? $(this).data("width")
    : $(this).hasClass("w-100")
    ? "100%"
    : "style",
  placeholder: $(this).data("placeholder"),
  closeOnSelect: false,
});

$("#btnCerrarSeleccionarAnioLectivo").on("click", function () {
  // limpia el select
  $("#anioLectivo").val(null).trigger("change");
});

$("#btnDescargarAnioLectivo").on("click", function () {
  const anioLectivo = $("#anioLectivo").val();

  // valida si se selecciono un valor
  if (anioLectivo.length == 0) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Seleccione un año lectivo",
    });
    return;
  }

  // crear el formdata para el ajax
  const data = new FormData();
  data.append("anioLectivo", anioLectivo);

  // solicitud ajax
  $.ajax({
    url: "ajax/reportesAdmisiones.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      const dataPorGradoNivel = agruparPorGradoNivel(response);
      const anios = separarAnioLectivo(response.reportesPorAnioLectivo);
      crearExcelPorGradoNivel(dataPorGradoNivel, anios);

      if (response.length == 0) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se encontraron registros",
        });
        return;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });

  // limpiar el select
  $("#anioLectivo").val(null).trigger("change");
});

// Funcion para separar solo los años lectivos
function separarAnioLectivo(data) {
  const anios = [];
  data.forEach((element) => {
    const anio = element.descripcionAnio.split(" ")[1];
    if (!anios.includes(anio)) {
      anios.push(anio);
    }
  });

  return anios;
}

// funcion agrupar por grado y sacar un total de matriculados, retirados y trasladados
function agruparPorGradoNivel(result) {
  const grados = result.grados;
  const data = result.reportesPorAnioLectivo;

  const dataPorGradoNivel = [];
  grados.forEach((grado) => {
    const total = data.filter(
      (element) =>
        element.descripcionGrado == grado.descripcionGrado &&
        element.descripcionNivel == grado.descripcionNivel
    ).length;

    const estados = {
      matriculado: data.filter(
        (element) =>
          element.descripcionGrado == grado.descripcionGrado &&
          element.descripcionNivel == grado.descripcionNivel &&
          element.estadoAdmisionAlumno == 2 //"Matriculado"
      ).length,
      retirado: data.filter(
        (element) =>
          element.descripcionGrado == grado.descripcionGrado &&
          element.descripcionNivel == grado.descripcionNivel &&
          element.estadoAdmisionAlumno == 4 //"Retirado"
      ).length,
      trasladado: data.filter(
        (element) =>
          element.descripcionGrado == grado.descripcionGrado &&
          element.descripcionNivel == grado.descripcionNivel &&
          element.estadoAdmisionAlumno == 3 //"Trasladado"
      ).length,
    };

    dataPorGradoNivel.push({
      grado: grado.descripcionGrado,
      nivel: grado.descripcionNivel,
      total: total,
      estados: estados,
    });
  });

  return dataPorGradoNivel;
}

// funcion para crear un excel por grado y nivel
function crearExcelPorGradoNivel(data, anios) {
  const wb = XLSX.utils.book_new();

  const ws_data = [
    [`ESTUDIANTES MATRICULADOS, RETIRADOS Y TRASLADADOS ${anios.join("-")} `],
    [],
    ["GRADO", "MATRICULADOS", "RETIRADOS", "TRASLADADOS", "TOTAL"],
  ];
  data.forEach((element) => {
    ws_data.push([
      element.nivel.substring(0, 4).toUpperCase() +
        " " +
        element.grado.substring(0, 1).padStart(2, "0") +
        " A",
      element.estados.matriculado === 0 ? "" : element.estados.matriculado,
      element.estados.retirado === 0 ? "" : element.estados.retirado,
      element.estados.trasladado === 0 ? "" : element.estados.trasladado,
      element.total === 0 ? "" : element.total,
    ]);
  });

  // Add the total row to ws_data
  ws_data.push([
    "Total General",
    { f: `SUM(B4:B${data.length + 3})`, t: "n" },
    { f: `SUM(C4:C${data.length + 3})`, t: "n" },
    { f: `SUM(D4:D${data.length + 3})`, t: "n" },
    { f: `SUM(E4:E${data.length + 3})`, t: "n" },
  ]);

  const ws = XLSX.utils.aoa_to_sheet(ws_data);

  // Poner ancho a las columnas
  ws["!cols"] = [
    { width: 12 },
    { width: 15 },
    { width: 11 },
    { width: 13 },
    { width: 7 },
  ];

  XLSX.utils.book_append_sheet(wb, ws, "Reporte Matriculados");
  XLSX.writeFile(wb, "ReporteMatriculados.xlsx");
}

// limpiar el select si se cierra el modal
$("#modalAnioLectivo").on("hidden.bs.modal", function () {
  $("#anioLectivo").val(null).trigger("change");
});

// reportes por antiguedad
$("#btnDescargarReporteNuevosAntiguos").on("click", function () {
  const data = new FormData();
  data.append("reportesNuevosAntiguos", true);

  $.ajax({
    url: "ajax/reportesAdmisiones.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      const dataPorAntiguedad = agruparPorAntiguedad(response);
      crearExcelPorAntiguedad(dataPorAntiguedad);

      if (response.length == 0) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se encontraron registros",
        });
        return;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

// agrupar alumnos por antiguedad por el campo de alumno nuevoAlumno , 1 => nuevo, 0 => antiguo
function agruparPorAntiguedad(result) {
  const grados = result.grados;
  const data = result.reporteNuevosAntiguos;

  const dataPorGradoAntiguedad = [];
  grados.forEach((grado) => {
    const nuevos = data.filter(
      (element) =>
        element.descripcionGrado == grado.descripcionGrado &&
        element.descripcionNivel == grado.descripcionNivel &&
        element.nuevoAlumno == 1
    ).length;

    const antiguos = data.filter(
      (element) =>
        element.descripcionGrado == grado.descripcionGrado &&
        element.descripcionNivel == grado.descripcionNivel &&
        element.nuevoAlumno == 0
    ).length;

    dataPorGradoAntiguedad.push({
      grado: grado.descripcionGrado,
      nivel: grado.descripcionNivel,
      nuevos: nuevos,
      antiguos: antiguos,
    });
  });

  return dataPorGradoAntiguedad;
}

// funcion para crear un excel por antiguedad
function crearExcelPorAntiguedad(data) {
  const wb = XLSX.utils.book_new();
  const ws_data = [
    ["ESTUDIANTES ANTIGUOS Y NUEVOS"],
    [""],
    ["CUENTA", "ANTIGUOS", "NUEVOS", "Total"],
  ];
  data.forEach((element) => {
    ws_data.push([
      element.nivel.substring(0, 4).toUpperCase() +
        " " +
        element.grado.substring(0, 1).padStart(2, "0") +
        " A",
      element.antiguos === 0 ? "" : element.antiguos,
      element.nuevos === 0 ? "" : element.nuevos,
      element.nuevos + element.antiguos === 0
        ? ""
        : element.nuevos + element.antiguos,
    ]);
  });

  // Add the total row to ws_data
  ws_data.push([
    "Total General",
    { f: `SUM(B4:B${data.length + 3})`, t: "n" },
    { f: `SUM(C4:C${data.length + 3})`, t: "n" },
    { f: `SUM(D4:D${data.length + 3})`, t: "n" },
  ]);

  const ws = XLSX.utils.aoa_to_sheet(ws_data);

  XLSX.utils.book_append_sheet(wb, ws, "Reporte Antiguos Nuevos");
  XLSX.writeFile(wb, "ReporteAntiguosNuevos.xlsx");
}

// reportes por edad/sexo
$("#btnDescargarReporteEdadSexo").on("click", function () {
  const data = new FormData();
  data.append("reportesPorEdadSexo", true);

  $.ajax({
    url: "ajax/reportesAdmisiones.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      const dataPorSexo = agruparPorSexo(response);
      crearExcelPorSexo(dataPorSexo);

      if (response.length == 0) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se encontraron registros",
        });
        return;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

// agrupar alumnos por sexo
function agruparPorSexo(result) {
  const grados = result.grados;
  const data = result.reportePorEdadSexo;

  const dataPorGradoSexo = [];
  grados.forEach((grado) => {
    const hombres = data.filter(
      (element) =>
        element.descripcionGrado == grado.descripcionGrado &&
        element.descripcionNivel == grado.descripcionNivel &&
        element.sexoAlumno == "Masculino"
    ).length;

    const mujeres = data.filter(
      (element) =>
        element.descripcionGrado == grado.descripcionGrado &&
        element.descripcionNivel == grado.descripcionNivel &&
        element.sexoAlumno == "Femenino"
    ).length;

    dataPorGradoSexo.push({
      grado: grado.descripcionGrado,
      nivel: grado.descripcionNivel,
      hombres: hombres,
      mujeres: mujeres,
    });
  });

  return dataPorGradoSexo;
}

// funcion para crear un excel por sexo
function crearExcelPorSexo(data) {
  const wb = XLSX.utils.book_new();
  const ws_data = [
    ["ESTUDIANTES MUJERES Y HOMBRES"],
    [""],
    ["CUENTA", "MUJERES", "HOMBRES", "Total"],
  ];
  data.forEach((element) => {
    ws_data.push([
      element.nivel.substring(0, 4).toUpperCase() +
        " " +
        element.grado.substring(0, 1).padStart(2, "0") +
        " A",
      element.mujeres === 0 ? "" : element.mujeres,
      element.hombres === 0 ? "" : element.hombres,
      element.hombres + element.mujeres === 0
        ? ""
        : element.hombres + element.mujeres,
    ]);
  });

  // Add the total row to ws_data
  ws_data.push([
    "Total General",
    { f: `SUM(B4:B${data.length + 3})`, t: "n" },
    { f: `SUM(C4:C${data.length + 3})`, t: "n" },
    { f: `SUM(D4:D${data.length + 3})`, t: "n" },
  ]);

  const ws = XLSX.utils.aoa_to_sheet(ws_data);

  XLSX.utils.book_append_sheet(wb, ws, "Reporte Por Sexo");
  XLSX.writeFile(wb, "ReportePorSexo.xlsx");
}
$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  if (ultimoSegmento==="reporteAdmisiones") {
    var totalMatriculados = [];
    var totalTrasladados = [];
    var totalRetirados = [];
    var pieChart;
    var grados = [];
    var nuevosAlumnos = [];
    var antiguosAlumnos = [];

    var pieChartSexoGrado;
    var gradosSexo = [];
    var masculinos = [];
    var femeninos = [];
    // Función para obtener los alumnos por tipo de admision
    function obtenerAlumnosPorTipoAdmision() {
      var data = new FormData();
      data.append("todosAlumnosPorTipoReporte", true);

      $.ajax({
        url: "ajax/admisionAlumnos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          var grados = [];
          var matriculados = [];
          var trasladados = [];
          var retirados = [];

          response.forEach(function (fila) {
            grados.push(fila.descripcionGrado);
            matriculados.push(fila.matriculados);
            trasladados.push(fila.trasladados);
            retirados.push(fila.retirados);
          });

          // Actualizar gráfico con los datos obtenidos
          actualizarGrafico(grados, matriculados, trasladados, retirados);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
    // Función para actualizar el gráfico
    function actualizarGrafico(grados, matriculados, trasladados, retirados) {
      new ApexCharts(
        document.querySelector("#reportsChartGradoAlumnosTiposEstado"),
        {
          series: [
            {
              name: "Matriculados",
              data: matriculados,
            },
            {
              name: "Trasladados",
              data: trasladados,
            },
            {
              name: "Retirados",
              data: retirados,
            },
          ],
          chart: {
            height: 700, // Aumentar la altura del gráfico
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
        }
      ).render();
    }
    // Función para obtener el total de cursos asignados al alumno
    function obtenerTotalMatriculadosTrasladadosRetirados() {
      var data = new FormData();
      data.append("todosAlumnosMatriculadosTrasladadosRetirados", true);

      $.ajax({
        url: "ajax/admisionAlumnos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          totalMatriculados = [];
          totalTrasladados = [];
          totalRetirados = [];
          response.forEach(function (fila) {
            totalMatriculados.push(fila.matriculados);
            totalTrasladados.push(fila.trasladados);
            totalRetirados.push(fila.retirados);
          });
          actualizarDatosAlumnosMatriculadosTrasladadosRetirados(0);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }

    // Función para actualizar los datos de alumnos por grado
    function actualizarDatosAlumnosMatriculadosTrasladadosRetirados(indice) {
      const totalMatriculado = $(".total-alumnos-matriculados-reporte");
      const totalTrasladado = $(".total-alumnos-trasladados-reporte");
      const totalRetirado = $(".total-alumnos-retirados-reporte");
      totalMatriculado.text(
        totalMatriculados[indice].toLocaleString() + " Matriculados"
      );
      totalTrasladado.text(
        totalTrasladados[indice].toLocaleString() + " Trasladados"
      );
      totalRetirado.text(
        totalRetirados[indice].toLocaleString() + " Retirados"
      );
    }
    // Función para obtener los datos de alumnos nuevos y antiguos por grado
    function obtenerTotalNuevosAntiguosGrafico() {
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
          grados = [];
          nuevosAlumnos = [];
          antiguosAlumnos = [];
          // Procesar la respuesta para obtener los datos del gráfico
          response.forEach(function (fila) {
            grados.push(fila.grado_nivel);
            nuevosAlumnos.push(fila.nuevos);
            antiguosAlumnos.push(fila.antiguos);
          });

          // Poblar el dropdown con los grados
          poblarGradoNuevoAntiguoDropdown(grados);

          // Inicializar el gráfico de pastel con los datos del primer grado
          crearGraficoPastel(nuevosAlumnos[0], antiguosAlumnos[0], grados[0]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }

    // Función para poblar el dropdown de grados
    function poblarGradoNuevoAntiguoDropdown(grados) {
      var dropdown = $("#gradoNuevoAntiguoDropdown");
      dropdown.empty(); // Vaciar el dropdown antes de poblarlo

      grados.forEach(function (grado, index) {
        dropdown.append(
          '<li><a class="dropdown-item" href="#" onclick="filtrarGradoNuevosAntiguos(' +
            index +
            ')">' +
            grado +
            "</a></li>"
        );
      });
    }

    // Función para crear el gráfico de pastel
    function crearGraficoPastel(nuevos, antiguos, gradosindice) {
      const filtroSeleccionado = $(".filtro-seleccionado-grado-nuevo-antiguo");
      filtroSeleccionado.text("| " + gradosindice);
      var ctx = document
        .getElementById("pieChartNuevoAntiguo")
        .getContext("2d");

      pieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: ["Nuevos", "Antiguos"],
          datasets: [
            {
              data: [nuevos, antiguos],
              backgroundColor: ["#03b581", "#00bfff"],
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
    function actualizarGraficoPastel(nuevos, antiguos) {
      pieChart.data.datasets[0].data = [nuevos, antiguos];
      pieChart.update();
    }

    // Función para filtrar por grado
    window.filtrarGradoNuevosAntiguos = function (indice) {
      const filtroSeleccionado = $(".filtro-seleccionado-grado-nuevo-antiguo");
      filtroSeleccionado.text("| " + grados[indice]);
      actualizarGraficoPastel(nuevosAlumnos[indice], antiguosAlumnos[indice]);
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
            gradosSexo.push(fila.grado_nivel);
            masculinos.push(fila.total_masculinos);
            femeninos.push(fila.total_femeninos);
          });

          // Poblar el dropdown con los grados
          poblarGradoSexoDropdown(gradosSexo);

          // Inicializar el gráfico de pastel con los datos del primer grado
          crearGraficoPastelSexoGrado(masculinos[0], femeninos[0], gradosSexo[0]);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }

    // Función para poblar el dropdown de grados
    function poblarGradoSexoDropdown(gradosSexo) {
      var dropdown = $("#gradoSexoReporteAdmisionesDropdown");
      dropdown.empty(); // Vaciar el dropdown antes de poblarlo

      gradosSexo.forEach(function (gradosSexo, index) {
        dropdown.append(
          '<li><a class="dropdown-item" href="#" onclick="filtrarGradoSexoReporte(' +
            index +
            ')">' +
            gradosSexo +
            "</a></li>"
        );
      });
    }

    // Función para crear el gráfico de pastel
    function crearGraficoPastelSexoGrado(masculinos, femeninos, gradosindice) {
      const filtroSeleccionado = $(".filtro-seleccionado-grado-sexo-reporte-admisiones");
      filtroSeleccionado.text("| " + gradosindice);
      var ctx = document.getElementById("pieChartSexoGradoReporte").getContext("2d");

      pieChartSexoGrado = new Chart(ctx, {
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
    function actualizarGraficoPastelSexoGradoReporte(masculinos, femeninos) {
      pieChartSexoGrado.data.datasets[0].data = [masculinos, femeninos];
      pieChartSexoGrado.update();
    }

    // Función para filtrar por grado
    window.filtrarGradoSexoReporte = function (indice) {
      const filtroSeleccionado = $(".filtro-seleccionado-grado-sexo-reporte-admisiones");
      filtroSeleccionado.text("| " + gradosSexo[indice]);
      actualizarGraficoPastelSexoGradoReporte(masculinos[indice], femeninos[indice]);
    };

    obtenerAlumnosPorTipoAdmision();
    obtenerTotalMatriculadosTrasladadosRetirados();
    obtenerTotalNuevosAntiguosGrafico();
    obtenerTotalMasculinoFemenino();
  }
});
