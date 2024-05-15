<?php
class FunctionPostulantes
{

  //  Estados de los postulantes
  public static function getEstadoPostulantes($stateValue)
  {
    //  Estado de los postulantes 1 = Registrado & 2 = En revisión & 3 = Admitido & 4 = Desistido & 5 = Error
    if ($stateValue == 1) {
      $estado = '<span class="badge rounded-pill bg-primary">Registrado</span>';
    }
    if ($stateValue == 2) {
      $estado = '<span class="badge rounded-pill bg-warning">En revisión</span>';
    }
    if ($stateValue == 3) {
      $estado = '<span class="badge rounded-pill bg-success">Admitido</span>';
    }
    if ($stateValue == 4) {
      $estado = '<span class="badge rounded-pill bg-danger">Desistido</span>';
    }
    if ($stateValue == 5) {
      $estado = '<span class="badge rounded-pill bg-secondary">Error</span>';
    }
    return $estado;
  }


  //  Botones para los postulantes
  public static function getBotonesPostulante($codPostulante, $estadoPostulante, $pagoMatricula)
  {
    $isDisabled = $estadoPostulante == 3 || $estadoPostulante == 4 || $estadoPostulante == 5 ? ' disabled' : '';
    $isPagoMatricula = $estadoPostulante == 3 || $estadoPostulante == 4 || $estadoPostulante == 5 || $pagoMatricula != null ? ' disabled' : '';
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPostulantes" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
    <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
    ';

    $botones .= '
      <li><button type="button" class="dropdown-item btnVisualizarPostulante" codPostulante="' . ($codPostulante) . '">Visualizar</button></li>
      <li><button type="button" class="dropdown-item btnEditarPostulante" codPostulante="' . ($codPostulante) . '"' . $isDisabled . '>Editar</button></li>
      <li><button type="button" class="dropdown-item btnActualizarEstadoPostulante" data-bs-toggle="modal" data-bs-target="#actualizarEstado" codPostulante="' . ($codPostulante) . '" codEstado="' . $estadoPostulante . '"' . $isDisabled . '>Actualizar</button></li>
      <li><button type="button" class="dropdown-item btnEliminarPostulante" codPostulante="' . ($codPostulante) . '"' . $isDisabled . '>Eliminar</button></li>
      <li><button type="button" class="dropdown-item btnAnadirPago" codPostulante="' . ($codPostulante) . '"' . $isPagoMatricula . '>Añadir pago</button></li>
    ';

    $botones .= '
    </ul>
    </div>
    ';
    return $botones;
  }
}
