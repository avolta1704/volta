<?php
require_once "connection.php";

class ModelAlumnos
{
  // Obtener todos los alumnos
  public static function mdlGetAlumnos($tabla)
  {
    $tablaAdmisionAlumno = "admision_alumno";
    $statement = Connection::conn()->prepare("SELECT
    alumno.idAlumno, 
    alumno.nombresAlumno, 
    alumno.apellidosAlumno, 
    alumno.sexoAlumno, 
    alumno.codAlumnoCaja, 
    alumno.dniAlumno, 
    grado.descripcionGrado, 
    nivel.descripcionNivel,
    aa.estadoAdmisionAlumno
    FROM
    $tabla
    INNER JOIN
    alumno_anio_escolar
    ON 
    alumno.idAlumno = alumno_anio_escolar.idAlumno
    INNER JOIN
    grado
    ON 
    alumno_anio_escolar.idGrado = grado.idGrado
    INNER JOIN
    nivel
    ON 
    grado.idNivel = nivel.idNivel
    INNER JOIN
    $tablaAdmisionAlumno as aa
    ON
    alumno.idAlumno =aa.idAlumno
    ORDER BY alumno.idAlumno DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //  Crear nuevo alumno
  public static function mdlCrearAlumno($tabla, $dataAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (nombresAlumno, apellidosAlumno, sexoAlumno, estadoSiagie, dniAlumno, fechaNacimiento, direccionAlumno, distritoAlumno, IEPProcedencia, seguroSalud, fechaIngresoVolta, numeroEmergencia, enfermedades, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:nombresAlumno, :apellidosAlumno, :sexoAlumno,:estadoSiagie, :dniAlumno, :fechaNacimiento, :direccionAlumno, :distritoAlumno, :IEPProcedencia, :seguroSalud, :fechaIngresoVolta, :numeroEmergencia, :enfermedades, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":nombresAlumno", $dataAlumno["nombresAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":apellidosAlumno", $dataAlumno["apellidosAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":sexoAlumno", $dataAlumno["sexoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":estadoSiagie", $dataAlumno["estadoSiagie"], PDO::PARAM_STR);
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

  //  crear postulante alumno admitido
  public static function mdlCreatePostulateAlumno($tabla, $dataArrayAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (estadoSiagie, nombresAlumno, apellidosAlumno, dniAlumno, fechaNacimiento, direccionAlumno, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:estadoSiagie,:nombresAlumno, :apellidosAlumno, :dniAlumno, :fechaNacimiento, :direccionAlumno, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":estadoSiagie", $dataArrayAlumno["estadoSiagie"], PDO::PARAM_STR);
    $statement->bindParam(":nombresAlumno", $dataArrayAlumno["nombresAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":apellidosAlumno", $dataArrayAlumno["apellidosAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":dniAlumno", $dataArrayAlumno["dniAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $dataArrayAlumno["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":direccionAlumno", $dataArrayAlumno["direccionAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataArrayAlumno["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataArrayAlumno["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataArrayAlumno["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataArrayAlumno["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //  Obtener el ultimo registro de alumno creado
  public static function mdlObtenerUltimoAlumnoCreado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT MAX(idAlumno) FROM $tabla");
    $statement->execute();
    return $statement->fetchColumn();
  }

  //  Obtener los datos del alumno para editar
  public static function mdlGetDatosAlumnoEditar($tabla, $codAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT
    alumno.estadoSiagie, 
    alumno.codAlumnoCaja, 
    alumno.nombresAlumno, 
    alumno.apellidosAlumno, 
    alumno.sexoAlumno, 
    alumno.dniAlumno, 
    alumno.fechaNacimiento, 
    alumno.direccionAlumno, 
    alumno.distritoAlumno, 
    alumno.IEPProcedencia, 
    alumno.seguroSalud, 
    alumno.fechaIngresoVolta, 
    alumno.numeroEmergencia, 
    alumno.enfermedades
    FROM $tabla WHERE idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $codAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Editar datos de un alumno
  public static function mdlEditarAlumno($tabla, $dataAlumno)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET nombresAlumno=:nombresAlumno, apellidosAlumno=:apellidosAlumno, codAlumnoCaja=:codAlumnoCaja, dniAlumno=:dniAlumno, fechaNacimiento=:fechaNacimiento, sexoAlumno=:sexoAlumno, direccionAlumno=:direccionAlumno, distritoAlumno=:distritoAlumno, IEPProcedencia=:IEPProcedencia, seguroSalud=:seguroSalud, fechaIngresoVolta=:fechaIngresoVolta, numeroEmergencia=:numeroEmergencia, enfermedades=:enfermedades, fechaActualizacion=:fechaActualizacion, usuarioActualizacion=:usuarioActualizacion WHERE idAlumno=:idAlumno");
    $statement->bindParam(":nombresAlumno", $dataAlumno["nombresAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":apellidosAlumno", $dataAlumno["apellidosAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":codAlumnoCaja", $dataAlumno["codAlumnoCaja"], PDO::PARAM_STR);
    $statement->bindParam(":dniAlumno", $dataAlumno["dniAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $dataAlumno["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":sexoAlumno", $dataAlumno["sexoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":direccionAlumno", $dataAlumno["direccionAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":distritoAlumno", $dataAlumno["distritoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":IEPProcedencia", $dataAlumno["IEPProcedencia"], PDO::PARAM_STR);
    $statement->bindParam(":seguroSalud", $dataAlumno["seguroSalud"], PDO::PARAM_STR);
    $statement->bindParam(":fechaIngresoVolta", $dataAlumno["fechaIngresoVolta"], PDO::PARAM_STR);
    $statement->bindParam(":numeroEmergencia", $dataAlumno["numeroEmergencia"], PDO::PARAM_STR);
    $statement->bindParam(":enfermedades", $dataAlumno["enfermedades"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataAlumno["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataAlumno["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idAlumno", $dataAlumno["idAlumno"], PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Obtener el ultimo alumno creado
  public static function mdlGetUltimoAlumnoCreado($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT MAX(idAlumno) AS idAlumno FROM $tabla");
    $statement->execute();
    return $statement->fetchColumn();
  }

  //  Obtener los alumnos para el pago
  public static function mdlGetAlumnosPago($table)
  {
    $statement = Connection::conn()->prepare("SELECT
    $table.idAlumno, 
    $table.nombresAlumno, 
    $table.apellidosAlumno
  FROM
    $table
    INNER JOIN
    admision_alumno
    ON 
    $table.idAlumno = admision_alumno.idAlumno
  WHERE
    admision_alumno.estadoAdmisionAlumno = 2");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener la data de un alumno para crear un pago
  public static function mdlGetDataAlumnoPago($table, $codAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT
    alumno.idAlumno, 
    alumno.dniAlumno, 
    grado.descripcionGrado, 
    nivel.descripcionNivel, 
    anio_escolar.descripcionAnio, 
    admision_alumno.idAdmisionAlumno
  FROM
    $table
    INNER JOIN
    admision_alumno
    ON 
      alumno.idAlumno = admision_alumno.idAlumno
    INNER JOIN
    alumno_anio_escolar
    ON 
      alumno.idAlumno = alumno_anio_escolar.idAlumno
    INNER JOIN
    grado
    ON 
    alumno_anio_escolar.idGrado = grado.idGrado
    INNER JOIN
    nivel
    ON 
      grado.idNivel = nivel.idNivel
    INNER JOIN
    anio_admision
    ON 
      admision_alumno.idAdmisionAlumno = anio_admision.idAdmisionAlumno
    INNER JOIN
    anio_escolar
    ON 
      anio_admision.idAnioEscolar = anio_escolar.idAnioEscolar
  WHERE
    alumno.idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $codAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  // TODO Ya no va el cambiar el estado del alumno
  //  Cambiar estado del alumno
  public static function mdlCambiarEstadoAlumno($tabla, $codAlumno, $cambiarEstadoAlumno)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoAlumno=:estadoAlumno WHERE idAlumno=:idAlumno");
    $statement->bindParam(":idAlumno", $codAlumno, PDO::PARAM_STR);
    $statement->bindParam(":estadoAlumno", $cambiarEstadoAlumno, PDO::PARAM_STR);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  /**
   * Modelo para obtener los alumnos de un curso.
   *
   * @param string $tabla Nombre de la tabla de la base de datos.
   * @return array $response Array con los alumnos de un curso.
   */
  public static function mdlGetAlumnosCurso($tabla, $idCurso, $idGrado, $idPersonal)
  {
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
    a.dniAlumno,
    g.descripcionGrado,
    n.descripcionNivel,
    admision.estadoAdmisionAlumno
  FROM
    $tabla as a    
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
  WHERE
    g.idGrado = :idGrado
    AND
    c.idCurso = :idCurso
    AND
    cg_personal.idPersonal = :idPersonal    
    AND
    admision.estadoAdmisionalumno = 1
    AND
    ae.estadoAnio = 1
    ORDER BY a.nombresAlumno ASC");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $statement->bindParam(":idPersonal", $idPersonal, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
  }

  public static function mdlGetAlumnosCursoNotas($tabla, $idCurso, $idGrado, $idPersonal, $idBimestre, $idUnidad)
  {
    $tablaAlumnoAnioEscolar = "alumno_anio_escolar";
    $tablaNivel = "nivel";
    $tablaGrado = "grado";
    $tablaAnioEscolar = "anio_escolar";
    $tablaCursoGrado = "curso_grado";
    $tablaCurso = "curso";
    $tablaCursoGradoPersonal = "cursogrado_personal";

    $statement = Connection::conn()->prepare("SELECT
    a.idAlumno,
    a.nombresAlumno,
    a.apellidosAlumno,
    a.dniAlumno,
    g.descripcionGrado,
    n.descripcionNivel,
    bimestre.descripcionBimestre, 
    unidad.descripcionUnidad  
  FROM
    $tabla as a    
    INNER JOIN
    $tablaAlumnoAnioEscolar as a_ae
    ON 
      a.idAlumno = a_ae.idAlumno
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
    bimestre
    ON 
    c_g.idCursoGrado = bimestre.idCursoGrado
    INNER JOIN
    unidad
    ON 
		bimestre.idBimestre = unidad.idBimestre
  WHERE
    g.idGrado = :idGrado
    AND
    c.idCurso = :idCurso
    AND
    cg_personal.idPersonal = :idPersonal    
    AND
    a.estadoAlumno = 1
    AND
    ae.estadoAnio = 1
    AND
    bimestre.idBimestre = :idBimestre
    AND
    unidad.idUnidad = :idUnidad
    ORDER BY a.nombresAlumno ASC");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idCurso", $idCurso, PDO::PARAM_INT);
    $statement->bindParam(":idPersonal", $idPersonal, PDO::PARAM_INT);
    $statement->bindParam(":idBimestre", $idBimestre, PDO::PARAM_INT);
    $statement->bindParam(":idUnidad", $idUnidad, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
  }

  /**
   * Modelo para obtener los datos de un alumno por su ID.
   * 
   * @param string $tabla Nombre de la tabla de la base de datos.
   * @param int $idAlumno ID del alumno.
   * @return array $response Array con los datos del alumno.
   */

  public static function mdlGetAlumnoById($tabla, $idAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT a.nombresAlumno, a.apellidosAlumno, a.dniAlumno, a.fechaNacimiento, a.sexoAlumno, a.numeroEmergencia FROM $tabla as a WHERE a.idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  /**
   * funcion de modelo para mostrar los datos de alumno.
   * @param int $idAlumno ID del alumno.
   * @param string $tabla alumno de la tabla de la base de datos.
   * @return array $response Array de datos con los datos de alumno.
   * 
   */
  public static function mdlMostrarDatosAlumno($tabla, $codALumnoVisualizar)
  {
    $statement = Connection::conn()->prepare("SELECT
    alumno.fechaIngresoVolta, 
    alumno.estadoMatricula, 
    alumno.estadoSiagie, 
    alumno.IEPProcedencia, 
    alumno.numeroEmergencia, 
    alumno.direccionAlumno, 
    alumno.distritoAlumno, 
    alumno.seguroSalud, 
    alumno.fechaNacimiento, 
    alumno.enfermedades
    FROM $tabla WHERE idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $codALumnoVisualizar, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
