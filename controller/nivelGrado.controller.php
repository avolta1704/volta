<?php
date_default_timezone_set('America/Lima');


class ControllerNivelGrado
{
  //  Obtener todos los niveles
  public static function ctrGetAllNiveles($tabla)
  {
    
  }

  //  Obtener todos los grados
  public static function ctrGetAllGrados($tabla)
  {
   
  }

  //  Obtener todos los grados por nivel
  public static function ctrGetGradosByNivel($codNivel)
  {
    $tabla = "grado";
    $gradoNivel = ModelNivelGrado::mdlGetGradosByNivel($tabla, $codNivel);
    return $gradoNivel;
  }

}