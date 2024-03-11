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
      $idTipoPersonal = 4;
    } else if ($dataUsuarioPersonal["idTipoUsuario"] == 3) {
      $idTipoPersonal = 6;
    } else {
      $idTipoPersonal = "";
    }
    $dataUsuarioPersonal = array(
      "idUsuario" => $dataUsuarioPersonal["idUsuario"],
      "idTipoPersonal" => $idTipoPersonal,
      "correoPersonal" => $dataUsuarioPersonal["correoUsuario"],
      "nombrePersonal" => $dataUsuarioPersonal["nombreUsuario"],
      "apellidoPersonal" => $dataUsuarioPersonal["apellidoUsuario"],
      "fechaCreacion" => $dataUsuarioPersonal["fechaCreacion"],
      "fechaActualizacion" => $dataUsuarioPersonal["fechaActualizacion"],
      "usuarioCreacion" => $dataUsuarioPersonal["usuarioCreacion"],
      "usuarioActualizacion" => $dataUsuarioPersonal["usuarioActualizacion"]
    );
    $listPersonal = ModelPersonal::mdlCrearUsuarioPersonal($table, $dataUsuarioPersonal);
    return $listPersonal;
  }
  //  Obtener datos del Personal para editar
  public static function ctrGetIdEditPersonal($codPersonal)
  {
    $tabla = "personal";
    $dataPersonal = ModelPersonal::mdlGetIdEditPersonal($tabla, $codPersonal);
    return $dataPersonal;
  }
  //  editar Personal
  public static function ctrIdEditarPersonal()
  {
    if (isset($_POST["codPersonal"]) && isset($_POST["editarTipoPersonal"])) {
      $tabla = "personal";
      $dataEditPersonal = array(
        "idPersonal" => $_POST["codPersonal"],
        "nombrePersonal" => $_POST["editarNombrePersonal"],
        "apellidoPersonal" => $_POST["editarApellidoPersonal"],
        "celularPersonal" => $_POST["editarNumPersonal"],
        "fechaContratacion" => $_POST["editarFechContrPersonal"],
        "idTipoPersonal" => $_POST["editarTipoPersonal"],
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPersonal::mdlIdEditarPersonal($tabla, $dataEditPersonal);
      if ($response == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Personal editado correctamente", "personal");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al editar el Personal", "personal");
        echo $mensaje;
      }
    }
  }

  //  Obtener tipo de docente para el inicio de sesion
  public static function ctrGetTipoDocente($codUsuario)
  {
    $table = "personal";
    $dataTipoDocente = ModelPersonal::mdlGetTipoDocente($table, $codUsuario);
    return $dataTipoDocente;
  }

}
