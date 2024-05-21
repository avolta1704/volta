<?php
class FunctionReportesPensiones
{
  //  Botones Opciones para la fila
  public static function getBotonesOpciones($codcronograma, $idAdmisionAlumno, $idAlumno)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmiAlumno" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAdmiAlumno">
        <li><button type="button" class="dropdown-item btnVisualizarAdmisionAlumno" idAdmisionAlumno="' . ($idAdmisionAlumno) . '" data-bs-toggle="modal" data-bs-target="#cronogramaPagoDeuda">Ver Calendario</button></li>
        <li><button type="button" class="dropdown-item btnEditarEstadoAdmisionAlumno" codAdmisionAlumno="' . ($idAdmisionAlumno) . '">Agregar Pago</button></li>


        <li><button type="button" class="dropdown-item btnEliminarAdmisionAlumno" codAdAlumCronograma="' . $codcronograma . '" codAlumno="' . $idAdmisionAlumno . '">Ver Comunicaciones</button></li>
      </ul>
    </div>
    ';
    return $botones;
  }
}
