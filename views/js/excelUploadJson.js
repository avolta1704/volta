$(document).ready(function () {
  // Código para cargar un archivo xlsx y mostrar un advertencia antes de cargar los datos
  $("#btnCargarArchivosExcel").on("click", function () {
    Swal.fire({
      icon: "warning",
      title: "Advertencia",
      html: "Creará registros en la base de datos desde un Excel,<br>verifique que los datos del registro,<br> CODIGO ALUMNO, PAGO, MORA sean NUMEROS validos correctos.<br><br>¿Desea continuar?",
      showCancelButton: true, // Muestra el botón de cancelación
      confirmButtonText: "Sí",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        $("#inputExcel").click();
      }
    });
  });
  // funcion para cargar el archivo xlsx y enviarlo al servidor por ajax y decargar la respuesa de los registros no cargados ala base de datos
  $("#inputExcel").on("change", function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var data = new Uint8Array(e.target.result);
      var workbook = XLSX.read(data, { type: "array" });
      var first_sheet_name = workbook.SheetNames[0];
      var worksheet = workbook.Sheets[first_sheet_name];
      var jsonDataXlsx = XLSX.utils.sheet_to_json(worksheet, { raw: true });

      //console.log(jsonDataXlsx);
      //codifica los datos del xlsx a formato json
      var jsonDataString = JSON.stringify(jsonDataXlsx);

      // codigo para mostrar un mensaje del porcentaje de carga de los datos del excel al servidor //solo es un mensaje
      var loadingSwal = Swal.fire({
        title: "Cargando...",
        html: "0%0%",
        icon: "success",
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        onOpen: () => {
          Swal.showLoading();
        },
      });
      var percentage = 0;
      var loadingInterval = setInterval(function () {
        percentage += 1;
        if (percentage > 20) {
          percentage = 20;
          clearInterval(loadingInterval); // Detiene el intervalo
        }
        var percentSymbols = "%".repeat(percentage);
        loadingSwal.update({
          html: `0%${percentSymbols} ${percentage * 5}%`,
        });
      }, 125); // Actualiza el porcentaje cada 125 milisegundos
      //fin mensaje de carga
      $.ajax({
        url: "ajax/uploadXlsx.ajax.php",
        type: "POST",
        data: { jsonDataStringXlsx: jsonDataString },
        //la respuesta del servidor llegan con dos datos el "ok" y los registros no cargados
        success: function (data) {
          setTimeout(function () {
            clearInterval(loadingInterval); // Detiene el intervalo
            Swal.close(); // Cierra el mensaje de carga
            //decodifica la respuesta del servidor
            var parsedData = JSON.parse(data);
            if (
              //si en la respuesta no tiene valores en infoErrCronoAlum envia un mensaje de correcto
              parsedData.response === "ok" &&
              parsedData.infoErrCronoAlum.length === 0
            ) {
              Swal.fire({
                icon: "success",
                title: "Correcto",
                text: "Registro Cargado Correctamente",
                showConfirmButton: true,
              }).then(() => {
                location.reload(); // Recarga la página
              });
            } else {
              //si en la respuesta si tiene valores en infoErrCronoAlum envia un mensaje
              //para descargar los registros no cargados de la respuesta ajax estos registros seran por de valores no numericos
              //de codalumno, mora, pension o que no existe el cronograma su cronograma o ya esta pagado su cronograma
              //el mesanje no se cerrar hasta descargar el archivo de los registros no cargados
              Swal.fire({
                icon: "warning",
                title: "Advertencia,\nRegistros Parcialmente Cargados",
                confirmButtonText: "Descargar Registros No Cargados",
                confirmButtonColor: "#008000",
                allowOutsideClick: false,
                allowEscapeKey: false,
              }).then((result) => {
                if (result.isConfirmed) {
                  // Crear un nuevo libro de trabajo
                  var wb = XLSX.utils.book_new();
                  // Crear una nueva hoja de cálculo a partir de los datos
                  var ws_data = [
                    [
                      "COD_ALUMNO",
                      "DNI",
                      "NOM_ALUMNO",
                      "APE_ALUMNO",
                      "SUBPERIODO_ANIO",
                      "SUBPERIODO_MES",
                      "PENSION",
                      "MORA",
                    ],
                  ];
                  ws_data = ws_data.concat(
                    parsedData.infoErrCronoAlum.map((item) => [
                      item.codAlumnoCaja,
                      item.dniAlumno,
                      item.nombresAlumno,
                      item.apellidosAlumno,
                      item.anio,
                      item.mes,
                      item.pension,
                      item.mora,
                    ])
                  );
                  var ws = XLSX.utils.aoa_to_sheet(ws_data);
                  XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
                  // Generar el archivo XLSX
                  var wbout = XLSX.write(wb, {
                    bookType: "xlsx",
                    type: "array",
                  });
                  // descargar el archivo XLSX
                  var date = new Date();
                  var day = String(date.getDate()).padStart(2, "0");
                  var month = String(date.getMonth() + 1).padStart(2, "0");
                  var year = date.getFullYear();
                  var filename = `registros_no_cargados_${day}-${month}-${year}.xlsx`;
                  saveAs(
                    new Blob([wbout], { type: "application/octet-stream" }),
                    filename
                  );
                  location.reload();
                }
              });
            }
          }, 2000); // Retrasa la ejecución del código en 2 segundos para mostrar el mensaje de carga
        },
        error: function () {
          clearInterval(loadingInterval);
          Swal.close();
          console.log("Error al enviar los datos");
        },
      });
    };
    reader.readAsArrayBuffer(this.files[0]);
  });
});
