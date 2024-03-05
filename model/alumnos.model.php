<?php
require_once "connection.php";

class ModelAlumnos
{
  // Obtener todos los alumnos
  public static function mdlGetAlumnos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    alumno.idAlumno, 
    alumno.nombresAlumno, 
    alumno.apellidosAlumno, 
    alumno.sexoAlumno, 
    alumno.estadoAlumno, 
    grado.descripcionGrado, 
    nivel.descripcionNivel, 
    alumno_grado.estadoGradoAlumno
  FROM
    alumno
    INNER JOIN
    alumno_grado
    ON 
      alumno.idAlumno = alumno_grado.idAlumno
    INNER JOIN
    grado
    ON 
      alumno_grado.idGrado = grado.idGrado
    INNER JOIN
    nivel
    ON 
      grado.idNivel = nivel.idNivel
    WHERE alumno_grado.estadoGradoAlumno = 1");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Crear nuevo alumno
  public static function mdlCrearAlumno($tabla, $dataAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (nombresAlumno, apellidosAlumno, sexoAlumno, estadoAlumno, dniAlumno, fechaNacimiento, direccionAlumno, distritoAlumno, IEPProcedencia, seguroSalud, fechaIngresoVolta, numeroEmergencia, enfermedades, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:nombresAlumno, :apellidosAlumno, :sexoAlumno, :estadoAlumno, :dniAlumno, :fechaNacimiento, :direccionAlumno, :distritoAlumno, :IEPProcedencia, :seguroSalud, :fechaIngresoVolta, :numeroEmergencia, :enfermedades, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":nombresAlumno", $dataAlumno["nombresAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":apellidosAlumno", $dataAlumno["apellidosAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":sexoAlumno", $dataAlumno["sexoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":estadoAlumno", $dataAlumno["estadoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":dniAlumno", $dataAlumno["dniAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $dataAlumno["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":direccionAlumno", $dataAlumno["direccionAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":distritoAlumno", $dataAlumno["distritoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":IEPProcedencia", $dataAlumno["IEPProcedencia"], PDO::PARAM_STR);
    $statement->bindParam(":seguroSalud", $dataAlumno["seguroSalud"], PDO::PARAM_STR);
    $statement->bindParam(":fechaIngresoVolta", $dataAlumno["fechaIngresoVolta"], PDO::PARAM_STR);
    $statement->bindParam(":numeroEmergencia", $dataAlumno["numeroEmergencia"], PDO::PARAM_STR);
    $statement->bindParam(":enfermedades", $dataAlumno["enfermedades"], PDO::PARAM_STR); 
    $statement->bindParam(":fechaCreacion", $dataAlumno["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataAlumno["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataAlumno["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataAlumno["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener ultimo alumno creado
  public static function mdlObtenerUltimoAlumno($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT MAX(idAlumno) AS idAlumno FROM $tabla");
    $statement->execute();
    return $statement->fetch();
  }

  //  Asignar alumno a apoderado
  public static function mdlAsignarAlumnoApoderado($tabla, $dataApoderadoAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (idAlumno, idApoderado, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:idAlumno, :idApoderado, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":idAlumno", $dataApoderadoAlumno["idAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":idApoderado", $dataApoderadoAlumno["idApoderado"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataApoderadoAlumno["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataApoderadoAlumno["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataApoderadoAlumno["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataApoderadoAlumno["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}