<?php
require_once "connection.php";

class ModelInicio
{
  public static function mdlObtenertodoslosAlumnosporGrandos()
  {
    $statement = Connection::conn()->prepare("SELECT
    grado.descripcionGrado,
    COUNT(alumno_anio_escolar.idAlumnoAnioEscolar) AS Alumnos
        
    FROM
	alumno
	INNER JOIN
	alumno_anio_escolar
	ON 
		alumno.idAlumno = alumno_anio_escolar.idAlumno
	RIGHT JOIN
	grado
	ON 
		alumno_anio_escolar.idGrado = grado.idGrado
		GROUP BY
    grado.descripcionGrado
	ORDER BY 
	grado.idGrado ASC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlObtenertodaslasPensionesPendientes()
  {
    $statement = Connection::conn()->prepare("SELECT
    cronograma_pago.mesPago,
    EXTRACT(YEAR FROM cronograma_pago.fechaLimite) AS año,
    EXTRACT(MONTH FROM cronograma_pago.fechaLimite) AS mes,
    COUNT(cronograma_pago.idCronogramaPago) AS pagos_vencidos,
    (COUNT(cronograma_pago.idCronogramaPago) * 100 / total.total_pensiones) AS porcentaje_vencidas,
    total.total_pensiones AS total_pensiones,
    cronograma_pago.fechaLimite
    FROM
        cronograma_pago
    LEFT JOIN
        pago ON pago.idCronogramaPago = cronograma_pago.idCronogramaPago
    JOIN
        (
            SELECT 
                mesPago, 
                COUNT(*) AS total_pensiones 
            FROM 
                cronograma_pago 
            GROUP BY 
                mesPago
        ) AS total 
    ON 
        cronograma_pago.mesPago = total.mesPago
    WHERE
        (
            (EXTRACT(YEAR FROM cronograma_pago.fechaLimite) < EXTRACT(YEAR FROM CURDATE())) OR
            (EXTRACT(YEAR FROM cronograma_pago.fechaLimite) = EXTRACT(YEAR FROM CURDATE()) AND
            EXTRACT(MONTH FROM cronograma_pago.fechaLimite) < EXTRACT(MONTH FROM CURDATE()))
        ) AND 
        pago.numeroComprobante IS NULL 
    GROUP BY
        cronograma_pago.mesPago, año, mes, total.total_pensiones
    ORDER BY
    año ASC, mes ASC;");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function mdlObtenerTodoslosAlumnosporAnio(){
    $statement = Connection::conn()->prepare("SELECT
	anio_escolar.descripcionAnio, 
	anio_escolar.estadoAnio, 
	COUNT(alumno_anio_escolar.idAlumnoAnioEscolar) AS total_alumno
    FROM
        alumno
        INNER JOIN
        alumno_anio_escolar
        ON 
            alumno.idAlumno = alumno_anio_escolar.idAlumno
        RIGHT JOIN
        anio_escolar
        ON 
            alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
    GROUP BY
        anio_escolar.descripcionAnio
        ORDER BY
        anio_escolar.idAnioEscolar ASC
    LIMIT 5");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlObtenerMontoRecaudadoporMeses(){
    $statement = Connection::conn()->prepare("SELECT
    CASE MONTH(pago.fechaPago)
        WHEN 1 THEN 'Enero'
        WHEN 2 THEN 'Febrero'
        WHEN 3 THEN 'Marzo'
        WHEN 4 THEN 'Abril'
        WHEN 5 THEN 'Mayo'
        WHEN 6 THEN 'Junio'
        WHEN 7 THEN 'Julio'
        WHEN 8 THEN 'Agosto'
        WHEN 9 THEN 'Septiembre'
        WHEN 10 THEN 'Octubre'
        WHEN 11 THEN 'Noviembre'
        WHEN 12 THEN 'Diciembre'
    END AS mes,
    SUM(pago.cantidadPago) AS totalPagado
    FROM
        pago
    GROUP BY
    MONTH(pago.fechaPago)");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlObtenerPersonalInicio(){
    $statement = Connection::conn()->prepare("SELECT
	personal.nombrePersonal, 
	personal.apellidoPersonal, 
	personal.correoPersonal, 
	tipo_personal.descripcionTipo, 
	usuario.ultimaConexion, 
	usuario.estadoUsuario
    FROM
	personal
	INNER JOIN
	tipo_personal
	ON 
		personal.idTipoPersonal = tipo_personal.idTipoPersonal
	INNER JOIN
	usuario
	ON 
		personal.idUsuario = usuario.idUsuario");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlObtenerAsistenciaporMeses($tabla, $idUsuario){
    $statement = Connection::conn()->prepare("SELECT
    CASE 
        WHEN MONTH(asistencia.fechaAsistencia) = 1 THEN 'Enero'
        WHEN MONTH(asistencia.fechaAsistencia) = 2 THEN 'Febrero'
        WHEN MONTH(asistencia.fechaAsistencia) = 3 THEN 'Marzo'
        WHEN MONTH(asistencia.fechaAsistencia) = 4 THEN 'Abril'
        WHEN MONTH(asistencia.fechaAsistencia) = 5 THEN 'Mayo'
        WHEN MONTH(asistencia.fechaAsistencia) = 6 THEN 'Junio'
        WHEN MONTH(asistencia.fechaAsistencia) = 7 THEN 'Julio'
        WHEN MONTH(asistencia.fechaAsistencia) = 8 THEN 'Agosto'
        WHEN MONTH(asistencia.fechaAsistencia) = 9 THEN 'Septiembre'
        WHEN MONTH(asistencia.fechaAsistencia) = 10 THEN 'Octubre'
        WHEN MONTH(asistencia.fechaAsistencia) = 11 THEN 'Noviembre'
        WHEN MONTH(asistencia.fechaAsistencia) = 12 THEN 'Diciembre'
    END AS Mes,
    SUM(CASE WHEN asistencia.estadoAsistencia = 'A' THEN 1 ELSE 0 END) AS Asistio,
    SUM(CASE WHEN asistencia.estadoAsistencia = 'F' THEN 1 ELSE 0 END) AS Falto,
    SUM(CASE WHEN asistencia.estadoAsistencia = 'T' THEN 1 ELSE 0 END) AS Inasistencia_Injustificada,
    SUM(CASE WHEN asistencia.estadoAsistencia = 'J' THEN 1 ELSE 0 END) AS Falta_Justificada,
    SUM(CASE WHEN asistencia.estadoAsistencia = 'U' THEN 1 ELSE 0 END) AS Tardanza_Justificada,
    COUNT(*) AS Total_Asistencias,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'A' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Asistio,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'F' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Falto,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'T' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Inasistencia_Injustificada,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'J' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Falta_Justificada,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'U' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Tardanza_Justificada
    FROM
        $tabla
        INNER JOIN
        personal ON usuario.idUsuario = personal.idUsuario
        INNER JOIN
        cursogrado_personal ON personal.idPersonal = cursogrado_personal.idPersonal
        INNER JOIN
        curso_grado ON cursogrado_personal.idCursoGrado = curso_grado.idCursoGrado
        INNER JOIN
        grado ON curso_grado.idGrado = grado.idGrado
        INNER JOIN
        alumno_anio_escolar ON grado.idGrado = alumno_anio_escolar.idGrado
        INNER JOIN
        asistencia ON alumno_anio_escolar.idAlumnoAnioEscolar = asistencia.idAlumnoAnioEscolar
            INNER JOIN
            anio_escolar ON alumno_anio_escolar.idAnioEscolar = alumno_anio_escolar.idAnioEscolar
    WHERE
        usuario.idUsuario = :idUsuario AND anio_escolar.estadoAnio = 1
    GROUP BY
        MONTH(asistencia.fechaAsistencia)
    ORDER BY
        MONTH(asistencia.fechaAsistencia);");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public static function mdlObtenerTodaslasCompetenciasNotas($tabla, $idUsuario){
    $statement = Connection::conn()->prepare("SELECT
	grado.descripcionGrado, 
	curso.descripcionCurso, 
	alumno.nombresAlumno, 
	alumno.apellidosAlumno, 
	competencias.descripcionCompetencia, 
	nota_competencia.notaCompetencia
    FROM
        $tabla
        INNER JOIN
        usuario
        ON 
            personal.idUsuario = usuario.idUsuario
        INNER JOIN
        cursogrado_personal
        ON 
            personal.idPersonal = cursogrado_personal.idPersonal
        INNER JOIN
        curso_grado
        ON 
            cursogrado_personal.idCursoGrado = curso_grado.idCursoGrado
        INNER JOIN
        nota_unidad
        ON 
            cursogrado_personal.idCursogradoPersonal = nota_unidad.idCursoGradoPersonal
        INNER JOIN
        nota_competencia
        ON 
            nota_unidad.idNotaUnidad = nota_competencia.idNotaUnidad
        INNER JOIN
        grado
        ON 
            curso_grado.idGrado = grado.idGrado
        INNER JOIN
        curso
        ON 
            curso_grado.idCurso = curso.idCurso
        INNER JOIN
        competencias
        ON 
            nota_competencia.idCompetencia = competencias.idCompetencia
        INNER JOIN
        alumno_anio_escolar
        ON 
            nota_unidad.idAlumnoAnioEscolar = alumno_anio_escolar.idAlumnoAnioEscolar AND
            grado.idGrado = alumno_anio_escolar.idGrado
        INNER JOIN
        alumno
        ON 
            alumno_anio_escolar.idAlumno = alumno.idAlumno
        INNER JOIN
        unidad
        ON 
            competencias.idUnidad = unidad.idUnidad AND
            nota_unidad.idUnidad = unidad.idUnidad
    WHERE
        usuario.idUsuario = :idUsuario AND
        unidad.estadoUnidad = 1");
    $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
