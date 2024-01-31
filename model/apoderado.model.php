<?php
require_once "connection.php";

class ModelApoderados
{
  // Obtener todos los alumnos
  public static function mdlCrearApoderadoAlumno($tabla, $dataApoderado)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (numeroApoderado, tipoApoderado, correoApoderado, nombreApoderado, apellidoApoderado, fechaCreacion, fechaActualizacion) VALUES(:numeroApoderado, :tipoApoderado, :correoApoderado, :nombreApoderado, :apellidoApoderado, :fechaCreacion, :fechaActualizacion)");
    $statement->bindParam(":numeroApoderado", $dataApoderado["numeroApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":tipoApoderado", $dataApoderado["tipoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":correoApoderado", $dataApoderado["correoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":nombreApoderado", $dataApoderado["nombreApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":apellidoApoderado", $dataApoderado["apellidoApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataApoderado["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataApoderado["fechaActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Ultimo apoderado creado
  public static function mdlObtenerUltimoApoderado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT MAX(idApoderado) AS idApoderado FROM $tabla");
    $statement->execute();
    return $statement->fetch();
  }
}
