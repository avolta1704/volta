<?php
date_default_timezone_set('America/Lima');

class ControllerPagos
{
  // Obtener todos los pagos
  public static function ctrGetAllPagos()
  {
    $tabla = "pago";
    $listaPagos = ModelPagos::mdlGetAllPagos($tabla);
    return $listaPagos;
  }
  //  crear registro pago alumno
  public static function ctrCrearRegistroPagoAlumno()
  {
    if (isset($_POST["formaTipoPago"]) && isset($_POST["cronogramaPago"])) {
      $tabla = "pago";
      $dataPagoAlumno = array(
        "idTipoPago" => $_POST["formaTipoPago"],
        "idCronogramaPago" => $_POST["cronogramaPago"],
        "fechaPago" => $_POST["fechaRegistroPago"],
        "cantidadPago" => $_POST["montoPago"],
        "metodoPago" => $_POST["metodoPago"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPagos::mdlCrearRegistroPagoAlumno($tabla, $dataPagoAlumno);
      //actualizar estado de cronograma_pago por el campo idCronogramaPago = $_POST["cronogramaPago"]
      if ($response == "ok") {
        $tabla = "cronograma_pago";
        $dataEditEstadoCrono = array(
          "idCronogramaPago" => $_POST["cronogramaPago"],
          "estadoCronograma" => 2, //estado cancelado
          "fechaCreacion" => date("Y-m-d H:i:s"),
          "usuarioCreacion" => $_SESSION["idUsuario"]
        );
        $response = ModelPagos::mdlEditarEstadoCronograma($tabla, $dataEditEstadoCrono);

        if ($response == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Registro Pago del Alumno correctamente", "listaPagos");
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al actualizar el estado del cronograma de pago", "listaPagos");
          echo $mensaje;
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Registro Pago del Alumno", "listaPagos");
        echo $mensaje;
      }
    }
  }
  //  Obtener datos del Pago para editar 
  public static function ctrGetIdEditPago($codPago)
  {
    $tabla = "pago";
    $dataPago = ModelPagos::mdlGetIdEditPago($tabla, $codPago);
    return $dataPago;
  }
  //  editar Pago
  public static function ctrEditarPagoAlumno()
  {
    if (isset($_POST["montoPagoEdit"]) && isset($_POST["metodoPagoEdit"])) {
      $tabla = "pago";
      $dataEditPagoAlumno = array(
        "idPago" => $_POST["pagoEdit"],
        //"idCronogramaPago" => $_POST["cronogramaPagoEdit"],
        "fechaPago" => $_POST["fechaRegistroPagoEdit"],
        "cantidadPago" => $_POST["montoPagoEdit"],
        "metodoPago" => $_POST["metodoPagoEdit"],
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $response = ModelPagos::mdlEditarPagoAlumno($tabla, $dataEditPagoAlumno);
      //actualizar estado de cronograma_pago por el campo idCronogramaPago = $_POST["cronogramaPagoEdit"]
      if ($response == "ok") {
        $tabla = "cronograma_pago";
        $dataEditEstadoCrono = array(
          "idCronogramaPago" => $_POST["cronogramaPagoEdit"],
          "estadoCronograma" => $_POST["estadoPagoEdit"],
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $response = ModelPagos::mdlEditarEstadoCronograma($tabla, $dataEditEstadoCrono);

        if ($response == "ok") {
          $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Registro Pago del Alumno Editado correctamente", "listaPagos");
          echo $mensaje;
        } else {
          $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Registro Pago Editar del Alumno", "listaPagos");
          echo $mensaje;
        }
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error Registro Pago Editar del Alumno", "listaPagos");
        echo $mensaje;
      }
    }
  }
  // eliminar registro de pago
  public static function ctrDeleteRegistroPago($codPagoDelet)
  {
    //sesión iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    $tabla = "pago";
    // Obtener el idCronogramaPago y estadoCronograma por codPagoDelet antes de eliminar el registro
    $dataPagoCrono = self::ctrObtenerIdCronogramaPago($codPagoDelet);
    // Eliminar el registro de la tabla 'pago'
    $response = ModelPagos::mdlDeleteRegistroPago($tabla, $codPagoDelet);
    if ($response == "ok") {
      $table = "cronograma_pago";
      $dataEditEstadoCrono = array(
        "idCronogramaPago" => $dataPagoCrono['idCronogramaPago'],
        "estadoCronograma" => 1, //regresa al estado a pendiente despues de eliminar el registro de su pago de la tabla pago
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $idUsuario,
      );
      $response = ModelPagos::mdlActualizarEstadoCronogramaDelete($table, $dataEditEstadoCrono);
      if ($response == "ok") {
        return "ok";
      } else {
        return $response;
      }
    } else {
      return $response;
    }
  }
  //obtener id de cronograma_pago y estado por idPago
  public static function ctrObtenerIdCronogramaPago($codPagoDelet)
  {
    $tabla = "pago";
    $dataPagoCrono = ModelPagos::mdlObtenerIdCronogramaPago($tabla, $codPagoDelet);
    return $dataPagoCrono;
  }
  // vista de pagos buscar alumno por el dni funcion principal
  public static function ctrGetDataPagoCodAlumno($codAlumno)
  {
    $tabla = "alumno";
    $DatosPagoAlumno = ModelPagos::mdlGetDataPagoCodAlumno($tabla, $codAlumno);

    if (!empty($DatosPagoAlumno)) {
      $idAlumno = $DatosPagoAlumno['idAlumno'];

      // Obtener datos de alumno_grado
      $DatosPagoAlumnoGrado = self::mdlGetGetDataPagoAlumnoGrado($idAlumno);
      $DatosPagoAlumno = array_merge($DatosPagoAlumno, $DatosPagoAlumnoGrado);
      // Obtener datos de admision_alumno
      $DatosPagoAdmisionAlumno = self::ctrGetDataPagoAdmisionAlumno($idAlumno);
      $DatosPagoAlumno['idAdmisionAlumno'] = $DatosPagoAdmisionAlumno['idAdmisionAlumno'];

      // Obtener datos de cronograma_pago
      $DatosPagoCronogramaPago = self::ctrGetDataPagoCronogramaPago($DatosPagoAdmisionAlumno['idAdmisionAlumno']);
      $DatosPagoAlumno['cronogramaPago'] = $DatosPagoCronogramaPago;
    }
    //enviar array de array con datos de alumno, grado, admision y cronograma
    return $DatosPagoAlumno;
  }
  //obtener id grado alumno por id alumno 
  public static function mdlGetGetDataPagoAlumnoGrado($idAlumno)
  {
    $tabla = "alumno_grado";
    $DatosPagoAlumnoGrado = ModelPagos::mdlGetGetDataPagoAlumnoGrado($tabla, $idAlumno);
    return $DatosPagoAlumnoGrado;
  }
  //obtener  idAdmisionAlumno por id alumno 
  public static function ctrGetDataPagoAdmisionAlumno($idAlumno)
  {
    $tabla = "admision_alumno";
    $DatosPagoAdmisionAlumno = ModelPagos::mdlGetDataPagoAdmisionAlumno($tabla, $idAlumno);
    return $DatosPagoAdmisionAlumno;
  }
  //obtener id cronograma pago alumno por idAdmisionAlumno 
  public static function ctrGetDataPagoCronogramaPago($idAdmisionAlumno)
  {
    $tabla = "cronograma_pago";
    $DatosPagoCronogramaPago = ModelPagos::mdlDataPagoCronogramaPago($tabla, $idAdmisionAlumno);
    return $DatosPagoCronogramaPago;
  }
  //  Listar tipo pago para el select vista registrarPago
  public static function ctrGetAllTipoPago()
  {
    $tabla = "tipo_pago";
    $listaTipoPagos = ModelPagos::mdlGetAllTipoPago($tabla);
    return $listaTipoPagos;
  }
  //datos de xlsx para la creacion de registro de pagos
  public static function ctrCrearRegistroPagoXlsx($jsonDataString)
  {
    //sesión iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    // Decodificar el JSON 
    $data = json_decode($jsonDataString, true);

    $infoErrCronoAlum = array(); // Nuevo array para almacenar los arrays con errores

    foreach ($data as $key => $value) {
      // Convertir y formatear la fecha de xlsx a un formato válido para la base de datos
      $value["FECHA_PAGO"] = self::excelDateToJSDate($value["FECHA_PAGO"]);
      //contolador para separar texto de SUBPERIODO del xlsx para el año y mes del cronograma de pago que se va a registrar
      $value["PERIODO_PAGO"] = self::ctrSepararTextoAnioMes($value["SUBPERIODO"]);
      //datos del alumno y cronograma de pago mas reciente a pagar por el CodigoAlumno(COD_ALUMNO) el año y mes del xlsx SUBPERIODO 
      $value["COD_ALUMNO_DATA"] = self::ctrDataPagoCodAlumnoXlsx($value["COD_ALUMNO"], $value["PERIODO_PAGO"]["anio"], $value["PERIODO_PAGO"]["mes"]);

      // Verificar si idCronogramaPago es falso Y MORA no es un numero se guardara en el array ($infoErrCronoAlum) para mostrar los registros no creados por COD_ALUMNO del xlsx
      if ($value["COD_ALUMNO_DATA"]["idCronogramaPago"] === false || !is_numeric($value["MORA"])) {
        $infoErrCronoAlum[] = $value["COD_ALUMNO_DATA"] + array(
            "anio" => $value["PERIODO_PAGO"]["anio"],
            "mes" => $value["PERIODO_PAGO"]["mes"],
            "pension" => $value["PENSION"],
            "mora" => $value["MORA"]
        );
        continue; // Saltar a la siguiente iteración del bucle
    }

      $dataCreateXlxs = array(
        "idTipoPago" => 2,//valor de tipoPago "Pension" 
        "idCronogramaPago" => $value["COD_ALUMNO_DATA"]["idCronogramaPago"]["idCronogramaPago"],
        "fechaPago" => $value["FECHA_PAGO"],
        "cantidadPago" => $value["PENSION"],
        "metodoPago" => $value["AGENCIA"],
        "moraPago" => $value["MORA"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
      );
      $tabla = "pago";
      $responseDataXlsx = ModelPagos::mdlCrearRegistroPagoXlsx($tabla, $dataCreateXlxs);
      //actualizar estado de cronograma_pago por el campo idCronogramaPago = $value["idCronogramaPago"] y tambien el "montoPago" => $value["PENSION"], que llega en el xlsx
      if ($responseDataXlsx == "ok") {
        $table = "cronograma_pago";
        $dataEditEstadoCrono = array(
          "idCronogramaPago" => $value["COD_ALUMNO_DATA"]["idCronogramaPago"]["idCronogramaPago"],
          "montoPago" => $value["PENSION"],
          "estadoCronograma" => 2, //estado cancelado
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $idUsuario,
        );
        $response = ModelPagos::mdlEditarEstadoCronogramaXlsx($table, $dataEditEstadoCrono);
        if ($response != "ok") {
          return;
        }
      }
    }
    // Devolver el array de errores y la respuesta "ok"
    return array('infoErrCronoAlum' => $infoErrCronoAlum, 'response' => "ok");
  }
  // buscar al alumno y su cronograma de pago mas reciente a pagar por el (COD_ALUMNO) CodigoAlumno  desde el xlsx subido 
  public static function ctrDataPagoCodAlumnoXlsx($codAlumnoXlsx, $anio, $mes)
  {
    $tabla = "alumno";
    $DatosPagoAlumno = ModelPagos::mdlGetDataPagoCodAlumno($tabla, $codAlumnoXlsx);

    if (!empty($DatosPagoAlumno)) {
      $idAlumno = $DatosPagoAlumno['idAlumno'];
      // Obtener datos de admision_alumno
      $DatosPagoAdmisionAlumno = self::ctrGetDataPagoAdmisionAlumno($idAlumno);
      $DatosPagoAlumno['idAdmisionAlumno'] = $DatosPagoAdmisionAlumno['idAdmisionAlumno'];
      // Obtener datos de cronograma_pago
      $DatosPagoCronogramaPago = self::ctrIdCronogramaPagoMasReciente($DatosPagoAdmisionAlumno['idAdmisionAlumno'], $anio, $mes);
      $DatosPagoAlumno['idCronogramaPago'] = $DatosPagoCronogramaPago;
    }
    //enviar array de array con datos de alumno, admision y cronograma
    return $DatosPagoAlumno;
  }
  //obtener id cronograma pago alumno por idAdmisionAlumno, año y mes xlsx 
  public static function ctrIdCronogramaPagoMasReciente($idAdmisionAlumno, $anio, $mes)
  {
    $tabla = "cronograma_pago";
    //si la respuesta es false se devolvera falso, servira para mostrar los registros no creados de COD_ALUMNO del xlsx 
    //como archivos duplicados o no encontrados por el año, mes, (fechaLimitePago,mesPago), estado(1)pendiente y Matricula
    $DatosPagoCronogramaPago = ModelPagos::mdlIdCronogramaPagoMasReciente($tabla, $idAdmisionAlumno, $anio, $mes);
    return $DatosPagoCronogramaPago;
  }
  //formatear ala fecha requeriada para la base de datos Y-m-d
  private static function excelDateToJSDate($serial)
  {
    if ($serial < 60) {
      $day = $serial;
    } else {
      $day = $serial - 1;
    }
    $unixTimestamp = ($day * 24 * 60 * 60) - (70 * 365.25 * 24 * 60 * 60);
    $date = new DateTime("@$unixTimestamp");
    // Formatear la fecha en el formato "Año-Mes-Día"
    return $date->format('Y-m-d');
  }
  //separa el texto de SUBPERIODO del xlsx para ontener el año y mes del cronograma de pago que se va a pagar 
  public static function ctrSepararTextoAnioMes($periodo)
  {
    $periodo = explode(" ", $periodo);
    $anioMes = $periodo[1]; // Obtiene el texto después del espacio
    $anio = substr($anioMes, 0, 4); // Obtiene los primeros 4 caracteres (el año)
    $mes = substr($anioMes, 4, 2); // Obtiene los últimos 2 caracteres (el mes)
    $meses = array(
      "01" => "Enero",
      "02" => "Febrero",
      "03" => "Marzo",
      "04" => "Abril",
      "05" => "Mayo",
      "06" => "Junio",
      "07" => "Julio",
      "08" => "Agosto",
      "09" => "Septiembre",
      "10" => "Octubre",
      "11" => "Noviembre",
      "12" => "Diciembre"
    );
    $mes = $meses[$mes];
    $periodo = array(
      "anio" => $anio,
      "mes" => $mes
    );
    return $periodo;
  }
}
