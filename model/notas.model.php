<?php

require_once "connection.php";

class ModelNotas
{
  /**
   * Modelo para obtener la nota de un alumno en un criterio
   * 
   * @param int $idAlumnoAnioEscolar id del alumno anio escolar
   * @param int $idCriterio id del criterio
   * @param int $idCompetencia id de la competencia
   * @return array con la nota del alumno en un criterio
   */
  public static function mdlObtenerNotaAlumnoCriterio($idAlumnoAnioEscolar, $idCriterio, $idCompetencia)
  {

    $tablaNotaCriterios = "nota_criterio";
    $tablaCriterios = "criterios_competencia";
    $tablaCompetencia = "competencias";
    $tablaAlumnoAnioEscolar = "alumno_anio_escolar";

    $stmt = Connection::conn()->prepare("SELECT
      nota_c.idNotaCriterio,
      nota_c.notaCriterio
    FROM
      $tablaNotaCriterios as nota_c
    INNER JOIN
      $tablaCriterios as cr
    ON
      nota_c.idCriterioCompetencia = cr.idCriterioCompetencia
    INNER JOIN
      $tablaCompetencia as co
    ON
      cr.idCompetencia = co.idCompetencia    
    INNER JOIN
      $tablaAlumnoAnioEscolar as aae
    ON
      nota_c.idAlumnoAnioEscolar = aae.idAlumnoAnioEscolar
    WHERE
      nota_c.idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND
      cr.idCriterioCompetencia = :idCriterio AND
      co.idCompetencia = :idCompetencia");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    $stmt->bindParam(":idCriterio", $idCriterio, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Modelo para obtener una nota de un alumno en un criterio
   * 
   * @param int $idNotaCriterio id de la nota criterio
   * @return array con la nota del alumno en un criterio
   */
  public static function mdlObtenerNotaAlumnoCriterioPorId($idNotaCriterio)
  {
    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("SELECT
      notaCriterio
    FROM
      $tablaNotaCriterios
    WHERE
      idNotaCriterio = :idNotaCriterio");
    $stmt->bindParam(":idNotaCriterio", $idNotaCriterio, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Modelo para actualizar una nota
   * 
   * @param int $idNotaCriterio id de la nota criterio
   * @param string $nota nota del criterio
   * @return string con el resultado de la consulta
   */
  public static function mdlActualizarNota($idNotaCriterio, $nota)
  {

    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("UPDATE
      $tablaNotaCriterios
    SET
      notaCriterio = :nota,
      usuarioActualizacion = :usuarioActualizacion,
      fechaActualizacion = :fechaActualizacion
    WHERE
      idNotaCriterio = :idNotaCriterio");
    $stmt->bindParam(":nota", $nota["nota"], PDO::PARAM_STR);
    $stmt->bindParam(":idNotaCriterio", $idNotaCriterio, PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $nota["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $nota["fechaActualizacion"], PDO::PARAM_STR);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Modelo para crear una nota
   * 
   * @param int $idAlumnoAnioEscolar id del alumno año escolar
   * @param int $idCriterioCompetencia id del criterio de competencia
   * @param string $nota nota del criterio
   */
  public static function mdlCrearNota($idAlumnoAnioEscolar, $idCriterioCompetencia, $nota)
  {
    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("INSERT INTO
      $tablaNotaCriterios
    (idAlumnoAnioEscolar, idCriterioCompetencia, notaCriterio, usuarioCreacion, usuarioActualizacion, fechaCreacion, fechaActualizacion)
    VALUES
      (:idAlumnoAnioEscolar, :idCriterioCompetencia, :nota, :usuarioCreacion, :usuarioActualizacion, :fechaCreacion, :fechaActualizacion)");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCriterioCompetencia", $idCriterioCompetencia, PDO::PARAM_INT);
    $stmt->bindParam(":nota", $nota["nota"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $nota["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $nota["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $nota["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $nota["fechaActualizacion"], PDO::PARAM_STR);

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Modelo para eliminar una nota
   * 
   * @param int $idNotaCriterio id de la nota criterio
   * @return string con el resultado de la consulta
   */
  public static function mdlEliminarNota($idNotaCriterio)
  {
    $tablaNotaCriterios = "nota_criterio";
    $stmt = Connection::conn()->prepare("DELETE FROM
      $tablaNotaCriterios
    WHERE
      idNotaCriterio = :idNotaCriterio");
    $stmt->bindParam(":idNotaCriterio", $idNotaCriterio, PDO::PARAM_INT);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Modelo para obtener una nota competencia por el idCompetencia y idAlumnoAnioEscolar
   * 
   * @param int $idAlumnoAnioEscolar
   * @param int $idCompetencia
   * @return array con la nota de la competencia del alumno o "error" si no se encuentra
   */
  public static function mdlObtenerNotaCompetenciaByIdAlumnoAnioEscolaryIdCompetencia($idAlumnoAnioEscolar, $idCompetencia)
  {
    $tablaNotaCompetencia = "nota_competencia";
    $stmt = Connection::conn()->prepare("SELECT
      idNotaCompetencia,
      notaCompetencia
    FROM
      $tablaNotaCompetencia
    WHERE
      idAlumnoAnioEscolar = :idAlumnoAnioEscolar AND
      idCompetencia = :idCompetencia");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) > 0) {
      return $result;
    } else {
      return "error";
    }
  }

  /**
   * Modelo para actualizar una nota competencia
   * 
   * @param int $idNotaCompetencia id de la nota competencia
   * @param string $nota nota de la competencia 
   * @return string con el resultado de la consulta "ok" o "error"
   */
  public static function mdlActualizarNotaCompetencia($idNotaCompetencia, $notaCompetencia)
  {
    $tablaNotaCompetencia = "nota_competencia";

    $stmt = Connection::conn()->prepare("UPDATE
      $tablaNotaCompetencia
    SET
      notaCompetencia = :notaCompetencia,
      usuarioActualizacion = :usuarioActualizacion,
      fechaActualizacion = :fechaActualizacion
    WHERE
      idNotaCompetencia = :idNotaCompetencia");
    $stmt->bindParam(":notaCompetencia", $notaCompetencia["notaCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":idNotaCompetencia", $idNotaCompetencia, PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $notaCompetencia["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaActualizacion", $notaCompetencia["fechaActualizacion"], PDO::PARAM_STR);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Modelo para crear una nota competencia
   * 
   * @param int $idAlumnoAnioEscolar id del alumno año escolar
   * @param int $idCompetencia id de la competencia
   * @param string $nota nota de la competencia
   */
  public static function mdlCrearNotaCompetencia($idAlumnoAnioEscolar, $idCompetencia, $notaCompetencia)
  {
    $tablaNotaCompetencia = "nota_competencia";
    $stmt = Connection::conn()->prepare("INSERT INTO
      $tablaNotaCompetencia
    (idAlumnoAnioEscolar, idCompetencia, notaCompetencia, usuarioCreacion, usuarioActualizacion, fechaCreacion, fechaActualizacion)
    VALUES
      (:idAlumnoAnioEscolar, :idCompetencia, :notaCompetencia, :usuarioCreacion, :usuarioActualizacion, :fechaCreacion, :fechaActualizacion)");
    $stmt->bindParam(":idAlumnoAnioEscolar", $idAlumnoAnioEscolar, PDO::PARAM_INT);
    $stmt->bindParam(":idCompetencia", $idCompetencia, PDO::PARAM_INT);
    $stmt->bindParam(":notaCompetencia", $notaCompetencia["notaCompetencia"], PDO::PARAM_STR);
    $stmt->bindParam(":usuarioCreacion", $notaCompetencia["usuarioCreacion"], PDO::PARAM_INT);
    $stmt->bindParam(":usuarioActualizacion", $notaCompetencia["usuarioActualizacion"], PDO::PARAM_INT);
    $stmt->bindParam(":fechaCreacion", $notaCompetencia["fechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":fechaActualizacion", $notaCompetencia["fechaActualizacion"], PDO::PARAM_STR);
    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  public static function mdlObtenerAlumnosApoderado($tabla, $idUsuario)
  {
    $stmt = Connection::conn()->prepare("SELECT DISTINCT
    alumno.idAlumno,
    CONCAT(alumno.nombresAlumno,' ',alumno.apellidosAlumno) AS nombre_completo,
    nivel.descripcionNivel, 
    grado.descripcionGrado, 
    admision_alumno.estadoAdmisionAlumno
  FROM
    $tabla
    INNER JOIN
    apoderado
    ON 
      usuario.idUsuario = apoderado.idUsuario
    INNER JOIN
    apoderado_alumno
    ON 
      apoderado.idApoderado = apoderado_alumno.idApoderado
    INNER JOIN
    alumno
    ON 
      apoderado_alumno.idAlumno = alumno.idAlumno
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
    admision_alumno
    ON 
      alumno.idAlumno = admision_alumno.idAlumno
    INNER JOIN
    curso_grado
    ON 
      grado.idGrado = curso_grado.idGrado
  WHERE
    usuario.idUsuario = :idUsuario AND
    admision_alumno.estadoAdmisionAlumno = 2 ");
    $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlObtenerListadoNotasAlumnoApoderado($tabla, $idAlumno)
  {
    $stmt = Connection::conn()->prepare("SELECT
          alumno.idAlumno,
          alumno.nombresAlumno, 
          alumno.apellidosAlumno,
          grado.descripcionGrado,
          nivel.descripcionNivel,
          curso.descripcionCurso, 
          MAX(CASE WHEN unidad.descripcionUnidad = 'I UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_i,
          MAX(CASE WHEN unidad.descripcionUnidad = 'II UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_ii,
          MAX(CASE WHEN unidad.descripcionUnidad = 'III UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_iii,
          MAX(CASE WHEN unidad.descripcionUnidad = 'IV UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_iv,
          MAX(CASE WHEN unidad.descripcionUnidad = 'V UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_v,
          MAX(CASE WHEN unidad.descripcionUnidad = 'VI UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_vi,
          MAX(CASE WHEN unidad.descripcionUnidad = 'VII UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_vii,
          MAX(CASE WHEN unidad.descripcionUnidad = 'VIII UNIDAD' THEN nota_unidad.notaUnidad END) AS nota_unidad_viii,
          MAX(CASE WHEN bimestre.descripcionBimestre = 'I BIMESTRE' THEN nota_bimestre.notaBimestre END) AS nota_bimestre_i,
          MAX(CASE WHEN bimestre.descripcionBimestre = 'II BIMESTRE' THEN nota_bimestre.notaBimestre END) AS nota_bimestre_ii,
          MAX(CASE WHEN bimestre.descripcionBimestre = 'III BIMESTRE' THEN nota_bimestre.notaBimestre END) AS nota_bimestre_iii,
          MAX(CASE WHEN bimestre.descripcionBimestre = 'IV BIMESTRE' THEN nota_bimestre.notaBimestre END) AS nota_bimestre_iv
      FROM
          alumno
          INNER JOIN alumno_anio_escolar ON alumno.idAlumno = alumno_anio_escolar.idAlumno
          INNER JOIN grado ON alumno_anio_escolar.idGrado = grado.idGrado
          INNER JOIN nivel ON grado.idNivel = nivel.idNivel 
          INNER JOIN curso_grado ON grado.idGrado = curso_grado.idGrado
          RIGHT JOIN bimestre ON curso_grado.idCursoGrado = bimestre.idCursoGrado
          LEFT JOIN unidad ON bimestre.idBimestre = unidad.idBimestre
          LEFT JOIN nota_bimestre ON alumno_anio_escolar.idAlumnoAnioEscolar = nota_bimestre.idAlumnoAnioEscolar AND bimestre.idBimestre = nota_bimestre.idBimestre
          LEFT JOIN nota_unidad ON alumno_anio_escolar.idAlumnoAnioEscolar = nota_unidad.idAlumnoAnioEscolar AND unidad.idUnidad = nota_unidad.idUnidad
          INNER JOIN curso ON curso_grado.idCurso = curso.idCurso
      WHERE
          alumno.idAlumno = :idAlumno
      GROUP BY
          alumno.nombresAlumno,
          alumno.apellidosAlumno,
          curso.descripcionCurso");
    $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
