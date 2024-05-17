<?php
class FunctionAlumnos
{
  //  Estados para los alumnos
  public static function getEstadosAlumnos($estadoAlumno)
  {
    //  Estado de los alumnos 1 = En Revisión 2 = Activo & 3 = Inactivo 
    if ($estadoAlumno == 1) {
      $estado = '<span class="badge rounded-pill bg-primary">Activo</span>';
    }
    if ($estadoAlumno == 2) {
      $estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
    }
    if ($estadoAlumno == 3) {
      $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
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
        <li><button type="button" class="dropdown-item btnEliminarAlumno" codAlumno="' . $codAlumno . '">Eliminar</button></li>
      ';
    }
    if ($estadoAlumno == 2) {
      $botones .= '
        <li><button type="button" class="dropdown-item btnVisualizarAlumno" data-bs-toggle="modal" data-bs-target="#modalViewAlumno" codAlumno="' . $codAlumno . '">Visualizar</button></li>
        <li><button type="button" class="dropdown-item btnEditarAlumno" codAlumno="' . $codAlumno . '">Editar</button></li>
        <li><button type="button" class="dropdown-item btnEliminarAlumno" codAlumno="' . $codAlumno . '" disabled>Eliminar</button></li>
      ';
    }
    if ($estadoAlumno == 3) {
      $botones .= '
        <li><button type="button" class="dropdown-item btnVisualizarAlumno" data-bs-toggle="modal" data-bs-target="#modalViewAlumno" codAlumno="' . $codAlumno . '">Visualizar</button></li>
        <li><button type="button" class="dropdown-item btnEditarAlumno" codAlumno="' . $codAlumno . '">Editar</button></li>
        <li><button type="button" class="dropdown-item btnEliminarAlumno" codAlumno="' . $codAlumno . '" disabled>Eliminar</button></li>
      ';
    }

    $botones .= '
        </ul>
      </div>
    ';

    return $botones;
  }


}
