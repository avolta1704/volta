<?php
require_once "connection.php";

class ModelAlumnos
{
  // Obtener todos los alumnos
  public static function mdlGetAlumnos($tabla)
  {
    $tablaAdmisionAlumno = "admision_alumno";
    $tablaAlumnoAnioEscolar = "alumno_anio_escolar";
    $statement = Connection::conn()->prepare("
        SELECT
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
            $tabla AS alumno
        INNER JOIN (
            SELECT
                aa1.idAlumno,
                aa1.estadoAdmisionAlumno
            FROM
                $tablaAdmisionAlumno AS aa1
            INNER JOIN (
                SELECT
                    idAlumno,
                    MAX(fechaCreacion) AS maxFechaCreacion
                FROM
                    $tablaAdmisionAlumno
                GROUP BY
                    idAlumno
            ) AS latest_aa
            ON aa1.idAlumno = latest_aa.idAlumno
            AND aa1.fechaCreacion = latest_aa.maxFechaCreacion
        ) AS aa
        ON alumno.idAlumno = aa.idAlumno
        INNER JOIN (
            SELECT
                ae.idAlumno,
                ae.idGrado,
                ae.idAnioEscolar
            FROM
                $tablaAlumnoAnioEscolar AS ae
            INNER JOIN (
                SELECT
                    idAlumno,
                    MAX(idAnioEscolar) AS maxIdAnioEscolar
                FROM
                    $tablaAlumnoAnioEscolar
                GROUP BY
                    idAlumno
            ) AS latest_ae
            ON ae.idAlumno = latest_ae.idAlumno
            AND ae.idAnioEscolar = latest_ae.maxIdAnioEscolar
        ) AS alumno_anio_escolar_latest
        ON alumno.idAlumno = alumno_anio_escolar_latest.idAlumno
        INNER JOIN grado
        ON alumno_anio_escolar_latest.idGrado = grado.idGrado
        INNER JOIN nivel
        ON grado.idNivel = nivel.idNivel
        WHERE aa.estadoAdmisionAlumno = 2
        ORDER BY alumno_anio_escolar_latest.idAnioEscolar DESC;
    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  /**
   * Modelo para obtener los alumnos de un año escolar.
   * 
   * @param string $tabla Nombre de la tabla de la base de datos.
   * @param int $idAnioEscolar Identificador del año escolar.
   * @return array $response Array con los alumnos de un año escolar.
   */
  public static function mdlGetAlumnosAnioEscolar($tabla, $idAnioEscolar)
  {
    $tablaAdmisionAlumno = "admision_alumno";
    $statement = Connection::conn()->prepare("
        SELECT
            alumno.idAlumno,
            alumno.nombresAlumno,
            alumno.apellidosAlumno,
            alumno.sexoAlumno,
            alumno.codAlumnoCaja,
            alumno.dniAlumno,
            grado.descripcionGrado,
            nivel.descripcionNivel,
            aa.idAdmisionAlumno
        FROM
            $tablaAdmisionAlumno AS aa
        INNER JOIN
            $tabla AS alumno ON alumno.idAlumno = aa.idAlumno
        INNER JOIN
            alumno_anio_escolar AS ae ON ae.idAlumno = aa.idAlumno
        INNER JOIN
            grado ON ae.idGrado = grado.idGrado
        INNER JOIN
            nivel ON grado.idNivel = nivel.idNivel
        INNER JOIN
            admision ON aa.idAdmision = admision.idAdmision
        WHERE
            ae.idAnioEscolar = :idAnioEscolar
            AND admision.idAnioEscolar = :idAnioEscolar
        GROUP BY
            alumno.idAlumno,
            alumno.nombresAlumno,
            alumno.apellidosAlumno,
            alumno.sexoAlumno,
            alumno.codAlumnoCaja,
            alumno.dniAlumno,
            grado.descripcionGrado,
            nivel.descripcionNivel,
            aa.idAdmisionAlumno
        ORDER BY
            alumno.idAlumno DESC");
    $statement->bindParam(":idAnioEscolar", $idAnioEscolar, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Obtener estadoAdmisionAlumno cuando sea por anio escolar
  public static function mdlGetEstadoAdmisionAlumnoAnioEscolar($tabla, $idAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT admision_alumno.estadoAdmisionAlumno FROM $tabla WHERE admision_alumno.idAdmisionAlumno = :idAdmisionAlumno");
    $statement->bindParam(":idAdmisionAlumno", $idAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
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
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (estadoSiagie, nombresAlumno, apellidosAlumno, sexoAlumno,dniAlumno, fechaNacimiento, direccionAlumno, IEPProcedencia,seguroSalud,fechaIngresoVolta,nuevoAlumno,enfermedades,fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES(:estadoSiagie,:nombresAlumno, :apellidosAlumno, :sexoAlumno, :dniAlumno, :fechaNacimiento, :direccionAlumno, :IEPProcedencia, :seguroSalud,:fechaIngresoVolta,:nuevoAlumno,:enfermedades,:fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":estadoSiagie", $dataArrayAlumno["estadoSiagie"], PDO::PARAM_STR);
    $statement->bindParam(":nombresAlumno", $dataArrayAlumno["nombresAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":apellidosAlumno", $dataArrayAlumno["apellidosAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":sexoAlumno", $dataArrayAlumno["sexoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":dniAlumno", $dataArrayAlumno["dniAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":fechaNacimiento", $dataArrayAlumno["fechaNacimiento"], PDO::PARAM_STR);
    $statement->bindParam(":direccionAlumno", $dataArrayAlumno["direccionAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":IEPProcedencia", $dataArrayAlumno["IEPProcedencia"], PDO::PARAM_STR);
    $statement->bindParam(":seguroSalud", $dataArrayAlumno["seguroSalud"], PDO::PARAM_STR);
    $statement->bindParam(":fechaIngresoVolta", $dataArrayAlumno["fechaIngresoVolta"], PDO::PARAM_STR);
    $statement->bindParam(":nuevoAlumno", $dataArrayAlumno["nuevoAlumno"], PDO::PARAM_STR);
    $statement->bindParam(":enfermedades", $dataArrayAlumno["enfermedades"], PDO::PARAM_STR);
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
    admision.estadoAdmisionAlumno,
    a_ae.idAlumnoAnioEscolar
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
    admision.estadoAdmisionAlumno = 2
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
    $tablaAdmisionAlumno = "admision_alumno";

    $statement = Connection::conn()->prepare("SELECT
      a.idAlumno,
      a.nombresAlumno,
      a.apellidosAlumno,
      a.dniAlumno,
      g.descripcionGrado,
      n.descripcionNivel,
      admision.estadoAdmisionAlumno,
      bimestre.descripcionBimestre, 
      unidad.descripcionUnidad  
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
      admision.estadoAdmisionAlumno = 2
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

  /**
   * Método para obtener los datos de un alumno por su ID para visualizar.
   * 
   * @param string $tabla Nombre de la tabla de la base de datos.
   * @param int $codAdmisionAlumno ID del alumno.
   */
  public static function mdlGetDatosVisualizar($tabla, $codAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT
    alumno.nombresAlumno, 
    alumno.apellidosAlumno, 
    postulante.fechaPostulacion, 
    alumno.fechaNacimiento, 
    alumno.sexoAlumno, 
    postulante.lugarNacimiento, 
    alumno.dniAlumno, 
    alumno.direccionAlumno, 
    nivel.descripcionNivel, 
    grado.descripcionGrado, 
    postulante.colegioProcedencia, 
    postulante.dificultadPostulante, 
    postulante.dificultadObservacion, 
    postulante.tipoAtencionPostulante, 
    postulante.tratamientoPostulante, 
    apoderado2.idApoderado AS apoderado1, 
    apoderado1.idApoderado AS apoderado2
  FROM
    $tabla
    INNER JOIN
    apoderado_alumno AS apm
    ON 
      alumno.idAlumno = apm.idAlumno
    INNER JOIN
    apoderado AS apoderado1
    ON 
      apm.idApoderado = apoderado1.idApoderado
    INNER JOIN
    apoderado_alumno AS app
    ON 
      alumno.idAlumno = app.idAlumno
    INNER JOIN
    apoderado AS apoderado2
    ON 
      app.idApoderado = apoderado2.idApoderado     
    INNER JOIN
    admision_alumno
    ON 
      alumno.idAlumno = admision_alumno.idAlumno
    INNER JOIN
    admision
    ON 
      admision_alumno.idAdmision = admision.idAdmision
    INNER JOIN
    postulante
    ON 
      admision.idPostulante = postulante.idPostulante
    INNER JOIN
    alumno_anio_escolar
    ON 
      alumno.idAlumno = alumno_anio_escolar.idAlumno
    INNER JOIN
    nivel
    INNER JOIN
    grado
    ON 
      nivel.idNivel = grado.idNivel AND
      alumno_anio_escolar.idGrado = grado.idGrado
  WHERE
    admision_alumno.idAdmisionAlumno = :IdAdmisionAlumno
    LIMIT 1 OFFSET 2
  ");
    $statement->bindParam(":IdAdmisionAlumno", $codAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Método para obtener los datos de un alumno por su idAlumnoAnioEscolar
   * 
   * @param string $tabla Nombre de la tabla de la base de datos.
   * @param int $idAlumnoAnioEscolar ID del alumno en el año escolar.
   * @return array $response Array con los datos del alumno.
   */
  public static function mdlGetAlumnoByIdAnioEscolar($tabla, $idAlumnoAnioEscolar)
  {
    $statement = Connection::conn()->prepare("SELECT
    a.nombresAlumno,
    a.apellidosAlumno,
    a.idAlumno,
    aae.idAlumnoAnioEscolar
    FROM
    $tabla as a
    INNER JOIN
    alumno_anio_escolar as aae
    ON 
      a.idAlumno = aae.idAlumno
    WHERE
      aae.idAlumnoAnioEscolar = :idAlumnoAnioEscolar");
    $statement->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    if ($statement->execute()) {
      return $statement->fetch();
    } else {
      return "error";
    }
  }
  public static function mdlGetAlumnoByIdAlumnoDocenteVisualizar($tabla, $idAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT
      a.nombresAlumno,
      a.apellidosAlumno,
      a.dniAlumno,
      a.fechaNacimiento,
      a.direccionAlumno,
      padre.nombreApoderado AS nombrePadre,
      padre.apellidoApoderado AS apellidoPadre,
      padre.convivenciaAlumno AS convivenciaPadre,
      padre.celularApoderado AS celularPadre,
      madre.nombreApoderado AS nombreMadre,
      madre.apellidoApoderado AS apellidoMadre,
      madre.convivenciaAlumno AS convivenciaMadre,
      madre.celularApoderado AS celularMadre
      FROM
          $tabla a
      LEFT JOIN (
          SELECT
              aa.idAlumno,
              ap.nombreApoderado,
              ap.apellidoApoderado,
              ap.convivenciaAlumno,
              ap.celularApoderado
          FROM
              apoderado_alumno aa
          INNER JOIN
              apoderado ap ON aa.idApoderado = ap.idApoderado
          WHERE
              ap.tipoApoderado = 'Padre'
      ) AS padre ON a.idAlumno = padre.idAlumno
      LEFT JOIN (
          SELECT
              aa.idAlumno,
              ap.nombreApoderado,
              ap.apellidoApoderado,
              ap.convivenciaAlumno,
              ap.celularApoderado
          FROM
              apoderado_alumno aa
          INNER JOIN
              apoderado ap ON aa.idApoderado = ap.idApoderado
          WHERE
              ap.tipoApoderado = 'Madre'
      ) AS madre ON a.idAlumno = madre.idAlumno
        WHERE
          a.idAlumno = :idAlumno");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  public static function mdlObtenerTodosIdAlumnoIdApoderadoHermanos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
      alumno.idAlumno, 
      alumno.nombresAlumno, 
      alumno.apellidosAlumno, 
      MAX(CASE WHEN apoderado.tipoApoderado = 'Padre' THEN apoderado.idApoderado END) AS idPadre,
      MAX(CASE WHEN apoderado.tipoApoderado = 'Madre' THEN apoderado.idApoderado END) AS idMadre
      FROM
          $tabla
          INNER JOIN apoderado_alumno ON alumno.idAlumno = apoderado_alumno.idAlumno
          INNER JOIN apoderado ON apoderado_alumno.idApoderado = apoderado.idApoderado
          INNER JOIN admision_alumno ON alumno.idAlumno = admision_alumno.idAlumno
      WHERE admision_alumno.estadoAdmisionAlumno = 2 
      GROUP BY
          alumno.idAlumno, alumno.nombresAlumno, alumno.apellidosAlumno");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
