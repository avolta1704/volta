<?php
class FunctionsAsistenciaAlumnos
{
  /**
   * Genera el badge del estado de la asistencia.
   * 
   * @param string $estado El estado de la asistencia.
   * @return string El estado de la asistencia.
   */
  public static function getEstadoAsistencia($estado)
  {
    switch ($estado) {
      case "A": // Asistió
        $estadoAsistencia = "<span class='badge bg-success'>Asistió</span>";
        break;
      case "F": // Faltó
        $estadoAsistencia = "<span class='badge bg-danger'>Faltó</span>";
        break;
      case "T": // Inasistencia Injustificado
        $estadoAsistencia = "<span class='badge bg-warning'>Inasistencia Injustificado</span>";
        break;
      case "J": // Falta Justificado
        $estadoAsistencia = "<span class='badge bg-warning'>Falta Justificado</span>";
        break;
      case "U": // Tardanza Justificado
        $estadoAsistencia = "<span class='badge bg-warning'>Tardanza</span>";
        break;
      default:
        $estadoAsistencia = "<span class='badge bg-secondary'>Sin registrar</span>";
        break;
    }
    return $estadoAsistencia;
  }

  /**
   * Genera un dropdown para seleccionar el estado de la asistencia.
   * 
   * @param string $estado El estado de la asistencia.
   * @return string El dropdown para seleccionar el estado de la asistencia.
   */
  public static function getDropdownEstadoAsistencia($idAlumno, $idCurso, $idGrado, $idPersonal, $estado)
  {
    $dropdown = "<select class='form-select' name='estado' required id='asistenciaAlumno' idAlumno='$idAlumno' idCurso='$idCurso' idGrado='$idGrado' idPersonal='$idPersonal'>";
    $dropdown .= "<option value='A' " . ($estado == "A" ? "selected" : "") . ">Asistió</option>";
    $dropdown .= "<option value='F' " . ($estado == "F" ? "selected" : "") . ">Faltó</option>";
    $dropdown .= "<option value='T' " . ($estado == "T" ? "selected" : "") . ">Inasistencia Injustificado</option>";
    $dropdown .= "<option value='J' " . ($estado == "J" ? "selected" : "") . ">Falta Justificado</option>";
    $dropdown .= "<option value='U' " . ($estado == "U" ? "selected" : "") . ">Tardanza Justificado</option>";
    $dropdown .= "</select>";
    return $dropdown;
  }
    //boton visualizar usuario
    public static function getBtnAsistenciaAlumnoApoderado($codAlumno)
    {
      $botones = '
      <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownNotasApoderado" aria-expanded="false">
          <i class="bi bi-pencil-square"></i>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
          <li><button type="button" class="dropdown-item btnVisualizarAsistenciaApoderado" data-bs-toggle="modal" data-bs-target="#modalNotasAlumnoApoderado" codAlumno="' . $codAlumno . '" >Visualizar</button></li>
        </ul>
      </div>
    ';
      return $botones;
    }
}
