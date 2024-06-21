<?php
class FunctionTecnicaseInstrumentos
{
  /**
   * Botones para listar los botones de la vista de técnicas e instrumentos
   *
   * @param int $idTecnica
   * @return string
   */
  public static function getButtonsTecnica($idTecnica)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownTecnicas" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownTecnicas">
        <div>
          <button type="button" class="dropdown-item btnVisualizarTecnica" codTecnica="' . ($idTecnica) . '" data-bs-toggle="modal" data-bs-target="#modalVisualizarTecnica">Visualizar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEditarTecnica" codTecnica="' . ($idTecnica) . '" data-bs-toggle="modal" data-bs-target="#modalEditarTecnica">Editar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEliminarTecnica" codTecnica="' . ($idTecnica) . '">Eliminar</button>
        </div>
      </ul>
    </div>
    ';
    return $botones;
  }
}
