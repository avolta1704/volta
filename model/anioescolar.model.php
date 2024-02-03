<?php
require_once "connection.php";

class ModelAnioEscolar
{
  //  Crear nuevo Año Escolar
  public static function mdlCrearAnioEscolar($tabla, $datosAnioEscolar)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (descripcionAnio, estadoAnio, costoMatricula, costoPension, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:descripcionAnio, :estadoAnio, :costoMatricula, :costoPension, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":descripcionAnio", $datosAnioEscolar["descripcionAnio"], PDO::PARAM_STR);
    $statement->bindParam(":estadoAnio", $datosAnioEscolar["estadoAnio"], PDO::PARAM_STR);
    $statement->bindParam(":costoMatricula", $datosAnioEscolar["costoMatricula"], PDO::PARAM_STR);
    $statement->bindParam(":costoPension", $datosAnioEscolar["costoPension"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $datosAnioEscolar["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosAnioEscolar["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $datosAnioEscolar["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $datosAnioEscolar["usuarioActualizacion"], PDO::PARAM_STR);
    
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}