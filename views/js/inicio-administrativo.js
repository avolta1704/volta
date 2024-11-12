$(document).ready(function () {
// Obtener la ruta actual de la URL
var rutaActual = window.location.pathname;
// Obtener el último segmento de la ruta
var ultimoSegmento = rutaActual.split("/").pop();
// Verificar si el último segmento es "inicio"
if (ultimoSegmento === "inicio") {
    const datos = document.getElementById("datos");
    let tipoUsuario = datos.getAttribute("data-tipo-usuario");
    if (tipoUsuario === "3" || tipoUsuario === "1") {
    var pagosPorMes = {};
    var porcentajePorMes = {};
    var totalPensiones = 0;
    var meses = [];
    var descripcionesAnio = [];
    var estadosAnio = [];
    var totalesAlumnos = [];
    var mesesRecaudado = [];
    var totalRecaudadoPorMes = {};

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
  }
}
});
