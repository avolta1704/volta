<?php
date_default_timezone_set('America/Lima');

class ControllerPersonal
{
  //  Crear personal apartir de un usuario
  public static function ctrCrearUsuarioPersonal($dataUsuario)
  {
    $tabla = "personal";
    $listPersonal = ModelPersonal::mdlCrearUsuarioPersonal($tabla, $dataUsuario);
    return $listPersonal;
  }

  //  Obtener el ultimo usuario creado
  public static function ctrUltimoUsuarioCreado()
  {
    $tabla = "usuario";
    $ultimoUsuarioCreado = ModelPersonal::mdlUltimoUsuarioCreado($tabla);
    return $ultimoUsuarioCreado;
  }

  //  Crear usuario
  public static function ctrCrearUsuarioPersonal1()
  {
    if (isset($_POST["usuarioCorreo"]) && isset($_POST["passwordUsuario"])) {
      $tabla = "usuario";
      $password = password_hash($_POST["passwordUsuario"], PASSWORD_ARGON2ID, [
        'memory_cost' => 1 << 12,
        'time_cost' => 2,
        'threads' => 2
      ]);
      $dataUsuario = array(
        "correoUsuario" => $_POST["usuarioCorreo"],
        "password" => $password,
        "nombreUsuario" => $_POST["nombreUsuario"],
        "apellidoUsuario" => $_POST["apellidoUsuario"],
        "dniUsuario" => $_POST["dniUsuario"],
        "idTipoUsuario" => $_POST["tipoUsuario"],
        "estadoUsuario" => "1",
        "fechaCreacion" => date("Y-m-d\TH:i:sP"),
        "fechaActualizacion" => date("Y-m-d\TH:i:sP"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );

      $response = ModelUsuarios::mdlCrearUsuario($tabla, $dataUsuario);

      if ($response == "ok") {
        if ($_POST["tipoUsuario"] != 1) {
          $tabla = "personal";
          $response = ModelPersonal::mdlCrearUsuarioPersonal($tabla, $dataUsuario);
        }

        if ($response == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Usuario creado correctamente", "usuarios");
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear un nuevo usuario", "usuarios");
          echo $mensaje;
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al crear un nuevo usuario", "usuarios");
        echo $mensaje;
      }
    }
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
