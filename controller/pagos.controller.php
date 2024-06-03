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

  /**
   * Función para crear un registro de pago de un alumno.
   *
   * Esta función verifica los datos enviados por el formulario y crea un registro de pago en la base de datos.
   * Si el tipo de pago es "Matrícula", se crea un registro de pago con cronograma de pago.
   * Si el tipo de pago no es "Matrícula", se crea un registro de pago sin cronograma de pago.
   *
   * @return void
   */
  public static function ctrCrearRegistroPagoAlumno()
  {
    // Código para crear un registro de pago con cronograma de pago
    if (isset($_POST["tipoPago"]) && isset($_POST["cronogramaPago"])) {
      $tabla = "pago";
      if ($_POST["tipoPago"] == "Matrícula") {
        $tipoPago = 1;
      } else {
        $tipoPago = 2;
      }
      $dataPagoAlumno = array(
        "idTipoPago" => $tipoPago,
        "idCronogramaPago" => $_POST["cronogramaPago"],
        "fechaPago" => $_POST["fechaRegistroPago"],
        "cantidadPago" => $_POST["montoPago"],
        "metodoPago" => $_POST["metodoPago"],
        "numeroComprobante" => $_POST["nroComprobante"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $crearPago = ModelPagos::mdlCrearRegistroPagoAlumno($tabla, $dataPagoAlumno);
      //  actualizar estado de cronograma_pago por el campo idCronogramaPago = $_POST["cronogramaPago"]
      if ($crearPago == "ok") {
        $tabla = "cronograma_pago";
        $dataEditEstadoCrono = array(
          "idCronogramaPago" => $_POST["cronogramaPago"],
          "estadoCronograma" => 2,  //estado cancelado
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $actualizarCronograma = ModelPagos::mdlEditarEstadoCronograma($tabla, $dataEditEstadoCrono);

        if ($actualizarCronograma == "ok") {
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
      // Código para crear un registro de pago sin cronograma de pago
    } else if (isset($_POST["tipoPago"]) && isset($_POST["idTipoPagoCuotaInicial"])) {
      // crear registro pago alumno sin cronograma de pago
      $tabla = "pago";
      $dataPagoAlumno = array(
        "idTipoPago" => $_POST["tipoPago"],
        "fechaPago" => $_POST["fechaRegistroPago"],
        "cantidadPago" => $_POST["montoPago"],
        "metodoPago" => $_POST["metodoPago"],
        "numeroComprobante" => $_POST["nroComprobante"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $crearPago = ModelPagos::mdlCrearRegistroPagoMatricula($tabla, $dataPagoAlumno);
      if ($crearPago == "ok") {
        $nuevoPago = self::ctrlObtenerUltimoRegistro();
        $tabla = "postulante";
        $datosActualizadoPostulante = array(
          "idPostulante" => intval($_GET["codPostulante"]),
          "pagoMatricula" => $nuevoPago["idPago"],
          "fechaPagoMatricula" => $nuevoPago["fechaPago"],
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $actualizarPostulante = ModelPostulantes::mdlEditarPagoPostulante($tabla, $datosActualizadoPostulante);
      }


      $dataPagoCuotaAlumno = array(
        "idTipoPago" => $_POST["idTipoPagoCuotaInicial"],
        "fechaPago" => $_POST["fechaRegistroPago"],
        "cantidadPago" => $_POST["cuotaInicial"],
        "metodoPago" => $_POST["metodoPago"],
        "numeroComprobante" => $_POST["nroComprobante"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $_SESSION["idUsuario"],
        "usuarioActualizacion" => $_SESSION["idUsuario"]
      );
      $tabla = "pago";
      $crearPagoCuotaInicial = ModelPagos::mdlCrearRegistroPagoMatricula($tabla, $dataPagoCuotaAlumno);

      if ($crearPagoCuotaInicial == "ok") {
        $nuevoPago = self::ctrlObtenerUltimoRegistro();
        $tabla = "postulante";
        $datosActualizadoPostulante = array(
          "idPostulante" => intval($_GET["codPostulante"]),
          "pagoCuotaIngreso" => $nuevoPago["idPago"],
          "fechaCuotaIngreso" => $nuevoPago["fechaPago"],
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioActualizacion" => $_SESSION["idUsuario"]
        );
        $actualizarPostulanteCuota = ModelPostulantes::mdlEditarCuotaInicialPostulante($tabla, $datosActualizadoPostulante);
      }


      if ($actualizarPostulante == "ok" && $actualizarPostulanteCuota == "ok") {
        $mensaje = ControllerFunciones::mostrarAlerta("success", "Correcto", "Registro Pago del Alumno correctamente", "listaPostulantes");
        echo $mensaje;
      } else {
        $mensaje = ControllerFunciones::mostrarAlerta("error", "Error", "Error al actualizar el estado del cronograma de pago", "listaPostulantes");
        echo $mensaje;
      }
    }
  }

  /**
   * Obtiene el último registro de pago.
   *
   * @return mixed Los datos del último pago.
   */
  public static function ctrlObtenerUltimoRegistro()
  {
    $tabla = "pago";
    $dataPago = ModelPagos::mldGetUltimoPago($tabla);
    return $dataPago;
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
    // Para eliminar pago matricula postulante, cuando no hay cronograma de pago
    if ($dataPagoCrono == false) {
      //Update de la tabla postulante el campo pagoMatricula igual a null
      $response = ModelPagos::mdlDeletePagoMatricula($codPagoDelet);
      return $response;
    } else {
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

      // Obtener datos de alumno_anio_escolar
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
    $tabla = "alumno_anio_escolar";
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
        "idTipoPago" => 2, //valor de tipoPago "Pension" 
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
  //funcion de carga de archivos xlsx formato 2 registro diario
  public static function ctrCrearRegistroPagoXlsxRegistro($jsonDataStringXlsxRegistro)
  {
    //sesión iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];
    // Decodificar el JSON 
    $data = json_decode($jsonDataStringXlsxRegistro, true);

    $infoErrCronoAlum = array(); // Nuevo array para almacenar los arrays con errores


    foreach ($data as $key => $value) {
      // Verificar si el array tiene al menos 3 posiciónes
      if (count($value) < 3) {
        continue; // Saltar a la siguiente iteración del bucle
      }
      // Convertir el array asociativo a un array indexado
      $indexedArray = array_values($value);

      // Ahora puedes acceder a los elementos por su posición
      $valueAtPosition0 = $indexedArray[0]; //codigo alumno
      $valueAtPosition1 = $indexedArray[1]; //NOMBRE
      $valueAtPosition2 = $indexedArray[2];
      $valueAtPosition3 = $indexedArray[3]; //NUMERO DE FACTURACION CAJA
      $valueAtPosition4 = $indexedArray[4]; //SUBPERIODO
      $valueAtPosition5 = $indexedArray[5]; //PENCION
      $valueAtPosition6 = $indexedArray[6]; //MORA
      $valueAtPosition7 = $indexedArray[7]; //AGENCIA

      // Controlador para separar texto de SUBPERIODO del xlsx para el año y mes del cronograma de pago que se va a registrar
      $value["PERIODO_PAGO"] = self::ctrSepararTextoAnioMes($valueAtPosition4);

      //datos del alumno y cronograma de pago mas reciente a pagar por el CodigoAlumno(COD_ALUMNO) el año y mes del xlsx SUBPERIODO 
      $value["COD_ALUMNO_DATA"] = self::ctrDataPagoCodAlumnoXlsx($valueAtPosition0, $value["PERIODO_PAGO"]["anio"], $value["PERIODO_PAGO"]["mes"]);

      // Verificar si idCronogramaPago es falso Y MORA no es un numero se guardara en el array ($infoErrCronoAlum) para mostrar los registros no creados por COD_ALUMNO del xlsx
      if ($value["COD_ALUMNO_DATA"]["idCronogramaPago"] === false) {
        $infoErrCronoAlum[] = $value["COD_ALUMNO_DATA"] + array(
          "anio" => $value["PERIODO_PAGO"]["anio"],
          "mes" => $value["PERIODO_PAGO"]["mes"],
          "pension" => $valueAtPosition5,
          "mora" => $valueAtPosition6
        );
        continue; // Saltar a la siguiente iteración del bucle
      }

      $dataCreateXlxs = array(
        "idTipoPago" => 2, //valor de tipoPago "Pension" 
        "idCronogramaPago" => $value["COD_ALUMNO_DATA"]["idCronogramaPago"]["idCronogramaPago"],
        "fechaPago" => date("Y-m-d"),
        "cantidadPago" => $valueAtPosition5,
        "metodoPago" => $valueAtPosition7,
        "numeroComprobante" => $valueAtPosition3,
        "moraPago" => $valueAtPosition6,
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
      );
      $tabla = "pago";
      //funcion de carga de archivos xlsx formato 2 registro diario
      $responseDataXlsx = ModelPagos::mdlCrearRegistroPagoXlsxRegistro2($tabla, $dataCreateXlxs);
      //actualizar estado de cronograma_pago por el campo idCronogramaPago = $value["idCronogramaPago"] y tambien el "montoPago" => $value["PENSION"], que llega en el xlsx
      if ($responseDataXlsx == "ok") {
        $table = "cronograma_pago";
        $dataEditEstadoCrono = array(
          "idCronogramaPago" => $value["COD_ALUMNO_DATA"]["idCronogramaPago"]["idCronogramaPago"],
          "montoPago" => $valueAtPosition5,
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
  //editar cronograma de pagos de pago modal editar 
  public static function ctrEditarRegistroPagoModal($dataEditCronoModal)
  {
    //sesión iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];

    $table = "cronograma_pago";
    $dataEditCronoPagoModal = array(
      "idCronogramaPago" => $dataEditCronoModal['btnEditCronoModal'], //valor de id guardado en el boton editar
      "fechaLimite" => $dataEditCronoModal['fechaLimtEditCrono'],
      "montoPago" => $dataEditCronoModal['montoEditCrono'],
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $idUsuario,
    );
    $response = ModelPagos::mdlEditarRegistroPagoModal($table, $dataEditCronoPagoModal);
    if ($response == "ok") {
      return "ok";
    } else {
      return $response;
    }
  }
  //  Obtener datos del tipo de pago
  public static function ctrGetIdTipoPago()
  {
    $tabla = "tipo_pago";
    $dataPago = ModelPagos::mdlGetIdTipoPago($tabla);
    return $dataPago;
  }

  //  Obtener idTipoPago de la cuota iniciañ
  public static function ctrGetIdTipoPagoCuotaInicial()
  {
    $tabla = "tipo_pago";
    $dataPago = ModelPagos::mdlGetIdTipoPagoCuotaInicial($tabla);
    return $dataPago;
  }

  /**
   * Obtiene el pago de matrícula por su ID.
   *
   * @param int $pagoMatricula El ID del pago de matrícula.
   * @return array La lista de cronograma de pago.
   */
  public static function ctrGetPagoMatriculaById($pagoMatricula)
  {
    $pago = ModelPagos::mdlGetPagoById($pagoMatricula);
    return $pago;
  }

  /**
   * Actualiza el ID del cronograma de pago de matrícula en la tabla de pagos.
   *
   * @param int $actualizarPagoMatriculaCodCronograma El código del cronograma de pago de matrícula a actualizar.
   * @return mixed La respuesta de la función mdlActualizarIdCronogramaPagoMatricula del modelo de pagos.
   */
  public static function ctrActualizarIdCronogramaPagoMatricula($actualizarPagoMatriculaCodCronograma)
  {
    $tabla = "pago";
    $response = ModelPagos::mdlActualizarIdCronogramaPagoMatricula($tabla, $actualizarPagoMatriculaCodCronograma);
    return $response;
  }

  /**
   * Obtiene los cronogramas por ID de alumno.
   *
   * @param int $idAlumno El ID del alumno.
   * @return array Los cronogramas asociados al alumno.
   */
  public static function ctrGetCronogramasPorIdAlumno($idAlumno)
  {
    $tabla = "cronograma_pago";
    $cronogramas = ModelPagos::mdlGetCronogramasPorIdAlumno($tabla, $idAlumno);
    return $cronogramas;
  }
}
