<?php
class FunctionReportesComunicados
{
  //  Botones Opciones para la fila
  public static function getBotonesOpciones($codAdmisionAlumno, $codAlumno)
  {
    $botones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmiAlumno" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownAdmiAlumno">
        <li><button type="button" class="dropdown-item btnVerComunicadosAlumno" codAlumnoComunicado="' . ($codAdmisionAlumno) . '" codAlumno="' . ($codAlumno) . '"  data-bs-toggle="modal" data-bs-target="#btnVerComunicadosAlumno">Ver Comunicados</button></li>
      </ul>
    </div>
    ';
    return $botones;
  }

  // Eliminar datos duplicados basados en idalumno
  public static function eliminarDuplicadosPorIdAlumno($array)
  {
    $result = array();
    $idsAlumno = array();

    foreach ($array as $item) {
      // Asegúrate de reemplazar 'idAlumno' con la clave real que se utiliza en tu array
      $idAlumno = $item['idAlumno'];

      if (!in_array($idAlumno, $idsAlumno)) {
        $idsAlumno[] = $idAlumno;
        $result[] = $item;
      }
    }

    return $result;
  }
}
