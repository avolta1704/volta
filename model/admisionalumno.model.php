<?php
require_once "connection.php";

class ModelAdmisionAlumno
{
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