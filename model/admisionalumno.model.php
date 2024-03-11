<?php
require_once "connection.php";

class ModelAdmisionAlumno
{
   //  Crear postulante
   public static function mdlCrearPostulanteAddExtraordinaria($tabla, $datosPostulante)
   {
     $statement = Connection::conn()->prepare("INSERT INTO $tabla (nombrePostulante, apellidoPostulante, dniPostulante, fechaPostulacion, fechaNacimiento, gradoPostulacion, estadoPostulante, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:nombrePostulante, :apellidoPostulante, :dniPostulante, :fechaPostulacion, :fechaNacimiento, :gradoPostulacion, :estadoPostulante, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
     $statement->bindParam(":nombrePostulante", $datosPostulante["nombrePostulante"], PDO::PARAM_STR);
     $statement->bindParam(":apellidoPostulante", $datosPostulante["apellidoPostulante"], PDO::PARAM_STR);
     $statement->bindParam(":dniPostulante", $datosPostulante["dniPostulante"], PDO::PARAM_STR);
     $statement->bindParam(":fechaPostulacion", $datosPostulante["fechaPostulacion"], PDO::PARAM_STR);
     $statement->bindParam(":fechaNacimiento", $datosPostulante["fechaNacimiento"], PDO::PARAM_STR);
     $statement->bindParam(":gradoPostulacion", $datosPostulante["gradoPostulacion"], PDO::PARAM_INT);
     $statement->bindParam(":estadoPostulante", $datosPostulante["estadoPostulante"], PDO::PARAM_INT);
     $statement->bindParam(":fechaCreacion", $datosPostulante["fechaCreacion"], PDO::PARAM_STR);
     $statement->bindParam(":fechaActualizacion", $datosPostulante["fechaActualizacion"], PDO::PARAM_STR);
     $statement->bindParam(":usuarioCreacion", $datosPostulante["usuarioCreacion"], PDO::PARAM_STR);
     $statement->bindParam(":usuarioActualizacion", $datosPostulante["usuarioActualizacion"], PDO::PARAM_STR);
 
     if ($statement->execute()) {
       return "ok";
     } else {
       return "error";
     }
   }
  //todos los registros de admision
  public static function mdlGetAdmisionAlumnos($tabla)
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
}