$(document).ready(function () {
  // Agregar el evento click al botón "Asignar Curso"
  $("#btnAsignarCurso").on("click", function () {
    // Obtener los valores seleccionados
    var gradoSeleccionado = $("#selectGrado").val();
    var cursoSeleccionado = $("#selectCurso").val();
    var idPersonal = $("#codPersonal").val();

    // Mostrar los valores en una alerta de SweetAlert
    Swal.fire({
      title: "Datos Seleccionados",
      html:
        "<p><strong>Grado seleccionado:</strong> " +
        gradoSeleccionado +
        "</p>" +
        "<p><strong>Curso seleccionado:</strong> " +
        cursoSeleccionado +
        "</p>" +
        "<p><strong>ID Personal:</strong> " +
        idPersonal +
        "</p>",
      icon: "info",
      confirmButtonText: "Aceptar",
    });
  });

  /*   $(".selectGrado").on("change", "#selectGrado", function () {
    var gradoSeleccionado = this.value;
    var selectCursoContainer = document.getElementById("selectCursoContainer");
    var gradoNivel =
      this.options[this.selectedIndex].getAttribute("data-nivel");
    var selectCurso = document.getElementById("selectCurso");

    // Limpiar la selección del segundo select si no se ha seleccionado un grado
    if (gradoSeleccionado === "") {
      selectCursoContainer.style.display = "none";
      selectCurso.value = "";
      return;
    }

    // Mostrar el segundo select solo para Docente Secundaria y Docente General
    var tipoDocente = "<?php echo $listaDocentes[0]['descripcionTipo']; ?>";
    if (
      tipoDocente === "Docente Secundaria" ||
      tipoDocente === "Docente General"
    ) {
      selectCursoContainer.style.display = "";
    } else {
      selectCursoContainer.style.display = "none";
      selectCurso.value = "";
    } */

  /*     // Mostrar solo los cursos que corresponden al grado seleccionado
    for (var i = 0; i < selectCurso.options.length; i++) {
      var option = selectCurso.options[i];
      if (option.getAttribute("data-grado") === gradoSeleccionado) {
        option.style.display = "";
      } else {
        option.style.display = "none";
      }
    }
  }); */
});

// Si deseas realizar alguna acción adicional con los datos seleccionados, puedes hacerlo aquí
/*     SELECT
	curso_grado.idCursoGrado
FROM
	curso_grado
	INNER JOIN
	curso
	ON 
		curso_grado.idCurso = curso.idCurso
	INNER JOIN
	grado
	ON 
		curso_grado.idGrado = grado.idGrado
WHERE
	curso.descripcionCurso = 'Ciencia y tecnologia' AND
	grado.descripcionGrado = '1er Año' */

$(".dataTableDocentes").on("click", ".btnVisualizarDocente", function () {
  // Obtener los valores seleccionados
  var tipoDocente = $(this).attr("codTipoPersonal");
  var codPersonal = $(this).attr("codPersonal");

  // Mostrar los valores en una alerta de SweetAlert
  var data = new FormData();
  data.append("tipoDocente", tipoDocente);
  $.ajax({
    url: "ajax/docentes.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      console.log(response);
      var opciones = "";
      //listaGrados = JSON.parse(response);
      response.forEach((grado) => {
        opciones +=
          '<option value="' +
          grado.idGrado +
          '" data-tipo-docente="' +
          tipoDocente +
          '">' +
          grado.descripcionGrado +
          "</option>";
      });

      selectDiv = document.getElementById("selectGrado");
      select =
        '<label for="selectGrado" class="form-label">Selecciona el Grado:</label>' +
        '<select class="form-select selectGrado" id="selectGrado" data-placeholder="Elegir grado">' +
        '<option value="">Selecciona un grado...</option>' +
        opciones +
        "</select>";
      selectDiv.innerHTML = select;
      $("#codPersonal").val(codPersonal);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});

$(".selectGrado").on("change", ".selectGrado", function () {
  // Obtener los valores seleccionados

  var idGrado = $(this).val();
  var tipoDocente = $(this).find(":selected").data("tipoDocente");
  var idPersonal = $("#codPersonal").val();

  // Limpiar el selectCurso
  var selectDiv = document.getElementById("selectCurso");
  selectDiv.innerHTML = "";

  if (tipoDocente == "1" || tipoDocente == "2") {
    console.log("Docente de Primaria y Secundaria");
  } else {
    // Mostrar los valores en una alerta de SweetAlert
    var data = new FormData();
    data.append("todosloscursos", true);
    $.ajax({
      url: "ajax/docentes.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        response.forEach((curso) => {
          if (idGrado == curso.idGrado) {
            var opciones = "";
            //listaGrados = JSON.parse(response);

            opciones +=
              '<option value="' +
              curso.idGrado +
              '" data-tipo-docente="' +
              tipoDocente +
              '">' +
              curso.descripcionCurso +
              "</option>";

            selectDiv = document.getElementById("selectCurso");
            select =
              '<label for="selectCurso" class="form-label">Selecciona el Curso:</label>' +
              '<select class="form-select selectCurso" id="selectCurso" data-placeholder="Elegir curso">' +
              '<option value="">Selecciona curso...</option>' +
              opciones +
              "</select>";
            selectDiv.innerHTML = select;
          }
        });
        // <label for="selectCurso" class="form-label">Selecciona el Curso:</label>
        //               <select class="form-select" id="selectCurso" data-placeholder="Elegir curso">
        //                   <option value="">Selecciona un curso...</option>
        //                   <?php
        //                   $listaCursos = ControllerDocentes::ctrGetCurso();
        //                   foreach ($listaCursos as $curso) {
        //                       echo "<option value='" . $curso["descripcionCurso"] . "' data-grado='" . $curso["descripcionGrado"] . "' style='display:none;'>" . $curso["descripcionCurso"] . "</option>";
        //                   }
        //                   ?>
        //               </select>
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText); // procendecia de error
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
});
