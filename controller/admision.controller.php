<?php
date_default_timezone_set('America/Lima');

class ControllerAdmision
{

  //  crear admision de postulante
  public static function ctrAdmisionEscolarActivaRegistroAlumno($listAnioEscolarActiva, $codPostulanteEdit)
  {
    // Asegúrate de que la sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    // Ahora puedes acceder a $_SESSION["idUsuario"]
    $idUsuario = $_SESSION["idUsuario"];
    // Crear el array de datos de la admisión
    $dataPostulanteAdmision = array(
      "idAnioEscolar" => $listAnioEscolarActiva,
      "idPostulante" => $codPostulanteEdit, // Usar el ID del postulante codPostulanteEdit
      "fechaAdmision" => date("Y-m-d H:i:s"),
      "tipoAdmision" => 1,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $idUsuario,
      "usuarioActualizacion" => $idUsuario
    );
    // Insertar los datos de la admisión en la base de datos
    $table = "admision";
    $result = ModelAdmision::mdlCreateAdmisionPostulate($table, $dataPostulanteAdmision);
    // Verificar si la inserción fue exitosa
    if ($result == "ok") {
      // Obtener el último registro de admisión creado
      $ultimoRegistroAdmicionCreado = ModelAdmision::mdlUltimoRegistroAdmisionCreado($table);
      // Devolver true si se obtuvo el último registro de admisión creado
      return $ultimoRegistroAdmicionCreado;
    }
  }
}