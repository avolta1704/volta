<?php
class FunctionCompetencia
{
  public static function getButtons($idCompetencia, $descripcionCompetencia)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownCompetencias" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
        <li><button type="button" class="dropdown-item btnEditarCompetencias" data-bs-toggle="modal" data-bs-target="#modalEditarCompetencia" idCompetencia="' . $idCompetencia . '" descripcionCompetencia="' . $descripcionCompetencia . '">Editar</button></li>
        <li><button type="button" class="dropdown-item btnEliminarCompetencia" idCompetencia="' . $idCompetencia . '">Eliminar</button></li>

      </ul>
    </div>
  ';
    return $botones;
  }
}
