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
  //  Obtener tipos de usuarios
  public static function ctrGetTipoUsuarios()
  {
    $tabla = "tipo_usuario";
    $listTipos = ModelUsuarios::mdlGetTipoUsuarios($tabla);
    return $listTipos;
  }
 
}
