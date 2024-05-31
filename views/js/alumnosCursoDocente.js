$("#dataTableListadoAlumnosCurso").on(
	"click",
	"#btnVisualizarDataAlumnoCurso",
	function () {
		var idAlumno = $(this).attr("idAlumno");

		const data = new FormData();
		data.append("idAlumno", idAlumno);
		$.ajax({
			url: "ajax/alumnosCursoDocente.ajax.php",
			method: "POST",
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (response) {
				$("#nombresAlumnoVisualizar").val(response.nombresAlumno);
				$("#apellidosAlumnoVisualizar").val(response.apellidosAlumno);
				$("#dniAlumnoVisualizar").val(response.dniAlumno);
				$("#fechaNacimientoVisualizar").val(response.fechaNacimiento);
				$("#direccionAlumnoVisualizar").val(response.direccionAlumno);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText); // procendecia de error
				console.log(
					"Error en la solicitud AJAX: ",
					textStatus,
					errorThrown
				);
			},
		});
	}
);
