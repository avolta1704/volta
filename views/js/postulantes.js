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

  // Agregar evento de clic al botón de subir archivo
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
  const file = e.target.files[0]
  const archivo = "fichaPostulante";
  const fileName = file.name; // Obtener el nombre del archivo
  const fileExtension = fileName.split(".").pop(); // Obtener la extensión del archivo
  const codPostulante = $("#btnUpdateFichaPostulante").data("codpostulante"); // Obtener el código del postulante
  let selectedDate = $("#fechaFichaPostulante").val(); // Obtener la fecha seleccionada


  // Verificar si ya existe un archivo subido con el mismo nombre
  var data = new FormData();
  data.append("codPostulanteURL", codPostulante);

  $.ajax({
      url: "ajax/postulantes.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
          if (response.downloadURL) {
              // Si existe un archivo subido, mostrar un mensaje de advertencia
              Swal.fire({
                  icon: "warning",
                  title: "Advertencia",
                  text: "Ya hay un archivo subido para este postulante. ¿Quiere subir otro archivo?",
                  showCancelButton: true,
                  confirmButtonText: "Sí",
                  cancelButtonText: "No",
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Si el usuario confirma, proceder con la eliminación del archivo existente y subir el nuevo archivo
                      const existingFileName = getFileNameFromURL(response.downloadURL); // Obtener el nombre del archivo existente
                      const storageRef = firebase.storage().ref(`${archivo}/${existingFileName}`); // Crear una referencia al archivo existente
                      storageRef.delete().then(() => { // Eliminar el archivo existente
                          // Archivo eliminado, ahora subimos el nuevo archivo
                          uploadFileToFirebase(file, selectedDate, codPostulante,fileExtension,archivo);
                      }).catch((error) => {
                          console.error('Error al eliminar el archivo:', error);
                          Swal.fire({
                              icon: "error",
                              title: "Error",
                              text: "Error al eliminar el archivo existente.",
                          });
                      });
                  } else {
                      // Reiniciar el input file si el usuario cancela
                      $("#fileInput").val("");
                  }
              });
          } else {
              // Si no existe ningún archivo subido, proceder con la subida del archivo
              uploadFileToFirebase(file, selectedDate, codPostulante, fileExtension,archivo);
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
          Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error al obtener la información del archivo.",
          });
      }
  });
});

// Función para extraer el nombre del archivo de la URL
function getFileNameFromURL(url) {
  const decodedURL = decodeURIComponent(url); // Decodificar el URL
  const parts = decodedURL.split('/'); // Dividir la URL en partes usando '/'
  const lastPart = parts.pop(); // Obtener la última parte de la URL
  const fileNameWithToken = lastPart.split('?')[0]; // Separar el nombre del archivo del token
  return fileNameWithToken;
}


// Función para subir el archivo a Firebase Storage
function uploadFileToFirebase(file, selectedDate, codPostulante, fileExtension,archivo) {
  const fileName = `${codPostulante}-${selectedDate}.${fileExtension}`;
  const storageRef = firebase.storage().ref(`${archivo}/${fileName}`);
  // Iniciar la tarea de subida
  const uploadTask = storageRef.put(file);

  // Mostrar mensaje de "Subiendo archivo..."
  Swal.fire({
      icon: 'info',
      title: 'Subiendo archivo...',
      text: 'Se está subiendo el archivo, por favor espere.',
      showConfirmButton: false,
  });

  uploadTask.on('state_changed',
      function () {
          // No se necesita hacer nada aquí, simplemente se está subiendo el archivo
      },
      function (error) {
          console.error('Error al subir el archivo:', error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error al subir el archivo',
          });
      },
      function () {
          uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
              downloadURL = url; // Guardar la URL en la variable global
              //console.log('Archivo disponible en:', downloadURL);

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
                              timer: 2000,
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
                      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error en la solicitud AJAX',
                      });
                  },
              });
          });
      }
  );
}

  // Agregar evento de clic al botón de descarga
