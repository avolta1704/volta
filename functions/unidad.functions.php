<?php
class FunctionUnidad
{
  public static function getButtons($idCompetencia)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownCompetencias" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
        <li><button type="button" class="dropdown-item btnEditarCompetencias" data-bs-toggle="modal" data-bs-target="#seleccionarCursosAsignados" idCompetencia="' . $idCompetencia . '">Editar</button></li>
        <li><button type="button" class="dropdown-item btnEliminar idCompetencia="' . $idCompetencia . '">Eliminar</button></li>

      </ul>
    </div>
  ';
    return $botones;
  }
}
