<?php

class ModelAnioPostulante
{
  // Insertar datos en la tabla anio_postulante
  public static function mdlCrearAnioPostulante($table, $dataCreate)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO $table(idPostulante, idAnioEscolar, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idPostulante, :idAnioEscolar, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $stmt->bindParam(":idPostulante", $dataCreate["idPostulante"], PDO::PARAM_INT);
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

  /**
   * Editar año de postulación
   * 
   * @param string $tabla
   * @param array $dataUpdate
   * @return string
   */
  public static function mdlEditarAnioPostulante($tabla, $dataUpdate) {
    $stmt = Connection::conn()->prepare("UPDATE $tabla SET idAnioEscolar = :idAnioEscolar, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idAnioPostulante = :idAnioPostulante");
    $stmt->bindParam(":idAnioEscolar", $dataUpdate["idAnioEscolar"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $dataUpdate["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioActualizacion", $dataUpdate["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":idAnioPostulante", $dataUpdate["idAnioPostulante"], PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}