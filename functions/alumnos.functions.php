<?php
class FunctionAlumnos
{
  //  Estados para los alumnos
  public static function getEstadosAlumnos($estadoAlumno)
  {
    if ($estadoAlumno == 1) {
      $estado = '<span class="badge rounded-pill bg-secondary">Anulado</span>';
    } else
    if ($estadoAlumno == 2) {
      $estado = '<span class="badge rounded-pill bg-success">Matriculado</span>';
    } else
    if ($estadoAlumno == 3) {
      $estado = '<span class="badge rounded-pill bg-warning">Trasladado</span>';
    } else
    if ($estadoAlumno == 4) {
      $estado = '<span class="badge rounded-pill bg-danger">Retirado</span>';
    } else {
      $estado = '<span class="badge rounded-pill bg-secondary">Otro</span>';
    }
    return $estado;
  }
  //  Botones para la vista de listar alumnos

  public static function getBotonesAlumnos($codAlumno, $estadoAlumno)
  {
    $botones = '
      <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmiAlumno" aria-expanded="false"><i class="bi bi-pencil-square"></i></button>
        <ul class="dropdown-menu" aria-labelledby="dropDownAdmiAlumno">
    ';

    if ($estadoAlumno == 1) {
      $botones .= '
        <li><button type="button" class="dropdown-item btnVisualizarAlumno" data-bs-toggle="modal" data-bs-target="#modalViewAlumno" codAlumno="' . $codAlumno . '">Visualizar</button></li>
        <li><button type="button" class="dropdown-item btnEditarAlumno" codAlumno="' . $codAlumno . '">Editar</button></li>
        <li><button type="button" class="dropdown-item btnDesactivarAlumno" codAlumno="' . $codAlumno . '">Desactivar</button></li>
      ';
    }
    if ($estadoAlumno == 2) {
      $botones .= '
        <li><button type="button" class="dropdown-item btnVisualizarAlumno" data-bs-toggle="modal" data-bs-target="#modalViewAlumno" codAlumno="' . $codAlumno . '">Visualizar</button></li>
        <li><button type="button" class="dropdown-item btnEditarAlumno" codAlumno="' . $codAlumno . '">Editar</button></li>
        <li><button type="button" class="dropdown-item btnActivarAlumno" codAlumno="' . $codAlumno . '">Activar</button></li>
      ';
    }
    if ($estadoAlumno == 3) {
      $botones .= '
        <li><button type="button" class="dropdown-item btnVisualizarAlumno" data-bs-toggle="modal" data-bs-target="#modalViewAlumno" codAlumno="' . $codAlumno . '">Visualizar</button></li>
        <li><button type="button" class="dropdown-item btnEditarAlumno" codAlumno="' . $codAlumno . '">Editar</button></li>

        <li><button type="button" class="dropdown-item btnEliminarAlumno" codAlumno="' . $codAlumno . '">Eliminar</button></li>
      ';
    }

    $botones .= '
        </ul>
      </div>
    ';

    return $botones;
  }
}
