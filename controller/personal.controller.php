<?php
date_default_timezone_set('America/Lima');

class ControllerPersonal
{
  //  Obtener todo el personal
  public static function ctrGetAllPersonal()
  {
    $table = "personal";
    $listPersonal = ModelPersonal::mdlGetAllPersonal($table);
    return $listPersonal;
  }
  //  Obtener el ultimo usuario creado
  public static function ctrUltimoUsuarioCreado()
  {
    $table = "usuario";
    $ultimoUsuarioCreado = ModelPersonal::mdlUltimoUsuarioCreado($table);
    return $ultimoUsuarioCreado;
  }
  //  Crear personal apartir de un usuario
  public static function ctrCrearUsuarioPersonal($dataUsuarioPersonal)
  {
    $table = "personal";
    if ($dataUsuarioPersonal["idTipoUsuario"] == 2) {
      $idTipoUsuario = 4;
    } else if ($dataUsuarioPersonal["idTipoUsuario"] == 3) {
      $idTipoUsuario = 6;
    } else {
      $idTipoUsuario = "";
    }
    $dataUsuarioPersonal = array(
      "idUsuario" => $dataUsuarioPersonal["idUsuario"],
      "idTipoUsuario" => $idTipoUsuario,
      "correoUsuario" => $dataUsuarioPersonal["correoUsuario"],
      "nombreUsuario" => $dataUsuarioPersonal["nombreUsuario"],
      "apellidoUsuario" => $dataUsuarioPersonal["apellidoUsuario"],
      "fechaCreacion" => $dataUsuarioPersonal["fechaCreacion"],
      "fechaActualizacion" => $dataUsuarioPersonal["fechaActualizacion"],
      "usuarioCreacion" => $dataUsuarioPersonal["usuarioCreacion"],
      "usuarioActualizacion" => $dataUsuarioPersonal["usuarioActualizacion"]
    );
    $listPersonal = ModelPersonal::mdlCrearUsuarioPersonal($table, $dataUsuarioPersonal);
    return $listPersonal;
  }


}
