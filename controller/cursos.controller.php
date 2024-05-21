<?php
class ControllerCursos
{
  /**
   * Obtiene los cursos.
   *
   * @return array Retorna un array con los cursos.
   */
  public static function ctrGetCursos()
  {
    $response = ModelCursos::mdlGetCursos();
    return $response;
  }
}
