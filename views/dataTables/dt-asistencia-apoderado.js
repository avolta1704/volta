$(document).ready(function () {
  // Variables para los selectores
  var selectAlumno = $("#selectAlumno");
  var selectMes = $("#selectMes");

  // Evento cuando se selecciona un alumno o un mes
  selectAlumno.add(selectMes).change(function () {
    var idAlumno = selectAlumno.val();
    var mes = selectMes.find("option:selected").text(); // Obtener el nombre del mes seleccionado

    if (idAlumno && mes) {
      obtenerAsistencia(idAlumno, mes);
    }
  });

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
        console.log(response); // Para depuración
        generarTabla(response, idAlumno, mes);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // Procedencia de error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }

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
    var añoActual = new Date().getFullYear();
    var diasEnMes = obtenerDiasEnMes(mes, añoActual); // Obtener días en el mes seleccionado

    var asistenciaContainer = $("#asistenciaContainer");
    asistenciaContainer.empty(); // Limpiar el contenedor antes de agregar la nueva tabla

    // Crear la tabla con estilo en línea
    var tabla = $(
      '<table style="border: 1px solid black; border-collapse: collapse; width: 100%;"></table>'
    );
    var encabezadoMes = $("<tr></tr>");
    var encabezadoDias = $("<tr></tr>");
    var filaAsistencia = $("<tr></tr>");

    // Fila del mes
    encabezadoMes.append('<td colspan="' + (diasEnMes + 1) + '">Mes</td>'); // Colspan ajustado para incluir la primera columna de "Días"
    tabla.append(encabezadoMes);

    // Fila de los días
    encabezadoDias.append('<td style="border: 1px solid black;">Días</td>');
    for (var dia = 1; dia <= diasEnMes; dia++) {
      encabezadoDias.append(
        '<td style="border: 1px solid black;">' + dia + "</td>"
      );
    }
    tabla.append(encabezadoDias);

    // Fila de la asistencia
    filaAsistencia.append(
      '<td style="border: 1px solid black;">Asistencia</td>'
    );

    var asistenciaPorDia = {}; // Objeto para guardar la asistencia por día

    data.forEach(function (entry) {
      if (entry.idAlumno == idAlumno && entry.Mes == mes) {
        var dia = entry["Día"];
        var estado = entry.estadoAsistencia;

        asistenciaPorDia[dia] = estado;
      }
    });

    for (var dia = 1; dia <= diasEnMes; dia++) {
      var celdaEstado = $('<td style="border: 1px solid black;"></td>'); // Celda de estado sin estilo
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
});
