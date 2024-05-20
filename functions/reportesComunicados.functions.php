<?php
class FunctionReportesComunicados
{
  //  Botones Opciones para la fila
  public static function getBotonesOpciones($codComunicado, $codAlumno)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmiAlumno" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAdmiAlumno">
        <li><button type="button" class="dropdown-item btnVerComunicadosAlumno" codAlumnoComunicado="' . ($codComunicado) . '" codAlumno="' . ($codAlumno) . '"  data-bs-toggle="modal" data-bs-target="#btnVerComunicadosAlumno">Ver Comunicados</button></li>
      </ul>
    </div>
    ';
    return $botones;
  }
}
