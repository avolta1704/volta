$("#nivelAlumno").change(function () {
  var nivel = $(this).val();
  var data = new FormData();
  data.append("codNivelBuscar", nivel);

  $.ajax({
    url: "ajax/nivelGrado.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      $("#gradoAlumno").empty();
      response.forEach(value => {
        $("#gradoAlumno").append(
          '<option value="' + value["idGrado"] + '">' + value["descripcionGrado"] + "</option>"
        );
      });
    },
  });
});