$("#btnDownloadFichaPostulante").on("click", function () {
  const codPostulanteURL = $("#btnDownloadFichaPostulante").data("codpostulante");

  var data = new FormData();
  data.append("codPostulanteURL", codPostulanteURL);

  // Realizar una solicitud AJAX para obtener la URL de la base de datos
  $.ajax({
    url: "ajax/postulantes.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

      success: function (response) {
          if (response.downloadURL) {
              // Crear un enlace temporal y hacer clic en él para iniciar la descarga
              const link = document.createElement("a");
              link.href = response.downloadURL; // Usar la URL obtenida de la base de datos
              link.target = "_blank"; // Asegurar que se abra en una nueva pestaña
              link.download = `${codPostulanteURL}-fichaPostulante`; // Usar el nombre original del archivo para la descarga
              document.body.appendChild(link); // Agregar el enlace temporal al cuerpo del documento
              link.click(); // Hacer clic en el enlace
              document.body.removeChild(link); // Eliminar el enlace temporal
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: "No se ha registrado ningún archivo todavía.",
              });
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
          Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error al obtener la información del archivo.",
          });
      }
  });
  
});

$("#btnUpdateInformePsicologico").on("click", function () {
  let selectedDate = $("#fechaInformePsico").val();

  if (!selectedDate) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Por favor selecciona una fecha antes de subir el archivo",
    });
  } else {
    $("#fileInput1").click();
  }
});

// Función para capturar el archivo seleccionado
$("#fileInput1").on("change", function (e) {
const file = e.target.files[0];
const archivo1 = "fichaPsicologica";
const fileName = file.name; // Obtener el nombre del archivo
const fileExtension = fileName.split(".").pop(); // Obtener la extensión del archivo
const codPostulante = $("#btnUpdateInformePsicologico").data("codpostulante"); // Obtener el código del postulante
let selectedDate = $("#fechaInformePsico").val(); // Obtener la fecha seleccionada

// Verificar si ya existe un archivo subido con el mismo nombre
var data = new FormData();
data.append("codPostulanteURLPsicologico", codPostulante);

$.ajax({
    url: "ajax/postulantes.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
        if (response.downloadURL) {
            // Si existe un archivo subido, mostrar un mensaje de advertencia
            Swal.fire({
                icon: "warning",
                title: "Advertencia",
                text: "Ya hay un archivo subido para este postulante. ¿Quiere subir otro archivo?",
                showCancelButton: true,
                confirmButtonText: "Sí",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, proceder con la eliminación del archivo existente y subir el nuevo archivo
                    const existingFileName = getFileNameFromURL(response.downloadURL); // Obtener el nombre del archivo existente
                    const storageRef = firebase.storage().ref(`${archivo1}/${existingFileName}`); // Crear una referencia al archivo existente
                    storageRef.delete().then(() => { // Eliminar el archivo existente
                        // Archivo eliminado, ahora subimos el nuevo archivo
                        uploadFileToFirebasePsicologico(file, selectedDate, codPostulante,fileExtension,archivo1);
                    }).catch((error) => {
                        console.error('Error al eliminar el archivo:', error);
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Error al eliminar el archivo existente.",
                        });
                    });
                } else {
                    // Reiniciar el input file si el usuario cancela
                    $("#fileInput1").val("");
                }
            });
        } else {
            // Si no existe ningún archivo subido, proceder con la subida del archivo
            uploadFileToFirebasePsicologico(file, selectedDate, codPostulante, fileExtension,archivo1);
        }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error al obtener la información del archivo.",
        });
    }
});
});

