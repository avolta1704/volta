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
    $idTipoUsuario = 1;
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
    $listApoderado = ModelApoderados::mdlCrearUsuarioApoderado($table, $dataUsuarioApoderado);
    return $listApoderado;
  }

  //  Crear apoderado 
  public static function ctrCrearApoderado($dataApoderado)
  {
    $tabla = "apoderado";
    $response = ModelApoderados::mdlCrearApoderado($tabla, $dataApoderado);
    return $response;
  }

  //  Editar datos de un apoderado
  public static function ctrEditarApoderado($dataApoderado)
  {
    $tabla = "apoderado";
    $response = ModelApoderados::mdlEditarApoderado($tabla, $dataApoderado);
    return $response;
  }

  //  Obtener ultimo apoderado creado
  public static function ctrObtenerUltimoApoderado()
  {
    $tabla = "apoderado";
    $response = ModelApoderados::mdlObtenerUltimoApoderado($tabla);
    return $response;
  }
  //  Obtener datos del Apoderado para editar
  public static function ctrGetIdEditApoderado($codApoderado)
  {
    $tabla = "apoderado";
    $dataPostulante = ModelApoderados::mdlGetIdEditApoderado($tabla, $codApoderado);
    return $dataPostulante;
  }
  //  editar Apoderado
  public static function ctrIdEditarApoderado()
  {
    if (isset($_POST["codApoderado"]) && isset($_POST["editarTipoApo"])) {
      $tabla = "apoderado";
      $dataEditApoderado = array(
        "idApoderado" => $_POST["codApoderado"],
        "nombreApoderado" => $_POST["editarNombreAp"],
        "apellidoApoderado" => $_POST["editarApellidoAp"],
        "numeroApoderado" => $_POST["editarNumAp"],
        "listaAlumnos" => $_POST["editarHijosAp"],
        "convivenciaAlumno" => $_POST["editarComvivAp"],
        "tipoApoderado" => $_POST["editarTipoApo"],
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelApoderados::mdlIdEditarApoderado($tabla, $dataEditApoderado);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Apoderado editado correctamente", "apoderado");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al editar el Apoderado", "apoderado");
        echo $mensaje;
      }
    }
  }

  //  Obtener los datos del apoderado por el identificador
  public static function ctrGetApoderadoById($codApoderado)
  {
    $tabla = "apoderado";
    $dataApoderado = ModelApoderados::mdlGetApoderadoById($tabla, $codApoderado);
    return $dataApoderado;
  }
}
