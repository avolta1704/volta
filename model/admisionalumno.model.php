<?php
require_once "connection.php";

class ModelAdmisionAlumno
{
  //todos los registros de admision
  public static function mdlGetAdmisionAlumnos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
      adal.idAdmisionAlumno, 
      al.idAlumno, 
      al.codAlumnoCaja, 
      al.apellidosAlumno, 
      al.nombresAlumno, 
      ad.fechaAdmision, 
      adal.estadoAdmisionAlumno, 
      admision.idAnioEscolar, 
      grado.descripcionGrado, 
      nivel.descripcionNivel
    FROM
      $tabla AS adal
      INNER JOIN
      admision AS ad
      ON 
        adal.idAdmision = ad.idAdmision
      INNER JOIN
      alumno AS al
      ON 
        adal.idAlumno = al.idAlumno
      INNER JOIN
      admision
      ON 
        adal.idAdmision = admision.idAdmision
      INNER JOIN
      alumno_anio_escolar
      ON 
        al.idAlumno = alumno_anio_escolar.idAlumno
      INNER JOIN
      grado
      ON 
        alumno_anio_escolar.idGrado = grado.idGrado
      INNER JOIN
      nivel
      ON 
        grado.idNivel = nivel.idNivel
    ORDER BY
	      adal.idAdmisionAlumno DESC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //Obtener el data de anio escolar para el cronograma de pago se obtiene solo el año activo que es de valor de estado 1
  public static function mdlGetDataAnioEscolar($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT cuotaInicial, matriculaInicial, pensionInicial, matriculaPrimaria, pensionPrimaria, matriculaSecundaria, pensionSecundaria
    FROM $tabla
    WHERE estadoAnio = 1");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  // Actualizar estado admision_alumno y crear registro en cronograma_pago 
  public static function mdlCrearCronogramaPago($tabla, $dataAdmisionCronoPago)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $tabla (idAdmisionAlumno, conceptoPago, montoPago, fechaLimite, estadoCronograma, mesPago, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idAdmisionAlumno, :conceptoPago, :montoPago, :fechaLimite, :estadoCronograma,:mesPago,:fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion)");
    $statement->bindParam(":idAdmisionAlumno", $dataAdmisionCronoPago["idAdmisionAlumno"], PDO::PARAM_INT);
    $statement->bindParam(":conceptoPago", $dataAdmisionCronoPago["conceptoPago"], PDO::PARAM_STR);
    $statement->bindParam(":montoPago", $dataAdmisionCronoPago["montoPago"], PDO::PARAM_STR);
    $statement->bindParam(":fechaLimite", $dataAdmisionCronoPago["fechaLimite"], PDO::PARAM_STR);
    $statement->bindParam(":estadoCronograma", $dataAdmisionCronoPago["estadoCronograma"], PDO::PARAM_INT);
    $statement->bindParam(":mesPago", $dataAdmisionCronoPago["mesPago"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataAdmisionCronoPago["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataAdmisionCronoPago["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataAdmisionCronoPago["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataAdmisionCronoPago["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // Actualizar estado admision_alumno
  public static function mdlActualizarestadoAdmisionAlumno($table, $data)
  {
    $statement = Connection::conn()->prepare("UPDATE $table SET estadoAdmisionAlumno = :estadoAdmisionAlumno, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idAdmisionAlumno = :idAdmisionAlumno");
    $statement->bindParam(":estadoAdmisionAlumno", $data["estadoAdmisionAlumno"], PDO::PARAM_INT);
    $statement->bindParam(":idAdmisionAlumno", $data["idAdmisionAlumno"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $data["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $data["usuarioActualizacion"], PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // ver calendario cronograma pago de la tabla  admision_alumno
  public static function mdlDataCronoPagoAdAlumEstado($table, $codAdAlumCalendario)
  {
    $statement = Connection::conn()->prepare("
      SELECT cp.conceptoPago, cp.montoPago, cp.fechaLimite, cp.estadoCronograma, cp.mesPago, cp.idCronogramaPago, p.fechaPago
      FROM $table cp
      LEFT JOIN pago p ON cp.idCronogramaPago = p.idCronogramaPago
      WHERE cp.idAdmisionAlumno = :idAdmisionAlumno
    ");
    $statement->bindParam(":idAdmisionAlumno", $codAdAlumCalendario, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //  Obtener el último admision_alumno creado
  public static function mdlObtenerUltimoAdmisionAlumno($table)
  {
    $statement = Connection::conn()->prepare("SELECT idAdmisionAlumno FROM $table ORDER BY idAdmisionAlumno DESC LIMIT 1");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  //  Obtener el calendario de pagos
  public static function mdlGetCalendarioPagos($table, $codAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT idCronogramaPago, conceptoPago, montoPago, fechaLimite, mesPago FROM $table WHERE idAdmisionAlumno = :idAdmisionAlumno AND estadoCronograma = 1");
    $statement->bindParam(":idAdmisionAlumno", $codAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Obtiene el código de admisión del alumno por admisión.
   *
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @param int $codAdmision El código de admisión.
   * @return int El código de admisión del alumno.
   */
  public static function mdlGetCodAdmisionAlumnoByAdmision($tabla, $codAdmision)
  {
    $statement = Connection::conn()->prepare("SELECT idAdmisionAlumno FROM $tabla WHERE idAdmision = :idAdmision");
    $statement->bindParam(":idAdmision", $codAdmision, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }

  /**
   * Obtiene el código del cronograma de matrícula por código de admisión del alumno.
   *
   * @param string $tabla La tabla en la que se realizará la consulta.
   * @param int $codAdmisionAlumno El código de admisión del alumno.
   * @return mixed El código del cronograma de matrícula o null si no se encuentra.
   */
  public static function mdlGetCodeCronogramaMatriculaByCodAdmisionAlumno($tabla, $codAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT idCronogramaPago FROM $tabla WHERE idAdmisionAlumno = :idAdmisionAlumno AND LOWER(conceptoPago) = 'matrícula'");
    $statement->bindParam(":idAdmisionAlumno", $codAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }

  /**
   * Obtiene el código del cronograma de cuota inicial por código de admisión del alumno.
   *
   * @param string $tabla La tabla en la que se realizará la consulta.
   * @param int $codAdmisionAlumno El código de admisión del alumno.
   * @return mixed El código del cronograma de pensión o null si no se encuentra.
   */

  public static function mdlGetCodeCronogramaCuotaInicialByCodAdmisionAlumno($tabla, $codAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT idCronogramaPago FROM $tabla WHERE idAdmisionAlumno = :idAdmisionAlumno AND LOWER(conceptoPago) = 'cuota inicial'");
    $statement->bindParam(":idAdmisionAlumno", $codAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }

  /**
   * Obtiene el idNivel de un alumno por su código de admision.
   * 
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @param int $codAdmision El código de admisión.
   * @return int El idNivel del alumno.
   */
  public static function mdlGetIdNivelByCodAdmisionAlumno($tabla, $codAdmisionAlumno)
  {
    $tablaAlumnoAnioEscolar = "alumno_anio_escolar";
    $tablaGrado = "grado";
    $tablaNivel = "nivel";

    $statement = Connection::conn()->prepare("SELECT ng.descripcionNivel
      FROM $tabla aa
      INNER JOIN $tablaAlumnoAnioEscolar ag ON aa.idAlumno = ag.idAlumno
      INNER JOIN $tablaGrado g ON ag.idGrado = g.idGrado
      INNER JOIN $tablaNivel ng ON g.idNivel = ng.idNivel
      WHERE aa.idAdmisionAlumno = :idAdmisionAlumno");
    $statement->bindParam(":idAdmisionAlumno", $codAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }

  /**
   * Obtiene el idPostulante de un alumno por su código de admision.
   * 
   * @param string $tabla El nombre de la tabla en la base de datos.
   * @param int $codAdmision El código de admisión.
   * @return int El idPostulante del alumno.
   */
  public static function mdlGetIdPostulanteByCodAdmisionAlumno($tabla, $codAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT idPostulante FROM admision WHERE idAdmision = (SELECT idAdmision FROM $tabla WHERE idAdmisionAlumno = :idAdmisionAlumno)");
    $statement->bindParam(":idAdmisionAlumno", $codAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn();
  }

  /**
   * Modelo para obtener todos los alumnos de un año escolar
   * 
   * @param string $tabla nombre de la tabla
   * @param int $idAnioEscolar id del año escolar
   */
  public static function mdlGetAdmisionAlumnosAnioEscolar($tabla, $idAnioEscolar)
  {
    $statement = Connection::conn()->prepare("SELECT
      adal.idAdmisionAlumno, 
      al.idAlumno, 
      al.codAlumnoCaja, 
      al.apellidosAlumno, 
      al.nombresAlumno, 
      ad.fechaAdmision, 
      adal.estadoAdmisionAlumno, 
      admision.idAnioEscolar, 
      grado.descripcionGrado, 
      nivel.descripcionNivel
    FROM
      $tabla AS adal
      INNER JOIN
      admision AS ad
      ON 
        adal.idAdmision = ad.idAdmision
      INNER JOIN
      alumno AS al
      ON 
        adal.idAlumno = al.idAlumno
      INNER JOIN
      admision
      ON 
        adal.idAdmision = admision.idAdmision
      INNER JOIN
      alumno_anio_escolar
      ON 
        al.idAlumno = alumno_anio_escolar.idAlumno
      INNER JOIN
      grado
      ON 
        alumno_anio_escolar.idGrado = grado.idGrado
      INNER JOIN
      nivel
      ON 
        grado.idNivel = nivel.idNivel
      WHERE ad.idAnioEscolar = :idAnioEscolar
    ORDER BY
      adal.idAdmisionAlumno DESC");
    $statement->bindParam(":idAnioEscolar", $idAnioEscolar, PDO::PARAM_INT);
    if ($statement->execute()) {
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return "error";
    }
  }
  // Función para obtener el numero de matriculados, translado y retirados
  public static function mdlObtenerAlumnosPorTipoReportes($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    CASE 
        WHEN grado.descripcionGrado = '3 Años' THEN 'INIC 03 A'
        WHEN grado.descripcionGrado = '4 Años' THEN 'INIC 04 A'
        WHEN grado.descripcionGrado = '5 Años' THEN 'INIC 05 A'
        WHEN grado.descripcionGrado = '1er Grado' THEN 'PRIM 01 A'
        WHEN grado.descripcionGrado = '2do Grado' THEN 'PRIM 02 A'
        WHEN grado.descripcionGrado = '3er Grado' THEN 'PRIM 03 A'
        WHEN grado.descripcionGrado = '4to Grado' THEN 'PRIM 04 A'
        WHEN grado.descripcionGrado = '5to Grado' THEN 'PRIM 05 A'
        WHEN grado.descripcionGrado = '6to Grado' THEN 'PRIM 06 A'
        WHEN grado.descripcionGrado = '1er Año' THEN 'SECUN 01 A'
        WHEN grado.descripcionGrado = '2do Año' THEN 'SECUN 02 A'
        WHEN grado.descripcionGrado = '3er Año' THEN 'SECUN 03 A'
        WHEN grado.descripcionGrado = '4to Año' THEN 'SECUN 04 A'
        WHEN grado.descripcionGrado = '5to Año' THEN 'SECUN 05 A'
        ELSE grado.descripcionGrado
      END AS descripcionGrado,
      COALESCE(SUM(CASE WHEN ae.estadoAnio = 1 AND admision_alumno.estadoAdmisionAlumno = 2 AND admision.idAnioEscolar = ae.idAnioEscolar THEN 1 ELSE 0 END), 0) AS matriculados,
      COALESCE(SUM(CASE WHEN ae.estadoAnio = 1 AND admision_alumno.estadoAdmisionAlumno = 3 AND admision.idAnioEscolar = ae.idAnioEscolar THEN 1 ELSE 0 END), 0) AS trasladados,
      COALESCE(SUM(CASE WHEN ae.estadoAnio = 1 AND admision_alumno.estadoAdmisionAlumno = 4 AND admision.idAnioEscolar = ae.idAnioEscolar  THEN 1 ELSE 0 END), 0) AS retirados,
      COUNT(DISTINCT CASE WHEN ae.estadoAnio = 1 AND admision.idAnioEscolar = ae.idAnioEscolar THEN alumno.idAlumno END) AS total_alumnos
      FROM
          $tabla
      LEFT JOIN alumno_anio_escolar ON grado.idGrado = alumno_anio_escolar.idGrado
      LEFT JOIN alumno ON alumno_anio_escolar.idAlumno = alumno.idAlumno
      LEFT JOIN admision_alumno ON admision_alumno.idAlumno = alumno.idAlumno
      LEFT JOIN admision ON admision_alumno.idAdmision = admision.idAdmision
      LEFT JOIN anio_escolar ae ON alumno_anio_escolar.idAnioEscolar = ae.idAnioEscolar
      GROUP BY
          grado.descripcionGrado
      ORDER BY
          grado.idGrado ASC");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Función para obtener el total de matriculados, translado y retirados
  public static function mdlObtenerTotalMatriculadosTrasladadosRetirados($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    SUM(CASE WHEN admision_alumno.estadoAdmisionAlumno = 2 AND anio_escolar.estadoAnio = 1 AND admision.idAnioEscolar = anio_escolar.idAnioEscolar THEN 1 ELSE 0 END) AS matriculados,
    SUM(CASE WHEN admision_alumno.estadoAdmisionAlumno = 3 AND anio_escolar.estadoAnio = 1 AND admision.idAnioEscolar = anio_escolar.idAnioEscolar THEN 1 ELSE 0 END) AS trasladados,
    SUM(CASE WHEN admision_alumno.estadoAdmisionAlumno = 4 AND anio_escolar.estadoAnio = 1 AND admision.idAnioEscolar = anio_escolar.idAnioEscolar THEN 1 ELSE 0 END) AS retirados
    FROM
      $tabla
      INNER JOIN
      alumno
      ON 
        admision_alumno.idAlumno = alumno.idAlumno
      INNER JOIN admision ON admision_alumno.idAdmision = admision.idAdmision
      INNER JOIN
      alumno_anio_escolar
      ON 
        alumno.idAlumno = alumno_anio_escolar.idAlumno
      INNER JOIN
      anio_escolar
      ON 
        alumno_anio_escolar.idAnioEscolar = anio_escolar.idAnioEscolar
    WHERE
      anio_escolar.estadoAnio = 1");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Obtener todos los datos para descargar en el excel de registros de matriculados
  public static function mdlObtenerTodoslosDatosAlumnosApoderadosRegistroExcel($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
      CONCAT(a.nombresAlumno, ' ', a.apellidosAlumno) AS Alumno,
      CONCAT(n.descripcionNivel, ' ', g.descripcionGrado) AS Nivel,
      a.nuevoAlumno AS 'Status',
      a.sexoAlumno AS Sexo,
      a.dniAlumno AS DNI,
      a.fechaNacimiento AS 'F. Nac.',
      a.direccionAlumno AS Dirección,
      a.distritoAlumno AS Distrito,
      a.IEPProcedencia AS 'IEP Procedencia',
      a.seguroSalud AS 'Seguro Salud',
      a.fechaIngresoVolta AS 'Ingreso AV',
      CONCAT(ap1.nombreApoderado, ' ', ap1.apellidoApoderado) AS Padre,
      ap1.dniApoderado AS 'DNI Padre',
      ap1.celularApoderado AS 'Telef. 01',
      ap1.convivenciaAlumno AS 'Vive C/ Estudiante Padre',
      ap1.correoApoderado AS 'Email Padre',
      CONCAT(ap2.nombreApoderado, ' ', ap2.apellidoApoderado) AS 'Madre',
      ap2.dniApoderado AS 'DNI Madre',
      ap2.celularApoderado AS 'Telef. 02',
      ap2.convivenciaAlumno AS 'Vive C/ Estudiante Madre',
      ap2.correoApoderado AS 'Email Madre',
      a.numeroEmergencia AS 'Telf. Emergencia',
      a.enfermedades AS 'Enfermedad',
      aa.estadoAdmisionAlumno AS 'Matric.',
      aa.fechaCreacion AS 'Fecha Matric.',
      MAX(CASE WHEN cp.mesPago = 'Matricula' THEN cp.montoPago ELSE NULL END) AS 'Monto Matric.',
      MAX(CASE WHEN cp.mesPago = 'Matricula' THEN p.numeroComprobante ELSE NULL END) AS 'Recibo Matric.',
      MAX(CASE WHEN cp.mesPago = 'Cuota Inicial' THEN cp.montoPago ELSE NULL END) AS 'Cuota Ingreso',
      MAX(CASE WHEN cp.mesPago = 'Cuota Inicial' THEN p.numeroComprobante ELSE NULL END) AS 'Recibo Admision',
      MAX(CASE WHEN cp.mesPago NOT IN ('Matricula', 'Cuota Inicial') THEN cp.montoPago ELSE 0 END) AS 'Monto Pension',
      a.estadoSiagie AS 'Estado SIAGIE'
      FROM
          $tabla a
          LEFT JOIN alumno_anio_escolar ae ON a.idAlumno = ae.idAlumno
          LEFT JOIN grado g ON ae.idGrado = g.idGrado
          LEFT JOIN nivel n ON g.idNivel = n.idNivel
          LEFT JOIN admision_alumno aa ON a.idAlumno = aa.idAlumno
          LEFT JOIN admision ON aa.idAdmision = admision.idAdmision
          LEFT JOIN cronograma_pago cp ON aa.idAdmisionAlumno = cp.idAdmisionAlumno
          LEFT JOIN pago p ON cp.idCronogramaPago = p.idCronogramaPago
          LEFT JOIN anio_escolar ae2 ON ae.idAnioEscolar = ae2.idAnioEscolar
          LEFT JOIN (
              SELECT
                  aa1.idAlumno,
                  ap1.nombreApoderado,
                  ap1.apellidoApoderado,
                  ap1.dniApoderado,
                  ap1.celularApoderado,
                  ap1.convivenciaAlumno,
                  ap1.correoApoderado,
                  ROW_NUMBER() OVER (PARTITION BY aa1.idAlumno ORDER BY aa1.idApoderado) AS ordenApoderado
              FROM
                  apoderado_alumno aa1
                  INNER JOIN apoderado ap1 ON aa1.idApoderado = ap1.idApoderado
          ) ap1 ON a.idAlumno = ap1.idAlumno AND ap1.ordenApoderado = 1
          LEFT JOIN (
              SELECT
                  aa2.idAlumno,
                  ap2.nombreApoderado,
                  ap2.apellidoApoderado,
                  ap2.dniApoderado,
                  ap2.celularApoderado,
                  ap2.convivenciaAlumno,
                  ap2.correoApoderado,
                  ROW_NUMBER() OVER (PARTITION BY aa2.idAlumno ORDER BY aa2.idApoderado) AS ordenApoderado
              FROM
                  apoderado_alumno aa2
                  INNER JOIN apoderado ap2 ON aa2.idApoderado = ap2.idApoderado
          ) ap2 ON a.idAlumno = ap2.idAlumno AND ap2.ordenApoderado = 2
      WHERE aa.estadoAdmisionAlumno = 2 AND ae.idAnioEscolar = 1 AND AND admision.idAnioEscolar = ae2.idAnioEscolar
      GROUP BY
          a.idAlumno, n.descripcionNivel, g.descripcionGrado, a.nombresAlumno, a.apellidosAlumno, a.nuevoAlumno, a.sexoAlumno, a.dniAlumno, a.fechaNacimiento, a.direccionAlumno, a.distritoAlumno, a.IEPProcedencia, a.seguroSalud, a.fechaIngresoVolta, ap1.nombreApoderado, ap1.apellidoApoderado, ap1.dniApoderado, ap1.celularApoderado, ap1.convivenciaAlumno, ap1.correoApoderado, ap2.nombreApoderado, ap2.apellidoApoderado, ap2.dniApoderado, ap2.celularApoderado, ap2.convivenciaAlumno, ap2.correoApoderado, a.numeroEmergencia, a.enfermedades, aa.estadoAdmisionAlumno, aa.fechaCreacion, a.estadoSiagie");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Obtener todos los datos para descargar en el excel de registros de matriculados por año escolar
  public static function mdlObtenerTodoslosDatosAlumnosApoderadosRegistroExcelAnioEscolar($tabla, $idAnioEscolar)
  {
    $statement = Connection::conn()->prepare("SELECT
        CONCAT(a.nombresAlumno, ' ', a.apellidosAlumno) AS Alumno,
        CONCAT(n.descripcionNivel, ' ', g.descripcionGrado) AS Nivel,
        a.nuevoAlumno AS 'Status',
        a.sexoAlumno AS Sexo,
        a.dniAlumno AS DNI,
        a.fechaNacimiento AS 'F. Nac.',
        a.direccionAlumno AS Dirección,
        a.distritoAlumno AS Distrito,
        a.IEPProcedencia AS 'IEP Procedencia',
        a.seguroSalud AS 'Seguro Salud',
        a.fechaIngresoVolta AS 'Ingreso AV',
        CONCAT(ap1.nombreApoderado, ' ', ap1.apellidoApoderado) AS Padre,
        ap1.dniApoderado AS 'DNI Padre',
        ap1.celularApoderado AS 'Telef. 01',
        ap1.convivenciaAlumno AS 'Vive C/ Estudiante Padre',
        ap1.correoApoderado AS 'Email Padre',
        CONCAT(ap2.nombreApoderado, ' ', ap2.apellidoApoderado) AS 'Madre',
        ap2.dniApoderado AS 'DNI Madre',
        ap2.celularApoderado AS 'Telef. 02',
        ap2.convivenciaAlumno AS 'Vive C/ Estudiante Madre',
        ap2.correoApoderado AS 'Email Madre',
        a.numeroEmergencia AS 'Telf. Emergencia',
        a.enfermedades AS 'Enfermedad',
        aa.estadoAdmisionAlumno AS 'Matric.',
        aa.fechaCreacion AS 'Fecha Matric.',
        MAX(CASE WHEN cp.mesPago = 'Matricula' THEN cp.montoPago ELSE NULL END) AS 'Monto Matric.',
        MAX(CASE WHEN cp.mesPago = 'Matricula' THEN p.numeroComprobante ELSE NULL END) AS 'Recibo Matric.',
        MAX(CASE WHEN cp.mesPago = 'Cuota Inicial' THEN cp.montoPago ELSE NULL END) AS 'Cuota Ingreso',
        MAX(CASE WHEN cp.mesPago = 'Cuota Inicial' THEN p.numeroComprobante ELSE NULL END) AS 'Recibo Admision',
        MAX(CASE WHEN cp.mesPago NOT IN ('Matricula', 'Cuota Inicial') THEN cp.montoPago ELSE 0 END) AS 'Monto Pension',
        a.estadoSiagie AS 'Estado SIAGIE'
        FROM
            $tabla a
            LEFT JOIN alumno_anio_escolar ae ON a.idAlumno = ae.idAlumno
            LEFT JOIN grado g ON ae.idGrado = g.idGrado
            LEFT JOIN nivel n ON g.idNivel = n.idNivel
            LEFT JOIN admision_alumno aa ON a.idAlumno = aa.idAlumno
            LEFT JOIN cronograma_pago cp ON aa.idAdmisionAlumno = cp.idAdmisionAlumno
            LEFT JOIN pago p ON cp.idCronogramaPago = p.idCronogramaPago
            LEFT JOIN anio_escolar ae2 ON ae.idAnioEscolar = ae2.idAnioEscolar
            LEFT JOIN (
                SELECT
                    aa1.idAlumno,
                    ap1.nombreApoderado,
                    ap1.apellidoApoderado,
                    ap1.dniApoderado,
                    ap1.celularApoderado,
                    ap1.convivenciaAlumno,
                    ap1.correoApoderado,
                    ROW_NUMBER() OVER (PARTITION BY aa1.idAlumno ORDER BY aa1.idApoderado) AS ordenApoderado
                FROM
                    apoderado_alumno aa1
                    INNER JOIN apoderado ap1 ON aa1.idApoderado = ap1.idApoderado
            ) ap1 ON a.idAlumno = ap1.idAlumno AND ap1.ordenApoderado = 1
            LEFT JOIN (
                SELECT
                    aa2.idAlumno,
                    ap2.nombreApoderado,
                    ap2.apellidoApoderado,
                    ap2.dniApoderado,
                    ap2.celularApoderado,
                    ap2.convivenciaAlumno,
                    ap2.correoApoderado,
                    ROW_NUMBER() OVER (PARTITION BY aa2.idAlumno ORDER BY aa2.idApoderado) AS ordenApoderado
                FROM
                    apoderado_alumno aa2
                    INNER JOIN apoderado ap2 ON aa2.idApoderado = ap2.idApoderado
            ) ap2 ON a.idAlumno = ap2.idAlumno AND ap2.ordenApoderado = 2
        WHERE aa.estadoAdmisionAlumno = 2 AND ae.idAnioEscolar = :idAnioEscolar
        GROUP BY
            a.idAlumno, n.descripcionNivel, g.descripcionGrado, a.nombresAlumno, a.apellidosAlumno, a.nuevoAlumno, a.sexoAlumno, a.dniAlumno, a.fechaNacimiento, a.direccionAlumno, a.distritoAlumno, a.IEPProcedencia, a.seguroSalud, a.fechaIngresoVolta, ap1.nombreApoderado, ap1.apellidoApoderado, ap1.dniApoderado, ap1.celularApoderado, ap1.convivenciaAlumno, ap1.correoApoderado, ap2.nombreApoderado, ap2.apellidoApoderado, ap2.dniApoderado, ap2.celularApoderado, ap2.convivenciaAlumno, ap2.correoApoderado, a.numeroEmergencia, a.enfermedades, aa.estadoAdmisionAlumno, aa.fechaCreacion, a.estadoSiagie");
    $statement->bindParam(":idAnioEscolar", $idAnioEscolar, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  // Obtener todos los datos para registrar pago del alumno de un nuevo anio
  public static function mdlObtenerDatosAdmisionAlumnoRegistrarPago($tabla, $idAdmisionAlumno, $idAnioEscolar)
  {
    $statement = Connection::conn()->prepare("SELECT
      alumno.nombresAlumno, 
      alumno.apellidosAlumno, 
      grado.descripcionGrado,
      nivel.idNivel,
      nivel.descripcionNivel, 
      alumno_anio_escolar.idAnioEscolar, 
      alumno.dniAlumno
    FROM
      $tabla
      INNER JOIN
      alumno
      ON 
        admision_alumno.idAlumno = alumno.idAlumno
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
    WHERE
      admision_alumno.idAdmisionAlumno = :idAdmisionAlumno AND alumno_anio_escolar.idAnioEscolar = :idAnioEscolar");
    $statement->bindParam(":idAdmisionAlumno", $idAdmisionAlumno, PDO::PARAM_INT);
    $statement->bindParam(":idAnioEscolar", $idAnioEscolar, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
}
