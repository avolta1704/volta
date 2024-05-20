//  Create a new order
$("#btnAgregarPostulante").on("click", function () {
  window.location = "index.php?ruta=nuevoPostulante";
});
//  Alert to delete an inside movement
$(".dataTablePostulantes").on("click", ".btnEliminarPostulante", function () {
  var codPostulante = $(this).attr("codPostulante");
  swal
    .fire({
      title: "¿Esta seguro de eliminar a este postulante?",
      text: "¡No podrá revertir el cambio! Se borrarán todos de este postulante",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar postulante!",
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location =
          "index.php?ruta=listaPostulantes&codPostulanteEliminar=" +
          codPostulante;
      }
    });
});
//  Cerrar vista de nuevo y editar postulante
$(".dataTablePostulantes").on("click", ".btnEditarPostulante", function () {
  var codPostulante = $(this).attr("codPostulante");
  window.location =
    "index.php?ruta=editarPostulante&codPostulanteEditar=" + codPostulante;
});

//  Cerrar vista de nuevo y editar postulante
$(".dataTablePostulantes").on("click", ".btnVisualizarPostulante", function () {
  var codPostulante = $(this).attr("codPostulante");
  window.location =
    "index.php?ruta=visualizarPostulante&codPostulante=" + codPostulante;
});

// Registrar el pago de matricula de un postulante
$(".dataTablePostulantes").on("click", ".btnAnadirPago", function () {
  var codPostulante = $(this).attr("codPostulante");
  window.location =
    "index.php?ruta=registrarPago&codPostulante=" + codPostulante;
});

//  Cerrar vista de nuevo y editar postulante
$(".cerrarCrearPostulante").on("click", function () {
  window.location = "index.php?ruta=listaPostulantes";
});
//modal para actualizar estado del postulante por la lista del modal
$(document).ready(function () {
  $(".dataTablePostulantes").on(
    "click",
    ".btnActualizarEstadoPostulante",
    function () {
      var codPostulante = $(this).attr("codPostulante");
      var estadoPostulante = $(this).attr("codEstado");
      var estadoTexto;
      if (estadoPostulante === "1") {
        estadoTexto = "Registrado";
      } else if (estadoPostulante === "2") {
        estadoTexto = "En revisión";
      } else if (estadoPostulante === "3") {
        estadoTexto = "Admitir";
      } else if (estadoPostulante === "4") {
        estadoTexto = "Desestimar";
      } else {
        estadoTexto = "Sin Estado";
      }
      $("#actualizarEstado #codPostulante").val(codPostulante);
      $(
        '#actualizarEstado #estadoPostulante option[value="' +
          estadoPostulante +
          '"]'
      ).remove();
      $("#actualizarEstado #estadoPostulante").prepend(
        '<option value="' +
          estadoPostulante +
          '" selected>' +
          estadoTexto +
          "</option>"
      );
      $("#actualizarEstado").modal("show");
    }
  );
});

