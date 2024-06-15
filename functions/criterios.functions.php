<?php
class FunctionsCriterios
{
  /**
   * Botones acciones de los criterios.
   * 
   * @param int $idCriterio El ID del criterio.
   * @return string Los botones de acciones.
   */
  public static function botonesAcciones($idCriterio)
  {
    $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarCriterio' idCriterio='$idCriterio'><i class='bi bi-pencil-square'></i></button><button class='btn btn-danger btnEliminarCriterio' idCriterio='$idCriterio'><i class='bi bi-trash3'></i></button></div>";
    return $botones;
  }
}
