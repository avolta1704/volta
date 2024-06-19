<?php
class ControllerGrado
{
  /**
   * Obtener un grado por su id
   * 
   * @param int $idGrado id del grado
   * @return string $data del grado o "error" en caso haya ocurrido un error
   */
  public static function ctrGetGradoById($idGrado)
  {
    $tabla = "grado";
    $response = ModelGradoAlumno::mdlGetGradoById($tabla, $idGrado);
    return $response;
  }
}
