// Definición inicial de dataTableAdmisionAlumnos
$(document).ready(function () {
  // Ejecutar el evento change para que se actualice la tabla de admisionAlumnos
  $("#selectAnioEscolarAdmisionAlumnos").trigger("change");

  var columnDefsAdmisionAlumno = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "codAlumnoCaja" },
    { data: "apellidosAlumno" },
    { data: "nombresAlumno" },
    { data: "fechaAdmision" },
    { data: "estadoAdmisionAlumno" },
    { data: "buttonsAdmisionAlumno" },
  ];

  var tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable({
    columns: columnDefsAdmisionAlumno,
  });

  // Titulo dataTableAdmisionAlumnos
  $(".tituloAdmisionAlumnos").text("Lista de Matriculados");

  //Estructura de dataTableAdmisionAlumnos
  $("#dataTableAdmisionAlumnos thead").html(`
      <tr>
        <th scope="col">#</th>
        <th scope="col">Código Caja</th>
        <th scope="col">Apellidos</th>
        <th scope="col">Nombres</th>
        <th scope="col">Fecha Admision</th>
        <th scope="col">Estado</th>
        <th scope="col">Acciones</th
      </tr>
    `);

  tableAdmisionAlumno.destroy();

  columnDefsAdmisionAlumno = [
    {
      data: "null",
      render: function (data, type, row, meta) {
        return meta.row + 1;
      },
    },
    { data: "codAlumnoCaja" },
    { data: "apellidosAlumno" },
    { data: "nombresAlumno" },
    { data: "fechaAdmision" },
    { data: "estadoAdmisionAlumno" },
    { data: "buttonsAdmisionAlumno" },
  ];

  var tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable({
    columns: columnDefsAdmisionAlumno,
    language: {
      url: "views/dataTables/Spanish.json",
    },
  });
});

// Crear Actualizar dataTableAdmisionAlumnos
function actualizarAdmisionAlumnos(response) {
  var tableAdmisionAlumno = $("#dataTableAdmisionAlumnos").DataTable();
  var data = new FormData();
  tableAdmisionAlumno.clear();
  tableAdmisionAlumno.rows.add(response);
  tableAdmisionAlumno.draw();
}

// Si se selecciona un año en el select #selectAnioEscolarAdmisionAlumnos, se actualiza la tabla de admisionAlumnos
$("#selectAnioEscolarAdmisionAlumnos").on("change", function () {
  var idAnioEscolar = $(this).val();
  var data = new FormData();
  data.append("todosLosAdmisionAlumnosAnio", idAnioEscolar);

  $.ajax({
    url: "ajax/admisionAlumnos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      actualizarAdmisionAlumnos(response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText); // procendecia de error
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
});
// btnDescargarReportePagos
$("#btnDescargarReporteMatriculadosCompleto").on("click", function () {
  var valorSeleccionado = $("#selectAnioEscolarAdmisionAlumnos").val();
  var data = new FormData();
  data.append("idAnioEscolarReporteMatriculados", valorSeleccionado);

  $.ajax({
    url: "ajax/admisionAlumnos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    success: function (response) {
      crearArchivoExcel(
        response,
        "Reporte Matriculados",
        "reporte_matriculados"
      );
    },
  }).fail(function (jqXHR, textStatus, errorThrown) {
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
  const crearArchivoExcel = (data, nombreHoja, nombreArchivo) => {
    // Modificar los valores nulos o vacíos
    const dataModificada = data.map(objeto => {
      const objetoModificado = { ...objeto };
      // Recorrer las claves del objeto
      Object.keys(objetoModificado).forEach(clave => {
          // Reemplazar los valores nulos o vacíos por "Sin Inf."
          if (objetoModificado[clave] === null || objetoModificado[clave] === "") {
              objetoModificado[clave] = "Sin Inf.";
          }
      });
      // Retornar el objeto modificado
      return objetoModificado;
  });
    // Crear un nuevo libro de trabajo
    var workbook = XLSX.utils.book_new();

    // Crear una hoja de trabajo
    const ws = XLSX.utils.json_to_sheet(dataModificada, {
      header: [
        "Alumno",
        "Nivel",
        "Status",
        "Sexo",
        "DNI",
        "F. Nac.",
        "Edad",
        "Dirección",
        "Distrito",
        "IEP Procedencia",
        "Seguro Salud",
        "Ingreso AV",
        "Padre",
        "DNI Padre",
        "Telef. 01",
        "Vive C/ Estudiante Padre",
        "Email Padre",
        "Madre",
        "DNI Madre",
        "Telef. 02",
        "Vive C/ Estudiante Madre",
        "Email Madre",
        "Telf. Emergencia",
        "Enfermedad",
        "Matric.",
        "Fecha Matric.",
        "Monto Matric.",
        "Recibo Matric.",
        "Cuota Ingreso",
        "Recibo Admision",
        "Monto Pension",
        "Estado SIAGIE",
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
});
