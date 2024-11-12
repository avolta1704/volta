$(document).ready(function () {
  // Obtener la ruta actual de la URL
  var rutaActual = window.location.pathname;
  // Obtener el último segmento de la ruta
  var ultimoSegmento = rutaActual.split("/").pop();

  // Verificar si la rutaActual contiene "volta/notasAlumnoDocente"
  if (ultimoSegmento==="notasAlumnoDocente") {
    $(".tituloNotaAlumnoDocente").text("Notas");
    var listaIdentificadores = document.getElementById(
      "dataTableCursosNotasAlumnosDocente"
    ).dataset.identificadores;
    listaIdentificadores = JSON.parse(listaIdentificadores);
    document.getElementById("tablaNotasAlumnosDocentes").style.display = "none";
    document.getElementById("tablaCursosDocenteNotas").style.display = "block";
    // Titulo dataTableAlumnosDocente
    $(".tituloNotaAlumnoDocente").text("Todos mis Cursos");
    document.getElementById("idNavegacionNotasAlumnosDocentes").textContent =
      "Todos mis Cursos";
    var columnDefsAlumnosDocente = [
      { data: "descripcionCurso" },
      { data: "descripcionGrado" },
      { data: "acciones" },
    ];
    var tablaAlumnosDocente = $(
      "#dataTableCursosNotasAlumnosDocente"
    ).DataTable({
      columns: columnDefsAlumnosDocente,
    });
    //Solicitud inicial de dataTableNotasAlumnosDocentes
    var data = new FormData();
    data.append("todosLosGradosNotasDocentes", true);

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

    //Estructura de dataTableNotasAlumnosDocentes
    $("#dataTableCursosNotasAlumnosDocente thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Curso</th>
        <th scope="col">Grado</th>
        <th scope="col">Acciones</th>
      </tr>`);

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
    tablaAlumnosDocente = $("#dataTableCursosNotasAlumnosDocente").DataTable({
      columns: columnDefsAlumnosDocente,
    });

    function actualizarDatosTablaNotasAlumnosDocente(
      idCurso,
      idGrado,
      idPersonal
    ) {
      document.getElementById("tablaNotasAlumnosDocentes").style.display =
        "block";
      document.getElementById("tablaCursosDocenteNotas").style.display = "none";
      var columnDefsCursosPorGrado = [
        { data: "descripcionCurso", width: "350px" },
        { data: "nota_unidad_i", width: "100px", className: "text-center" },
        { data: "nota_unidad_ii", width: "100px", className: "text-center" },
        { data: "nota_unidad_iii", width: "100px", className: "text-center" },
        { data: "nota_unidad_iv", width: "100px", className: "text-center" },
        { data: "nota_unidad_v", width: "100px", className: "text-center" },
        { data: "nota_unidad_vi", width: "100px", className: "text-center" },
        { data: "nota_unidad_vii", width: "100px", className: "text-center" },
        { data: "nota_unidad_viii", width: "100px", className: "text-center" },
      ];

      var tableCursosPorGrado = $("#dataTableNotasAlumnosDocentes").DataTable({
        columns: columnDefsCursosPorGrado,
        retrieve: true,
        paging: false,
        destroy: true,
        ordering: false, // Desactiva el ordenamiento
        language: {
          url: "views/dataTables/Spanish.json",
        },
        rowCallback: function (row, data, index) {
          if (data.descripcionCurso === "PROMEDIO BIMESTRE") {
            $(row).css({
              "font-weight": "bold",
            });
          }
        },
      });

      var data = new FormData();
      data.append("idCursoAlumnoNotasDocente", idCurso);
      data.append("idGradoAlumnoNotasDocente", idGrado);
      data.append("idPersonalAlumnoNotasDocente", idPersonal);

      $.ajax({
        url: "ajax/notas.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          // Actualizar la información del curso
          $("#idAlumnoInput").val(response[0]["idCurso"]);
          $("#nombreAlumnoInput").val(response[0]["descripcionCurso"]);
          $("#nivelAlumnoInput").val(response[0]["descripcionNivel"]);
          $("#gradoAlumnoInput").val(response[0]["descripcionGrado"]);
          var formattedData = [];
          response.forEach(function (item) {
            var cursoData = {
              descripcionCurso:
                item.nombresAlumno || item.apellidosAlumno
                  ? item.nombresAlumno + " " + item.apellidosAlumno
                  : " ",
              nota_unidad_i: item.nota_unidad_i || " ",
              nota_unidad_ii: item.nota_unidad_ii || " ",
              nota_unidad_iii: item.nota_unidad_iii || " ",
              nota_unidad_iv: item.nota_unidad_iv || " ",
              nota_unidad_v: item.nota_unidad_v || " ",
              nota_unidad_vi: item.nota_unidad_vi || " ",
              nota_unidad_vii: item.nota_unidad_vii || " ",
              nota_unidad_viii: item.nota_unidad_viii || " ",
              nota_bimestre_i: item.nota_bimestre_i || " ",
              nota_bimestre_ii: item.nota_bimestre_ii || " ",
              nota_bimestre_iii: item.nota_bimestre_iii || " ",
              nota_bimestre_iv: item.nota_bimestre_iv || " ",
            };
            formattedData.push(cursoData);

            // Asignar promedio al final de cada curso
            var promedioBimestre = {
              descripcionCurso: "PROMEDIO BIMESTRE",
              nota_unidad_i: "",
              nota_unidad_ii: item.nota_bimestre_i || " ",
              nota_unidad_iii: "",
              nota_unidad_iv: item.nota_bimestre_ii || " ",
              nota_unidad_v: "",
              nota_unidad_vi: item.nota_bimestre_iii || " ",
              nota_unidad_vii: "",
              nota_unidad_viii: item.nota_bimestre_iv || " ",
            };
            formattedData.push(promedioBimestre);
          });

          tableCursosPorGrado.clear();
          tableCursosPorGrado.rows.add(formattedData);
          tableCursosPorGrado.draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });

      $("#dataTableNotasAlumnosDocentes thead").html(`
          <tr>
              <th rowspan="2" width="400px" style="text-align: center;">Alumno</th> 
              <th colspan="2" style="text-align: center;">I BIMESTRE</th>
              <th colspan="2" style="text-align: center;">II BIMESTRE</th>
              <th colspan="2" style="text-align: center;">III BIMESTRE</th>
              <th colspan="2" style="text-align: center;">IV BIMESTRE</th>
          </tr>
          <tr>
              <th style="text-align: center;">I UNIDAD</th>
              <th style="text-align: center;">II UNIDAD</th>
              <th style="text-align: center;">III UNIDAD</th>
              <th style="text-align: center;">IV UNIDAD</th>
              <th style="text-align: center;">V UNIDAD</th>
              <th style="text-align: center;">VI UNIDAD</th>
              <th style="text-align: center;">VII UNIDAD</th>
              <th style="text-align: center;">VIII UNIDAD</th>
          </tr>
      `);
    }

    $("#dataTableCursosNotasAlumnosDocente").on(
      "click",
      ".btnVerNotasAlumnosCursoDocente",
      function () {
        var idCurso = $(this).attr("idCurso");
        var idGrado = $(this).attr("idGrado");
        var idPersonal = $(this).attr("idPersonal");
        // Quitar la clase 'active' del elemento existente
        $("#idNavegacionNotasAlumnosDocentes").removeClass("active");
        // Crear un nuevo elemento <a> y agregarlo dentro de #idNavegacionNombreCursos
        $("#idNavegacionNotasAlumnosDocentes")
          .empty()
          .append('<a href="notasAlumnoDocente">Todos mis Cursos</a>');
        $(".breadcrumb").append(
          '<li class="breadcrumb-item active">Notas</li>'
        );

        actualizarDatosTablaNotasAlumnosDocente(idCurso, idGrado, idPersonal);
      }
    );
  }
});
