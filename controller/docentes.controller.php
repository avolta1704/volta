<?php
date_default_timezone_set('America/Lima');

class ControllerDocentes
{

  //  Agregar nuevo usuario
  public static function ctrGetAllDocentes()
  {
    $tabla = "usuario";
    $listUsuarios = ModelDocentes::mdlGetAllDocentes($tabla);
    return $listUsuarios;
  }
  public static function ctrGetCursoGrado()
  {
    $tabla = "grado";
    $listaGrados = ModelDocentes::mdlGetCursoGrado($tabla);
    return $listaGrados;
  }
  public static function ctrGetGrado($idpersonal)
  {
    $tabla = "usuario";
    $listaGrados = ModelDocentes::mdlGetGrado($tabla, $idpersonal);
    return $listaGrados;
  }
  public static function ctrGetCurso()
  {
    $tabla = "grado";
    $listaGrados = ModelDocentes::mdlGetCurso($tabla);
    return $listaGrados;
  }

  //  Cambiar estado del alumno
  public static function ctrobtenerIdCursogrado($gradoSeleccionado, $cursoSeleccionado)
  {
    $tabla = "curso_grado";
    $dataAlumno = ModelDocentes::mdlobtenerIdCursogrado($tabla, $gradoSeleccionado, $cursoSeleccionado);
    return $dataAlumno;
  }

  //  Asignar curso a docente
  public static function ctroAsignarCurso($idPersonal, $response)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $dataCursoGradoPersonal = array(
      "idCursoGrado" => $response,
      "idPersonal" => $idPersonal,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $table = "cursogrado_personal";
    $result = ModelDocentes::mdlAsignarCurso($table, $dataCursoGradoPersonal);

    $idCursoGradoPersonal = ModelDocentes::mdlObtenerIdUltimoPostulante();
    $anioEscolarActiva = ControllerAnioEscolar::ctrAnioEscolarActivoParaRegistroAlumno(1); // 1 para estadoAnio = 1

    $asignaraniocursogrado = ControllerAnioCursoGrado::ctrCrearAnioCursoGrado($idCursoGradoPersonal, $anioEscolarActiva);


    if ($asignaraniocursogrado == "error") {
      error_log("Error al asignar el año del curso grado");
    } else {
      return $result;
    }
  }

  //  Obtener ID de cursos ya seleccionados
  public static function ctroObteneridCursos($gradoSeleccionado)
  {
    $table = "curso_grado";
    $result = ModelDocentes::mdlObteneridCursos($table, $gradoSeleccionado);
    return $result;
  }

  //  Obtener el ID Personal de cursos ya seleccionaods
  public static function ctroObteneridPersonal($gradoSeleccionado, $cursoSeleccionado)
  {
    $table = "cursogrado_personal";
    $result = ModelDocentes::mdlObteneridPersonal($table, $gradoSeleccionado, $cursoSeleccionado);
    return $result;
  }


  //  Obtener el ID Personal grado
  public static function ctroObteneridPersonalGrado($gradoSeleccionado)
  {
    $table = "cursogrado_personal";
    $result = ModelDocentes::mdlObteneridPersonalGrado($table, $gradoSeleccionado);
    return $result;
  }

  //  Obtener el ID Personal de cursos ya seleccionaods
  public static function ctroCambiarIdPersonal($idPersonalRepetido, $idPersonalReemplazo, $idcursogradoRepetido)
  {
    $table = "cursogrado_personal";
    $result = ModelDocentes::mdlCambiarIdPersonal($table, $idPersonalRepetido, $idPersonalReemplazo, $idcursogradoRepetido);
    return $result;
  }

  //  Cambiar estado del docente
  public static function ctrCambiarEstadoDocente($idUsuarioEstado, $cambiarEstadoDocente)
  {
    $tabla = "usuario";
    $dataAlumno = ModelDocentes::mdlCambiarEstadoDocente($tabla, $idUsuarioEstado, $cambiarEstadoDocente);
    return $dataAlumno;
  }

  //  Obtener todos los cursos asignados al docente
  public static function ctrCursosporDocente($codPersonal)
  {
    $tabla = "curso";
    $dataAlumno = ModelDocentes::mdlCursosporDocente($tabla, $codPersonal);
    return $dataAlumno;
  }

  //  Obtener todos los cursos asignados al docente
  public static function ctrEliminarCursoGradoPersonal($idCursogradoPersonal)
  {
    $tabla = "cursogrado_personal";
    $dataAnioEscolar = ModelDocentes::mdlEliminarAnioCursoGrado($idCursogradoPersonal);
    if ($dataAnioEscolar != "error") {
      $dataCursos = ModelDocentes::mdlEliminarCursoGradoPersonal($tabla, $idCursogradoPersonal);
      return $dataCursos;
    }
  }

  //  Obtener ID de cursos ya seleccionados para reemplazar
  public static function ctroObteneridCursosReemplaza($gradoSeleccionado)
  {
    $table = "curso_grado";
    $result = ModelDocentes::mdlObteneridCursosReemplaza($table, $gradoSeleccionado);
    return $result;
  }

  /**
   * Obtener los cursos asignados al docente
   * 
   * @param int $idPersonal ID del docente
   * @return array $response Array con los cursos asignados al docente
   */
  public static function ctrObtenerCursosAsignados()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    $idUsuario = $_SESSION["idUsuario"];

    $idPersonal = ModelDocentes::mdlObtenerIdPersonalByIdUsuario($idUsuario);

    if ($idPersonal == null) {
      return "error";
    }

    $cursos = ModelDocentes::mdlObtenerCursosAsignados($idPersonal);

    return $cursos;
  }

  /**
   * Obtener el ID del personal del curso y grado
   * 
   * @param int $idCurso ID del curso
   * @param int $idGrado ID del grado
   * @return int $idPersonalCursoGrado ID del personal del curso y grado
   */
  public static function ctrObtenerIdPersonalCursoGrado($idCurso, $idGrado)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $idUsuario = $_SESSION["idUsuario"];

    $idPersonal = ModelDocentes::mdlObtenerIdPersonalByIdUsuario($idUsuario);

    $idPersonalCursoGrado = ModelDocentes::mdlObtenerIdPersonalCursoGrado($idCurso, $idGrado, $idPersonal);

    return $idPersonalCursoGrado["idCursogradoPersonal"];
  }

    /**
   * Obtener los identificadores de idCurso, idGrado e idPersonal del docente
   * 
   * @return array $response Array con los identificadores del docente
   */
  public static function ctrGetIdentificadoresDocente($idUsuario)
  {
    $tabla = "usuario";
    $listaIdentificadores = ModelDocentes::mdlGetIndetificadoresDocente($tabla, $idUsuario);
    return $listaIdentificadores;
  }
}
