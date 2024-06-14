<?php
class FunctionCompetencia
{
  public static function getButtons($idCompetencia,  $data, $idNotaCompetencia)
  {
    //Evalue si la competencia tiene una nota asignada si es asi deshabilita el boton de eliminar
    $disabled = (!is_null($idNotaCompetencia)) ? 'disabled' : '';

    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownCompetencias" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
        <li><button type="button" class="dropdown-item btnEditarCompetencias" data-bs-toggle="modal" data-bs-target="#modalEditarCompetencia" idCompetencia="' . $idCompetencia . '" descripcionCompetencia="' . $data["descripcionCompetencia"] . '" capacidadesCompetencia="' . $data["capacidadesCompetencia"] . '"  estandarCompetencia="' . $data["estandarCompetencia"] . '">Editar</button></li>
        <li><button type="button" class="dropdown-item btnEliminarCompetencia" idCompetencia="' . $idCompetencia . '" ' . $disabled . '>Eliminar</button></li>

      </ul>
    </div>
  ';
    return $botones;
  }
}
