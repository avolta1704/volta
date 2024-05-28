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

  //  Crear admision de alumno
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
    return $result;
  }

  //  Crear admision de alumno
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
}
