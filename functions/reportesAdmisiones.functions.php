<?php
class FunctionReportesAdmisiones
{
  /**
   * Obtiene el estado de admisión de un alumno.
   *
   * @param string $estado El estado de admisión del alumno.
   * @return mixed El estado de admisión del alumno.
   */
  public static function getEstadoAdmisionAlumno($estado)
  {
    //  Estado de los postulantes 1 = Registrado & 2 = En revisión & 3 = Admitido & 4 = Desistido & 5 = Error
    if ($estado == 1) {
      $estadoAdmision = '<span class="badge rounded-pill bg-secondary">Anulado</span>';
    } else
    if ($estado == 2) {
      $estadoAdmision = '<span class="badge rounded-pill bg-success">Matriculado</span>';
    } else
    if ($estado == 3) {
      $estadoAdmision = '<span class="badge rounded-pill bg-warning">Trasladado</span>';
    } else
    if ($estado == 4) {
      $estadoAdmision = '<span class="badge rounded-pill bg-danger">Retirado</span>';
    } else {
      $estadoAdmision = '<span class="badge rounded-pill bg-secondary">Otro</span>';
    }

    return $estadoAdmision;
  }

  /**
   * Obtiene las acciones de admisión de un alumno.
   *
   * @param int $idAdmisionAlumno El ID de la admisión del alumno.
   * @return array Las acciones de admisión del alumno.
   */
  public static function getAccionesAdmisionAlumno($idAdmisionAlumno)
  {
    $acciones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmisiones" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
    <ul class="dropdown-menu" aria-labelledby="dropDownAdmisiones">
    ';

    $acciones .= '
      <li><button type="button" class="dropdown-item btnVerCalendarioAdmision" idAdmisionAlumno="' . ($idAdmisionAlumno) . '">Ver Calendario</button></li>
      <li><button type="button" class="dropdown-item btnVisualizarAdmision" idAdmisionAlumno="' . ($idAdmisionAlumno) . '">Visualizar</button></li>
      </ul>
    </div>
    ';

    return $acciones;
  }
}
