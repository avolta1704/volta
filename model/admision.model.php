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
    $statement->bindParam(":fechaAdmision", $dataPostulanteAdmicion["fechaAdmision"], PDO::PARAM_STR);
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

  /**
   * Obtiene el código de admisión por postulante.
   *
   * @param string $table La tabla de la base de datos.
   * @param int $idPostulante El ID del postulante.
   * @return int El código de admisión.
   */
  public static function mdlGetCodAdmisionByPostulante($table, $idPostulante)
  {
    $statement = Connection::conn()->prepare("SELECT idAdmision FROM $table WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $idPostulante, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }
  //buscar claves florareas de idAlumno para eliminar registros
  public static function mdlBuscarClavesForaneasDelAlumno($tabla, $codAlumnoEliminar)
  {
    $statement = Connection::conn()->prepare("SELECT 
     alumno.idAlumno,
     admision_alumno.idAdmisionAlumno,
     admision_alumno.idAdmision,
     alumno_grado.idAlumnoGrado,
     apoderado_alumno.idApoderadoAlumno,
     anio_admision.idAnioAdmision,
     postulante.idPostulante
     FROM alumno
     LEFT JOIN admision_alumno ON alumno.idAlumno = admision_alumno.idAlumno
     LEFT JOIN alumno_grado ON alumno.idAlumno = alumno_grado.idAlumno
     LEFT JOIN apoderado_alumno ON alumno.idAlumno = apoderado_alumno.idAlumno
     LEFT JOIN anio_admision ON admision_alumno.idAdmisionAlumno = anio_admision.idAdmisionAlumno
     LEFT JOIN admision ON admision_alumno.idAdmision = admision.idAdmision
     LEFT JOIN postulante ON admision.idPostulante = postulante.idPostulante
      WHERE
     $tabla.idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $codAlumnoEliminar, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //  Eliminar un alumno
  public static function mdlElimarDataMatriculaPostulante($dataArrayIdEliminar)
  {
    $statement = Connection::conn()->prepare("DELETE FROM anio_admision WHERE idAnioAdmision = :idAnioAdmision;
     DELETE FROM apoderado_alumno WHERE idApoderadoAlumno = :idApoderadoAlumno;
     DELETE FROM alumno_grado WHERE idAlumnoGrado = :idAlumnoGrado;
     DELETE FROM admision_alumno WHERE idAdmisionAlumno = :idAdmisionAlumno;
     DELETE FROM alumno WHERE idAlumno = :idAlumno;
     DELETE FROM admision WHERE idAdmision = :idAdmision;");

    $statement->bindParam(":idAnioAdmision", $dataArrayIdEliminar['idAnioAdmision'], PDO::PARAM_INT);
    $statement->bindParam(":idApoderadoAlumno", $dataArrayIdEliminar['idApoderadoAlumno'], PDO::PARAM_INT);
    $statement->bindParam(":idAlumnoGrado", $dataArrayIdEliminar['idAlumnoGrado'], PDO::PARAM_INT);
    $statement->bindParam(":idAdmisionAlumno", $dataArrayIdEliminar['idAdmisionAlumno'], PDO::PARAM_INT);
    $statement->bindParam(":idAlumno", $dataArrayIdEliminar['idAlumno'], PDO::PARAM_INT);
    $statement->bindParam(":idAdmision", $dataArrayIdEliminar['idAdmision'], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // actualizar estado del postulante a postulante despues de eliminar su matricula
  public static function mdlActualizarEstadoPostulante($table, $idPostulante)
  {
    $statement = Connection::conn()->prepare("UPDATE $table SET estadoPostulante = 1 WHERE idPostulante = :idPostulante");
    $statement->bindParam(":idPostulante", $idPostulante, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
