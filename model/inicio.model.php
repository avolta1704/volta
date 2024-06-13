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
    return $statement->fetchAll();
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
    return $statement->fetchAll();
  }
}
