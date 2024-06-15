<?php
class FunctionsCriterios
{
  /**
   * Botones acciones de los criterios.
   * 
   * @param int $idCriterio El ID del criterio.
   * @return string Los botones de acciones.
   */
  public static function botonesAcciones($idCriterio, $idCompetencia, $idTecnica, $idInstrumento, $descripcion)
  {
    $botones = "<div class='btn-group'><button class='btn btn-warning' id='btnEditarCriterio' data-bs-toggle='modal' data-bs-target='#modalEditarCriterio' idCriterio='$idCriterio' 
    idCompetencia='$idCompetencia'
    idTecnica='$idTecnica'
    idInstrumento='$idInstrumento'
    descripcionCriterio='$descripcion'
    ><i class='bi bi-pencil-square'></i></button><button class='btn btn-danger' id='btnEliminarCriterio' idCriterio='$idCriterio' idCompetencia='$idCompetencia'><i class='bi bi-trash3'></i></button></div>";
    return $botones;
  }
}
