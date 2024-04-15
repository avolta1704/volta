<?php
require_once "connection.php";

class ModelBuscarAlumno
{
  // Obtener todos los alumnos
  public static function mdlGetAllBusquedaAlumno($tabla)
  {
    $statement = Connection::conn()->prepare("
      SELECT
        alumno.idAlumno, 
        alumno.nombresAlumno, 
        alumno.apellidosAlumno, 
        alumno.sexoAlumno, 
        alumno.estadoAlumno, 
        alumno.codAlumnoCaja, 
        alumno.dniAlumno, 
        alumno.estadoSiagie, 
        alumno.estadoMatricula, 
        alumno.fechaNacimiento, 
        alumno.direccionAlumno, 
        alumno.distritoAlumno, 
        alumno.IEPProcedencia, 
        alumno.seguroSalud, 
        alumno.fechaIngresoVolta, 
        alumno.numeroEmergencia, 
        alumno.enfermedades,
        grado.descripcionGrado, 
        nivel.descripcionNivel, 
        alumno_grado.estadoGradoAlumno,
        apoderado1.nombreApoderado as nombreApoderado1,
        apoderado1.apellidoApoderado as apellidoApoderado1,
        apoderado1.celularApoderado as celularApoderado1,
        apoderado2.nombreApoderado as nombreApoderado2,
        apoderado2.apellidoApoderado as apellidoApoderado2,
        apoderado2.celularApoderado as celularApoderado2
      FROM
        $tabla
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
      LEFT JOIN
        (SELECT * FROM apoderado_alumno LIMIT 2) as apoderado_alumno
      ON 
        alumno.idAlumno = apoderado_alumno.idAlumno
      LEFT JOIN
        apoderado as apoderado1
      ON 
        apoderado_alumno.idApoderado = apoderado1.idApoderado
      LEFT JOIN
        apoderado as apoderado2
      ON 
        apoderado_alumno.idApoderado = apoderado2.idApoderado
      WHERE alumno_grado.estadoGradoAlumno = 1
      ORDER BY alumno.idAlumno DESC
    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}

