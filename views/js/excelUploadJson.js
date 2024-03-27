$(document).ready(function () {
  $("#btnCargarArchivosExcel").on("click", function () {
    $("#inputExcel").click();
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
          console.log("Datos enviados con éxito");
        },
        error: function () {
          console.log("Error al enviar los datos");
        },
      });
    };
    reader.readAsArrayBuffer(this.files[0]);
  });

});
