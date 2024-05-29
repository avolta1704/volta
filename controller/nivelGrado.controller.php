<?php
date_default_timezone_set('America/Lima');


class ControllerNivelGrado
{
  //  Obtener todos los niveles
  public static function ctrGetAllNiveles()
  {
  }

  //  Obtener todos los grados
  public static function ctrGetAllGrados()
  {
    $table = "grado";
    $listaGrados = ModelNivelGrado::mdlGetAllGrados($table);
    return $listaGrados;
  }

  //  Obtener todos los grados por nivel
  public static function ctrGetGradosByNivel($codNivel)
  {
    $tabla = "grado";
    $gradoNivel = ModelNivelGrado::mdlGetGradosByNivel($tabla, $codNivel);
    return $gradoNivel;
  }

  /**
   * Obtener todos los grados por nivel
   * 
   * @return array/string $respuesta Retorna un array con los datos de los grados o un string con un mensaje de error.
   */

  public static function ctrGetAllGradosByNivel()
  {
    $tabla = "grado";
    $respuesta = ModelNivelGrado::mdlGetAllGradosByNivel($tabla);
    return $respuesta;
  }
}
