<?php
require_once "connection.php";
class ModelUsuarios
{
  //  Obtener datos de inicio de sesión
  public static function mdlObtenerDatosSesion($tabla, $email)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idUsuario, usuario.correoUsuario, usuario.nombreUsuario, usuario.apellidoUsuario, usuario.idTipoUsuario FROM $tabla WHERE correoUsuario=:correoUsuario");
    $statement->bindParam(":correoUsuario", $email, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Hacer update del last login
  public static function mdlActualizarSesion($tabla, $ultimaConexion, $idUsuario)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET ultimaConexion=:ultimaConexion WHERE usuario.idUsuario = $idUsuario");
    $statement->bindParam(":ultimaConexion", $ultimaConexion, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  // Obtener datos usuarios verificar
  public static function mdlObtenerDataUsuario($tabla, $email)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.password FROM $tabla WHERE correoUsuario=:correoUsuario");
    $statement->bindParam(":correoUsuario", $email, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Obtener todos los usuarios
  public static function mdlGetAllUsuarios($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idUsuario, usuario.correoUsuario, usuario.nombreUsuario, usuario.apellidoUsuario, usuario.estadoUsuario, usuario.ultimaConexion, tipo_usuario.descripcionTipoUsuario FROM $tabla INNER JOIN tipo_usuario ON usuario.idTipoUsuario = tipo_usuario.idTipoUsuario ORDER BY usuario.idUsuario DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener tipo de usuarios
  public static function mdlGetTipoUsuarios($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT tipo_usuario.idTipoUsuario, tipo_usuario.descripcionTipoUsuario FROM $tabla");
    $statement->execute();
    return $statement->fetchAll();
  }

  //  Obtener dato de un usuario
  public static function mdlGetUsuarioEditar($tabla, $codUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT usuario.idTipoUsuario, usuario.correoUsuario, usuario.nombreUsuario, usuario.apellidoUsuario, usuario.dniUsuario, usuario.estadoUsuario, tipo_usuario.descripcionTipoUsuario FROM $tabla INNER JOIN tipo_usuario ON usuario.idTipoUsuario = tipo_usuario.idTipoUsuario WHERE usuario.idUsuario=$codUsuario");
    $statement->execute();
    return $statement->fetch();
  }

  //  Crear un nuevo usuario
  public static function mdlCrearUsuario($tabla, $dataUsuario)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (correoUsuario, password, nombreUsuario, apellidoUsuario, dniUsuario, idTipoUsuario, estadoUsuario, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:correoUsuario, :password, :nombreUsuario, :apellidoUsuario, :dniUsuario, :idTipoUsuario, :estadoUsuario, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":correoUsuario", $dataUsuario["correoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":password", $dataUsuario["password"], PDO::PARAM_STR);
    $statement->bindParam(":nombreUsuario", $dataUsuario["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuario["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":dniUsuario", $dataUsuario["dniUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":idTipoUsuario", $dataUsuario["idTipoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":estadoUsuario", $dataUsuario["estadoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataUsuario["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuario["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataUsuario["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataUsuario["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Editar data usuario personal
  public static function mdlEditarUsuarioPersonal($tabla, $dataUsuario)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET correoUsuario=:correoUsuario, nombreUsuario=:nombreUsuario, apellidoUsuario=:apellidoUsuario, dniUsuario=:dniUsuario, idTipoUsuario=:idTipoUsuario, fechaActualizacion=:fechaActualizacion, usuarioActualizacion=:usuarioActualizacion WHERE idUsuario=:idUsuario");
    $statement->bindParam(":correoUsuario", $dataUsuario["correoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":nombreUsuario", $dataUsuario["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuario["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":dniUsuario", $dataUsuario["dniUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":idTipoUsuario", $dataUsuario["idTipoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuario["LastConnection"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataUsuario["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idUsuario", $dataUsuario["idUsuario"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener estado del usuario
  public static function mdlObtenerEstadoUsuario($tabla, $codUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT estadoUsuario FROM $tabla WHERE idUsuario = $codUsuario");
    $statement->execute();
    return $statement->fetch();
  }

  //  Obtener estado del usuario por correo para el login
  public static function mdlObtenerEstadoUsuarioCorreo($tabla, $email)
  {
    $statement = Connection::conn()->prepare("SELECT estadoUsuario FROM $tabla WHERE correoUsuario = :email");
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }

  //  Actualizar estado del usuario
  public static function mdlActualizarEstado($tabla, $codUsuario, $estado)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoUsuario=:estadoUsuario WHERE idUsuario=:idUsuario");
    $statement->bindParam(":idUsuario", $codUsuario, PDO::PARAM_STR);
    $statement->bindParam(":estadoUsuario", $estado, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //  Actualizar datos del usuario por el personal
  public static function mdlActualizarDatosPersonal($tabla, $dataUsuario)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombreUsuario = :nombreUsuario, apellidoUsuario = :apellidoUsuario,  fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idUsuario = :idUsuario");
    $statement->bindParam(":nombreUsuario", $dataUsuario["nombreUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoUsuario", $dataUsuario["apellidoUsuario"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataUsuario["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataUsuario["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idUsuario", $dataUsuario["idUsuario"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Verificar si el correo ya existe
  public static function mdlValidarCorreo($tabla, $validarCorreo)
  {
    $statement = Connection::conn()->prepare("SELECT COUNT(correoUsuario) AS validacion FROM $tabla WHERE correoUsuario=:correoUsuario");
    $statement->bindParam(":correoUsuario", $validarCorreo, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Eliminar usuario 
  public static function mdlEliminarUsuario($table, $codUsuario)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $table WHERE idUsuario = :idUsuario");
    $statement->bindParam(":idUsuario", $codUsuario, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Verificar usabilidad de un usuario en toda la base de datos
  public static function mdlVerificarUsuario($codUsuario)
  {
    $statement = Connection::conn()->prepare("SELECT CASE 
    WHEN EXISTS (
        SELECT 1 FROM alumno WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM anio_admision WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM anio_escolar WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM curso WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM curso_grado WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM cursogrado_personal WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM comunicacion_pago WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM cronograma_pago WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM personal WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM pago WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM postulante WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
        UNION ALL
        SELECT 1 FROM record_nota WHERE usuarioCreacion = :idUsuario OR usuarioActualizacion = :idUsuario
    ) THEN TRUE
    ELSE FALSE
END AS existencia
    ");
    $statement->bindParam(":idUsuario", $codUsuario, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
