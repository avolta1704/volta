<?php
require_once "connection.php";

class ModelUnidad
{

  public static function mdlInsertarUnidad($dataUnidad)
  {
    $stmt = Connection::conn()->prepare("INSERT INTO unidad (idBimestre, descripcionUnidad, estadoUnidad, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idBimestre, :descripcionUnidad, :estadoUnidad, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");

    $stmt->bindParam(":idBimestre", $dataUnidad["idBimestre"], PDO::PARAM_INT);
    $stmt->bindParam(":descripcionUnidad", $dataUnidad["descripcionUnidad"], PDO::PARAM_STR);
    $stmt->bindParam(":estadoUnidad", $dataUnidad["estadoUnidad"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $dataUnidad["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $dataUnidad["fechaActualizacion"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $dataUnidad["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $dataUnidad["usuarioActualizacion"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Obtener todas las unidades
  public static function mdlObtenerTodasLasUnidades($tabla, $idBimestre)
  {
    $stmt = Connection::conn()->prepare("SELECT
    descripcionUnidad, 
    unidad.idUnidad,
    unidad.estadoUnidad
  FROM
    $tabla
    INNER JOIN
    bimestre
    ON 
      unidad.idBimestre = bimestre.idBimestre
  WHERE
    bimestre.idBimestre = :idBimestre;");
    $stmt->bindParam(":idBimestre", $idBimestre, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
