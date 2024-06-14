$("#btnAgregarInstrumento").on("click", function (e) {
  var listaInstrumentos = $(".listaInstrumentos");
  var inputInstrumentos = $(".listaInstrumentosPorTecnica");

  var nuevoInstrumento = `
      <div class="nuevoInstrumento" style="display: flex">
        <input type="text" placeholder="Descripción Instrumento" name="descripcionInstrumento" class="form-control descripcionInstrumento" required/>
        <input type="text" placeholder="Código Instrumento" name="codigoInstrumento" class="form-control codigoInstrumento" required/>
        <button type="button" class="btn btn-danger btnEliminarInstrumento">Eliminar</button>
      </div>
    `;
  listaInstrumentos.append(nuevoInstrumento);
  actualizarInstrumentos();

  function actualizarInstrumentos() {
    const instrumentos = [];
    document.querySelectorAll(".nuevoInstrumento").forEach((fila) => {
      const descripcion = fila.querySelector(
        "input[type=text]:nth-child(1)"
      ).value;
      const codigo = fila.querySelector("input[type=text]:nth-child(2)").value;
      instrumentos.push({ descripcion, codigo });
    });
    inputInstrumentos.val(JSON.stringify(instrumentos));
    console.log(inputInstrumentos.val());
  }

  $(".btnEliminarInstrumento").on("click", function (e) {
    $(this).parent().remove();
    actualizarInstrumentos();
  });
  $(".descripcionInstrumento").on("change", function (e) {
    actualizarInstrumentos();
  });
  $(".codigoInstrumento").on("change", function (e) {
    actualizarInstrumentos();
  });
});

$("#btnRegistrarTecnica").on("click", function () {
  var descripcionTecnica = $("#descripcionTecnica").val();
  var codigoTecnica = $("#codigoTecnica").val();
  var listaInstrumentosPorTecnica = $("#listaInstrumentosPorTecnica").val();
  console.log(listaInstrumentosPorTecnica);

  var dataRegistrarTecnica = {
    descripcionTecnica: descripcionTecnica,
    codigoTecnica: codigoTecnica,
    listaInstrumentosPorTecnica: listaInstrumentosPorTecnica,
  };

  var data = new FormData();
  data.append("dataRegistrarTecnica", JSON.stringify(dataRegistrarTecnica));

  $.ajax({
    url: "ajax/tecnicaseInstrumentos.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response) {
        /*$("#descripcionInstrumento").val("");
        $("#codigoInstrumento").val("");*/

        Swal.fire({
          icon: "success",
          title: "Registrado",
          text: "Técnica e Instrumento registrados correctamente",
          showConfirmButton: true,
        }).then((result) => {
          location.reload();
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Errir al registrar la técnica e instrumento",
        timer: 2000,
        showConfirmButton: true,
      });
      console.error("Error al registrar la técnica e instrumento: ", textStatus, errorThrown);
    },
  });
});
