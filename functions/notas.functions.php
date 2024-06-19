<?php
class FunctionNotas
{
  /**
   * Función para obtener el select de las notas de cada criterio de evaluación
   * 
   * @param $idCriterio id del criterio de evaluación
   * @param $idNota id de la nota
   * @return string
   */
  public static function selectNotas($idCriterioCompetencia, $idAlumnoAnioEscolar, $idNotaCriterio, $nota)
  {
    $select = "<select class='form-control selectNota' name='nota' id='nota' idCriterioCompetencia='$idCriterioCompetencia' idAlumnoAnioEscolar='$idAlumnoAnioEscolar' idNotaCriterio='$idNotaCriterio'>";
    $select .= "<option value='null'>Seleccione</option>";
    $select .= "<option value='AD' " . ($nota == "AD" ? "selected" : "") . ">AD</option>";
    $select .= "<option value='A' " . ($nota == "A" ? "selected" : "") . ">A</option>";
    $select .= "<option value='B' " . ($nota == "B" ? "selected" : "") . ">B</option>";
    $select .= "<option value='C' " . ($nota == "C" ? "selected" : "") . ">C</option>";
    $select .= "</select>";

    return $select;
  }
}
