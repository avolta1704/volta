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
}
