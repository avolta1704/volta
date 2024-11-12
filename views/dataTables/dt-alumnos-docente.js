$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();

  // Verificar si la rutaActual contiene "volta/listaAlumnosDocentes"
  if (ultimoSegmento === "listaAlumnosDocentes") {
    //  Obtener el tipo de docente y establecer el data table a partir de este identificador
    var tipoDocente = document.getElementById("dataTableAlumnosDocente").dataset
      .tipoDocente;
    var listaIdentificadores = document.getElementById(
      "dataTableAlumnosDocente"
    ).dataset.identificadores;
    listaIdentificadores = JSON.parse(listaIdentificadores);

    //  Identificar el tipo de usuario y en base a este valor se le muestra un datatable u otro.
    if (tipoDocente === "1" || tipoDocente === "2") {
      actualizarDatosTabla(
        listaIdentificadores[0]["idCurso"],
        listaIdentificadores[0]["idGrado"],
        listaIdentificadores[0]["idPersonal"]
      );
    } else if (tipoDocente === "3" || tipoDocente === "4") {
      // Titulo dataTableAlumnosDocente
      $(".tituloCursosDocente").text("Todos mis Cursos");
      document.getElementById("idNavegacionNombreCursos").textContent =
        "Todos mis Cursos";
      var columnDefsAlumnosDocente = [
        { data: "descripcionCurso" },
        { data: "descripcionGrado" },
        { data: "acciones" },
      ];
      var tablaAlumnosDocente = $("#dataTableAlumnosDocente").DataTable({
        columns: columnDefsAlumnosDocente,
      });
      //Solicitud inicial de dataTableAlumnosDocente
      var data = new FormData();
      data.append("todosLosGrados", true);

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
      $("#dataTableAlumnosDocente thead").html(`
<tr>
  <th scope="col">#</th>
  <th scope="col">Nivel</th>
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
      tablaAlumnosDocente = $("#dataTableAlumnosDocente").DataTable({
        columns: columnDefsAlumnosDocente,
      });
    }
    function actualizarDatosTabla(idCurso, idGrado, idPersonal) {
      $(".tituloCursosDocente").text("Todos mis Alumnos");

      // Prepara los datos para la solicitud AJAX
      var data = new FormData();
      data.append("todosLosAlumnosDocente", true);
      data.append("idCurso", idCurso);
      data.append("idGrado", idGrado);
      data.append("idPersonal", idPersonal);

      // Realiza la solicitud AJAX
      $.ajax({
        url: "ajax/alumnosDocente.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          // Verifica si el DataTable ya está inicializado y lo destruye si es necesario
          if ($.fn.DataTable.isDataTable("#dataTableAlumnosDocente")) {
            $("#dataTableAlumnosDocente").DataTable().destroy();
          }

          // Actualiza la estructura del thead antes de inicializar DataTable
          $("#dataTableAlumnosDocente thead").html(`
              <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Apellido</th>
                  <th scope="col">Acciones</th>
              </tr>
          `);

          // Define las columnas para DataTable
          var columnDefsAlumnosDocente = [
            {
              data: null,
              render: function (data, type, row, meta) {
                return meta.row + 1; // Añade un contador de filas
              },
            },
            { data: "nombresAlumno" },
            { data: "apellidosAlumno" },
            { data: "acciones" },
          ];

          // Inicializa el DataTable con la nueva configuración
          var tablaAlumnosDocente = $("#dataTableAlumnosDocente").DataTable({
            columns: columnDefsAlumnosDocente,
          });

          // Limpia los datos actuales de la tabla y agrega los nuevos
          tablaAlumnosDocente.clear().rows.add(response).draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
    $("#dataTableAlumnosDocente").on(
      "click",
      ".btnVerAlumnosCursoDocente",
      function () {
        var idCurso = $(this).attr("idCurso");
        var idGrado = $(this).attr("idGrado");
        var idPersonal = $(this).attr("idPersonal");
        // Quitar la clase 'active' del elemento existente
        $("#idNavegacionNombreCursos").removeClass("active");
        // Crear un nuevo elemento <a> y agregarlo dentro de #idNavegacionNombreCursos
        $("#idNavegacionNombreCursos")
          .empty()
          .append('<a href="listaAlumnosDocentes">Todos mis Cursos</a>');
        $(".breadcrumb").append(
          '<li class="breadcrumb-item active">Todos mis Alumnos</li>'
        );
        actualizarDatosTabla(idCurso, idGrado, idPersonal);
      }
    );
    $("#dataTableAlumnosDocente").on(
      "click",
      ".btnVisualizarAlumno",
      function () {
        var idAlumno = $(this).attr("idAlumno");
        var data = new FormData();
        data.append("idAlumnoVisualizarDatosDocente", idAlumno);

        // Realiza la solicitud AJAX
        $.ajax({
          url: "ajax/alumnos.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            // Función para asignar valores a los campos de entrada
            function setInputValue(selector, value) {
              $(selector).val(value ? value : "Sin Inf.");
            }

            // Asignar valores a los campos del modal
            setInputValue(
              "#nombresAlumno",
              response["nombresAlumno"] + " " + response["apellidosAlumno"]
            );
            setInputValue("#dniAlumno", response["dniAlumno"]);
            setInputValue(
              "#fechaNacimientoAlumno",
              response["fechaNacimiento"]
            );
            setInputValue("#direccionAlumno", response["direccionAlumno"]);
            setInputValue(
              "#nombrePadre",
              response["nombrePadre"] + " " + response["apellidoPadre"]
            );
            setInputValue("#convivenciaPadre", response["convivenciaPadre"]);
            setInputValue("#celularPadre", response["celularPadre"]);
            setInputValue(
              "#nombreMadre",
              response["nombreMadre"] + " " + response["apellidoMadre"]
            );
            setInputValue("#convivenciaMadre", response["convivenciaMadre"]);
            setInputValue("#celularMadre", response["celularMadre"]);
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
    );
  }
});
