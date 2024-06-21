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

        cp.estadoCronograma,
        cp.conceptoPago,
        cp.mesPago,
        n.descripcionNivel
      FROM pago p
      JOIN cronograma_pago cp ON p.idCronogramaPago = cp.idCronogramaPago
      JOIN admision_alumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
      JOIN alumno_anio_escolar ag ON aa.idAlumno = ag.idAlumno
      JOIN grado g ON ag.idGrado = g.idGrado
      JOIN nivel n ON g.idNivel = n.idNivel
      JOIN alumno a ON aa.idAlumno = a.idAlumno
      ORDER BY p.idPago DESC
    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }


  /**
   * Obtener todos los pagos 
   * 
   * 
   */
  public static function mdlTodosLosPagos($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT 
        p.idPago,
        p.idTipoPago,
        p.idCronogramaPago, 
        p.fechaPago, 
        p.cantidadPago, 
        p.metodoPago,
        p.moraPago,
        p.numeroComprobante,
        p.boletaElectronica,

        a.idAlumno,
        a.codAlumnoCaja,
        
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

        cp.estadoCronograma,
        cp.conceptoPago,
        cp.mesPago,
        n.descripcionNivel,
        ae.descripcionAnio
        
      FROM pago p
      INNER JOIN cronograma_pago cp ON p.idCronogramaPago = cp.idCronogramaPago
      INNER JOIN admision_alumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
      INNER JOIN alumno_anio_escolar ag ON aa.idAlumno = ag.idAlumno
      INNER JOIN grado g ON ag.idGrado = g.idGrado
      INNER JOIN nivel n ON g.idNivel = n.idNivel
      INNER JOIN alumno a ON aa.idAlumno = a.idAlumno
      INNER JOIN tipo_pago tp ON tp.idTipoPago = p.idTipoPago
      INNER JOIN anio_escolar ae ON ag.idAnioEscolar = ae.idAnioEscolar
      WHERE tp.descripcionTipo = 'Pago Pensión' AND ae.estadoAnio = 1
      ORDER BY p.idPago DESC
    ");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Obtener todos los pagos de un año escolar
   * 
   * @param string $tabla Nombre de la tabla en la base de datos.
   * @param int $idAnioEscolar Identificador del año escolar.
   * @return array Arreglo con los pagos de un año escolar o "error".
   */
  public static function mdlGetPagosAnioEscolar($tabla, $idAnioEscolar)
  {
    $statement = Connection::conn()->prepare("SELECT 
        p.idPago,
        p.idTipoPago,
        p.idCronogramaPago, 
        p.fechaPago, 
        p.cantidadPago, 
        p.metodoPago,
        p.moraPago,
        p.numeroComprobante,
        p.boletaElectronica,

        a.idAlumno,
        a.codAlumnoCaja,
        
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

        cp.estadoCronograma,
        cp.conceptoPago,
        cp.mesPago,
        n.descripcionNivel,
        ae.descripcionAnio
        
      FROM $tabla p
      INNER JOIN cronograma_pago cp ON p.idCronogramaPago = cp.idCronogramaPago
      INNER JOIN admision_alumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
      INNER JOIN alumno_anio_escolar ag ON aa.idAlumno = ag.idAlumno
      INNER JOIN grado g ON ag.idGrado = g.idGrado
      INNER JOIN nivel n ON g.idNivel = n.idNivel
      INNER JOIN alumno a ON aa.idAlumno = a.idAlumno
      INNER JOIN tipo_pago tp ON tp.idTipoPago = p.idTipoPago
      INNER JOIN anio_escolar ae ON ag.idAnioEscolar = ae.idAnioEscolar
      WHERE tp.descripcionTipo = 'Pago Pensión' AND ae.idAnioEscolar = :idAnioEscolar
      ORDER BY p.idPago DESC
    ");
    $statement->bindParam(":idAnioEscolar", $idAnioEscolar, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  //  crear registro pago alumno
  public static function mdlCrearRegistroPagoAlumno($table, $dataPagoAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idTipoPago, idCronogramaPago, fechaPago, cantidadPago, metodoPago, numeroComprobante, boletaElectronica, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idTipoPago, :idCronogramaPago, :fechaPago, :cantidadPago, :metodoPago, :numeroComprobante, :boletaElectronica, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion) ");
    $statement->bindParam(":idTipoPago", $dataPagoAlumno["idTipoPago"], PDO::PARAM_INT);
    $statement->bindParam(":idCronogramaPago", $dataPagoAlumno["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaPago", $dataPagoAlumno["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataPagoAlumno["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataPagoAlumno["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":numeroComprobante", $dataPagoAlumno["numeroComprobante"], PDO::PARAM_STR);
    $statement->bindParam(":boletaElectronica", $dataPagoAlumno["boletaElectronica"], PDO::PARAM_STR);
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
    $statement = Connection::conn()->prepare("UPDATE $tabla SET fechaPago = :fechaPago, cantidadPago = :cantidadPago, metodoPago = :metodoPago, numeroComprobante = :numeroComprabante ,boletaElectronica = :boletaElectronica, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idPago = :idPago");
    $statement->bindParam(":fechaPago", $dataEditPagoAlumno["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataEditPagoAlumno["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataEditPagoAlumno["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":numeroComprabante", $dataEditPagoAlumno["numeroComprobante"], PDO::PARAM_STR);
    $statement->bindParam(":boletaElectronica", $dataEditPagoAlumno["boletaElectronica"], PDO::PARAM_STR);
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

  //  Eliminar pago de matricula de la tabla postulante
  public static function mdlDeletePagoMatricula($codPagoDelet)
  {
    $statement = Connection::conn()->prepare("UPDATE postulante SET pagoMatricula = NULL WHERE pagoMatricula = :idPago;");
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
          p.numeroComprobante,
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
          cp.mesPago,
          p.boletaElectronica
        FROM $tabla p
        JOIN cronograma_pago cp ON p.idCronogramaPago = cp.idCronogramaPago
        JOIN admision_alumno aa ON cp.idAdmisionAlumno = aa.idAdmisionAlumno
        JOIN alumno_anio_escolar ag ON aa.idAlumno = ag.idAlumno
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

  //  obtener datos de pago
  public static function mdlGetIdTipoPago($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    idTipoPago,
    descripcionTipo
    FROM $tabla WHERE descripcionTipo = 'Pago Matrícula' ");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Obtener idTipo pago cuota inicial por descripcionTipo
   * 
   * @param string $tabla
   */
  public static function mdlGetIdTipoPagoCuotaInicial($tabla)
  {
    $statement = Connection::conn()->prepare("SELECT
    idTipoPago
    FROM $tabla WHERE descripcionTipo = 'Pago Cuota Inicial'");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Obtiene un pago por su ID.
   *
   * @param int $idPago El ID del pago a obtener.
   * @return array|false Los datos del pago como un array asociativo, o false si no se encuentra el pago.
   */
  public static function mdlGetPagoById($idPago)
  {
    $statement = Connection::conn()->prepare("SELECT * FROM pago WHERE idPago = :idPago");
    $statement->bindParam(":idPago", $idPago, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }


  /**
   * Crea un nuevo registro de pago de matrícula en la base de datos.
   *
   * @param string $table El nombre de la tabla en la que se insertará el registro.
   * @param array $dataPagoAlumno Los datos del pago del alumno.
   * @return mixed Retorna el registro insertado si la ejecución es exitosa, de lo contrario retorna "error".
   */
  public static function mdlCrearRegistroPagoMatricula($table, $dataPagoAlumno)
  {
    $statement = Connection::conn()->prepare("INSERT INTO $table (idTipoPago,  fechaPago, cantidadPago, metodoPago, numeroComprobante, boletaElectronica, fechaCreacion, fechaActualizacion, usuarioCreacion, usuarioActualizacion) VALUES (:idTipoPago, :fechaPago, :cantidadPago, :metodoPago, :numeroComprobante, :boletaElectronica, :fechaCreacion, :fechaActualizacion, :usuarioCreacion, :usuarioActualizacion) ");
    $statement->bindParam(":idTipoPago", $dataPagoAlumno["idTipoPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaPago", $dataPagoAlumno["fechaPago"], PDO::PARAM_STR);
    $statement->bindParam(":cantidadPago", $dataPagoAlumno["cantidadPago"], PDO::PARAM_STR);
    $statement->bindParam(":metodoPago", $dataPagoAlumno["metodoPago"], PDO::PARAM_STR);
    $statement->bindParam(":numeroComprobante", $dataPagoAlumno["numeroComprobante"], PDO::PARAM_STR);
    $statement->bindParam(":boletaElectronica", $dataPagoAlumno["boletaElectronica"], PDO::PARAM_STR);
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

  /**
   * Obtiene el último pago de una tabla específica.
   *
   * @param string $table El nombre de la tabla.
   * @return array|null Los datos del último pago como un array asociativo, o null si no hay pagos.
   */
  public static function mldGetUltimoPago($table)
  {
    $statement = Connection::conn()->prepare("SELECT idPago, fechaPago FROM $table ORDER BY idPago DESC LIMIT 1");
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Actualiza el ID del cronograma de pago de una matrícula en la tabla especificada.
   *
   * @param string $tabla El nombre de la tabla en la que se realizará la actualización.
   * @param array $dataPago Los datos del pago a actualizar, incluyendo el ID del pago, el ID del cronograma de pago, la fecha de actualización y el usuario de actualización.
   * @return string Retorna "ok" si la actualización se realiza correctamente, o "error" si ocurre algún error.
   */
  public static function mdlActualizarIdCronogramaPagoMatricula($tabla, $actualizarPagoMatriculaCodCronograma)
  {
    $statement = Connection::conn()->prepare("UPDATE $tabla SET  idCronogramaPago = :idCronogramaPago, fechaActualizacion = :fechaActualizacion, usuarioActualizacion = :usuarioActualizacion WHERE idPago = :idPago");
    $statement->bindParam(":idPago", $actualizarPagoMatriculaCodCronograma["idPago"], PDO::PARAM_INT);
    $statement->bindParam(":idCronogramaPago", $actualizarPagoMatriculaCodCronograma["idCronogramaPago"], PDO::PARAM_INT);
    $statement->bindParam(":fechaActualizacion", $actualizarPagoMatriculaCodCronograma["fechaActualizacion"], PDO::PARAM_STR);
    $statement->bindParam(":usuarioActualizacion", $actualizarPagoMatriculaCodCronograma["usuarioActualizacion"], PDO::PARAM_STR);

    if ($statement->execute()) {
      return "ok";
    } else {
      return "error";
    }
  }

  /**
   * Obtiene todos los cronogramas de pago por el ID del alumno de admisión.
   *
   * @param string $tabla El nombre de la tabla.
   * @param int $idAdmisionAlumno El ID del alumno de admisión.
   * @return array|null Los cronogramas de pago como un array asociativo, o null si no hay cronogramas.
   */
  public static function mdlGetCronogramasPorIdAlumno($tabla, $idAdmisionAlumno)
  {
    $statement = Connection::conn()->prepare("SELECT idCronogramaPago, conceptoPago, montoPago, fechaLimite, mesPago, estadoCronograma FROM $tabla WHERE idAdmisionAlumno = :idAdmisionAlumno");
    $statement->bindParam(":idAdmisionAlumno", $idAdmisionAlumno, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }
}
