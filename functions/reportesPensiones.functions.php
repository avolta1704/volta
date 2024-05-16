<?php
class FunctionReportesPensiones
{
  //  Botones Opciones para la fila
  public static function getBotonesOpciones($codPago)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmiAlumno" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAdmiAlumno">
        <li><button type="button" class="dropdown-item btnVisualizarAdmisionAlumno" codAdAlumCronograma="' . ($codPago) . '" data-bs-toggle="modal" data-bs-target="#cronogramaPagoDeuda">Ver Calendario</button></li>
        <li><button type="button" class="dropdown-item btnEditarEstadoAdmisionAlumno" codAdmisionAlumno="' . ($codPago) . '">Agregar Pago</button></li>
        <li><button type="button" class="dropdown-item btnEliminarAdmisionAlumno" codAdmisionAlumno="' . ($codPago) . '">Ver Comunicaciones</button></li>
      </ul>
    </div>
    ';
    return $botones;
  }
}
