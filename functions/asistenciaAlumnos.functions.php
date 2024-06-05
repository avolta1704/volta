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
      case "A":
        $estadoAsistencia = "<span class='badge bg-success'>Asistió</span>";
        break;
      case "F":
        $estadoAsistencia = "<span class='badge bg-danger'>Faltó</span>";
        break;
      case "J":
        $estadoAsistencia = "<span class='badge bg-warning'>Justificado</span>";
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
  public static function getDropdownEstadoAsistencia($estado)
  {
    $dropdown = "<select class='form-select' name='estado' required>";
    $dropdown .= "<option value='A' " . ($estado == "A" ? "selected" : "") . ">Asistió</option>";
    $dropdown .= "<option value='F' " . ($estado == "F" ? "selected" : "") . ">Faltó</option>";
    $dropdown .= "<option value='J' " . ($estado == "J" ? "selected" : "") . ">Justificado</option>";
    $dropdown .= "</select>";
    return $dropdown;
  }
}
