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
    g.idGrado,
    c.idCurso,
    cg_personal.idPersonal,
    asis.estadoAsistencia,
    a_ae.idAlumnoAnioEscolar
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
      AND
      asis.fechaAsistencia = :diaActual 
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
    ORDER BY a.nombresAlumno ASC");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $statement->bindParam(":idPersonal", $idPersonal, PDO::PARAM_INT);
    $statement->bindParam(":diaActual", $diaActual, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll();
  }

  /**
   * Mostrar la asistencia de los alumnos registrados en el sistema
   * 
   * @param int $idCurso identificador del curso
   * @param int $idGrado identificador del grado
   * @param int $idPersonal identificador del personal
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos
   */
  static public function mdlMostrarAsistenciaAlumnosRegistradosMes($tabla, $idCurso, $idGrado, $idPersonal, $mesActual)
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
    $statement = Connection::conn()->prepare("SELECT
    a.idAlumno,
    a.nombresAlumno,
    a.apellidosAlumno,
    g.idGrado,
    c.idCurso,
    cg_personal.idPersonal,
    asis.estadoAsistencia,
    asis.fechaAsistencia,
    a_ae.idAlumnoAnioEscolar
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
      AND
      asis.fechaAsistencia LIKE :mesActual
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
    ORDER BY a.nombresAlumno ASC");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $statement->bindParam(":idPersonal", $idPersonal, PDO::PARAM_INT);
    $statement->bindValue(":mesActual", $mesActual . "%", PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll();
  }

  /**
   * Crear la asistencia del alumno para el dia actual
   * 
   * @param array $data array con la informacion de la asistencia del alumno
   * @return string $respuesta  respuesta de la creacion de la asistencia del alumno o error en caso de que no se haya podido realizar la operacion
   */
  public static function mdlCrearAsistenciaAlumno($data)
  {
    $tabla = "asistencia";
    $statement = Connection::conn()->prepare("INSERT INTO $tabla 
    (idAlumnoAnioEscolar, fechaAsistencia, estadoAsistencia, usuarioCreacion, fechaCreacion, usuarioActualizacion, fechaActualizacion) 
    VALUES (:idAlumnoAnioEscolar, :fechaAsistencia, :estadoAsistencia, :usuarioCreacion, :fechaCreacion, :usuarioActualizacion, :fechaActualizacion)");

    $statement->bindParam(":idAlumnoAnioEscolar", $data["idAlumnoAnioEscolar"], PDO::PARAM_INT);
    $statement->bindParam(":fechaAsistencia", $data["fechaAsistencia"], PDO::PARAM_STR);
    $statement->bindParam(":estadoAsistencia", $data["estadoAsistencia"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $data["usuarioCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":fechaCreacion", $data["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Actualizar la asistencia del alumno para el dia actual
   * 
   * @param array $data array con la informacion de la asistencia del alumno
   * @return string $respuesta  respuesta de la actualizacion de la asistencia del alumno o error en caso de que no se haya podido realizar la operacion
   */
  static public function mdlActualizarAsistenciaAlumno($data)
  {
    $tabla = "asistencia";
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoAsistencia = :estadoAsistencia, usuarioActualizacion = :usuarioActualizacion, fechaActualizacion = :fechaActualizacion WHERE idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND fechaAsistencia = :fechaAsistencia");
    $statement->bindParam(":estadoAsistencia", $data["estadoAsistencia"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idAlumnoAnioEscolar", $data["idAlumnoAnioEscolar"], PDO::PARAM_INT);
    $statement->bindParam(":fechaAsistencia", $data["fechaAsistencia"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtener todos las asistencias de una fecha especifica
   * 
   * @param string $fechaAsistencia fecha de la asistencia
   * @return array $respuesta  array con la informacion de la asistencia de los alumnos
   */
  static public function mdlMostrarAsistenciaAlumnosPorFecha($tabla, $idCurso, $idGrado, $idPersonal, $fechaAsistencia)
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

    $statement = Connection::conn()->prepare("SELECT
    a.idAlumno,
    a.nombresAlumno,
    a.apellidosAlumno,
    g.idGrado,
    c.idCurso,
    cg_personal.idPersonal,
    asis.estadoAsistencia,
    a_ae.idAlumnoAnioEscolar
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
    INNER JOIN
    $tabla as asis
    ON 
      a_ae.idAlumnoAnioEscolar = asis.idAlumnoAnioEscolar    
      AND
      asis.fechaAsistencia = :fechaAsistencia 
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
    ORDER BY a.nombresAlumno ASC");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $statement->bindParam(":idPersonal", $idPersonal, PDO::PARAM_INT);
    $statement->bindParam(":fechaAsistencia", $fechaAsistencia, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetchAll();
  }

  /**
   * Eliminar la asistencia del alumno 
   * 
   * @param string $tabla nombre de la tabla
   * @param int $idAlumnoAnioEscolar identificador del alumno anio escolar
   * @param string $fechaAsistencia fecha de la asistencia
   * @return string $respuesta  respuesta de la eliminacion de la asistencia del alumno o error en caso de que no se haya podido realizar la operacion
   */
  static public function mdlEliminarAsistenciaAlumno($tabla, $idAlumnoAnioEscolar, $fechaAsistencia)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $tabla WHERE idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND fechaAsistencia = :fechaAsistencia");
    $statement->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $statement->bindParam(":fechaAsistencia", $fechaAsistencia, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}