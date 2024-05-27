<?php
class FunctionAdmisionAlumnos
{

  //  Estados para  tipoAdmision
  public static function getEstadoTipoAdmision($tipoAdmision)
  {
    $tipoAdmision = intval($tipoAdmision);
    //  Estado tipoAdmision 1 = ordinario 2 = Extraordinario & 3 = Proceso
    if ($tipoAdmision == 1) {
      $tipo = '<span class="badge rounded-pill bg-secondary">Ordinario</span>';
    }
    if ($tipoAdmision == 2) {
      $tipo = '<span class="badge rounded-pill bg-secondary">Extra Ordinario</span>';
    }
    if ($tipoAdmision == "") {
      $tipo = '<span class="badge rounded-pill bg-secondary">Proceso</span>';
    }
    return $tipo;
  }
  //  Estados para estadoAdmisionAlumno
  public static function getEstadoAdmisionAlumno($estadoAdmisionAlumno)
  {
    //  Estado estadoAdmisionAlumno 1 = registrado  2 = Matriculado  & 3 = Trasladado 4 = Retirado 
    if ($estadoAdmisionAlumno == 1) {
      $estado = '<span class="badge rounded-pill bg-warning">Registrado</span>';
    }
    if ($estadoAdmisionAlumno == 2) {
      $estado = '<span class="badge rounded-pill bg-success">Matriculado</span>';
    }
    if ($estadoAdmisionAlumno == 3) {
      $estado = '<span class="badge rounded-pill bg-primary">Trasladado</span>';
    }
    if ($estadoAdmisionAlumno == 4) {
      $estado = '<span class="badge rounded-pill bg-danger">Retirado</span>';
    }
    return $estado;
  }
  //  Estados para los alumnos
  public static function getEstadoAlumno($estadoAlumno)
  {
    //  Estado de los alumnos 1 = Activo 2 = Inactivo & 3 = en revisión estraordinaria 
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
  //  Estados para estadoSiagie
  public static function getEstadoSiagie($estadoSiagie)
  {
    //  Estado de los alumnos 1 = Activo 2 = Inactivo & 3 = Proceso 
    if ($estadoSiagie == 1) {
      $estado = '<span class="badge rounded-pill bg-success">Activo</span>';
    }
    if ($estadoSiagie == 2) {
      $estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
    }
    if ($estadoSiagie == "") {
      $estado = '<span class="badge rounded-pill bg-warning">Proceso</span>';
    }
    return $estado;
  }
  //  Estados para estadoAlumno
  public static function getEstadoMatricula($estadoMatricula)
  {
    //  Estado de los alumnos 1 = Registrado 2 = Matriculado & 3 = sin Registro 
    if ($estadoMatricula == 1) {
      $estado = '<span class="badge rounded-pill bg-warning">Registrado</span>';
    }
    if ($estadoMatricula == 2) {
      $estado = '<span class="badge rounded-pill bg-success">Matriculado</span>';
    }
    if ($estadoMatricula == "") {
      $estado = '<span class="badge rounded-pill bg-primary">Sin Registro</span>';
    }
    return $estado;
  }

  //  Botones para la vista de alumnosAdmision
  public static function getBotonesAdmisionAlumnos($codAdmisionAlumno, $estadoAdmisionAlumno, $idAlumno)
  {
    $botones = '
      <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmiAlumno" aria-expanded="false">
          <i class="bi bi-pencil-square"></i>
        </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAdmiAlumno">
      ';

    $opciones = [
      'Ver Calendario' => ['btnVisualizarCronograma', 'codAdAlumCronograma', '#cronogramaAdmisionPago'],
      'Visualizar' => ['btnVisualizarAdmisionAlumno', 'codAdmisionAlumno'],
      'Editar' => ['btnEditarAlumno', 'codAlumno'],
    ];

    foreach ($opciones as $texto => $opcion) {
      $clase = $opcion[0];
      $codigo = $opcion[1];
      $target = isset($opcion[2]) ? 'data-bs-toggle="modal" data-bs-target="' . $opcion[2] . '"' : '';
      $disabled = ($estadoAdmisionAlumno == 1 && $texto == 'Ver Calendario') || ($estadoAdmisionAlumno > 1 && $texto == 'Programar') || ($estadoAdmisionAlumno > 1 && $texto == 'Eliminar') ? 'disabled' : '';
      $botones .= '<li><button type="button" class="dropdown-item ' . $clase . '" ' . $codigo . '="' . ($codigo == 'codAlumno' ? $idAlumno : $codAdmisionAlumno) . '" ' . $target . ' ' . $disabled . '>' . $texto . '</button></li>';
    }

    $botones .= '
    <li><button type="button" id="btnAbrirModalEstadoMatricula" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#actualizarEstadoAdmisionAlumno" idAdmisionAlumno="' . $codAdmisionAlumno . '" >Actualizar</button></li>
        </ul>
      </div>
      ';

    return $botones;
  }
}
