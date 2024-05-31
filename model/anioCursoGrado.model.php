<?php

class ModelAnioCursoGrado
{
  // Insertar datos en la tabla anio_postulante
  public static function mdlCrearAnioCursoGrado($table, $dataaniocursoGrado)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $table(idCursogradoPersonal, idAnioEscolar, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idCursoGradoPersonal, :idAnioEscolar, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idCursoGradoPersonal", $dataaniocursoGrado["idCursoGradoPersonal"], PDO::PARAM_INT);
    $stmt->bindParam(":idAnioEscolar", $dataaniocursoGrado["idAnioEscolar"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $dataaniocursoGrado["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $dataaniocursoGrado["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $dataaniocursoGrado["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $dataaniocursoGrado["usuarioActualizacion"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}