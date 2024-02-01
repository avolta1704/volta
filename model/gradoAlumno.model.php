<?php
require_once "connection.php";

class ModelGradoAlumno
{
  //  Asignar grado a alumno
  public static function mdlAsignarGradoAlumno($tabla, $dataAlumnoGrado)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (idAlumno, idGrado, estadoGradoAlumno, fechaCreacion, fechaActualizacion) VALUES (:idAlumno, :idGrado, :estadoGradoAlumno, :fechaCreacion, :fechaActualizacion)");
    $statement->bindParam(":idAlumno", $dataAlumnoGrado["idAlumno"], PDO::PARAM_INT);
    $statement->bindParam(":idGrado", $dataAlumnoGrado["idGrado"], PDO::PARAM_INT);
    $statement->bindParam(":estadoGradoAlumno", $dataAlumnoGrado["estadoGradoAlumno"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $dataAlumnoGrado["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataAlumnoGrado["fechaActualizacion"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}