// Función para subir el archivo de Ficha Psicologica a Firebase Storage
function uploadFileToFirebasePsicologico(file, selectedDate, codPostulante, fileExtension,archivo1) {
  const fileName = `${codPostulante}-${selectedDate}.${fileExtension}`;
  const storageRef = firebase.storage().ref(`${archivo1}/${fileName}`);
  // Iniciar la tarea de subida
  const uploadTask = storageRef.put(file);

  // Mostrar mensaje de "Subiendo archivo..."
  Swal.fire({
      icon: 'info',
      title: 'Subiendo archivo...',
      text: 'Se está subiendo el archivo, por favor espere.',
      showConfirmButton: false,
  });

  uploadTask.on('state_changed',
      function () {
          // No se necesita hacer nada aquí, simplemente se está subiendo el archivo
      },
      function (error) {
          console.error('Error al subir el archivo:', error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error al subir el archivo',
          });
      },
      function () {
          uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
              downloadURL = url; // Guardar la URL en la variable global
              //console.log('Archivo disponible en:', downloadURL);

              // Subir a la base de datos el URL
              var data = new FormData();
              data.append("downloadURLPsicologico", downloadURL);
              data.append("codPostulantePsicologico", codPostulante);

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
                              timer: 2000,
                              showConfirmButton: false,
                          });
                          // Mostrar el nombre del archivo
                          $("#fileName1").text(`Archivo subido: ${fileName}`).show();
                          // Reiniciar el input file para permitir nuevas subidas
                          $("#fileInput1").val("");
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
                      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
                      Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: 'Error en la solicitud AJAX',
                      });
                  },
              });
          });
      }
  );
}

  // Agregar evento de clic al botón de descarga de Informe Psicologico
  $("#btnDownloadInformePsicologico").on("click", function () {
    const codPostulanteURL = $("#btnDownloadInformePsicologico").data("codpostulante");
  
    var data = new FormData();
    data.append("codPostulanteURLPsicologico", codPostulanteURL);
  
    // Realizar una solicitud AJAX para obtener la URL de la base de datos
    $.ajax({
      url: "ajax/postulantes.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
  
        success: function (response) {
            if (response.downloadURL) {
                // Crear un enlace temporal y hacer clic en él para iniciar la descarga
                const link = document.createElement("a");
                link.href = response.downloadURL; // Usar la URL obtenida de la base de datos
                link.target = "_blank"; // Asegurar que se abra en una nueva pestaña
                link.download = `${codPostulanteURL}-fichaPostulante`; // Usar el nombre original del archivo para la descarga
                document.body.appendChild(link); // Agregar el enlace temporal al cuerpo del documento
                link.click(); // Hacer clic en el enlace
                document.body.removeChild(link); // Eliminar el enlace temporal
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se ha registrado ningún archivo todavía.",
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error al obtener la información del archivo.",
            });
        }
    });
    
  });


});


