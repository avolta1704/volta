$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();

  // Verificar si la rutaActual contiene "volta/asistenciaAlumnosDocentes"
  if (ultimoSegmento==="asistenciaAlumnosDocentes") {
    // Descripcion del Curso Grado para asignarle a la asistencia
    var descripcionCursoGradoGlobal = null;
    //  Obtener el tipo de docente y establecer el data table a partir de este identificador
    var tipoDocente = document.getElementById(
      "asistenciaAlumnoDocenteContainer"
    ).dataset.tipoDocente;

    //  Identificar el tipo de usuario y en base a este valor se le muestra un datatable u otro.
    if (tipoDocente === "1" || tipoDocente === "2") {
      document.getElementById("alumnosAsistenciaContainer").style.display =
        "block";
      document.getElementById("tablaCursosDocenteAsistencia").style.display =
        "none";
      var listaIdentificadores = document.getElementById(
        "asistenciaAlumnoDocenteContainer"
      ).dataset.identificadores;
      listaIdentificadores = JSON.parse(listaIdentificadores);
      obtenerDescripcionCursoGrado(
        listaIdentificadores[0]["idCurso"],
        listaIdentificadores[0]["idGrado"],
        listaIdentificadores[0]["idPersonal"]
      );
      actualizarDatosAsistenciaAlumnos(
        listaIdentificadores[0]["idCurso"],
        listaIdentificadores[0]["idGrado"],
        listaIdentificadores[0]["idPersonal"]
      );
    } else if (tipoDocente === "3" || tipoDocente === "4") {
      document.getElementById("alumnosAsistenciaContainer").style.display =
        "none";
      document.getElementById("tablaCursosDocenteAsistencia").style.display =
        "block";
      // Titulo dataTableAsistenciaAlumnosDocente
      $(".tituloAsistenciaAlumnosDocente").text("Todos mis Cursos");
      document.getElementById("idNavegacionNombreAsistencia").textContent =
        "Todos mis Cursos";
      var columnDefsAlumnosDocente = [
        { data: "descripcionCurso" },
        { data: "descripcionGrado" },
        { data: "acciones" },
      ];
      var tablaAlumnosDocente = $(
        "#dataTableAsistenciaAlumnosDocente"
      ).DataTable({
        columns: columnDefsAlumnosDocente,
      });
      //Solicitud inicial de dataTableAlumnosDocente
      var data = new FormData();
      data.append("todosLosGradosAsistencia", true);

      $.ajax({
        url: "ajax/alumnosDocente.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",

        success: function (response) {
          tablaAlumnosDocente.clear();
          tablaAlumnosDocente.rows.add(response);
          tablaAlumnosDocente.draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });

      //Estructura de dataTableAlumnosDocente
      $("#dataTableAsistenciaAlumnosDocente thead").html(`
 <tr>
   <th scope="col">#</th>
   <th scope="col">Curso</th>
   <th scope="col">Grado</th>
   <th scope="col">Acciones</th>
 </tr>
 `);

      tablaAlumnosDocente.destroy();

      columnDefsAlumnosDocente = [
        {
          data: null,
          render: function (data, type, row, meta) {
            return meta.row + 1;
          },
        },
        { data: "descripcionCurso" },
        { data: "descripcionGrado" },
        { data: "acciones" },
      ];
      tablaAlumnosDocente = $("#dataTableAsistenciaAlumnosDocente").DataTable({
        columns: columnDefsAlumnosDocente,
      });
    }
    function actualizarDatosAsistenciaAlumnos(idCurso, idGrado, idPersonal) {
      // Titulo dataTableAsistenciaAlumnosDocente
      $(".tituloAsistenciaAlumnosDocente").text("Asistencia");
      var selectMes = $("#selectMesDocenteAsistencia");
      // Evento cuando se selecciona un mes
      selectMes.change(function () {
        var mes = selectMes.find("option:selected").text().trim(); // Asegurarse de que el texto del mes no tenga espacios en blanco al inicio o al final
        var mesValue = selectMes.val(); // Obtener el valor del mes seleccionado

        // Verificar que tanto idAlumno como mes estén seleccionados y no sean valores predeterminados
        if (mesValue == "1" || mes == "Ninguna Opción") {
          var asistenciaContainer = $("#asistenciaAlumnoDocenteContainer");
          asistenciaContainer.empty(); // Limpiar el contenedor
        } else {
          obtenerAsistencia(idCurso, idGrado, idPersonal, mes);
        }
      });
      // Funcion para obtener el registro de asistencia del alumno en base al select de alumno y al select de mes
      function obtenerAsistencia(idCurso, idGrado, idPersonal, mes) {
        var data = new FormData();
        data.append("idCursoAsistenciaAlumnosDocente", idCurso);
        data.append("idGradoAsistenciaAlumnosDocente", idGrado);
        data.append("idPersonalAsistenciaAlumnosDocente", idPersonal);

        $.ajax({
          url: "ajax/asistenciaAlumnos.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            generarTabla(response, mes);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText); // Procedencia de error
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
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

      function generarTabla(data, mes) {
        // Obtener el año actual
        var añoActual = new Date().getFullYear();
        var diasEnMes = obtenerDiasEnMes(mes, añoActual); // Obtener días en el mes seleccionado
        var asistenciaContainer = $("#asistenciaAlumnoDocenteContainer");
        asistenciaContainer.empty(); // Limpiar el contenedor antes de agregar la nueva tabla

        // Crear la tabla con estilo en línea
        var tabla = $(
          '<table style="border: 2px solid black; border-collapse: collapse; width: 100%;"></table>'
        );
        var encabezadoMes = $("<tr></tr>");
        var encabezadoDiasSemana = $("<tr></tr>");
        var encabezadoDias = $("<tr></tr>");

        // Fila del mes
        encabezadoMes.append(
          '<td colspan="' +
            (diasEnMes - countWeekends(mes, añoActual) + 1) + // Ajuste para omitir los fines de semana
            '" style="text-align: center; font-weight: bold; background-color: #00bfbf;">' +
            mes +
            "</td>"
        );
        tabla.append(encabezadoMes);

        // Fila de los nombres de los días de la semana
        encabezadoDiasSemana.append(
          '<td rowspan="2" style="border: 1px solid black; font-weight: bold; background-color: #fbbc27; text-align: center;">Días</td>'
        );

        // Iterar sobre los días de la semana
        for (var dia = 1; dia <= diasEnMes; dia++) {
          var nombreDia = obtenerNombreDiaSemana(dia, mes, añoActual);
          if (nombreDia !== "SA" && nombreDia !== "DO") {
            // Omitir sábados y domingos
            encabezadoDiasSemana.append(
              '<td style="border: 1px solid black; text-align: center; background-color: #d7464c; color: white;">' +
                nombreDia +
                "</td>"
            );
          }
        }
        tabla.append(encabezadoDiasSemana);
        // Fila de los números de los días
        for (var dia = 1; dia <= diasEnMes; dia++) {
          var nombreDia = obtenerNombreDiaSemana(dia, mes, añoActual);
          if (nombreDia !== "SA" && nombreDia !== "DO") {
            // Omitir sábados y domingos
            encabezadoDias.append(
              '<td style="border: 1px solid black; text-align: center;">' +
                dia +
                "</td>"
            );
          }
        }
        tabla.append(encabezadoDias);

        // Agrupar datos por nombreCompleto
        var asistenciaPorAlumno = {};
        data.forEach(function (entry) {
          if (entry.Mes === mes) {
            if (!asistenciaPorAlumno[entry.nombreCompleto]) {
              asistenciaPorAlumno[entry.nombreCompleto] = {};
            }
            asistenciaPorAlumno[entry.nombreCompleto][entry.Día] =
              entry.estadoAsistencia;
          }
        });

        // Generar filas de asistencia para cada alumno
        Object.keys(asistenciaPorAlumno).forEach(function (nombreCompleto) {
          var filaAsistencia = $("<tr></tr>");
          filaAsistencia.append(
            '<td style="border: 1px solid black; text-align: center; width: 250px;">' +
              nombreCompleto +
              "</td>"
          );

          for (var dia = 1; dia <= diasEnMes; dia++) {
            var nombreDia = obtenerNombreDiaSemana(dia, mes, añoActual);
            if (nombreDia !== "SA" && nombreDia !== "DO") {
              // Omitir sábados y domingos
              var celdaEstado = $(
                '<td style="border: 1px solid black; text-align: center; width: 45px; font-weight: bold"></td>'
              ); // Celda de estado sin estilo
              if (asistenciaPorAlumno[nombreCompleto][dia]) {
                var estado = asistenciaPorAlumno[nombreCompleto][dia];
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
          }

          tabla.append(filaAsistencia);
        });

        asistenciaContainer.append(tabla);
      }

      // Función para contar los fines de semana en un mes
      function countWeekends(nombreMes, año) {
        var mesNumerico = obtenerNumeroMes(nombreMes);
        var diasEnMes = new Date(año, mesNumerico, 0).getDate();
        var count = 0;
        for (var dia = 1; dia <= diasEnMes; dia++) {
          var fecha = new Date(año, mesNumerico - 1, dia);
          var diaSemana = fecha.getDay();
          if (diaSemana === 0 || diaSemana === 6) {
            count++;
          }
        }
        return count;
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
    }
    $("#dataTableAsistenciaAlumnosDocente").on(
      "click",
      ".btnVerAsistenciaAlumnosCursoDocente",
      function () {
        var idCurso = $(this).attr("idCurso");
        var idGrado = $(this).attr("idGrado");
        var idPersonal = $(this).attr("idPersonal");

        // Quitar la clase 'active' del elemento existente
        $("#idNavegacionNombreAsistencia").removeClass("active");
        // Crear un nuevo elemento <a> y agregarlo dentro de #idNavegacionNombreCursos
        $("#idNavegacionNombreAsistencia")
          .empty()
          .append('<a href="asistenciaAlumnosDocentes">Todos mis Cursos</a>');
        $(".breadcrumb").append(
          '<li class="breadcrumb-item active">Asistencia</li>'
        );
        document.getElementById("alumnosAsistenciaContainer").style.display =
          "block";
        document.getElementById("tablaCursosDocenteAsistencia").style.display =
          "none";
        obtenerDescripcionCursoGrado(idCurso, idGrado, null);
        actualizarDatosAsistenciaAlumnos(idCurso, idGrado, idPersonal);
      }
    );
    function obtenerDescripcionCursoGrado(idCurso, idGrado, idPersonal) {
      var data = new FormData();
      data.append("idCursoAsistenciaDescripcion", idCurso);
      data.append("idGradoAsistenciaDescripcion", idGrado);

      $.ajax({
        url: "ajax/cursos.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          if (idPersonal != null) {
            descripcionCursoGradoGlobal = response["descripcionGrado"];
          } else {
            descripcionCursoGradoGlobal =
              response["descripcionCurso"] +
              " - " +
              response["descripcionGrado"];
          }
          // Seleccionar el elemento del DOM con el ID 'labelCursoGradoAsistencia'
          let labelCursoGradoAsistencia = document.getElementById(
            "labelCursoGradoAsistencia"
          );

          // Actualizar el valor del input
          labelCursoGradoAsistencia.value = descripcionCursoGradoGlobal;
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // Procedencia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
  }
});
