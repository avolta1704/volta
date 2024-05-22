<?php
class ControllerCursos
{
  /**
   * Obtiene los cursos.
   *
   * @return array Retorna un array con los cursos.
   */
  public static function ctrGetCursos()
  {
    $response = ModelCursos::mdlGetCursos();
    return $response;
  }

  /**
   * Registra un curso.
   *
   * @param array $data Datos del curso.
   * @return string Retorna un mensaje de éxito o error.
   */
  public static function ctrRegistrarCurso($data)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $idUsuario = $_SESSION['idUsuario'];
    $dataRegistrarCursoModal = array(
      "descripcionCurso" => $data["descripcionCurso"],
      "idArea" => $data["idArea"],
      "usuarioCreacion" => $idUsuario,
      "fechaCreacion" => date('Y-m-d H:i:s'),
      "usuarioActualizacion" => $idUsuario,
      "fechaActualizacion" => date('Y-m-d H:i:s'),
    );

    $response = ModelCursos::mdlRegistrarCurso($dataRegistrarCursoModal);
    return $response;
  }

  /**
   * Elimina un curso.
   *
   * @param int $idCurso El ID del curso.
   * @return string Retorna un mensaje de éxito o error.
   */
  public static function ctrEliminarCurso($idCurso)
  {

    $existeCurso = ModelCursos::mdlExisteCursoEnCursoGrado($idCurso);
    if ($existeCurso == "ok") {
      return "error";
    }

    $response = ModelCursos::mdlEliminarCurso($idCurso);
    if ($response == "ok") {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtiene un curso.
   *
   * @param int $idCurso El ID del curso a obtener.
   * @return array Retorna un array con los datos del curso.
   */
  public static function ctrGetCurso($idCurso)
  {
    $response = ModelCursos::mdlGetCurso($idCurso);
    return $response;
  }

  /**
   * Edita un curso.
   *
   * @param array $data Datos del curso.
   * @return string Retorna un mensaje de éxito o error.
   */
  public static function ctrEditarCurso($data)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $idUsuario = $_SESSION['idUsuario'];
    $dataEditarCursoModal = array(
      "idCurso" => $data["idCurso"],
      "descripcionCurso" => $data["descripcionCurso"],
      "idArea" => $data["idArea"],
      "usuarioActualizacion" => $idUsuario,
      "fechaActualizacion" => date('Y-m-d H:i:s'),
    );

    $response = ModelCursos::mdlEditarCurso($dataEditarCursoModal);
    return $response;
  }
}
