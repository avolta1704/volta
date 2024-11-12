// btnDescargarReportePagos
$("#btnDescargarReportePagos").on("click", function () {
  $.ajax({
    url: "ajax/reportesPensiones.ajax.php",
    method: "POST",
    data: { todosLosPagosGeneral: true },
    dataType: "json",
  })
    .done(function (data) {
      const dataConMeses = organizarData(data);
      crearArchivoExcel(
        dataConMeses,
        "Reporte de Pagos General",
        "reporte_pagos_general"
      );
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);

      Swal.fire({
        icon: "error",
        title: "¡Error!",
        text: "No se pudo descargar el reporte de pagos.",
        showConfirmButton: false,
        timer: 1500,
      });
    });
});

// btnDescargarReporteInicial
$("#btnDescargarReporteInicial").on("click", function () {
  $.ajax({
    url: "ajax/reportesPensiones.ajax.php",
    method: "POST",
    data: { todosLosPensionesPendientesPorAlumno: true },
    dataType: "json",
  }).done(function (data) {
    const dataOrganizada = organizarData(data);
    const dataSoloInicial = dataOrganizada.filter(
      (item) => item.Nivel === "Inicial"
    );

    const dataFormateado = formatoDataReporteIndividual(dataSoloInicial);
    crearArchivoExcelSinNivel(
      dataFormateado,
      "Reporte Inicial",
      "reporte_pagos_inicial"
    );
  });
});

// btnDescargarReportePrimaria
$("#btnDescargarReportePrimaria").on("click", function () {
  $.ajax({
    url: "ajax/reportesPensiones.ajax.php",
    method: "POST",
    data: { todosLosPensionesPendientesPorAlumno: true },
    dataType: "json",
  }).done(function (data) {
    const dataOrganizada = organizarData(data);

    const dataSoloPrimaria = dataOrganizada.filter(
      (item) => item.Nivel === "Primaria"
    );

    const dataFormateado = formatoDataReporteIndividual(dataSoloPrimaria);
    crearArchivoExcelSinNivel(
      dataFormateado,
      "Reporte Primaria",
      "reporte_pagos_primaria"
    );
  });
});

// btnDescargarReporteSecundaria
$("#btnDescargarReporteSecundaria").on("click", function () {
  $.ajax({
    url: "ajax/reportesPensiones.ajax.php",
    method: "POST",
    data: { todosLosPensionesPendientesPorAlumno: true },
    dataType: "json",
  }).done(function (data) {
    const dataOrganizada = organizarData(data);
    const dataSoloSecundaria = dataOrganizada.filter(
      (item) => item.Nivel === "Secundaria"
    );
    const dataFormateado = formatoDataReporteIndividual(dataSoloSecundaria);

    crearArchivoExcelSinNivel(
      dataFormateado,
      "Reporte Secundaria",
      "reporte_pagos_secundaria"
    );
  });
});

// Select de meses
$("#selectMonth").select2({
  theme: "bootstrap-5",
  width: $(this).data("width")
    ? $(this).data("width")
    : $(this).hasClass("w-100")
    ? "100%"
    : "style",
  placeholder: $(this).data("placeholder"),
  closeOnSelect: false,
});

// Limpiar el select de meses al cerrar el modal
$("#seleccionarRangoFechas").on("hidden.bs.modal", function () {
  const $selectMonth = $("#selectMonth");
  $selectMonth.val(null).trigger("change");
});

// btnDescargarReporteRangoFecha
$("#btnDescargarReporteRangoFecha").on("click", function () {
  $.ajax({
    url: "ajax/reportesPensiones.ajax.php",
    method: "POST",
    data: { todosLosPagosPorRango: true },
    dataType: "json",
  })
    .done(function (data) {
      const meses = $("#selectMonth").val();

      const dataConMeses = organizarData(data);

      const dataFiltrada = filtrarDatosConMesesSeleccionados(
        dataConMeses,
        meses
      );

      const dataEstadoAlumno = dataFiltrada.map((item) => {
        if (item.Estado === 1) {
          item.Estado = "Anulado";
        } else if (item.Estado === 2) {
          item.Estado = "Matriculado";
        } else if (item.Estado === 3) {
          item.Estado = "Trasladado";
        } else if (item.Estado === 4) {
          item.Estado = "Retirado";
        } else {
          item.Estado = "Sin estado";
        }

        return item;
      });

      crearArchivoExcelConMesesSeleccionados(
        meses,
        dataEstadoAlumno,
        "Reporte de Pagos por Meses",
        "reporte_pagos_" + meses[0] + "_" + meses[meses.length - 1]
      );

      $("#seleccionarRangoFechas").modal("hide");
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);

      Swal.fire({
        icon: "error",
        title: "¡Error!",
        text: "No se pudo descargar el reporte de pagos.",
        showConfirmButton: false,
        timer: 1500,
      });
    });
});