//  Actualizar estado del postulante
$(document).ready(function () {
  $("#btnActualizarEstadoPostulante").on("click", function () {
    var codPostulanteEdit = $("#codPostulante").val();
    var estadoPostulanteEdit = $("#estadoPostulante").val();
    var data = new FormData();
    data.append("codPostulanteEdit", codPostulanteEdit);
    data.append("estadoPostulanteEdit", estadoPostulanteEdit);

    $.ajax({
      url: "ajax/postulantes.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",

      success: function (response) {
        if (response == "ok") {
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Estado actualizado correctamente",
          }).then(function (result) {
            if (result.value) {
              window.location = "listaPostulantes";
            }
          });
        } else {
          Swal.fire({
            icon: "warning",
            title: "Adveterencia",
            text: "No modifico el estado del Postulante",
          }).then(function (result) {
            if (result.value) {
              window.location = "listaPostulantes";
            }
          });
        }
        // Cerrar el modal después de recibir la respuesta
        $("#actualizarEstado").modal("hide");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  });
});

//  Buscar Postulante
$(document).ready(function () {
  $(".busquedaPostulante").select2();

  $(".busquedaPostulante").on("change", function (e) {
    var codPostulante = $(this).val();

    if (codPostulante == "0") {
      limpiarDatosPostulante();
    } else {
      var data = new FormData();
      data.append("codPostulanteBusqueda", codPostulante);

      $.ajax({
        url: "ajax/postulantes.ajax.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",

        success: function (response) {
          actualizarDatosPostulante(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText); // procedencia de error
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    }
  });

  const limpiarDatosPostulante = () => {
    //  Data Alumno
    $("#sexoPostulante").val("");
    $("#dniPostulante").val("");
    $("#nivelPostulante").val("");
    $("#gradoBusqueda").val("");
    $("#fechaPostulacion").val("");
    $("#fechaNacimiento").val("");
    $("#lugarNacimiento").val("");
    $("#domicilioPostulante").val("");
    $("#colegioProcedencia").val("");
    $("#dificultadPostulante").val("");
    $("#obsDificultad").val("");
    $("#tipoAtencion").val("");
    $("#obsTratamiento").val("");

    //  Data Padre
    $("#nombrePadre").val("");
    $("#apellidoPadre").val("");
    $("#dniPadre").val("");
    $("#nacimientoPadre").val("");
    $("#convivePadre").val("");
    $("#gradoPadre").val("");
    $("#profesionPadre").val("");
    $("#correoPadre").val("");
    $("#numeroPadre").val("");
    $("#dependenciaPadre").val("");
    $("#centroPadre").val("");
    $("#tlfTrabajoPadre").val("");
    $("#ingresoPadre").val("");

    //  Data Madre
    $("#nombreMadre").val("");
    $("#apellidoMadre").val("");
    $("#dniMadre").val("");
    $("#nacimientoMadre").val("");
    $("#conviveMadre").val("");
    $("#gradoMadre").val("");
    $("#profesionMadre").val("");
    $("#correoMadre").val("");
    $("#numeroMadre").val("");
    $("#dependenciaMadre").val("");
    $("#centroMadre").val("");
    $("#tlfTrabajoMadre").val("");
    $("#ingresoMadre").val("");
  };

  const actualizarDatosPostulante = (postulante) => {
    //  Actualizar data postulante
    $("#sexoPostulante").val(postulante.sexoPostulante);
    $("#dniPostulante").val(postulante.dniPostulante);
    $("#nivelPostulante").val(postulante.gradoPostulacion);
    $("#gradoBusqueda").val(postulante.gradoPostulacion);
    $("#fechaPostulacion").val(postulante.fechaPostulacion);
    $("#fechaNacimiento").val(postulante.fechaNacimiento);
    $("#lugarNacimiento").val(postulante.lugarNacimiento);
    $("#domicilioPostulante").val(postulante.domicilioPostulante);
    $("#colegioProcedencia").val(postulante.colegioProcedencia);
    $("#dificultadPostulante").val(postulante.dificultadPostulante);
    $("#obsDificultad").val(postulante.dificultadObservacion);
    $("#tipoAtencion").val(postulante.tipoAtencionPostulante);
    $("#obsTratamiento").val(postulante.tratamientoPostulante);

    //  Actualizar data padre
    $("#nombrePadre").val(postulante.idPadre.apellidoApoderado);
    $("#apellidoPadre").val(postulante.idPadre.nombreApoderado);
    $("#dniPadre").val(postulante.idPadre.dniApoderado);
    $("#nacimientoPadre").val(postulante.idPadre.fechaNacimiento);
    $("#convivePadre").val(postulante.idPadre.convivenciaAlumno);
    $("#gradoPadre").val(postulante.idPadre.gradoInstruccion);
    $("#profesionPadre").val(postulante.idPadre.profesionApoderado);
    $("#correoPadre").val(postulante.idPadre.correoApoderado);
    $("#numeroPadre").val(postulante.idPadre.celularApoderado);
    $("#dependenciaPadre").val(postulante.idPadre.dependenciaApoderado);
    $("#centroPadre").val(postulante.idPadre.centroLaboral);
    $("#tlfTrabajoPadre").val(postulante.idPadre.telefonoTrabajo);
    $("#ingresoPadre").val(postulante.idPadre.ingresoMensual);

    //  Actualizar data madre
    $("#nombreMadre").val(postulante.idMadre.apellidoApoderado);
    $("#apellidoMadre").val(postulante.idMadre.nombreApoderado);
    $("#dniMadre").val(postulante.idMadre.dniApoderado);
    $("#nacimientoMadre").val(postulante.idMadre.fechaNacimiento);
    $("#conviveMadre").val(postulante.idMadre.convivenciaAlumno);
    $("#gradoMadre").val(postulante.idMadre.gradoInstruccion);
    $("#profesionMadre").val(postulante.idMadre.profesionApoderado);
    $("#correoMadre").val(postulante.idMadre.correoApoderado);
    $("#numeroMadre").val(postulante.idMadre.celularApoderado);
    $("#dependenciaMadre").val(postulante.idMadre.dependenciaApoderado);
    $("#centroMadre").val(postulante.idMadre.centroLaboral);
    $("#tlfTrabajoMadre").val(postulante.idMadre.telefonoTrabajo);
    $("#ingresoMadre").val(postulante.idMadre.ingresoMensual);
  };
});

//  Cerrar vista de visualizar postulante
$(".cerrarVisualizarPostulante").on("click", function () {
  window.location = "index.php?ruta=listaPostulantes";
});

$(document).ready(function () {
  // Iniciar Firebase
  const firebaseConfig = {
      apiKey: "AIzaSyCefGvyBIwVK_Ewzpc0bY1aVdVc33dzz-A",
      authDomain: "nscodeuploadtask-521ff.firebaseapp.com",
      projectId: "nscodeuploadtask-521ff",
      storageBucket: "nscodeuploadtask-521ff.appspot.com",
      messagingSenderId: "1058923542325",
      appId: "1:1058923542325:web:9f6945b26162c0e102fe7c",
  };
  firebase.initializeApp(firebaseConfig);

  let downloadURL = ""; // Variable global para almacenar la URL de descarga
  let downloadFileName = ""; // Variable global para almacenar el nombre del archivo con extensión

  $("#btnUpdateFichaPostulante").on("click", function () {
      let selectedDate = $("#fechaFichaPostulante").val();

      if (!selectedDate) {
          Swal.fire({
              icon: "error",
              title: "Error",
              text: "Por favor selecciona una fecha antes de subir el archivo",
          });
      } else {
          $("#fileInput").click();
      }
  });

// Función para capturar el archivo seleccionado
$("#fileInput").on("change", function (e) {
  const file = e.target.files[0];
  const fileExtension = file.name.split(".").pop(); // Obtener la extensión del archivo
  const codPostulante = $("#btnUpdateFichaPostulante").data("codpostulante");
  let selectedDate = $("#fechaFichaPostulante").val();

  downloadFileName = `${codPostulante}-${selectedDate}.${fileExtension}`; // Guardar el nombre del archivo con la extensión

  // Confirmación antes de subir el archivo
  Swal.fire({
      icon: "warning",
      title: "Advertencia",
      html: "Está a punto de subir un archivo.<br>¿Desea continuar?",
      showCancelButton: true,
      confirmButtonText: "Sí",
      cancelButtonText: "No",
  }).then((result) => {
      if (result.isConfirmed) {
          uploadFileToFirebase(file, selectedDate, codPostulante, fileExtension);
      } else {
          // Reiniciar el input file si el usuario cancela
          $("#fileInput").val("");
      }
  });
});

// Función para subir el archivo a Firebase Storage
function uploadFileToFirebase(file, selectedDate, codPostulante, fileExtension) {
  const fileName = `${codPostulante}-${selectedDate}.${fileExtension}`;
  const storageRef = firebase.storage().ref(`myimages/${fileName}`);
  const uploadTask = storageRef.put(file);

  // Mostrar mensaje de "Subiendo archivo..."
  Swal.fire({
      icon: "info",
      title: "Subiendo archivo...",
      text: "Se está subiendo el archivo, por favor espere.",
      showConfirmButton: false,
      allowOutsideClick: false
  });

  uploadTask.on(
      "state_changed",
      null,
      function (error) {
          console.error("Error al subir el archivo:", error);
          Swal.close(); // Cerrar el Swal de "Subiendo archivo..."
          Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error al subir el archivo",
          });
      },
      //funcion ajax
      function ajaxSubir () {
          uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
              downloadURL = url; // Guardar la URL en la variable global
              console.log("Archivo disponible en:", downloadURL);

              // Subir a la base de datos el URL
              var data = new FormData();
              data.append("downloadURL", downloadURL);
              data.append("codPostulante", codPostulante);

              $.ajax({
                  url: "ajax/postulantes.ajax.php",
                  method: "POST",
                  data: data,
                  cache: false,
                  contentType: false,
                  processData: false,
                  dataType: "json",

                  success: function (response) {
                      Swal.close(); // Cerrar el Swal de "Subiendo archivo..."
                      if (response == "ok") {
                          // Mostrar el mensaje de éxito
                          Swal.fire({
                              icon: "success",
                              title: "Archivo subido",
                              text: "El archivo se ha subido correctamente.",
                              timer: 5000,
                              showConfirmButton: false,
                          });
                          // Mostrar el nombre del archivo
                          $("#fileName").text(`Archivo subido: ${fileName}`).show();
                          // Reiniciar el input file para permitir nuevas subidas
                          $("#fileInput").val("");
                      } else {
                          Swal.fire({
                              icon: "warning",
                              title: "Advertencia",
                              text: "No se modificó el estado del Postulante",
                          });
                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                      Swal.close(); // Cerrar el Swal de "Subiendo archivo..." en caso de error
                      console.log(jqXHR.responseText); // procedencia de error
                      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
                  },
              });
          });
      }
  );
}

  // Agregar evento de clic al botón de descarga
  $("#btnDownloadFichaPostulante").on("click", function () {
      if (downloadURL) {
          // Crear un enlace temporal y hacer clic en él para iniciar la descarga
          const link = document.createElement("a");
          link.href = downloadURL;
          link.target = "_blank"; // Asegurar que se abra en una nueva pestaña
          link.download = downloadFileName; // Usar el nombre original del archivo para la descarga
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link); // Eliminar el enlace temporal
      } else {
          Swal.fire({
              icon: "error",
              title: "Error",
              text: "No se ha subido ningún archivo todavía.",
          });
      }
  });
});