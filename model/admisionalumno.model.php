<?php
require_once "connection.php";

class ModelAdmisionAlumno
{
  //todos los registros de admision
  public static function mdlGetAdmisionAlumnos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT adal.idAdmisionAlumno, 
    al.dniAlumno,
    al.apellidosAlumno,
    al.nombresAlumno, 
    ad.tipoAdmision,
    ad.fechaAdmision,
    adal.estadoAdmisionAlumno,
    al.estadoAlumno, 
    al.estadoSiagie, 
    al.estadoMatricula, 
    al.codAlumnoCaja, 
    al.fechaIngresoVolta      
    FROM $tabla adal
    INNER JOIN admision ad ON adal.idAdmision = ad.idAdmision
    INNER JOIN alumno al ON adal.idAlumno = al.idAlumno;");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

}