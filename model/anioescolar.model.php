<?php
require_once "connection.php";

class ModelAnioEscolar
{
  //  Crear nuevo Año Escolar
  public static function mdlCrearAnioEscolar($tabla, $datosAnioEscolar)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (descripcionAnio, estadoAnio, cuotaInicial, matriculaInicial, pensionInicial, matriculaPrimaria, pensionPrimaria, matriculaSecundaria, pensionSecundaria, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:descripcionAnio, :estadoAnio, :cuotaInicial, :matriculaInicial, :pensionInicial, :matriculaPrimaria, :pensionPrimaria, :matriculaSecundaria, :pensionSecundaria, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":descripcionAnio", $datosAnioEscolar["descripcionAnio"], PDO::PARAM_STR);
    $statement->bindParam(":estadoAnio", $datosAnioEscolar["estadoAnio"], PDO::PARAM_STR);
    $statement->bindParam(":cuotaInicial", $datosAnioEscolar["cuotaInicial"], PDO::PARAM_STR);
    $statement->bindParam(":matriculaInicial", $datosAnioEscolar["matriculaInicial"], PDO::PARAM_STR);
    $statement->bindParam(":pensionInicial", $datosAnioEscolar["pensionInicial"], PDO::PARAM_STR);
    $statement->bindParam(":matriculaPrimaria", $datosAnioEscolar["matriculaPrimaria"], PDO::PARAM_STR);
    $statement->bindParam(":pensionPrimaria", $datosAnioEscolar["pensionPrimaria"], PDO::PARAM_STR);
    $statement->bindParam(":matriculaSecundaria", $datosAnioEscolar["matriculaSecundaria"], PDO::PARAM_STR);
    $statement->bindParam(":pensionSecundaria", $datosAnioEscolar["pensionSecundaria"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $datosAnioEscolar["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosAnioEscolar["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $datosAnioEscolar["usuarioCreacion"], PDO::PARAM_INT);
    $statement->bindParam(":usuarioActualizacion", $datosAnioEscolar["usuarioActualizacion"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //  Obtener el anio escolar por el estado activo = 1
  public static function mdlGetAnioEscolarEstadoActivo($table, $estadoAnio)
  {
    $statement = Connection::conn()->prepare("SELECT idAnioEscolar FROM $table WHERE estadoAnio = :estadoAnio");
    $statement->bindParam(":estadoAnio", $estadoAnio, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }

  //  Obtener datos del anio escolar

  public static function mdlGetAnioEscolarActivo($table)
  {
    $activoAnio = 1;
    $statement = Connection::conn()->prepare("SELECT *
    FROM $table WHERE estadoAnio = $activoAnio");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Otener todos los años escolares
  public static function mdlGetTodosAniosEscolar($table)
  {
    $statement = Connection::conn()->prepare("SELECT idAnioEscolar, descripcionAnio, estadoAnio, cuotaInicial FROM $table ORDER BY descripcionAnio DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  Obtener un año escolar para luego editarlo
  public static function mdlBuscarAnioEscolar($table, $codAnio)
  {
    $statement = Connection::conn()->prepare("SELECT idAnioEscolar, descripcionAnio, estadoAnio, cuotaInicial, matriculaInicial, pensionInicial, matriculaPrimaria, pensionPrimaria, matriculaSecundaria, pensionSecundaria FROM $table WHERE idAnioEscolar = :idAnioEscolar");
    $statement->bindParam(":idAnioEscolar", $codAnio, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Editar un año escolar existente
  public static function mdlEditarAnioEscolar($tabla, $datosEditarAnio)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET descripcionAnio = :descripcionAnio, cuotaInicial = :cuotaInicial, matriculaInicial = :matriculaInicial, pensionInicial = :pensionInicial, matriculaPrimaria = :matriculaPrimaria, pensionPrimaria = :pensionPrimaria, matriculaSecundaria = :matriculaSecundaria, pensionSecundaria = :pensionSecundaria, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idAnioEscolar = :idAnioEscolar");
    $statement->bindParam(":idAnioEscolar", $datosEditarAnio["idAnioEscolar"], PDO::PARAM_INT);
    $statement->bindParam(":descripcionAnio", $datosEditarAnio["descripcionAnio"], PDO::PARAM_STR);
    $statement->bindParam(":cuotaInicial", $datosEditarAnio["cuotaInicial"], PDO::PARAM_STR);
    $statement->bindParam(":matriculaInicial", $datosEditarAnio["matriculaInicial"], PDO::PARAM_STR);
    $statement->bindParam(":pensionInicial", $datosEditarAnio["pensionInicial"], PDO::PARAM_STR);
    $statement->bindParam(":matriculaPrimaria", $datosEditarAnio["matriculaPrimaria"], PDO::PARAM_STR);
    $statement->bindParam(":pensionPrimaria", $datosEditarAnio["pensionPrimaria"], PDO::PARAM_STR);
    $statement->bindParam(":matriculaSecundaria", $datosEditarAnio["matriculaSecundaria"], PDO::PARAM_STR);
    $statement->bindParam(":pensionSecundaria", $datosEditarAnio["pensionSecundaria"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $datosEditarAnio["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $datosEditarAnio["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Activar o desactivar el año escolar
  public static function mdlActivarAnioEscolar($tabla, $datosActivarAnio)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoAnio = :estadoAnio, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idAnioEscolar = :idAnioEscolar");
    $statement->bindParam(":idAnioEscolar", $datosActivarAnio["idAnioEscolar"], PDO::PARAM_INT);
    $statement->bindParam(":estadoAnio", $datosActivarAnio["estadoAnio"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $datosActivarAnio["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $datosActivarAnio["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  //  Verificar el uso del año escolar en las tablas de la base de datos
  public static function mdlVerificarUsoAnioEscolar($codAnio)
  {
    $statement = Connection::conn()->prepare("SELECT COALESCE((SELECT 1 FROM anio_admision WHERE idAnioEscolar = :idAnioEscolar LIMIT 1), 0) AS existencia");
    $statement->bindParam(":idAnioEscolar", $codAnio, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Eliminar un año escolar
  public static function mdlEliminarAnioEscolar($tabla, $codAnio)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $tabla WHERE idAnioEscolar = :idAnioEscolar");
    $statement->bindParam(":idAnioEscolar", $codAnio, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  /**
   * Obtener el nivel de educacion
   * 
   * @param int $idNivelEducacion
   * @return string
   */
  public static function mdlGetNivelEducacion($table, $idNivelEducacion)
  {
    $statement = Connection::conn()->prepare("SELECT descripcionNivel FROM $table WHERE idNivel = :idNivel");
    $statement->bindParam(":idNivel", $idNivelEducacion, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }
  // Obtener todos los grados para cerrar el año escolar
  public static function mdlMostrarGradosCerrarAnioEscolar($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT grado.idGrado, nivel.descripcionNivel, descripcionGrado FROM $tabla INNER JOIN nivel ON  grado.idNivel = nivel.idNivel ORDER BY grado.idGrado ASC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Obtenemos los alumnos de un grado para cerrar el año escolar
  public static function mdlMostrarAlumnosGradoCerrarAnio($tabla, $idGrado)
  {
    $statement = Connection::conn()->prepare("SELECT
    alumno.idAlumno,
    alumno.nombresAlumno, 
    alumno.apellidosAlumno,
    grado.idGrado, 
    grado.descripcionGrado,
    anio_escolar.idAnioEscolar,
    alumno_anio_escolar.estadoFinal
    FROM
      $tabla
      INNER JOIN
      alumno_anio_escolar
      ON 
        alumno.idAlumno = alumno_anio_escolar.idAlumno
      INNER JOIN
      anio_escolar
      ON 
        alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
      INNER JOIN
      grado
      ON 
        alumno_anio_escolar.idGrado = grado.idGrado
    WHERE
      alumno_anio_escolar.idGrado = :idGrado AND
      anio_escolar.estadoAnio = 1");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Actualizar el estado final del alumno en el año escolar
  public static function mdlActualizarEstadoFinalAlumnoAnioEscolarCerrarAnio($tabla, $idGrado, $idAnioEscolar, $idAlumno, $estadoFinal)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET estadoFinal = :estadoFinal WHERE idGrado = :idGrado AND idAnioEscolar = :idAnioEscolar AND idAlumno = :idAlumno");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idAnioEscolar", $idAnioEscolar, PDO::PARAM_INT);
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->bindParam(":estadoFinal", $estadoFinal, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Obtener IDS Alumnos matriculados por grado 
  public static function mdlGetAlumnosMatriculadosGrado($tabla, $idGrado)
  {
    $statement = Connection::conn()->prepare("SELECT alumno.idAlumno, alumno_anio_escolar.estadoFinal FROM $tabla INNER JOIN alumno_anio_escolar ON  alumno.idAlumno = alumno_anio_escolar.idAlumno INNER JOIN anio_escolar ON alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar INNER JOIN grado ON alumno_anio_escolar.idGrado = grado.idGrado INNER JOIN admision_alumno ON alumno.idAlumno = admision_alumno.idAlumno WHERE alumno_anio_escolar.idGrado = :idGrado AND anio_escolar.estadoAnio = 1 AND admision_alumno.estadoAdmisionAlumno = 2");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Validar si existen notas subidas por el alumno en el IV Bimestre
  public static function mdlValidacionNotasSubidasporAlumno($tabla, $idAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT
        curso_grado.idCurso, 
        bimestre.descripcionBimestre, 
        nota_bimestre.notaBimestre
    FROM
        $tabla
        INNER JOIN alumno_anio_escolar ON alumno.idAlumno = alumno_anio_escolar.idAlumno
        INNER JOIN grado ON alumno_anio_escolar.idGrado = grado.idGrado
        INNER JOIN curso_grado ON grado.idGrado = curso_grado.idGrado
        INNER JOIN bimestre ON curso_grado.idCursoGrado = bimestre.idCursoGrado
        LEFT JOIN nota_bimestre ON 
            alumno_anio_escolar.idAlumnoAnioEscolar = nota_bimestre.idAlumnoAnioEscolar AND
            bimestre.idBimestre = nota_bimestre.idBimestre
    WHERE
        bimestre.descripcionBimestre = 'IV BIMESTRE' AND alumno.idAlumno = :idAlumno AND nota_bimestre.notaBimestre IS NULL");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();

    // Verificar si hay resultados
    if ($statement->rowCount() > 0) {
      return "error";
    } else {
      return "ok";
    }
  }
  // Validar si el alumno tiene el estado final en NULL
  public static function mdlValidarEstadoFinalporAlumno($tabla, $idAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT alumno.idAlumno FROM $tabla INNER JOIN alumno_anio_escolar ON  alumno.idAlumno = alumno_anio_escolar.idAlumno WHERE alumno.idAlumno = :idAlumno AND alumno_anio_escolar.estadoFinal IS NULL");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    // Verificar si hay resultados
    if ($statement->rowCount() > 0) {
      return "error";
    } else {
      return "ok";
    }
  }
    // Validar si el alumno tiene el estado final en NULL
    public static function mdlValidarFinAnioGradoAnioEscolar($tabla, $idGrado)
    {
      $statement = Connection::conn()->prepare("SELECT DISTINCT alumno_anio_escolar.finAnio FROM $tabla INNER JOIN anio_escolar ON alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar WHERE anio_escolar.estadoAnio = 1 AND alumno_anio_escolar.finAnio IS NOT NULL AND alumno_anio_escolar.idGrado = :idGrado");
      $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
      $statement->execute();
      // Verificar si hay resultados
      if ($statement->rowCount() > 0) {
        return "ok";
      } else {
        return "error";
      }
    }
  // Actualizar el finAnio 
  public static function mdlActualizarFinAnioAlumnoAnioEscolarCerrarAnio($tabla, $idGrado, $idAnioEscolar, $idAlumno, $finAnio)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET finAnio = :finAnio WHERE idGrado = :idGrado AND idAnioEscolar = :idAnioEscolar AND idAlumno = :idAlumno");
    $statement->bindParam(":idGrado", $idGrado, PDO::PARAM_INT);
    $statement->bindParam(":idAnioEscolar", $idAnioEscolar, PDO::PARAM_INT);
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->bindParam(":finAnio", $finAnio, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  /* Validar el cierre de anio para cada grado con el dato finAnio
    Obtiene todos las filas de la tabla alumno_anio_escolar que estén nulas y que la columna de estadoAnio de la tabla anio_escolar a la que está vinculada esté activo
  */
  public static function mdlValidarCierreGradoAlumnoFinAnio($tabla){
    $statement = Connection::conn()->prepare("SELECT alumno_anio_escolar.finAnio FROM $tabla INNER JOIN anio_escolar ON  alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar WHERE alumno_anio_escolar.finAnio IS NULL AND anio_escolar.estadoAnio = 1");
    $statement->execute();
    // Verificar si hay resultados
    if ($statement->rowCount() > 0) {
      return "error";
    } else {
      return "ok";
    }
  }
  /* Obtener el finAnio de cada grado
    Se obtiene el contador de los alumnos que tienen el valor de finAnio distinto de cero y los que tienen el estadoAnio igual a 1
  */
  public static function mdlObtenerIdAnioEscolarElegidoenCadaGrado($tabla){
    $statement = Connection::conn()->prepare("SELECT DISTINCT alumno_anio_escolar.finAnio FROM $tabla INNER JOIN anio_escolar ON 
		alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar WHERE alumno_anio_escolar.finAnio IS NOT NULL AND anio_escolar.estadoAnio = 1 AND alumno_anio_escolar.finAnio != 0");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   *  Verificar la cantidad de años que están abiertos
   * @param string $table
   */
  public static function mdlObtenerCantidadAniosActivos($table)
  {
    $statement = Connection::conn()->prepare("SELECT COUNT(anio_escolar.IdAnioEscolar) AS CantidadAnios FROM $table WHERE anio_escolar.estadoAnio = 1");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
