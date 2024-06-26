$("#dataTableNotasAlumnoApoderado").on(
  "click",
  ".btnVisualizarNotaApoderado",
  function () {
    var codAlumno = $(this).attr("codAlumno");

    var columnDefsCursosPorGrado = [
      { data: "descripcionCurso" },
      { data: "nota_unidad_i" },
      { data: "nota_unidad_ii" },
      { data: "nota_unidad_iii" },
      { data: "nota_unidad_iv" },
      { data: "nota_unidad_v" },
      { data: "nota_unidad_vi" },
      { data: "nota_unidad_vii" },
      { data: "nota_unidad_viii" },
    ];

    var tableCursosPorGrado = $("#dataTableNotasPorAlumnoApoderado").DataTable({
      columns: columnDefsCursosPorGrado,
      retrieve: true,
      paging: false,
      destroy: true,
      ordering: false, // Desactiva el ordenamiento
      language: {
        url: "views/dataTables/Spanish.json",
      },
      rowCallback: function (row, data) {
        if (data.descripcionCurso === "PROMEDIO BIMESTRE") {
          $(row).css("font-weight", "bold");
        }
      },
    });

    var data = new FormData();
    data.append("idAlumnoNotasApoderado", codAlumno);

    $.ajax({
      url: "ajax/notas.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        // Actualizar la información del alumno en el modal
        $("#idAlumno").text(response[0]["idAlumno"]);
        $("#nombreAlumno").text(
          response[0]["nombresAlumno"] + " " + response[0]["apellidosAlumno"]
        );
        $("#nivelAlumno").text(response[0]["descripcionNivel"]);
        $("#gradoAlumno").text(response[0]["descripcionGrado"]);
        var formattedData = [];
        response.forEach(function (item) {
          var cursoData = {
            descripcionCurso: item.descripcionCurso,
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

          // Asginar promedio al final de cada curso
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

    $("#dataTableNotasPorAlumnoApoderado thead").html(`
      <tr>
          <th rowspan="2">Curso</th>
          <th colspan="2">I BIMESTRE</th>
          <th colspan="2">II BIMESTRE</th>
          <th colspan="2">III BIMESTRE</th>
          <th colspan="2">IV BIMESTRE</th>
      </tr>
      <tr>
          <th>I UNIDAD</th>
          <th>II UNIDAD</th>
          <th>III UNIDAD</th>
          <th>IV UNIDAD</th>
          <th>V UNIDAD</th>
          <th>VI UNIDAD</th>
          <th>VII UNIDAD</th>
          <th>VIII UNIDAD</th>
      </tr>
  `);
  }
);
$("#modalNotasAlumnoApoderado").on("click", "#btnImprimirPDF", function () {
  const { jsPDF } = window.jspdf;
  var doc = new jsPDF();

  // Cargar y añadir el logo
  var img = new Image();
  img.src = "http://localhost/volta/assets/img/logo.png";
  img.onload = function () {
    var imgWidth = 20; // Ancho del logo en el PDF
    var imgHeight = (this.height * imgWidth) / this.width; // Calcular el alto para mantener la proporción
    var pageWidth = doc.internal.pageSize.getWidth();
    var marginRight = 6; // Margen derecho
    var xPosition = pageWidth - imgWidth - marginRight; // Calcula la posición x para alinear a la derecha

    // Añadir la imagen al PDF en la posición calculada
    doc.addImage(this, "PNG", xPosition, 5, imgWidth, imgHeight); // Ajusta '5' y 'imgHeight' para la posición y y el alto del logo según sea necesario

    // Título del PDF, ajustado para dejar espacio para el logo
    doc.setFontSize(16);
    doc.text("REGISTRO DE NOTAS", 105, 15, null, null, "center");

    // Ajustar la posición vertical después del título y el logo
    var yPosition = 30;

    // Extraer información del alumno de manera específica para la izquierda
    var infoAlumnoIzquierda = [
      "ID Alumno: " + $("#idAlumno").text(),
      "Nombre Alumno: " + $("#nombreAlumno").text(),
    ].join("\n");

    // Extraer información del alumno de manera específica para la derecha
    var infoAlumnoDerecha = [
      "Nivel: " + $("#nivelAlumno").text(),
      "Grado: " + $("#gradoAlumno").text(),
    ].join("\n");

    // Añadir información del alumno al PDF
    doc.setFontSize(10);
    doc.text(infoAlumnoIzquierda, 10, yPosition);
    var splitDerecha = doc.splitTextToSize(infoAlumnoDerecha, 90);
    doc.text(splitDerecha, doc.internal.pageSize.width - 100, yPosition); // Ajustar según el ancho de la página

    // Ajustar la posición vertical para la tabla
    yPosition +=
      Math.max(infoAlumnoIzquierda.split("\n").length, splitDerecha.length) * 7;
    // Dibujar una línea horizontal para separar los datos del alumno de la tabla
    doc.setDrawColor(0); // Establece el color de la línea, negro en este caso
    doc.line(10, yPosition, doc.internal.pageSize.width - 10, yPosition); // Ajusta '10' y 'doc.internal.pageSize.width - 10' según sea necesario

    // Incrementar yPosition para dejar espacio después de la línea
    yPosition += 5;

    // Preparar los encabezados y datos de la tabla
    var encabezados = [
      [
        { content: "Curso", rowSpan: 2, styles: { halign: 'center', valign: 'middle' } },
        { content: "I BIMESTRE", colSpan: 2, styles: { halign: 'center' } },
        { content: "II BIMESTRE", colSpan: 2, styles: { halign: 'center' } },
        { content: "III BIMESTRE", colSpan: 2, styles: { halign: 'center' } },
        { content: "IV BIMESTRE", colSpan: 2, styles: { halign: 'center' } },
      ],
      [
        "I UNIDAD",
        "II UNIDAD",
        "III UNIDAD",
        "IV UNIDAD",
        "V UNIDAD",
        "VI UNIDAD",
        "VII UNIDAD",
        "VIII UNIDAD",
      ],
    ];

    // Extraer los datos de la tabla
    var data = $("#dataTableNotasPorAlumnoApoderado")
      .DataTable()
      .rows()
      .data()
      .toArray();

    // Aplicar estilos condicionales para "PROMEDIO BIMESTRE"
    var bodyStyles = { fontStyle: "normal", fontSize: 8
     };
    var rowStyles = data.map((row, index) => {
      return row.descripcionCurso === "PROMEDIO BIMESTRE"
        ? { fontStyle: "bold" }
        : { fontStyle: "normal" };
    });

    // Añadir la tabla al PDF
    doc.autoTable({
      startY: yPosition,
      head: encabezados,
      body: data.map((item) => [
        item.descripcionCurso,
        item.nota_unidad_i,
        item.nota_unidad_ii,
        item.nota_unidad_iii,
        item.nota_unidad_iv,
        item.nota_unidad_v,
        item.nota_unidad_vi,
        item.nota_unidad_vii,
        item.nota_unidad_viii,
      ]),
      bodyStyles: bodyStyles,
      rowStyles: rowStyles,
      headStyles: { fontSize: 8, halign: 'center' }, // Establece un tamaño de fuente  para los encabezados y los centra horizontalmente
    });

    // Guardar el documento PDF
    doc.save("Registro_de_Notas.pdf");
  };
});
