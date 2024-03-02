<?php
date_default_timezone_set('America/Lima');

class ControllerPersonal
{
  //  Obtener el ultimo usuario creado
  public static function ctrUltimoUsuarioCreado()
  {
    $tabla = "usuario";
    $ultimoUsuarioCreado = ModelPersonal::mdlUltimoUsuarioCreado($tabla);
    return $ultimoUsuarioCreado;
  }

  //  Crear personal apartir de un usuario
  public static function ctrCrearUsuarioPersonal($dataUsuarioPersonal)
  {
    $tabla = "personal";

    // Aquí estás tomando los datos que se están enviando al controlador
    $data = array(
      "idUsuario" => $dataUsuarioPersonal["idUsuario"],
      "correoUsuario" => $dataUsuarioPersonal["correoUsuario"],
      //"password" => $dataUsuarioPersonal["password"],
      "nombreUsuario" => $dataUsuarioPersonal["nombreUsuario"],
      "apellidoUsuario" => $dataUsuarioPersonal["apellidoUsuario"],
      "dniUsuario" => $dataUsuarioPersonal["dniUsuario"],
      "idTipoUsuario" => $dataUsuarioPersonal["idTipoUsuario"],
      "estadoUsuario" => $dataUsuarioPersonal["estadoUsuario"],
      "fechaCreacion" => $dataUsuarioPersonal["fechaCreacion"],
      "fechaActualizacion" => $dataUsuarioPersonal["fechaActualizacion"],
      "usuarioCreacion" => $dataUsuarioPersonal["usuarioCreacion"],
      "usuarioActualizacion" => $dataUsuarioPersonal["usuarioActualizacion"]
    );

    // Y aquí estás enviando esos datos al modelo para su creación
    $listPersonal = ModelPersonal::mdlCrearUsuarioPersonal($tabla, $data);
    return $listPersonal;
  }




  //  Obtener datos para editar
  public static function ctrGetUsuarioEdit($codUsuario)
  {
    $tabla = "usuario";
    $dataUsuario = ModelUsuarios::mdlGetUsuarioEditar($tabla, $codUsuario);
    return $dataUsuario;
  }

  //  Editar usuario
  public static function ctrEditarUsuarioPersonal()
  {
    if (isset($_POST["correoEditar"])) {
      $tabla = "usuario";
      $dataUsuario = array(
        "correoUsuario" => $_POST["correoEditar"],
        "nombreUsuario" => $_POST["nombreEditar"],
        "apellidoUsuario" => $_POST["apellidoEditar"],
        "dniUsuario" => $_POST["dniEditar"],
        "idTipoUsuario" => $_POST["tipoEditar"],
        "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
        "usuarioActualizacion" => $_SESSION["idUsuario"],
        "idUsuario" => $_POST["codUsuario"]
      );
      $response = ModelUsuarios::mdlEditarUsuarioPersonal($tabla, $dataUsuario);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta('success', 'Correcto', 'Usuario editado correctamente', 'usuarios');
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta('error', 'Error', 'Error al editar el usuario', 'usuarios');
        echo $mensaje;
      }
    }
  }

  //  Actualizar estado del usuario
  public static function ctrActualizarEstado($codUsuario)
  {
    $tabla = "usuario";
    $estadoUsuario = ModelUsuarios::mdlObtenerEstadoUsuario($tabla, $codUsuario);
    if ($estadoUsuario["estadoUsuario"] == "1 ") {
      $nuevoEstado = ModelUsuarios::mdlActualizarEstado($tabla, $codUsuario, "2");
    } else {
      $nuevoEstado = ModelUsuarios::mdlActualizarEstado($tabla, $codUsuario, "1");
    }
    return $nuevoEstado;
  }
}
