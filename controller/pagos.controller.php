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
    if (isset ($_POST["formaTipoPago"]) && isset ($_POST["cronogramaPago"])) {
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
          "estadoCronograma" => 2,//estado cancelado
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
    if (isset ($_POST["montoPagoEdit"]) && isset ($_POST["metodoPagoEdit"])) {
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
  public static function ctrGetDataPagoDniAlumno($dniAlumno)
  {
    $tabla = "alumno";
    $DatosPagoDniAlumno = ModelPagos::mdlGetDataPagoDniAlumno($tabla, $dniAlumno);

    if (!empty ($DatosPagoDniAlumno)) {
      $idAlumno = $DatosPagoDniAlumno['idAlumno'];

      // Obtener datos de alumno_grado
      $DatosPagoAlumnoGrado = self::mdlGetGetDataPagoAlumnoGrado($idAlumno);
      $DatosPagoDniAlumno = array_merge($DatosPagoDniAlumno, $DatosPagoAlumnoGrado);
      // Obtener datos de admision_alumno
      $DatosPagoAdmisionAlumno = self::ctrGetDataPagoAdmisionAlumno($idAlumno);
      $DatosPagoDniAlumno['idAdmisionAlumno'] = $DatosPagoAdmisionAlumno['idAdmisionAlumno'];

      // Obtener datos de cronograma_pago
      $DatosPagoCronogramaPago = self::ctrGetDataPagoCronogramaPago($DatosPagoAdmisionAlumno['idAdmisionAlumno']);
      $DatosPagoDniAlumno['cronogramaPago'] = $DatosPagoCronogramaPago;
    }
    //enviar array de array con datos de alumno, grado, admision y cronograma
    return $DatosPagoDniAlumno;
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

    foreach ($data as $key => $value) {
      // Convertir y formatear la fecha de Excel
      $value["FECHA_PAGO"] = self::excelDateToJSDate($value["FECHA_PAGO"]);

      $dataCreateXlxs = array(
        "idTipoPago" => $value["formaTipoPago"],
        "idCronogramaPago" => $value["cronogramaPago"],
        "fechaPago" => $value["FECHA_PAGO"],
        "cantidadPago" => $value["PENCION"],
        "metodoPago" => $value["AGENCIA"],
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
      );
      $tabla = "pago";
      $responseDateXlsx = ModelPagos::mdlCrearRegistroPagoXlsx($tabla, $dataCreateXlxs);
    }
    return $responseDateXlsx;
  }

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
}
