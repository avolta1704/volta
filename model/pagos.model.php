<?php
require_once "connection.php";

class ModelPagos
{
  // Obtener todos los pagos
  public static function mdlGetAllPagos($tabla)
  {
    $statement = Connection::conn()->prepare("
      SELECT 
        p.idPago,
        p.idTipoPago,
        p.idCronogramaPago, 
        p.fechaPago, 
        p.cantidadPago, 
        p.metodoPago,
        p.moraPago,
        p.numeroComprobante,

        a.idAlumno,
        
        a.nombresAlumno,
        a.apellidosAlumno,
        a.dniAlumno,
        g.idGrado,
        g.idNivel,
        g.descripcionGrado,
        ag.idAlumno,

        ag.idGrado,

        aa.idAdmisionAlumno,
        aa.idAlumno,
        cp.idCronogramaPago,

        cp.idAdmisionAlumno,

        cp.estadoCronograma
      FROM pago p
      JOIN cronograma_pago cp ON p.idCronogramaPago = cp.idCronogramaPago
      JOIN admision_alumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
      JOIN alumno_grado ag ON aa.idAlumno = ag.idAlumno
      JOIN grado g ON ag.idGrado = g.idGrado
      JOIN alumno a ON aa.idAlumno = a.idAlumno
      ORDER BY p.idPago DESC
    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
  //  crear registro pago alumno
  public static function mdlCrearRegistroPagoAlumno($table, $dataPagoAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idTipoPago, idCronogramaPago, fechaPago, cantidadPago, metodoPago, numeroComprobante, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idTipoPago, :idCronogramaPago, :fechaPago, :cantidadPago, :metodoPago, :numeroComprobante, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion) ");
    $statement->bindParam(":idTipoPago", $dataPagoAlumno["idTipoPago"], PDO::PARAM_INT);
    $statement->bindParam(":idCronogramaPago", $dataPagoAlumno["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaPago", $dataPagoAlumno["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataPagoAlumno["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataPagoAlumno["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":numeroComprobante", $dataPagoAlumno["numeroComprobante"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataPagoAlumno["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataPagoAlumno["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataPagoAlumno["usuarioCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataPagoAlumno["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //editar Registro Pago
  public static function mdlEditarPagoAlumno($tabla, $dataEditPagoAlumno)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET fechaPago = :fechaPago, cantidadPago = :cantidadPago, metodoPago = :metodoPago, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idPago = :idPago");
    $statement->bindParam(":fechaPago", $dataEditPagoAlumno["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataEditPagoAlumno["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataEditPagoAlumno["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataEditPagoAlumno["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditPagoAlumno["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idPago", $dataEditPagoAlumno["idPago"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //  Eliminar registro de pago
  public static function mdlDeleteRegistroPago($tabla, $codPagoDelet)
  {
    $statement = Connection::conn()->prepare("DELETE FROM $tabla WHERE idPago = :idPago");
    $statement->bindParam(":idPago", $codPagoDelet, PDO::PARAM_INT);
    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //obtener id de cronograma_pago y estado por idPago 
  public static function mdlObtenerIdCronogramaPago($tabla, $codPago)
  {
    $statement = Connection::conn()->prepare("
        SELECT 
          cp.idCronogramaPago
        FROM $tabla p
        JOIN cronograma_pago cp ON p.idCronogramaPago = cp.idCronogramaPago
        WHERE p.idPago = :idPago
      ");
    $statement->bindParam(":idPago", $codPago, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //Actualizar estado de cronograma_pago despues de eliminar su registro en la tabla pago
  public static function mdlActualizarEstadoCronogramaDelete($table, $dataEditEstadoCrono)
  {
    $statement = Connection::conn()->prepare("UPDATE $table SET idCronogramaPago = :idCronogramaPago, estadoCronograma = :estadoCronograma, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idCronogramaPago = :idCronogramaPago");
    $statement->bindParam(":idCronogramaPago", $dataEditEstadoCrono["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":estadoCronograma", $dataEditEstadoCrono["estadoCronograma"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $dataEditEstadoCrono["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditEstadoCrono["usuarioActualizacion"], PDO::PARAM_STR);
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
    $statement->bindParam(":idCronogramaPago", $dataEditEstadoCrono["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":estadoCronograma", $dataEditEstadoCrono["estadoCronograma"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $dataEditEstadoCrono["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditEstadoCrono["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  // vista de pagos buscar alumno por el dni
  public static function mdlGetDataPagoCodAlumno($tabla, $codAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT 
    idAlumno,
    dniAlumno, 
    nombresAlumno,
    apellidosAlumno, 
    codAlumnoCaja
    FROM $tabla
    WHERE codAlumnoCaja = :codAlumnoCaja");
    $statement->bindParam(':codAlumnoCaja', $codAlumno, PDO::PARAM_INT);
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
  //datos de pago detalles de pago
  public static function mdlGetIdEditPago($tabla, $codPago)
  {
    $statement = Connection::conn()->prepare("
        SELECT 
          p.idPago,
          p.idTipoPago,
          p.idCronogramaPago, 
          p.fechaPago, 
          p.cantidadPago, 
          p.metodoPago,
          a.nombresAlumno,
          a.apellidosAlumno,
          a.dniAlumno,
          a.codAlumnoCaja,
          g.idNivel,
          g.descripcionGrado,
          cp.idCronogramaPago,
          cp.conceptoPago,
          cp.fechaLimite,
          cp.estadoCronograma,
          cp.mesPago
        FROM $tabla p
        JOIN cronograma_pago cp ON p.idCronogramaPago = cp.idCronogramaPago
        JOIN admision_alumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
        JOIN alumno_grado ag ON aa.idAlumno = ag.idAlumno
        JOIN grado g ON ag.idGrado = g.idGrado
        JOIN alumno a ON aa.idAlumno = a.idAlumno
        WHERE p.idPago = :idPago
      ");
    $statement->bindParam(":idPago", $codPago, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  //obtener id cronograma pago alumno mas reciente de pago por idAdmisionAlumno y año y mes del SUBPERIODO de xlsx si no encuantra valores iguales devovlera falso 
  public static function mdlIdCronogramaPagoMasReciente($table, $idAdmisionAlumno, $anio, $mes)
  {
    $statement = Connection::conn()->prepare("SELECT idCronogramaPago
      FROM $table 
      WHERE idAdmisionAlumno = :idAdmisionAlumno AND estadoCronograma = 1 AND conceptoPago != 'Matricula' AND mesPago = :mes AND YEAR(fechaLimite) = :anio
      ORDER BY idCronogramaPago DESC
      LIMIT 1");
    $statement->bindParam(":idAdmisionAlumno", $idAdmisionAlumno, PDO::PARAM_INT);
    $statement->bindParam(":anio", $anio, PDO::PARAM_INT);
    $statement->bindParam(":mes", $mes, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  //datos de xlsx para la creacion de registro de pagos
  public static function mdlCrearRegistroPagoXlsx($table, $dataCreateXlxs)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idTipoPago, idCronogramaPago, fechaPago, cantidadPago, metodoPago, moraPago, fechaCreacion, usuarioCreacion) VALUES (:idTipoPago, :idCronogramaPago, :fechaPago, :cantidadPago, :metodoPago, :moraPago, :fechaCreacion, :usuarioCreacion) ");
    $statement->bindParam(":idTipoPago", $dataCreateXlxs["idTipoPago"], PDO::PARAM_INT);
    $statement->bindParam(":idCronogramaPago", $dataCreateXlxs["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaPago", $dataCreateXlxs["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataCreateXlxs["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataCreateXlxs["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":moraPago", $dataCreateXlxs["moraPago"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataCreateXlxs["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataCreateXlxs["usuarioCreacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //funcion de carga de archivos xlsx formato 2 registro diario
  public static function mdlCrearRegistroPagoXlsxRegistro2($table, $dataCreateXlxs)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idTipoPago, idCronogramaPago, fechaPago, cantidadPago, metodoPago, numeroComprobante, moraPago, fechaCreacion, usuarioCreacion) VALUES (:idTipoPago, :idCronogramaPago, :fechaPago, :cantidadPago, :metodoPago, :numeroComprobante, :moraPago, :fechaCreacion, :usuarioCreacion) ");
    $statement->bindParam(":idTipoPago", $dataCreateXlxs["idTipoPago"], PDO::PARAM_INT);
    $statement->bindParam(":idCronogramaPago", $dataCreateXlxs["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaPago", $dataCreateXlxs["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataCreateXlxs["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataCreateXlxs["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":numeroComprobante", $dataCreateXlxs["numeroComprobante"], PDO::PARAM_STR);
    $statement->bindParam(":moraPago", $dataCreateXlxs["moraPago"], PDO::PARAM_STR);
    $statement->bindParam(":fechaCreacion", $dataCreateXlxs["fechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioCreacion", $dataCreateXlxs["usuarioCreacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //  actualizar estado de  cronograma_pago por el Xlxs  idCronogramaPago = $value["idCronogramaPago"] y tambien actualizar el monto de pago del xlsx
  public static function mdlEditarEstadoCronogramaXlsx($tabla, $dataEditEstadoCrono)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET idCronogramaPago = :idCronogramaPago, montoPago = :montoPago, estadoCronograma = :estadoCronograma, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idCronogramaPago = :idCronogramaPago");
    $statement->bindParam(":idCronogramaPago", $dataEditEstadoCrono["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":montoPago", $dataEditEstadoCrono["montoPago"], PDO::PARAM_STR);
    $statement->bindParam(":estadoCronograma", $dataEditEstadoCrono["estadoCronograma"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $dataEditEstadoCrono["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditEstadoCrono["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
  //editar cronograma de pagos de pago modal editar 
  public static function mdlEditarRegistroPagoModal($tabla, $dataEditCronoPagoModal)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET  montoPago = :montoPago, fechaLimite = :fechaLimite, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idCronogramaPago = :idCronogramaPago");
    $statement->bindParam(":montoPago", $dataEditCronoPagoModal["montoPago"], PDO::PARAM_STR);
    $statement->bindParam(":fechaLimite", $dataEditCronoPagoModal["fechaLimite"], PDO::PARAM_STR);
    $statement->bindParam(":fechaActualizacion", $dataEditCronoPagoModal["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $dataEditCronoPagoModal["usuarioActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":idCronogramaPago", $dataEditCronoPagoModal["idCronogramaPago"], PDO::PARAM_INT);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }
}
