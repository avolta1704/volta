<?php
require_once "connection.php";

class ModelInicio
{
    // Obtiene todos los alumnos por grado
    public static function mdlObtenertodoslosAlumnosporGrandos()
    {
        $statement = Connection::conn()->prepare("SELECT
    grado.descripcionGrado, 
    COALESCE(COUNT(alumno_anio_escolar.idAlumnoAnioEscolar), 0) AS Alumnos
    FROM
        grado
    LEFT JOIN
        alumno_anio_escolar
    ON 
        grado.idGrado = alumno_anio_escolar.idGrado
    LEFT JOIN
        anio_escolar
    ON 
        alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
        AND anio_escolar.estadoAnio = 1
    GROUP BY
        grado.descripcionGrado
    ORDER BY
        grado.idGrado ASC;");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene todas las pensiones pendientes
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
    // Obtiene todos los alumnos por anio
    public static function mdlObtenerTodoslosAlumnosporAnio()
    {
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
    // Obtiene el monto recaudado por meses
    public static function mdlObtenerMontoRecaudadoporMeses()
    {
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
        INNER JOIN
        cronograma_pago
        ON 
            pago.idCronogramaPago = cronograma_pago.idCronogramaPago
        INNER JOIN
        admision_alumno
        ON 
            cronograma_pago.idAdmisionAlumno = admision_alumno.idAdmisionAlumno
        INNER JOIN
        anio_admision
        ON 
            admision_alumno.idAdmisionAlumno = anio_admision.idAdmisionAlumno
        INNER JOIN
        anio_escolar
        ON 
            anio_admision.idAnioEscolar = anio_escolar.idAnioEscolar
    WHERE
        anio_escolar.estadoAnio = 1
    GROUP BY
	MONTH(pago.fechaPago)");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene el personal de inicio
    public static function mdlObtenerPersonalInicio()
    {
        $statement = Connection::conn()->prepare("SELECT
	personal.nombrePersonal, 
	personal.apellidoPersonal, 
	personal.correoPersonal, 
    tipo_personal.idTipoPersonal,
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
    // Obtiene la asistencia por meses
    public static function mdlObtenerAsistenciaporMeses($tabla, $idUsuario)
    {
        $statement = Connection::conn()->prepare("SELECT
    grado.descripcionGrado,
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
    COUNT(DISTINCT alumno.idAlumno) AS Total_Alumnos,
    COUNT(DISTINCT asistencia.idAsistencia) AS Total_Asistencias,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'A' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Asistio,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'F' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Falto,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'T' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Inasistencia_Injustificada,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'J' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Falta_Justificada,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'U' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS Porcentaje_Tardanza_Justificada
FROM 
    $tabla
    INNER JOIN personal ON usuario.idUsuario = personal.idUsuario
    INNER JOIN cursogrado_personal ON personal.idPersonal = cursogrado_personal.idPersonal
    INNER JOIN curso_grado ON cursogrado_personal.idCursoGrado = curso_grado.idCursoGrado
    INNER JOIN grado ON curso_grado.idGrado = grado.idGrado
    INNER JOIN alumno_anio_escolar ON grado.idGrado = alumno_anio_escolar.idGrado
    INNER JOIN alumno ON alumno.idAlumno = alumno_anio_escolar.idAlumno
    LEFT JOIN asistencia ON alumno_anio_escolar.idAlumnoAnioEscolar = asistencia.idAlumnoAnioEscolar
    INNER JOIN anio_escolar ON alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
WHERE
    usuario.idUsuario = :idUsuario AND anio_escolar.estadoAnio = 1
GROUP BY 
    grado.descripcionGrado,
    MONTH(asistencia.fechaAsistencia)
ORDER BY 
    MONTH(asistencia.fechaAsistencia);");
        $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene todas las competencias y notas
    public static function mdlObtenerTodaslasCompetenciasNotas($tabla, $idUsuario)
    {
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
        grado
        ON 
            curso_grado.idGrado = grado.idGrado
        INNER JOIN
        alumno_anio_escolar
        ON 
            grado.idGrado = alumno_anio_escolar.idGrado
        INNER JOIN
        bimestre
        ON 
            curso_grado.idCursoGrado = bimestre.idCursoGrado
        INNER JOIN
        unidad
        ON 
            bimestre.idBimestre = unidad.idBimestre
        INNER JOIN
        competencias
        ON 
            unidad.idUnidad = competencias.idUnidad
        LEFT JOIN
        nota_competencia
        ON 
            alumno_anio_escolar.idAlumnoAnioEscolar = nota_competencia.idAlumnoAnioEscolar AND
            competencias.idCompetencia = nota_competencia.idCompetencia
        INNER JOIN
        curso
        ON 
            curso_grado.idCurso = curso.idCurso
        INNER JOIN
        alumno
        ON 
            alumno_anio_escolar.idAlumno = alumno.idAlumno
    WHERE
        usuario.idUsuario = :idUsuario AND
        unidad.estadoUnidad = 1");
        $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene todos los alumnos asignados a un docente
    public static function mdlObtenerTodoslosAlumnosAsignadosDocente($tabla, $idUsuario)
    {
        $statement = Connection::conn()->prepare("SELECT
	grado.descripcionGrado, 
	COUNT(DISTINCT alumno.idAlumno) AS alumnos_asignados
    FROM
        $tabla
        INNER JOIN
        personal
        ON 
            usuario.idUsuario = personal.idUsuario
        INNER JOIN
        cursogrado_personal
        ON 
            personal.idPersonal = cursogrado_personal.idPersonal
        INNER JOIN
        curso_grado
        ON 
            cursogrado_personal.idCursoGrado = curso_grado.idCursoGrado
        INNER JOIN
        alumno_anio_escolar
        INNER JOIN
        grado
        ON 
            alumno_anio_escolar.idGrado = grado.idGrado AND
            curso_grado.idGrado = grado.idGrado
        INNER JOIN
        anio_escolar
        ON 
            alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
        INNER JOIN
        alumno
        ON 
            alumno_anio_escolar.idAlumno = alumno.idAlumno
        WHERE
            anio_escolar.estadoAnio = 1 AND
            usuario.idUsuario = :idUsuario
        GROUP BY
            grado.descripcionGrado");
        $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene el total de cursos asignados a un docente
    public static function mdlObtenerTotaldeCursosAsignados($tabla, $idUsuario)
    {
        $statement = Connection::conn()->prepare("SELECT
        COUNT(DISTINCT curso.idCurso) AS cursos_asignados, 
        CONCAT(personal.nombrePersonal, ' ', personal.apellidoPersonal) AS nombreCompleto
        FROM
            $tabla
        INNER JOIN
            personal
        ON 
            usuario.idUsuario = personal.idUsuario
        INNER JOIN
            cursogrado_personal
        ON 
            personal.idPersonal = cursogrado_personal.idPersonal
        INNER JOIN
            curso_grado
        ON 
            cursogrado_personal.idCursoGrado = curso_grado.idCursoGrado
        INNER JOIN
            curso
        ON 
            curso_grado.idCurso = curso.idCurso
        INNER JOIN
            grado
        ON 
            curso_grado.idGrado = grado.idGrado
        INNER JOIN
            alumno_anio_escolar
        ON 
            grado.idGrado = alumno_anio_escolar.idGrado
        INNER JOIN
            anio_escolar
        ON 
            alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
        WHERE
            usuario.idUsuario = :idUsuario AND
            anio_escolar.estadoAnio = 1	");

        $statement->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene el total de docentes y cursos por grado
    public static function mdlObtenerTotalDocenterCursosporGrado($tabla)
    {
        $statement = Connection::conn()->prepare("SELECT
    grado.descripcionGrado, 
    COUNT(DISTINCT curso.idCurso) AS cursos, 
    COUNT(DISTINCT personal.idPersonal) AS docentes
    FROM
    $tabla
    LEFT JOIN
    alumno_anio_escolar
    ON 
        grado.idGrado = alumno_anio_escolar.idGrado
    LEFT JOIN
    anio_escolar
    ON 
        alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar AND
        anio_escolar.estadoAnio = 1
    LEFT JOIN
    curso_grado
    ON 
        grado.idGrado = curso_grado.idGrado
    LEFT JOIN
    cursogrado_personal
    ON 
        curso_grado.idCursoGrado = cursogrado_personal.idCursoGrado
    LEFT JOIN
    personal
    ON 
        cursogrado_personal.idPersonal = personal.idPersonal
    LEFT JOIN
    curso
    ON 
        curso_grado.idCurso = curso.idCurso
    GROUP BY
    grado.descripcionGrado
    ORDER BY
    grado.idGrado ASC;");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene el nombre del docente y el curso
    public static function mdlObtenerNombreDocenteyCurso($tabla)
    {
        $statement = Connection::conn()->prepare("SELECT DISTINCT
    grado.descripcionGrado, 
    CONCAT(personal.nombrePersonal, ' ', personal.apellidoPersonal) AS docente, 
    curso.descripcionCurso
    FROM
        $tabla
        LEFT JOIN
        curso_grado
        ON 
            grado.idGrado = curso_grado.idGrado
        LEFT JOIN
        cursogrado_personal
        ON 
            curso_grado.idCursoGrado = cursogrado_personal.idCursoGrado
        LEFT JOIN
        personal
        ON 
            cursogrado_personal.idPersonal = personal.idPersonal
        LEFT JOIN
        curso
        ON 
            curso_grado.idCurso = curso.idCurso
        LEFT JOIN
        alumno_anio_escolar
        ON 
            grado.idGrado = alumno_anio_escolar.idGrado
        LEFT JOIN
        anio_escolar
        ON 
            alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar AND
            anio_escolar.estadoAnio = 1
    ORDER BY
        grado.idGrado ASC;");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene todos los docentes por tipo
    public static function mdlObtenerTodoslosDocentesporTipo($tabla)
    {
        $statement = Connection::conn()->prepare("SELECT
            REPLACE(tipo_personal.descripcionTipo, 'Docente', '') AS descripcionTipo,
            COUNT(personal.idTipoPersonal) AS total_docentes
        FROM
            $tabla
            INNER JOIN tipo_personal ON personal.idTipoPersonal = tipo_personal.idTipoPersonal
            INNER JOIN usuario ON personal.idUsuario = usuario.idUsuario
            INNER JOIN tipo_usuario ON usuario.idTipoUsuario = tipo_usuario.idTipoUsuario
        WHERE
            tipo_usuario.idTipoUsuario = 2
            AND usuario.estadoUsuario = 1
        GROUP BY
            REPLACE(tipo_personal.descripcionTipo, 'Docente', '')");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene el total de alumnos por grado
    public static function mdlObtenerTotalMasculinoFemeniniporGrados($tabla)
    {
        $statement = Connection::conn()->prepare("SELECT
	COUNT(CASE WHEN alumno.sexoAlumno = 'Masculino' THEN 1 END) AS total_masculinos,
	COUNT(CASE WHEN alumno.sexoAlumno = 'Femenino' THEN 1 END) AS total_femeninos,
	CONCAT(nivel.descripcionNivel, ' - ', grado.descripcionGrado) AS grado_nivel
FROM
	alumno
	INNER JOIN
	alumno_anio_escolar
	ON 
		alumno.idAlumno = alumno_anio_escolar.idAlumno
	INNER JOIN
	grado
	ON 
		alumno_anio_escolar.idGrado = grado.idGrado
	INNER JOIN
	anio_escolar
	ON 
		alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
	INNER JOIN
	admision_alumno
	ON 
		alumno.idAlumno = admision_alumno.idAlumno
	INNER JOIN
	nivel
	ON 
		grado.idNivel = nivel.idNivel
WHERE
	alumno.sexoAlumno IS NOT NULL AND
	anio_escolar.estadoAnio = 1 AND
	admision_alumno.estadoAdmisionAlumno = 2
GROUP BY
	grado_nivel
ORDER BY
	grado.idGrado ASC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene todos los alumnos nuevos y antiguos
    public static function mdlObtenerTodoslosAlumnosNuevosAntiguos($tabla)
    {
        $statement = Connection::conn()->prepare("SELECT DISTINCT
        CONCAT(nivel.descripcionNivel, ' - ', grado.descripcionGrado) AS grado_nivel, 
            COUNT(CASE WHEN alumno.nuevoAlumno = 1 THEN 1 ELSE NULL END) AS nuevos,
        COUNT(CASE WHEN alumno.nuevoAlumno = 0 THEN 1 ELSE NULL END) AS antiguos
        FROM
            $tabla
            INNER JOIN
            alumno
            ON 
                alumno_anio_escolar.idAlumno = alumno.idAlumno
            INNER JOIN
            admision_alumno
            ON 
                alumno.idAlumno = admision_alumno.idAlumno
            INNER JOIN
            grado
            ON 
                alumno_anio_escolar.idGrado = grado.idGrado
            INNER JOIN
            nivel
            ON 
                grado.idNivel = nivel.idNivel
        WHERE
            admision_alumno.estadoAdmisionAlumno = 2
        GROUP BY
        grado_nivel;");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene todos los pagos pendientes de los alumnos
    public static function mdlObtenerTodosPagosPendientesAlumnosApoderado($tabla, $idAlumno)
    {
    $statement = Connection::conn()->prepare("SELECT DISTINCT
        alumno.nombresAlumno, 
        cronograma_pago.conceptoPago, 
        cronograma_pago.montoPago, 
        cronograma_pago.fechaLimite, 
        cronograma_pago.mesPago, 
        CASE
            WHEN pago.fechaPago IS NOT NULL THEN 2  
            WHEN cronograma_pago.fechaLimite >= CURRENT_DATE THEN 1
            ELSE 0
        END AS estadoPago
        FROM
            alumno
        INNER JOIN
            alumno_anio_escolar
            ON alumno.idAlumno = alumno_anio_escolar.idAlumno
        INNER JOIN
            admision_alumno
            ON alumno.idAlumno = admision_alumno.idAlumno
        INNER JOIN
            cronograma_pago
            ON admision_alumno.idAdmisionAlumno = cronograma_pago.idAdmisionAlumno
        LEFT JOIN
            pago
            ON cronograma_pago.idCronogramaPago = pago.idCronogramaPago
        WHERE
            alumno.idAlumno =:idAlumno;");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene la fecha de pago del apoderado
    public static function mdlObtenerFechaPagoApoderado($tabla, $idAlumno){
        $statement = Connection::conn()->prepare("SELECT
        cronograma_pago.mesPago, 
        MIN(cronograma_pago.fechaLimite) AS proximaFechaPago
        FROM
            $tabla
            INNER JOIN
            admision_alumno
            ON 
                alumno.idAlumno = admision_alumno.idAlumno
            INNER JOIN
            cronograma_pago
            ON 
                admision_alumno.idAdmisionAlumno = cronograma_pago.idAdmisionAlumno
            LEFT JOIN
            pago
            ON 
                cronograma_pago.idCronogramaPago = pago.idCronogramaPago
            INNER JOIN
            alumno_anio_escolar
            ON 
                alumno.idAlumno = alumno_anio_escolar.idAlumno
            INNER JOIN
            anio_escolar
            ON 
                alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
        WHERE
            pago.fechaPago IS NULL AND
            alumno.idAlumno = :idAlumno AND
            cronograma_pago.fechaLimite >= CURRENT_DATE AND
            anio_escolar.estadoAnio = 1;");
        $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene el registro de asistencia del alumno
    public static function mdlObtenerRegistroAsitenciaAlumnoApoderado($tabla, $idAlumno){
        $statement = Connection::conn()->prepare("SELECT CASE 
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
        COUNT(DISTINCT CASE WHEN asistencia.estadoAsistencia = 'A' THEN asistencia.fechaAsistencia END) AS total_asistio,
        COUNT(DISTINCT CASE WHEN asistencia.estadoAsistencia = 'F' THEN asistencia.fechaAsistencia END) AS total_falto,
        COUNT(DISTINCT CASE WHEN asistencia.estadoAsistencia = 'T' THEN asistencia.fechaAsistencia END) AS total_inasistencia_injustificada,
        COUNT(DISTINCT CASE WHEN asistencia.estadoAsistencia = 'J' THEN asistencia.fechaAsistencia END) AS total_falta_justificada,
        COUNT(DISTINCT CASE WHEN asistencia.estadoAsistencia = 'U' THEN asistencia.fechaAsistencia END) AS total_tardanza_justificada,
        COUNT(DISTINCT asistencia.fechaAsistencia) AS total_registro
        FROM
            $tabla
            INNER JOIN
            alumno_anio_escolar
            ON 
                alumno.idAlumno = alumno_anio_escolar.idAlumno
            INNER JOIN
            asistencia
            ON 
                alumno_anio_escolar.idAlumnoAnioEscolar = asistencia.idAlumnoAnioEscolar
            INNER JOIN
            anio_escolar
            ON 
                alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
        WHERE
            alumno_anio_escolar.idAlumno = :idAlumno AND
            anio_escolar.estadoAnio = 1
            GROUP BY 
            MONTH(asistencia.fechaAsistencia)");
        $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene los detalles del alumno para la vista Apoderado
    public static function mdlObtenerDetallesAlumnoApoderado($tabla,$idAlumno){
    $statement = Connection::conn()->prepare("SELECT DISTINCT
    CONCAT(alumno.nombresAlumno, ' ', alumno.apellidosAlumno) AS nombre_completo,
	alumno.dniAlumno, 
	alumno.fechaNacimiento, 
	alumno.direccionAlumno, 
	alumno.fechaIngresoVolta, 
	grado.descripcionGrado, 
	nivel.descripcionNivel
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
        curso_grado
        ON 
            grado.idGrado = curso_grado.idGrado
        INNER JOIN
        curso
        ON 
            curso_grado.idCurso = curso.idCurso
    WHERE
        alumno.idAlumno = :idAlumno;");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
    }
    // Obtiene todos los cursos asignados al alumno
    public static function mdlObtenerTodoslosCursosAsignadosAlumno($tabla,$idAlumno){
    $statement = Connection::conn()->prepare("SELECT
	grado.descripcionGrado,
	COUNT(DISTINCT curso.idCurso) AS total_cursos
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
        curso_grado
        ON 
            grado.idGrado = curso_grado.idGrado
        INNER JOIN
        curso
        ON 
            curso_grado.idCurso = curso.idCurso
        INNER JOIN
        anio_escolar
        ON 
            alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
    WHERE
        alumno.idAlumno = :idAlumno AND
        anio_escolar.estadoAnio = 1 ");
        $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene todas las notas de los bimestres por curso
    public static function mdlObtenerTodasNotasBimestresporCursos($tabla, $idAlumno){
    $statement = Connection::conn()->prepare("SELECT
        curso.descripcionCurso, 
        bimestre.descripcionBimestre, 
        nota_bimestre.fechaCreacion, 
        nota_bimestre.notaBimestre AS nota
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
            curso_grado
            ON 
                grado.idGrado = curso_grado.idGrado
            RIGHT JOIN
            bimestre
            ON 
                curso_grado.idCursoGrado = bimestre.idCursoGrado
            LEFT JOIN
            nota_bimestre
            ON 
                alumno_anio_escolar.idAlumnoAnioEscolar = nota_bimestre.idAlumnoAnioEscolar AND
                bimestre.idBimestre = nota_bimestre.idBimestre
            INNER JOIN
            curso
            ON 
                curso_grado.idCurso = curso.idCurso
            INNER JOIN
            anio_escolar
            ON 
                alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
        WHERE
            alumno.idAlumno = :idAlumno AND
            anio_escolar.estadoAnio = 1
        GROUP BY
            bimestre.idBimestre");
        $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obtiene el porcentaje anual de la asistencia del alumno
    public static function mdlObtenerPorcentajesAnualAsistencia($tabla, $idAlumno){
    $statement = Connection::conn()->prepare("SELECT 
    'Total Anual' AS Mes,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'A' THEN 1 ELSE 0 END) * 100.0 / COUNT(DISTINCT asistencia.fechaAsistencia)) AS total_asistio,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'F' THEN 1 ELSE 0 END) * 100.0 / COUNT(DISTINCT asistencia.fechaAsistencia)) AS total_falto,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'T' THEN 1 ELSE 0 END) * 100.0 / COUNT(DISTINCT asistencia.fechaAsistencia)) AS total_inasistencia_injustificada,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'J' THEN 1 ELSE 0 END) * 100.0 / COUNT(DISTINCT asistencia.fechaAsistencia)) AS total_falta_justificada,
    (SUM(CASE WHEN asistencia.estadoAsistencia = 'U' THEN 1 ELSE 0 END) * 100.0 / COUNT(DISTINCT asistencia.fechaAsistencia)) AS total_tardanza_justificada,
	COUNT(DISTINCT asistencia.fechaAsistencia) AS total_registro
FROM
    alumno
    INNER JOIN alumno_anio_escolar ON alumno.idAlumno = alumno_anio_escolar.idAlumno
    INNER JOIN asistencia ON alumno_anio_escolar.idAlumnoAnioEscolar = asistencia.idAlumnoAnioEscolar
    INNER JOIN anio_escolar ON alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
WHERE
    alumno_anio_escolar.idAlumno = :idAlumno AND anio_escolar.estadoAnio = 1
    AND anio_escolar.estadoAnio = 1");
    $statement->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}