/**
 * Filtra los datos de acuerdo a los meses especificados.
 *
 * @param {Array} dataConMeses - Los datos originales con información de los meses.
 * @param {Array} mes - Los meses a filtrar.
 * @returns {Array} - Los datos filtrados.
 */
const filtrarDatosConMesesSeleccionados = (dataConMeses, mes) => {
  return dataConMeses.map((item) => {
    const filteredItem = {
      Alumno: item.Alumno,
      DNI: item.DNI,
      Grado: item.Grado,
      Nivel: item.Nivel,
      Estado: item.Estado,
    };

    Object.keys(item).forEach((key) => {
      if (mes.includes(key)) {
        filteredItem[key] = item[key];
      }
    });

    return filteredItem;
  });
};

/**
 * Formatea los datos de un reporte individual eliminando la propiedad "Nivel" de cada objeto.
 * @param {Array} data - Los datos a formatear.
 * @returns {Array} - Los datos formateados.
 */
const formatoDataReporteIndividual = (data) => {
  return data.map((item) => {
    delete item.Nivel;
    return item;
  });
};

/**
 * Organiza los datos de acuerdo a ciertas condiciones.
 * @param {Array} data - Los datos a organizar.
 * @returns {Array} - Los datos organizados.
 */
const organizarData = (data) => {
  const dataConMeses = data.map((item) => {
    item.meses.forEach((mes) => {
      if (mes.estadoCronograma === 1) {
        mes.estadoCronograma = "";
      } else if (mes.estadoCronograma === 2 || mes.estadoCronograma === 3) {
        mes.estadoCronograma = 1;
      }
      item[mes.mesPago] = mes.estadoCronograma;
    });
    delete item.meses;
    return item;
  });
  return dataConMeses;
};

/**
 * Crea un archivo Excel a partir de los datos proporcionados.
 *
 * @param {Array} data - Los datos que se utilizarán para crear el archivo Excel.
 * @param {string} nombreHoja - El nombre de la hoja de trabajo en el archivo Excel.
 * @param {string} nombreArchivo - El nombre del archivo Excel.
 */
const crearArchivoExcel = (data, nombreHoja, nombreArchivo) => {
  // Crear un nuevo libro de trabajo
  var workbook = XLSX.utils.book_new();

  // Crear una hoja de trabajo
  const ws = XLSX.utils.json_to_sheet(data, {
    header: [
      "Alumno",
      "DNI",
      "Grado",
      "Nivel",
      "Matricula",
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
    ],
  });

  const date = new Date().toLocaleDateString().replaceAll("/", "-");

  // Agregar estilo a la columna A

  // Agregar la hoja de trabajo al libro de trabajo
  XLSX.utils.book_append_sheet(workbook, ws, nombreHoja);

  // Generar el archivo Excel
  var excelBuffer = XLSX.write(workbook, {
    bookType: "xlsx",
    type: "array",
  });

  // Convertir el archivo Excel en un Blob
  var blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  // Crear un enlace de descarga
  var url = URL.createObjectURL(blob);
  var link = document.createElement("a");
  link.href = url;
  link.download = nombreArchivo + ".xlsx";
  link.click();

  // Liberar el enlace de descarga
  URL.revokeObjectURL(url);
};

/**
 * Crea un archivo Excel sin nivel a partir de los datos proporcionados.
 *
 * @param {Array} data - Los datos que se utilizarán para crear el archivo Excel.
 * @param {string} nombreHoja - El nombre de la hoja de trabajo en el archivo Excel.
 * @param {string} nombreArchivo - El nombre del archivo Excel.
 */
