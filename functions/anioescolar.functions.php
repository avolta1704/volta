<?php
class FunctionAnioEscolar
{
  //  Botones para listar los botones del año escolar
  public static function getButtonsAnioEscolar($idAnio, $estadoAnio)
  {
    $descripcion = $estadoAnio == 1 ? "Desactivar" : "Activar";
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPagos" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAniosEscolar">
        <div>
          <button type="button" class="dropdown-item btnVisualizarAnio" codAnio="' . ($idAnio) . '" data-bs-toggle="modal" data-bs-target="#modalVisualizarAnio">Visualizar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEditarAnio" codAnio="' . ($idAnio) . '" data-bs-toggle="modal" data-bs-target="#modalEditarAnio">Editar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnActualizarEstado" codAnio="' . ($idAnio) . '" codEstado="' . ($estadoAnio) . '">' . $descripcion . '</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEliminarAnio" codAnio="' . ($idAnio) . '">Eliminar</button>
        </div>
      </ul>
    </div>
    ';
    return $botones;
  }

  //  Obtener los estados para el año escolar
  public static function getEstadoAnioEscolar($estadoAnio)
  {
    if ($estadoAnio == 1) {
      $estado = '<span class="badge bg-success">Activo</span>';
    }
    if ($estadoAnio == 2) {
      $estado = '<span class="badge bg-danger">Inactivo</span>';
    }
    return $estado;
  }
}
