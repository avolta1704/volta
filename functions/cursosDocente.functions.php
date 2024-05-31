<?php

class FunctionCursosDocente
{

  /**
   * Obtiene las acciones de los cursos asignados al docente.
   * 
   */
  static public function getAccionesCursosDocente($idCurso, $idGrado, $idPersonal)
  {
    $acciones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmisiones" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
    <ul class="dropdown-menu" aria-labelledby="dropDownAdmisiones">
    ';

    $acciones .= '
      <li><button type="button" class="dropdown-item btnVerAlumnosCurso" id="btnVerAlumnosCurso" data-bs-toggle="modal" data-bs-target="#modalListadoAlumnosCurso" idCurso="' . ($idCurso) . '" idGrado="' . ($idGrado) . '" idPersonal="' . ($idPersonal) . '" >Ver alumnos</button></li>
      <li><button type="button" class="dropdown-item" id="btnNotasCursoDocente" idCurso="' . ($idCurso) . '" idGrado="' . ($idGrado) . '" idPersonal="' . ($idPersonal) . '" >Notas</button></li>
      <li><button type="button" class="dropdown-item btn" idPersonal="' . ($idPersonal) . '" disabled>Asistencia</button></li>
      </ul>
    </div>
    ';
    return $acciones;
  }

  /**
   * Obtiene las acciones de los alumnos por curso
   */
  static public function getAccionesAlumnosPorCurso($idAlumno)
  {
    $acciones = '
    <div class="btn-group">
      <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownAdmisiones" aria-expanded="false">
        <i class="bi bi-pencil-square"></i>
      </button>
    <ul class="dropdown-menu" aria-labelledby="dropDownAdmisiones">
    ';

    $acciones .= '
      <li><button type="button" class="dropdown-item btn" idAlumno="' . ($idAlumno) . '">Visualizar</button></li>
      </ul>
    </div>
    ';
    return $acciones;
  }
}
