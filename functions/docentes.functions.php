<?php
class FunctionDocente
{

  public static function getTipoUsuarioLogin($tipoUsuarioLogin)
  {

    if ($tipoUsuarioLogin == 1) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Administrador</span>';
    }
    if ($tipoUsuarioLogin == 2) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Docente</span>';
    }
    if ($tipoUsuarioLogin == 3) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Administrativo</span>';
    }
    if ($tipoUsuarioLogin == 4) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Apoderado</span>';
    }
    if ($tipoUsuarioLogin > 5) {
      $TipoUsuario = '<span class="badge rounded-pill bg-success">Sin Tipo Usuario</span>';
    }

    return $TipoUsuario;
  }
  //  Estados de los usuarios
  public static function getEstadoocentes($stateValue)
  {
    //  Estado de los usuarios 1 = Activo & 2 = Desactivado
    if ($stateValue == 1) {
      $estado = '<span class="badge rounded-pill bg-success">Activo</span>';
    }
    if ($stateValue == 2) {
      $estado = '<span class="badge rounded-pill bg-danger">Desactivado</span>';
    }
    if ($stateValue > 3) {
      $estado = '<span class="badge rounded-pill bg-warning">Sin Estado</span>';
    }

    return $estado;
  }

  public static function getGrado($grado)
  {
    //  Grado Asignado
    if ($grado == false) {
      $gradoasignado = '<span class="badge rounded-pill bg-danger">Sin asignar</span>';
    } else {
      $gradoasignado = '<span class="badge rounded-pill bg-success">Asignado</span>';
    }

    return $gradoasignado;
  }

  //botones usuarios
  public static function getBtnUsuarios($codPersonal, $estadoUsuario, $codTipoPersonal, $idUsuario)
  {
    $descripcion = $estadoUsuario == 1 ? "Desactivar" : "Activar";
    $buttonId = $estadoUsuario == 1 ? "btnDesactivarDocente" : "btnActivarDocente";
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPostulantes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
        <li><button type="button" class="dropdown-item btnVisualizarDocente" data-bs-toggle="modal" data-bs-target="#seleccionarCursosAsignados" codPersonal="' . $codPersonal . '" codTipoPersonal="' . $codTipoPersonal . '">Asignar Curso</button></li>
        <li><button type="button" class="dropdown-item" id="' . $buttonId . '" idUsuario="' . $idUsuario . '">' . $descripcion . '</button></li>
        <li><button type="button" class="dropdown-item btnVisualizarAsignaciones" id="btnVisualizarAsignaciones" data-bs-toggle="modal" data-bs-target="#modalListarCursosDocente" codPersonal="' . $codPersonal . '" codTipoPersonal="' . $codTipoPersonal . '">Ver Asignaciones</button></li>

      </ul>
    </div>
  ';
    return $botones;
  }

  public static function getButtonDeleteCurso($idCursogradoPersonal)
  {
    return  '<button type="button" class="btn btn-outline-danger btnEliminarCursoAsignadoDocente" id="btnEliminarCursoAsignadoDocente" idCursogradoPersonal="' . $idCursogradoPersonal . '">
            Eliminar
          </button>';
  }

  /**
   * Método para obtener los botones de los docentes de inicial y de primaria
   * 
   * @param int $idAlumno Código del alumno.
   * @return string $botones Botones del alumno.
   */
  public static function getAccionesDocenteIniPrim($idAlumno)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu">
        <li><button type="button" class="dropdown-item btnVisualizarAlumno" idAlumno="' . $idAlumno . '">Visualizar</button></li>
        <li><button type="button" class="dropdown-item btnVisualizarNotas" idAlumno="' . $idAlumno . '">Ver Notas</button></li>
        <li><button type="button" class="dropdown-item btnVisualizarAsistencia" idAlumno="' . $idAlumno . '">Ver Asistencia</button></li>
      </ul>
    </div>';
    return $botones;
  }

  /**
   * Método para visualizar los alumnos de un docente de cieto grado
   * 
   * @param int $idCursogradoPersonal Código del curso y grado del docente.
   */
  public static function getButtonVerAlumnos($idCurso, $idGrado, $idPersonal)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownCursosDocentes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownCursosDocentes">
        <button type="button" class="dropdown-item btn btnVerAlumnosCursoDocente" idCurso="' . $idCurso . '" idGrado="' . $idGrado . '" idPersonal="' . $idPersonal . '">Ver Alumnos</button>
      </ul>
    </div>
    ';
    return $botones;
  }
  public static function getButtonVerAsistenciaAlumnos($idCurso, $idGrado, $idPersonal)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownCursosDocentes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownCursosDocentes">
        <button type="button" class="dropdown-item btn btnVerAsistenciaAlumnosCursoDocente" idCurso="' . $idCurso . '" idGrado="' . $idGrado . '" idPersonal="' . $idPersonal . '">Ver Asistencia</button>
      </ul>
    </div>
    ';
    return $botones;
  }
  public static function getButtonVerNotasAlumnos($idCurso, $idGrado, $idPersonal)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownCursosDocentes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownCursosDocentes">
        <button type="button" class="dropdown-item btn btnVerNotasAlumnosCursoDocente" idCurso="' . $idCurso . '" idGrado="' . $idGrado . '" idPersonal="' . $idPersonal . '">Ver Notas</button>
      </ul>
    </div>
    ';
    return $botones;
  }
}