const crearArchivoExcelSinNivel = (data, nombreHoja, nombreArchivo) => {
  // Crear un nuevo libro de trabajo
  var workbook = XLSX.utils.book_new();

  // Crear una hoja de trabajo
  const ws = XLSX.utils.json_to_sheet(data, {
    header: [
      "Alumno",
      "DNI",
      "Grado",
      "Matricula",
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
    ],
  });

  const date = new Date().toLocaleDateString().replaceAll("/", "-");

  // Agregar estilo a la columna A

  // Agregar la hoja de trabajo al libro de trabajo
  XLSX.utils.book_append_sheet(workbook, ws, nombreHoja);

  // Generar el archivo Excel
  var excelBuffer = XLSX.write(workbook, {
    bookType: "xlsx",
    type: "array",
  });

  // Convertir el archivo Excel en un Blob
  var blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  // Crear un enlace de descarga
  var url = URL.createObjectURL(blob);
  var link = document.createElement("a");
  link.href = url;
  link.download = nombreArchivo + ".xlsx";
  link.click();

  // Liberar el enlace de descarga
  URL.revokeObjectURL(url);
};

/**
 * Crea un archivo Excel con los meses seleccionados.
 *
 * @param {Array<string>} meses - Los meses seleccionados.
 * @param {Array<Object>} data - Los datos a incluir en el archivo Excel.
 * @param {string} nombreHoja - El nombre de la hoja de trabajo en el archivo Excel.
 * @param {string} nombreArchivo - El nombre del archivo Excel.
 */
const crearArchivoExcelConMesesSeleccionados = (
  meses,
  data,
  nombreHoja,
  nombreArchivo
) => {
  // Crear un nuevo libro de trabajo
  var workbook = XLSX.utils.book_new();

  // Crear una hoja de trabajo
  const ws = XLSX.utils.json_to_sheet(data, {
    header: ["Alumno", "DNI", "Grado", "Nivel", "Estado", ...meses],
  });

  const date = new Date().toLocaleDateString().replaceAll("/", "-");

  // Agregar estilo a la columna A

  // Agregar la hoja de trabajo al libro de trabajo
  XLSX.utils.book_append_sheet(workbook, ws, nombreHoja);

  // Generar el archivo Excel
  var excelBuffer = XLSX.write(workbook, {
    bookType: "xlsx",
    type: "array",
  });

  // Convertir el archivo Excel en un Blob
  var blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  // Crear un enlace de descarga
  var url = URL.createObjectURL(blob);
  var link = document.createElement("a");
  link.href = url;
  link.download = nombreArchivo + ".xlsx";
  link.click();

  // Liberar el enlace de descarga
  URL.revokeObjectURL(url);
};

//  Vista para el modal de cronograma de pagos de Reporte de Pensisones Atrasadas
$(".dataTableReportesPensiones").on(
  "click",
  ".btnVisualizarAdmisionAlumno",
  function () {
    var idAdmisionAlumno = $(this).attr("idAdmisionAlumno");
    var data = new FormData();
    data.append("codAdAlumCronograma", idAdmisionAlumno);

    $.ajax({
      url: "ajax/admisionAlumnos.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        var modalBody = $("#cronogramaPagoDeuda .modal-body");
        modalBody.empty();

        $.each(response, function (index, item) {
          var div = $("<div>").addClass("mb-3");

          var label2 = $("<label>")
            .addClass("form-label h5 font-weight-bold")
            .attr("id", "tipoCronoPago")
            .attr("name", "tipoCronoPago")
            .css("margin-left", "8px") // Agrega un margen a la izquierda
            .html("<strong>" + item.mesPago + "</strong>");

          var inputGroup = $("<div>").addClass("input-group");

          var input1 = $("<input>")
            .attr("type", "text")
            .addClass("form-control")
            .attr("id", "fechaPago")
            .attr("name", "fechaPago")
            // uso de la funcion para justar el formato de la fecha
            .val("Fecha Límite: " + formatFecha(item.fechaLimite))
            .attr("readonly", true)
            .css("width", "auto"); // Establecer el ancho automático

          var input2 = $("<input>")
            .attr("type", "text")
            .addClass("form-control")
            .attr("id", "montoPago")
            .attr("name", "montoPago")
            .val("Monto: S/ " + item.montoPago)
            .attr("readonly", true)
            .css("width", "75px"); // Ajusta este valor según tus necesidades

          var input3 = $("<div>")
            .addClass("form-control fs-6 text-center")
            .attr("id", "stadoCronograma")
            .attr("name", "stadoCronograma")
            .html(item.estadoCronogramaPago);

          // Agregamos los elementos al div principal
          inputGroup.append(input1, input2, input3);
          div.append(label2, inputGroup);
          modalBody.append(div);
        });

        $("#cronogramaPagoDeuda").modal("show");
      },
      /*  error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
        }, */
    });
  }
);