//editar checklist de postulante
$(document).ready(function () {
  $(".btnActualizarChecklistPostulante").click(function (event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del botón
    swal
      .fire({
        title: "¿Esta seguro de Actualizar el Checklist?",
        text: "¡Puede volver a actulizarlo!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Actualizar!",
      })
      .then((result) => {
        if (result.isConfirmed) {
          // Inicia el flujo del código para actualizar el checklist
          var data = new FormData();
          var checklistData = {};
          $("#checklistPostulante input").each(function () {
            checklistData[$(this).attr("name")] = $(this).val();
          });
          // Reemplazar los valores de checklistData con los valores de checkboxStates
          for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxStates.hasOwnProperty(checkboxes[i])) {
              checklistData[checkboxes[i]] = checkboxStates[checkboxes[i]];
            }
          }
          data.append("actualizarCheclist", JSON.stringify(checklistData));
          //console.log(checklistData);
          $.ajax({
            url: "ajax/postulantes.ajax.php",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
              console.log(response);
              if (response == "ok") {
                Swal.fire({
                  icon: "success",
                  title: "Correcto",
                  text: "Checklist actualizado correctamente",
                }).then(function (result) {
                  if (result.value) {
                    // Actualizar la página actual
                    location.reload();
                  }
                });
              } else {
                Swal.fire({
                  icon: "warning",
                  title: "Advertencia",
                  text: "No se modificó el Checklist",
                }).then(function (result) {
                  if (result.value) {
                    // Actualizar la página actual
                    location.reload();
                  }
                });
              }
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
      });
  });
});

//funcion para identificar los cambios checkbox seleccionados y deseleccionados
var checkboxes = [
  "checkFichaPostulante",
  "checkEntrevista",
  "checkInformePsico",
  "checkConstAdeudo",
  "checkCartaAdmision",
  "checkContrato",
  "checkConstVacante",
  "checkPagoMatricula",
];
var checkboxStates = {};

document.addEventListener("DOMContentLoaded", function () {
  for (var i = 0; i < checkboxes.length; i++) {
    var checkboxElement = document.getElementById(checkboxes[i]);
    if (checkboxElement) {
      // Inicializar el estado del checkbox en el objeto checkboxStates
      checkboxStates[checkboxes[i]] = checkboxElement.checked ? "on" : "";

      checkboxElement.addEventListener("change", function () {
        // Actualizar el estado del checkbox en el objeto checkboxStates cuando cambie
        checkboxStates[this.id] = this.checked ? "on" : "";

        console.log(checkboxStates); // Imprimir el objeto checkboxStates para verificar
      });
    } else {
      console.log("No se encontró el checkbox con id: " + checkboxes[i]);
    }
  }
});
// Visualizar Pago de Matricula cuando no hay pago
$("#btnVisualizarPagoMatricula1").click(function(event) {
  Swal.fire({
      icon: 'warning',
      title: 'No hay ningún pago registrado',
      confirmButtonText: 'OK'
  });
});


// Funcionalidad para el botón Registrar Pago de Matrícula
$("#btnPagoMatricula").click(function (event) {

  // Obtener el codgio de postulante de pago del atributo del botón
  var codPostulante = $(this).data("codpostulante");
	window.location = "index.php?ruta=registrarPago&codPostulante=" + codPostulante;

});

// Funcionalidad para el botón "Visualizar Pago de Matrícula" cuando hay pago realizado
$("#btnVisualizarPagoMatricula").click(function (event) {
  var codPago = $(this).data("pago-matricula");
	var data = new FormData();
	data.append("codPago", codPago);

	$.ajax({
		url: "ajax/postulantes.ajax.php",
		method: "POST",
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
      // Obtener la descripción del grado desde la respuesta del servidor
      var descripcionGrado = response.descripcionGrado;

      // Dividir la descripción del grado en nivel y año
      var nivel = descripcionGrado.split(' ')[0]; // Extrae la primera palabra
      // Encontrar el índice del primer espacio en la descripción del grado
      var primerEspacioIndex = descripcionGrado.indexOf(' ');

      // Extraer el año del grado (texto después del primer espacio)
      var año = descripcionGrado.slice(primerEspacioIndex + 1); 
			$("#nombresDetalle").val(response.nombrePostulante);
			$("#apellidosDetalle").val(response.apellidoPostulante);
			$("#gradoDetalle").val(nivel);
			$("#nivelDertalle").val(año);
			$("#codigoCajaDetalle").val(response.cantidadPago);
			$("#mesDetalle").val(response.idTipoPago);
			$("#LimitePagoDetalle").val(response.fechaPago);

			// Abre el modal después de recibir la respuesta
			$("#modalDetallePago").modal("show");
      
		},
	});
});

// Botón "Editar" y "Eliminar" en el modal de detalle de pago
$(document).ready(function() {
    // Funcionalidad para el botón "Editar"
    $("#modalDetallePago").on("click", "#btnEditarPago", function() {
      // Obtener el código de postulante de pago del atributo del botón
      var codPago = $(this).data("pago-matricula");

      // Mostrar un mensaje de confirmación utilizando SweetAlert
      Swal.fire({
          title: '¿Deseas editar este pago?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, editar',
          cancelButtonText: 'Cancelar'
      }).then((result) => {
          if (result.isConfirmed) {
              // Si el usuario confirma, redirige a la página de edición
              /* window.location = "index.php?ruta=editarPago&codPago=" + codPago; */
          }
      });
  });

  // Funcionalidad para el botón "Eliminar"
  $("#modalDetallePago").on("click", "#btnEliminarPago", function() {
    // Obtener el código de postulante de pago del atributo del botón
    var codPago = $(this).data("pago-matricula");
    var data = new FormData();
    data.append("codPagoDelet", codPago);
  
    Swal.fire({
      icon: "warning",
      title: "Advertencia",
      html: "¿Está seguro de eliminar el registro de pago? <br> <br> <strong>¡Esta acción no se podra deshacer!</strong>",
      showCancelButton: true, // Muestra el botón de cancelación
      confirmButtonText: "Sí",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "ajax/pagos.ajax.php",
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
                text: "Registro Eliminado correctamente",
                timer: 1500,
                showConfirmButton: false,
              });
              // Desmarcar el checkbox
              $("#checkPagoMatricula").prop("checked", false);
              location.reload();
            } else {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "Error al Eliminar el Registro",
                timer: 1000,
                showConfirmButton: false,
              });
            }
            setTimeout(function () {
              location.reload();
            }, 1500);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
          },
        });
      }
    });
  });
});



