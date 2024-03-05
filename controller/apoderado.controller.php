<?php
date_default_timezone_set('America/Lima');

class ControllerApoderados
{
  //mostar todos los Apoderados DataTable
  public static function ctrGetAllApoderados()
  {
    $table = "apoderado";
    $listApoderado = ModelApoderados::mdlGetAllApoderados($table);
    return $listApoderado;
  }
    //  Obtener el ultimo usuario creado
    public static function ctrUltimoUsuarioCreado()
    {
      $table = "usuario";
      $ultimoUsuarioCreado = ModelApoderados::mdlUltimoUsuarioCreado($table);
      return $ultimoUsuarioCreado;
    }
    //  Crear Apoderado apartir de un usuario
    public static function ctrCrearUsuarioApoderado($dataUsuarioApoderado)
    {
      $table = "apoderado";
      if ($dataUsuarioApoderado["idTipoUsuario"] == 4) {
        $idTipoUsuario = 1;
      } else if ($dataUsuarioApoderado["idTipoUsuario"] == 3) {
        $idTipoUsuario = 6;
      } else {
        $idTipoUsuario = "";
      }
      $dataUsuarioApoderado = array(
        "idUsuario" => $dataUsuarioApoderado["idUsuario"],
        "idTipoUsuario" => $idTipoUsuario,
        "correoUsuario" => $dataUsuarioApoderado["correoUsuario"],
        "nombreUsuario" => $dataUsuarioApoderado["nombreUsuario"],
        "apellidoUsuario" => $dataUsuarioApoderado["apellidoUsuario"],
        "fechaCreacion" => $dataUsuarioApoderado["fechaCreacion"],
        "fechaActualizacion" => $dataUsuarioApoderado["fechaActualizacion"],
        "usuarioCreacion" => $dataUsuarioApoderado["usuarioCreacion"],
        "usuarioActualizacion" => $dataUsuarioApoderado["usuarioActualizacion"]
      );
      $listPersonal = ModelApoderados::mdlCrearUsuarioApoderado($table, $dataUsuarioApoderado);
      return $listPersonal;
    }
  //  Listar alumnos
  public static function ctrCrearApoderadoAlumno($dataApoderado)
  {
    $tabla = "apoderado";
    $response = ModelApoderados::mdlCrearApoderadoAlumno($tabla, $dataApoderado);
    return $response;
  }

  //  Obtener ultimo apoderado creado
  public static function ctrObtenerUltimoApoderado()
  {
    $tabla = "apoderado";
    $response = ModelApoderados::mdlObtenerUltimoApoderado($tabla);
    return $response;
  }

}