//boton para ir a la vista agregar pago
$(".dataTableReportesPensiones").on(
  "click",
  ".btnEditarEstadoAdmisionAlumno",
  function () {
    window.location = "index.php?ruta=registrarPago&ReportePensiones=1";
  }
);

//boton para ir a la vista de comunicado de pago
$(".dataTableReportesPensiones").on(
  "click",
  ".btnEliminarAdmisionAlumno",
  function () {
    // Obtener el código de pago del atributo del botón
    var codAdAlumCronograma = $(this).attr("codAdAlumCronograma");
    var codAlumno = $(this).attr("codAlumno");

    window.location =
      "index.php?ruta=registrarComunicadoPago&codAdAlumCronograma=" +
      codAlumno +
      "&codAlumno=" +
      codAlumno;
  }
);

// Descargar reporte general del pensiones
$("#btnDescargarExcelReportePagos").on("click", function () {
  var data = new FormData();
  data.append("todosLosPagos", true);
  $.ajax({
    url: "ajax/pagos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      crearExcelTodosPensiones(response, "Listado_Pago", "BASE_PENSIONES");

      if (response.length == 0) {
        Swal.fire({
          icon: "warning",
          title: "Aviso",
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

function numeroMesPension(nombreMes) {
  const meses = {
    enero: 1,
    febrero: 2,
    marzo: 3,
    abril: 4,
    mayo: 5,
    junio: 6,
    julio: 7,
    agosto: 8,
    septiembre: 9,
    octubre: 10,
    noviembre: 11,
    diciembre: 12,
  };
  // Convertir el nombre del mes a minúsculas para hacer la búsqueda insensible a mayúsculas
  const mesMinuscula = nombreMes.toLowerCase();

  // Verificar si el mes existe en el objeto meses
  if (meses.hasOwnProperty(mesMinuscula)) {
    return meses[mesMinuscula].toString().padStart(2, "0");
  } else {
    return "-";
  }
}

function numberAnioEscolar(anio) {
  return anio.split(" ")[1];
}

function crearExcelTodosPensiones(data, nombreHoja, nombreArchivo) {
  // Crear un nuevo libro de trabajo
  var workbook = XLSX.utils.book_new();
  const ws_data = [
    [
      "CÓDIGO",
      "ALUMNO",
      "NIVEL",
      "PENSION",
      "MONTO",
      "MORA",
      "AGENCIA",
      "MES",
      "FECHA PAGO",
      "N° COMPROBANTE",
      "BOLETA ELECTRÓNICA",
    ],
  ];

  data.forEach((element) => {
    ws_data.push([
      element.codAlumnoCaja,
      element.apellidosAlumno + ", " + element.nombresAlumno,
      element.descripcionNivel.substring(0, 4).toUpperCase() +
        " " +
        element.descripcionGrado.substring(0, 1).padStart(2, "0") +
        " U",
      "SUBPERIODO " +
        numberAnioEscolar(element.descripcionAnio) +
        numeroMesPension(element.mesPago),
      element.cantidadPago,
      element.moraPago,
      element.metodoPago,
      element.mesPago,
      element.fechaPago,
      element.numeroComprobante,
      element.boletaElectronica,
    ]);
  });

  // Crear una hoja de trabajo
  const ws = XLSX.utils.aoa_to_sheet(ws_data);

  // Agregar estilo a la fila 1
  ws["!rows"] = [{ hpt: 40 }];

  ws["!cols"] = [
    { width: 10 },
    { width: 25 },
    { width: 13 },
    { width: 20 },
    { width: 10 },
    { width: 10 },
    { width: 20 },
    { width: 13 },
    { width: 13 },
    { width: 20 },
    { width: 21 },
  ];

  // Agregar la hoja de trabajo al libro de trabajo
  XLSX.utils.book_append_sheet(workbook, ws, nombreHoja);

  // Generar el archivo Excel
  var excelBuffer = XLSX.write(workbook, {
    bookType: "xlsx",
    type: "array",
  });

  // Convertir el archivo Excel en un Blob
  var blob = new Blob([excelBuffer], {
    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
  });

  // Crear un enlace de descarga
  var url = URL.createObjectURL(blob);
  var link = document.createElement("a");
  link.href = url;
  link.download = nombreArchivo + ".xlsx";
  link.click();

  // Liberar el enlace de descarga
  URL.revokeObjectURL(url);
}
$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();
  if (ultimoSegmento==="reportePagos") {
    var niveles = [];
    var pagosPendientes = [];
    var pagosRealizados = [];
    // Función para obtener pensiones atrasadas por grado
    function obtenerNumeroPensionesAtrasadasPorGrados() {
      var data = new FormData();
      data.append("todosLosPagosPendientesPorGrado", true);

      $.ajax({
        url: "ajax/pagos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          var grados = [];
          var pagosPendientes = [];

          response.forEach(function (fila) {
            grados.push(fila.descripcionGrado);
            pagosPendientes.push(fila.pagosPendientes);
          });

          // Actualizar gráfico con los datos obtenidos
          actualizarGrafico(grados, pagosPendientes);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
    // Función para actualizar el gráfico
    function actualizarGrafico(grados, alumnos) {
      new ApexCharts(
        document.querySelector("#reportsChartPagosPendienteporGrado"),
        {
          series: [
            {
              name: "Pagos Pendientes",
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
                return val + " Pagos Pendientes";
              },
            },
          },
        }
      ).render();
    }
    // Función para obtener los pagos realizados y pendientes por niveles
    function obtenerCantidadPagosRealizadosPendientesNiveles() {
      var data = new FormData();
      data.append("cantidadPagosRealizadosPendientesNiveles", true);

      $.ajax({
        url: "ajax/pagos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          // Procesar la respuesta para obtener los datos del gráfico
          response.forEach(function (fila) {
            niveles.push(fila.descripcionNivel);
            pagosRealizados.push(fila.pagosRealizados);
            pagosPendientes.push(fila.pagosPendientes);
          });
          // Inicializar el gráfico de pastel con los datos del primer grado
          crearGraficoPastel(
            pagosRealizados[0],
            pagosPendientes[0],
            niveles[0],
            "pieChartInicalPagosReporte",
            ".filtro-seleccionado-nivel-pago1"
          );
          crearGraficoPastel(
            pagosRealizados[1],
            pagosPendientes[1],
            niveles[1],
            "pieChartPrimariaPagosReporte",
            ".filtro-seleccionado-nivel-pago2"
          );
          crearGraficoPastel(
            pagosRealizados[2],
            pagosPendientes[2],
            niveles[2],
            "pieChartSecundariaPagosReporte",
            ".filtro-seleccionado-nivel-pago3"
          );
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }

    // Función para crear el gráfico de pastel
    function crearGraficoPastel(
      nuevos,
      antiguos,
      gradosindice,
      grafico,
      nivelasignado
    ) {
      const filtroSeleccionado = $(nivelasignado);
      filtroSeleccionado.text("| " + gradosindice);
      var ctx = document.getElementById(grafico).getContext("2d");

      pieChart = new Chart(ctx, {
        type: "pie",
        data: {
          labels: ["Realizados", "Pendientes"],
          datasets: [
            {
              data: [nuevos, antiguos],
              backgroundColor: ["#28a745", "#ff851b"],
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        },
      });
    }
    obtenerNumeroPensionesAtrasadasPorGrados();
    obtenerCantidadPagosRealizadosPendientesNiveles();
  }
});
