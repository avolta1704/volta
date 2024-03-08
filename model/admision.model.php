<?php
require_once "connection.php";

class ModelAdmision
{
  //  registrar  a postulante en admision 
  public static function mdlCrearAdmisionPostulate($table, $dataPostulanteAdmicion)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idAnioEscolar, idPostulante, fechaAdmision, tipoAdmision, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idAnioEscolar, :idPostulante, :fechaAdmision, :tipoAdmision, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":idAnioEscolar", $dataPostulanteAdmicion["idAnioEscolar"], PDO::PARAM_INT);
    $statement->bindParam(":idPostulante", $dataPostulanteAdmicion["idPostulante"], PDO::PARAM_INT);
    $statement->bindParam(":fechaAdmision", $dataPostulanteAdmicion["fechaAdmision"], PDO::PARAM_INT);
    $statement->bindParam(":tipoAdmision", $dataPostulanteAdmicion["tipoAdmision"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $dataPostulanteAdmicion["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataPostulanteAdmicion["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataPostulanteAdmicion["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataPostulanteAdmicion["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener el ultimo registro de admision creado tabla "admision"
  public static function mdlUltimoRegistroAdmisionCreado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT idAdmision FROM $tabla ORDER BY idAdmision DESC LIMIT 1");
    $statement->execute();
    return $statement->fetchColumn();
  }
  //  registrar al alumno en alumno_admision aprobado
  public static function mdlCrearAlumnoAdmision($table, $dataPostulanteAdmicion)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idAdmision, idAlumno, estadoAdmisionAlumno, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idAdmision, :idAlumno, :estadoAdmisionAlumno, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":idAdmision", $dataPostulanteAdmicion["idAdmision"], PDO::PARAM_INT);
    $statement->bindParam(":idAlumno", $dataPostulanteAdmicion["idAlumno"], PDO::PARAM_INT);
    $statement->bindParam(":estadoAdmisionAlumno", $dataPostulanteAdmicion["estadoAdmisionAlumno"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $dataPostulanteAdmicion["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataPostulanteAdmicion["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataPostulanteAdmicion["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataPostulanteAdmicion["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}