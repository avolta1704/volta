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
    }
    else {
      $gradoasignado = '<span class="badge rounded-pill bg-success">Asignado</span>';
    }

    return $gradoasignado;
  }

  //botones usuarios
  public static function getBtnUsuarios($codUsuario,$estadoUsuario)
  {
    
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPostulantes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
  ';

  if ($estadoUsuario == 1) {
    $botones .= '
      <li><button type="button" class="dropdown-item btnVisualizarAlumno" data-bs-toggle="modal" data-bs-target="#seleccionarCursosAsignados" codAlumno="' . $codUsuario . '">Asignar Curso</button></li>
      <li><button type="button" class="dropdown-item btnDesactivarAlumno" codUsuario="' . $codUsuario . '">Desactivar</button></li>
    ';
  }
  if ($estadoUsuario == 2) {
    $botones .= '
      <li><button type="button" class="dropdown-item btnVisualizarAlumno" data-bs-toggle="modal" data-bs-target="#seleccionarCursosAsignados" codAlumno="' . $codUsuario . '">Asignar Curso</button></li>
      <li><button type="button" class="dropdown-item btnActivarAlumno" codUsuario="' . $codUsuario . '">Activar</button></li>
    ';
  }

  $botones .= '
      </ul>
    </div>
  ';

    
    return $botones;
  }
}
