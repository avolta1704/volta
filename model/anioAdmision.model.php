<?php

class ModelAnioAdmision
{
  public static function mdlCrearAnioAdmision($table, $dataCreate)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $table(idAdmisionAlumno, idAnioEscolar, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idAdmisionAlumno, :idAnioEscolar, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idAdmisionAlumno", $dataCreate["idAdmisionAlumno"], PDO::PARAM_INT);
    $stmt->bindParam(":idAnioEscolar", $dataCreate["idAnioEscolar"], PDO::PARAM_INT);
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