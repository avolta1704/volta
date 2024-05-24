<?php
date_default_timezone_set('America/Lima');

class ControllerDocentes
{

  //  Agregar nuevo usuario
  public static function ctrGetAllDocentes()
  {
    $tabla = "usuario";
    $listUsuarios = ModelDocentes::mdlGetAllDocentes($tabla);
    return $listUsuarios;
  }
  public static function ctrGetCursoGrado()
  {
    $tabla = "grado";
    $listaGrados = ModelDocentes::mdlGetCursoGrado($tabla);
    return $listaGrados;
  }
  public static function ctrGetGrado($idpersonal)
  {
    $tabla = "usuario";
    $listaGrados = ModelDocentes::mdlGetGrado($tabla,$idpersonal);
    return $listaGrados;
  }
  public static function ctrGetCurso()
  {
    $tabla = "grado";
    $listaGrados = ModelDocentes::mdlGetCurso($tabla);
    return $listaGrados;
  }
 
}
