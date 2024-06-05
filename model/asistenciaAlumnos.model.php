<?php

require_once "connection.php";
class ModelAsistenciaAlumnos
{
  /**
   * Mostrar la asistencia de los alumnos del dia actual
   *
   * @param int $idCurso identificador del curso
   * @param int $idGrado identificador del grado
   * @param int $idPersonal identificador del personal
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos
   */
  static public function mdlMostrarAsistenciaAlumnos($tabla, $idCurso, $idGrado, $idPersonal)
  {
    $tablaAlumno = "alumno";
    $tablaAlumnoAnioEscolar = "alumno_anio_escolar";
    $tablaNivel = "nivel";
    $tablaGrado = "grado";
    $tablaAnioEscolar = "anio_escolar";
    $tablaCursoGrado = "curso_grado";
    $tablaCurso = "curso";
    $tablaCursoGradoPersonal = "cursogrado_personal";
    $tablaAdmisionAlumno = "admision_alumno";
    $diaActual = date("Y-m-d");

    $statement = Connection::conn()->prepare("SELECT
    a.idAlumno,
    a.nombresAlumno,
    a.apellidosAlumno,
    asis.estadoAsistencia
  FROM
    $tablaAlumno as a    
    INNER JOIN
    $tablaAlumnoAnioEscolar as a_ae
    ON 
      a.idAlumno = a_ae.idAlumno
    INNER JOIN 
    $tablaAdmisionAlumno as admision
    ON 
      a.idAlumno = admision.idAlumno
    INNER JOIN
    $tablaGrado as g
    ON 
      a_ae.idGrado = g.idGrado
    INNER JOIN
    $tablaNivel as n
    ON 
      g.idNivel = n.idNivel
    INNER JOIN
    $tablaCursoGrado as c_g
    ON 
      g.idGrado = c_g.idGrado
    INNER JOIN 
    $tablaCurso as c
    ON 
      c_g.idCurso = c.idCurso
    INNER JOIN
    $tablaCursoGradoPersonal as cg_personal
    ON 
      c_g.idCursoGrado = cg_personal.idCursoGrado
    INNER JOIN
    $tablaAnioEscolar as ae
    ON 
      a_ae.idAnioEscolar = ae.idAnioEscolar
    LEFT JOIN
    $tabla as asis
    ON 
      a_ae.idAlumnoAnioEscolar = asis.idAlumnoAnioEscolar    
  WHERE
    g.idGrado = :idGrado
    AND
    c.idCurso = :idCurso
    AND
    cg_personal.idPersonal = :idPersonal    
    AND
    admision.estadoAdmisionAlumno = 2 -- 2 es el estado de alumno matriculado y activo
    AND
    ae.estadoAnio = 1
    AND
    asis.fechaAsistencia = :diaActual 
    ORDER BY a.nombresAlumno ASC");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $statement->bindParam(":idPersonal", $idPersonal, PDO::PARAM_INT);
    $statement->bindParam(":diaActual", $diaActual, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll();
  }
}
