<?php
class FunctionAreas
{
  /**
   * Obtiene el botón de áreas.
   *
   * @param int $idArea El ID del área.
   * @return string El botón de áreas.
   */
  public static function getBtnAreas($idArea)
  {
    $botones = "<div class='btn-group'><button type='button' class='btn btn-warning btnEditarArea' idArea='$idArea' data-bs-toggle='modal' data-bs-target='#modalEditarArea'><i class='bi bi-pencil-square'></i></button><button class='btn btn-danger btnEliminarArea' idArea='$idArea'><i class='bi bi-trash'></i></button></div>";
    return $botones;
  }
}
