<?php
require_once "connection.php";

class ModelApoderadoAlumno
{
  //  Crear apoderado_alumno
  static public function mdlCrearApoderadoAlumno($table, $dataCreate)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $table(idApoderado, idAlumno, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idApoderado, :idAlumno, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idApoderado", $dataCreate["idApoderado"], PDO::PARAM_INT);
    $stmt->bindParam(":idAlumno", $dataCreate["idAlumno"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $dataCreate["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $dataCreate["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $dataCreate["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $dataCreate["usuarioActualizacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
