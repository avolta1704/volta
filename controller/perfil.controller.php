<?php
date_default_timezone_set('America/Lima');

class ControllerPerfil
{
  //  Obtener todo el perfil de usuario
  public static function ctrGetAllPerfilUsuario($idUsuario)
  {
    $table = "usuario";
    $listUsuario = ModelPerfil::mdlGetAllPerfilUsuario($table, $idUsuario);
    return $listUsuario;
  }
  //  Obtener todo el perfil de usuario para mostar en editar perfil
  public static function ctrGetAllPerfilUsuarioDataEdit($idUsuario)
  {
    $table = "usuario";
    $listUsuario = ModelPerfil::mdlGetAllPerfilUsuarioDataEdit($table, $idUsuario);
    return $listUsuario;
  }
  //  Obtener todo el perfil de personal
  public static function ctrGetAllPerfilPersonal($idUsuario)
  {
    $table = "personal";
    $listPersonal = ModelPerfil::mdlGetAllPerfilPersonal($table, $idUsuario);
    return $listPersonal;
  }
  //  Obtener todo el perfil de personal para mostar en editar perfil
  public static function ctrGetAllPerfilPersonalDataEdit($idUsuario)
  {
    $table = "personal";
    $listPersonal = ModelPerfil::mdlGetAllPerfilPersonalDataEdit($table, $idUsuario);
    return $listPersonal;
  }

}
