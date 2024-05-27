<?php
require_once "connection.php";

class ModelAdmisionAlumno
{
  //todos los registros de admision
  public static function mdlGetAdmisionAlumnos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT adal.idAdmisionAlumno, 
    al.idAlumno,
    al.codAlumnoCaja,
    al.apellidosAlumno,
    al.nombresAlumno, 
    ad.fechaAdmision,
    adal.estadoAdmisionAlumno
    FROM $tabla adal
    INNER JOIN admision ad ON adal.idAdmision = ad.idAdmision
    INNER JOIN alumno al ON adal.idAlumno = al.idAlumno
    ORDER BY adal.idAdmisionAlumno DESC");
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
    $statement = Connection::conn()->prepare("SELECT conceptoPago, montoPago, fechaLimite, estadoCronograma, mesPago, idCronogramaPago
      FROM $table WHERE idAdmisionAlumno = :idAdmisionAlumno");
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
    $tablaAlumnoGrado = "alumno_grado";
    $tablaGrado = "grado";
    $tablaNivel = "nivel";

    $statement = Connection::conn()->prepare("SELECT ng.descripcionNivel
      FROM $tabla aa
      INNER JOIN $tablaAlumnoGrado ag ON aa.idAlumno = ag.idAlumno
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
}
