<?php
class FunctionCursos
{
  /**
   * Obtiene los botones de opciones de los cursos.
   *
   * @param int $idCurso El ID del curso.
   * @return array Los botones de los cursos.
   */
  public static function getBotonesCursos($idCurso)
  {
/*     $botones = "<div class='btn-group'><button class='btn btn-warning btnEditarCurso' idCurso='$idCurso' data-bs-toggle='modal' data-bs-target='#modalEditarCurso'><i class='bi bi-pencil-square'></i></button><button class='btn btn-danger btnEliminarCurso' idCurso='$idCurso'><i class='bi bi-trash'></i></button></div>"; */

    $botones = '
      <div class="btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" id="dropDownPagos" aria-expanded="false">
          <i class="bi bi-pencil-square"></i>
        </button>
      <ul class="dropdown-menu" aria-labelledby="dropDownPostulantes">
        <div>
          <button type="button" class="dropdown-item btnEditarCurso" idCurso="' . ($idCurso) . '" data-bs-toggle="modal" data-bs-target="#modalEditarCurso">Editar</button>
        </div>
        <div>
            <button type="button" class="dropdown-item btnEliminarCurso" idCurso="' . ($idCurso) . '">Eliminar</button>
        </div>
        ';
    return $botones;
  }

  /**
   * Obtiene el estado del curso.
   *
   * @param string $estado El estado del curso.
   * @return string El estado del curso.
   */
  public static function getEstadoCurso($estado)
  {
    if ($estado == 1) {
      $estado = "<span class='badge bg-success'>Activo</span>";
    } else {
      $estado = "<span class='badge bg-danger'>Inactivo</span>";
    }
    return $estado;
  }
}
