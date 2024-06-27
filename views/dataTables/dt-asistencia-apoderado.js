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
    for (var dia = 1; dia <= diasEnMes; dia++) {
      var nombreDia = obtenerNombreDiaSemana(dia, mes, añoActual);
      encabezadoDiasSemana.append(
        '<td style="border: 1px solid black; text-align: center;">' +
          nombreDia +
          "</td>"
      );
    }
    tabla.append(encabezadoDiasSemana);

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

    data.forEach(function (entry) {
      if (entry.idAlumno == idAlumno && entry.Mes == mes) {
        var dia = entry["Día"];
        var estado = entry.estadoAsistencia;

        asistenciaPorDia[dia] = estado;
      }
    });

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

  function obtenerNombreDiaSemana(dia, nombreMes, año) {
    var mesNumerico = obtenerNumeroMes(nombreMes); // Obtener el número del mes a partir del nombre
    var fecha = new Date(año, mesNumerico - 1, dia); // mesNumerico - 1 porque en JavaScript los meses son de 0 a 11
    var diasSemana = ['DO', 'LU', 'MA', 'MI', 'JU', 'VI', 'SA']; // Array de días de la semana
    var nombreDia = diasSemana[fecha.getDay()]; // getDay() devuelve el día de la semana (0 para Domingo, 1 para Lunes, ..., 6 para Sábado)
    return nombreDia;
  }
  
  function obtenerNumeroMes(nombreMes) {
    var meses = [
      'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
      'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];
    return meses.indexOf(nombreMes) + 1; // Sumar 1 porque los meses en JavaScript van de 0 a 11
  }
});
