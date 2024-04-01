$(document).ready(function () {
  $("#btnCargarArchivosExcel").on("click", function () {
    Swal.fire({
      icon: "warning",
      title: "Advertencia",
      text: "Creará registros en la base de datos desde un Excel, verifique que los datos del registro sean correctos. ¿Desea continuar?",
      showCancelButton: true, // Muestra el botón de cancelación
      confirmButtonText: "Sí",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        $("#inputExcel").click();
      }
    });
  });

  $("#inputExcel").on("change", function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var data = new Uint8Array(e.target.result);
      var workbook = XLSX.read(data, { type: "array" });

      var first_sheet_name = workbook.SheetNames[0];
      var worksheet = workbook.Sheets[first_sheet_name];
      var jsonDataXlsx = XLSX.utils.sheet_to_json(worksheet, { raw: true });

      console.log(jsonDataXlsx);

      var jsonDataString = JSON.stringify(jsonDataXlsx);

      $.ajax({
        url: "ajax/uploadXlsx.ajax.php",
        type: "POST",
        data: { jsonDataStringXlsx: jsonDataString },
        success: function (data) {
          var parsedData = JSON.parse(data);
          if (parsedData.response === "ok" && parsedData.infoErrCronoAlum.length === 0) {
            Swal.fire({
              icon: "success",
              title: "Correcto",
              text: "Registro Cargado Correctamente",
              showConfirmButton: true,
            }).then(() => {
              location.reload(); // Recarga la página
            });
          } else {
            var codAlumnoCajaText = '';
            for (var i = 0; i < parsedData.infoErrCronoAlum.length; i++) {
              codAlumnoCajaText += parsedData.infoErrCronoAlum[i].codAlumnoCaja + ', ';
            }
            Swal.fire({
              icon: "warning",
              title: "Advertencia, Registros Parcialmente Cargados",
              text: "Registros no Cargados: " + codAlumnoCajaText,
              showConfirmButton: true,
              confirmButtonText: 'OK',
              showCancelButton: true,
              cancelButtonText: 'Descargar Registro Simple',
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload(); // Recarga la página
              } else if (result.isDismissed) {
                var blob = new Blob([codAlumnoCajaText], {type: "text/plain;charset=utf-8"});
                saveAs(blob, "codigos_alumno.txt");
              }
            });
          }
        },
        error: function () {
          console.log("Error al enviar los datos");
        },
      });
    };
    reader.readAsArrayBuffer(this.files[0]);
  });
});
