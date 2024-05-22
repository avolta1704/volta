<?php
class FunctionAsignarCursos
{
  /**
   * Obtiene el botón para listar los cursos por grado.
   * 
   * @param int $idGrado El ID del grado.
   * @return string Retorna el botón para listar los cursos por grado.
   */
  public static function getButtonListarCursos($idGrado)
  {
    return  '<button type="button" class="btn btn-outline-primary btnListarCursosPorGrado" data-bs-toggle="modal" id="btnListarCursosPorGrado" data-bs-target="#modalListarCursos" idGrado="' . $idGrado . '">
            Ver Cursos
          </button>';
  }

  /**
   * Obtiene el botón para eliminar un curso.
   * 
   * @param int $idCurso El ID del curso.
   * @return string Retorna el botón para eliminar un curso.
   */
  public static function getButtonDeleteCurso($idCursoGrado)
  {
    return  '<button type="button" class="btn btn-outline-danger btnEliminarCursoAsignado" id="btnEliminarCursoAsignado" idCursoGrado="' . $idCursoGrado . '">
            Eliminar
          </button>';
  }
}
