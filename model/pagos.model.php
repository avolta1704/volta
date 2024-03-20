<?php
require_once "connection.php";

class ModelPagos
{
  // Obtener todos los pagos
  public static function mdlGetAllPagos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT 
    idPago,
    idAdmisionAlumno
    idTipoPago,
    idCronogramaPago, 
    fechaPago, 
    cantidadPago, 
    metodoPago,
    INER JOIN tipo_pago tp ON p.idTipoPago = tp.idTipoPago
    FROM tipo_pago p
    INNER JOIN alumno al ON p.idCronogramaPago = al.idCronogramaPago
    nombresAlumno
    apellidosAlumno
    INER JOIN cronograma_pago cp ON al.idCronogramaPago = cp.idCronogramaPago
    estadoCronograma
    FROM $tabla");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //  crear registro pago alumno
  public static function mdlCrearRegistroPagoAlumno($table, $dataPagoAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idTipoPago, idCronogramaPago, fechaPago, cantidadPago, metodoPago, fechaCreacion, usuarioCreacion) VALUES (:idTipoPago, :idCronogramaPago, :fechaPago, :cantidadPago, :metodoPago, :fechaCreacion, :usuarioCreacion) ");
    $statement->bindParam(":idTipoPago", $dataPagoAlumno["idTipoPago"], PDO::PARAM_INT);
    $statement->bindParam(":idCronogramaPago", $dataPagoAlumno["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaPago", $dataPagoAlumno["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataPagoAlumno["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataPagoAlumno["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataPagoAlumno["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataPagoAlumno["usuarioCreacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //  actualizar estado de  cronograma_pago por el  pago alumno idCronogramaPago = $_POST["cronogramaPago"]
  public static function mdlEditarEstadoCronograma($tabla, $dataEditEstadoCrono)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET idCronogramaPago = :idCronogramaPago, estadoCronograma = :estadoCronograma, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idCronogramaPago = :idCronogramaPago");
    $statement->bindParam(":idCronogramaPago", $dataEditEstadoCrono["idCronogramaPago"], PDO::PARAM_STR);
    $statement->bindParam(":estadoCronograma", $dataEditEstadoCrono["estadoCronograma"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataEditEstadoCrono["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditEstadoCrono["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // vista de pagos buscar alumno por el dni
  public static function mdlGetDataPagoDniAlumno($tabla, $dniAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT 
    idAlumno,
    dniAlumno, 
    nombresAlumno,
    apellidosAlumno, 
    codAlumnoCaja
    FROM $tabla
    WHERE dniAlumno = :dniAlumno");
    $statement->bindParam(':dniAlumno', $dniAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //obtener el grado alumno por id alumno 
  public static function mdlGetGetDataPagoAlumnoGrado($tabla, $idAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT g.idNivel, g.descripcionGrado
    FROM $tabla ag
    INNER JOIN grado g ON ag.idGrado = g.idGrado
    WHERE ag.idAlumno = :idAlumno");
    $statement->bindParam(':idAlumno', $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //obtener idAdmisionAlumno por id alumno 
  public static function mdlGetDataPagoAdmisionAlumno($tabla, $idAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT idAdmisionAlumno
    FROM $tabla
    WHERE idAlumno = :idAlumno");
    $statement->bindParam(':idAlumno', $idAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //obtener el cronograma pago del alumno por idAdmisionAlumno 
  public static function mdlDataPagoCronogramaPago($table, $idAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT conceptoPago, montoPago, fechaLimite, mesPago , estadoCronograma ,idCronogramaPago
      FROM $table WHERE idAdmisionAlumno = :idAdmisionAlumno");
    $statement->bindParam(":idAdmisionAlumno", $idAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //  Listar tipo pago para el select vista registrarPago
  public static function mdlGetAllTipoPago($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT 
    idTipoPago, 
    descripcionTipo
    FROM $tabla");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}