<?php
date_default_timezone_set('America/Lima');

class ControllerAdmision
{
  // crear admision de postulante
  public static function ctrAdmisionEscolarActivaRegistroPostulante($anioEscolarActiva, $codPostulanteEdit, $tipoAdmision)
  {
    // usar por el origen del dato  $tipoAdmision 1 = ordinario, 2 = extraordinario
    $dataPostulanteAdmision = array(
      "idAnioEscolar" => $anioEscolarActiva,
      "idPostulante" => $codPostulanteEdit,
      "fechaAdmision" => date("Y-m-d"),
      "tipoAdmision" => $tipoAdmision,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );

    $table = "admision";
    $result = ModelAdmision::mdlCrearAdmisionPostulate($table, $dataPostulanteAdmision);
    if ($result == "ok") {
      $admisionAnioEscolar = ModelAdmision::mdlUltimoRegistroAdmisionCreado($table);
      return $admisionAnioEscolar;
    }
  }

  /**
   * Obtiene el código de admisión por postulante.
   *
   * @param int $idPostulante El ID del postulante.
   * @return mixed El código de admisión del postulante.
   */
  public static function ctrGetCodAdmisionByPostulante($idPostulante)
  {
    $table = "admision";
    $result = ModelAdmision::mdlGetCodAdmisionByPostulante($table, $idPostulante);
    return $result;
  }
  //  eliminar Postulante Matriculado = Alumno; y volverlo a postulante
  public static function ctrElimarDataMatriculaPostulante($codAlumnoEliminar)
  {
    $idAlumnoEliminar = self::ctrBuscarRegistrosDeMatriculaPostulante($codAlumnoEliminar);

    $dataArrayIdEliminar = array(
      'idAlumno' => $idAlumnoEliminar['idAlumno'],
      'idAdmisionAlumno' => $idAlumnoEliminar['idAdmisionAlumno'],
      'idAdmision' => $idAlumnoEliminar['idAdmision'],
      'idAlumnoAnioEscolar' => $idAlumnoEliminar['idAlumnoAnioEscolar'],
      'idApoderadoAlumno' => $idAlumnoEliminar['idApoderadoAlumno'],
      'idAnioAdmision' => $idAlumnoEliminar['idAnioAdmision'],
    );

    $eliminarAlumno = ModelAdmision::mdlElimarDataMatriculaPostulante($dataArrayIdEliminar);
    if ($eliminarAlumno != "ok") {
      return $eliminarAlumno;
      //acrtualizar estado de postulante a registrado = 1
    } else {
      $table = "postulante";
      $actualizarEstadoPostulante = ModelAdmision::mdlActualizarEstadoPostulante($table, $idAlumnoEliminar['idPostulante'],);
      if ($actualizarEstadoPostulante != "ok") {
        return $actualizarEstadoPostulante;
      }
    }
    return "ok";
  }
  //obtener todos los id asociados al idAlumno del postulante para eliminar registros
  public static function ctrBuscarRegistrosDeMatriculaPostulante($codAlumnoEliminar)
  {
    $tabla = "alumno";
    $idAlumnoEliminar = ModelAdmision::mdlBuscarClavesForaneasDelAlumno($tabla, $codAlumnoEliminar);
    return $idAlumnoEliminar;
  }
  // Obtenerlos datos del alumno para registrar Pago
  public static function ctrObtenerDatosAdmisionAlumnoRegistrarPago($idAdmisionAlumno, $idAnioEscolar)
  {
    $tabla = "admision_alumno";
    $result = ModelAdmisionAlumno::mdlObtenerDatosAdmisionAlumnoRegistrarPago($tabla, $idAdmisionAlumno, $idAnioEscolar);
    return $result;
  }
}
