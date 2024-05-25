<?php
class FunctionAnioEscolar
{
  //  Botones para listar los botones del año escolar
  public static function getButtonsAnioEscolar($idAnio)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPagos" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAniosEscolar">
        <div>
          <button type="button" class="dropdown-item btnVisualizarAnio" codAnio="' . ($idAnio) . '" data-bs-toggle="modal" data-bs-target="#modalDetallePago">Visualizar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEditarAnio" codAnio="' . ($idAnio) . '">Editar</button>
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
    //  Estado de los postulantes 1 = Registrado & 2 = En revisión & 3 = Admitido & 4 = Desistido & 5 = Error
    if ($estadoAnio == 1) {
      $estado = '<span class="badge rounded-pill bg-success">Activo</span>';
    }
    if ($estadoAnio == 2) {
      $estado = '<span class="badge rounded-pill bg-danger">Inactivo</span>';
    }
    return $estado;
  }
}
