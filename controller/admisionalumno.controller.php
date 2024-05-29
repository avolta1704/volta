<?php
date_default_timezone_set('America/Lima');

class ControllerAdmisionAlumno
{
  //todos los registros de admision
  public static function ctrGetAdmisionAlumnos()
  {
    $tabla = "admision_alumno";
    $listaAdmisionAlumnos = ModelAdmisionAlumno::mdlGetAdmisionAlumnos($tabla);
    return $listaAdmisionAlumnos;
  }

  //ontener data de anio escolar
  public static function ctrOGetDataAnioEscolar()
  {
    $tabla = "anio_escolar";
    $dataAnioEscolar = ModelAdmisionAlumno::mdlGetDataAnioEscolar($tabla);
    return $dataAnioEscolar;
  }

  /**
   * Obtiene los datos del año escolar por nivel.
   *
   * @param string $nivel El nivel del año escolar.
   * @return array Los datos del año escolar.
   */
  public static function getDataAnioEscolarByNivel($nivel)
  {
    $tabla = "anio_escolar";
    $dataAnioEscolar = ModelAdmisionAlumno::mdlGetDataAnioEscolar($tabla);

    if ($dataAnioEscolar) {
      $dataAnioEscolar["coutaInicial"] = $dataAnioEscolar["cuotaInicial"];
      switch ($nivel) {
        case "Inicial":
          $dataAnioEscolar["costoMatricula"] = $dataAnioEscolar["matriculaInicial"];
          $dataAnioEscolar["costoPension"] = $dataAnioEscolar["pensionInicial"];
          break;
        case "Primaria":
          $dataAnioEscolar["costoMatricula"] = $dataAnioEscolar["matriculaPrimaria"];
          $dataAnioEscolar["costoPension"] = $dataAnioEscolar["pensionPrimaria"];
          break;
        case "Secundaria":
          $dataAnioEscolar["costoMatricula"] = $dataAnioEscolar["matriculaSecundaria"];
          $dataAnioEscolar["costoPension"] = $dataAnioEscolar["pensionSecundaria"];
          break;
      }
    }

    return $dataAnioEscolar;
  }
  // Actualizar estado admision_alumno y crear registro en cronograma_pago
  public static function ctrActualizarestadoAdmisionAlumno($codAdmisionAlumno)
  {
    // Obtener el registro de anio_escolar
    $dataAnioEscolar = self::ctrOGetDataAnioEscolar();
    if ($dataAnioEscolar) {
      //sesión esté iniciada
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      // acceder a la variable de sesión
      $idUsuario = $_SESSION["idUsuario"];

      $tabla = "cronograma_pago";

      //  crear solo una vez este array de datos por que es la matriculado
      $dataCronoPagoMatricula = array(
        "idAdmisionAlumno" => $codAdmisionAlumno,
        "conceptoPago" => "Matrícula",
        "montoPago" => $dataAnioEscolar["costoMatricula"],
        "fechaLimite" => "2021-03-05",
        "estadoCronograma" => 1,
        "mesPago" => "Matricula",
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
        "usuarioActualizacion" => $idUsuario
      );
      //crear 11 veces este array de datos por que es la Pension pero se tiene que crear desde marzo hasta diciembre
      $dataAllCronoPago = array();
      $dataAllCronoPago[] = $dataCronoPagoMatricula;
      $meses = array(
        1 => "Enero",
        2 => "Febrero",
        3 => "Marzo",
        4 => "Abril",
        5 => "Mayo",
        6 => "Junio",
        7 => "Julio",
        8 => "Agosto",
        9 => "Septiembre",
        10 => "Octubre",
        11 => "Noviembre",
        12 => "Diciembre"
      );

      for ($i = 4; $i <= 12; $i++) {
        $mesPago = $meses[$i];
        $ultimoDia = date("t", mktime(0, 0, 0, $i, 1, date("Y")));
        $fechaLimite = date("Y") . '-' . $i . '-' . $ultimoDia;

        $dataCronoPagoPension = array(
          "idAdmisionAlumno" => $codAdmisionAlumno,
          "conceptoPago" => "Pensión",
          "montoPago" => $dataAnioEscolar["costoPension"],
          "fechaLimite" => $fechaLimite,
          "estadoCronograma" => 1,
          "mesPago" => $mesPago,
          "fechaCreacion" => date("Y-m-d H:i:s"),
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioCreacion" => $idUsuario,
          "usuarioActualizacion" => $idUsuario
        );
        $dataAllCronoPago[] = $dataCronoPagoPension;
      }
      foreach ($dataAllCronoPago as $dataAdmisionCronoPago) {
        $response = ModelAdmisionAlumno::mdlCrearCronogramaPago($tabla, $dataAdmisionCronoPago);
        if ($response != "ok") {
          return "error";
        }
      }
      // Actualizar el campo en la tabla admision_alumno
      $table = "admision_alumno";
      $dataActualizarEstadoAdAlum = array(
        "idAdmisionAlumno" => $codAdmisionAlumno,
        "estadoAdmisionAlumno" => 2, //estado por defecto 1 = registrado 2 = establecido 3 = cancelado
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $idUsuario
      );
      $response = ModelAdmisionAlumno::mdlActualizarestadoAdmisionAlumno($table, $dataActualizarEstadoAdAlum);
      if ($response == "ok") {
        return "ok";
      } else {
        return "error";
      }
    } else {
      return "error";
    }
  }
  // ver calendario cronograma pago de la tabla  admision_alumno
  public static function ctrDataCronoPagoAdAlumEstado($codAdAlumCalendario)
  {
    $tabla = "cronograma_pago";
    $dataAdAlumCalendario = ModelAdmisionAlumno::mdlDataCronoPagoAdAlumEstado($tabla, $codAdAlumCalendario);
    return $dataAdAlumCalendario;
  }

  //  Obtener el último registro de admision_alumno
  public static function ctrObtenerUltimoAdmisionAlumno()
  {
    $tabla = "admision_alumno";
    $ultimoAdmisionAlumno = ModelAdmisionAlumno::mdlObtenerUltimoAdmisionAlumno($tabla);
    return $ultimoAdmisionAlumno;
  }

  //  Crear admision de alumno
  public static function ctrCrearAdmisionAlumno($admisionAnioEscolar, $alumnoAdmision)
  {
    $dataAlumnoAdmision = array(
      "idAdmision" => $admisionAnioEscolar,
      "idAlumno" => $alumnoAdmision["idAlumno"],
      "estadoAdmisionAlumno" => 1,
      "fechaCreacion" => date("Y-m-d H:i:s"),
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioCreacion" => $_SESSION["idUsuario"],
      "usuarioActualizacion" => $_SESSION["idUsuario"]
    );
    $table = "admision_alumno";
    $result = ModelAdmision::mdlCrearAlumnoAdmision($table, $dataAlumnoAdmision);
    return $result;
  }

  //  Get data del calendario de pagos
  public static function ctrGetCalendarioPagos($codAdmisionAlumno)
  {
    $tabla = "cronograma_pago";
    $dataCalendarioPagos = ModelAdmisionAlumno::mdlGetCalendarioPagos($tabla, $codAdmisionAlumno);
    return $dataCalendarioPagos;
  }

  public static function ctrActualizarestadoAdmisionAlumnoCancelado($codAdmisionAlumno)
  {

    $tablaAdmisionAlumno = "admision_alumno";
    $nivel = ModelAdmisionAlumno::mdlGetIdNivelByCodAdmisionAlumno($tablaAdmisionAlumno, $codAdmisionAlumno);

    // Obtener el registro de anio_escolar
    $dataAnioEscolar = self::getDataAnioEscolarByNivel($nivel);
    if ($dataAnioEscolar) {
      //sesión esté iniciada
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      // acceder a la variable de sesión
      $idUsuario = $_SESSION["idUsuario"];

      $tabla = "cronograma_pago";
      //  crear solo una vez este array de datos por que es la matriculado
      $dataCronoPagoMatricula = array(
        "idAdmisionAlumno" => $codAdmisionAlumno,
        "conceptoPago" => "Matrícula",
        "montoPago" => $dataAnioEscolar["costoMatricula"],
        "fechaLimite" => "2021-03-05",
        "estadoCronograma" => 2,
        "mesPago" => "Matricula",
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
        "usuarioActualizacion" => $idUsuario
      );

      // crear sola una vez este array para la cuota inicial
      $dataCronoPagoCuotaInicial = array(
        "idAdmisionAlumno" => $codAdmisionAlumno,
        "conceptoPago" => "Cuota Inicial",
        "montoPago" => $dataAnioEscolar["cuotaInicial"],
        "fechaLimite" => "2021-03-05",
        "estadoCronograma" => 2,
        "mesPago" => "Cuota Inicial",
        "fechaCreacion" => date("Y-m-d H:i:s"),
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioCreacion" => $idUsuario,
        "usuarioActualizacion" => $idUsuario
      );
      //crear 11 veces este array de datos por que es la Pension pero se tiene que crear desde marzo hasta diciembre
      $dataAllCronoPago = array();
      $dataAllCronoPago[] = $dataCronoPagoMatricula;
      $dataAllCronoPago[] = $dataCronoPagoCuotaInicial;
      $meses = array(
        1 => "Enero",
        2 => "Febrero",
        3 => "Marzo",
        4 => "Abril",
        5 => "Mayo",
        6 => "Junio",
        7 => "Julio",
        8 => "Agosto",
        9 => "Septiembre",
        10 => "Octubre",
        11 => "Noviembre",
        12 => "Diciembre"
      );

      for ($i = 3; $i <= 12; $i++) {
        $mesPago = $meses[$i];
        $ultimoDia = date("t", mktime(0, 0, 0, $i, 1, date("Y")));
        $fechaLimite = date("Y") . '-' . $i . '-' . $ultimoDia;

        $dataCronoPagoPension = array(
          "idAdmisionAlumno" => $codAdmisionAlumno,
          "conceptoPago" => "Pensión",
          "montoPago" => $dataAnioEscolar["costoPension"],
          "fechaLimite" => $fechaLimite,
          "estadoCronograma" => 1,
          "mesPago" => $mesPago,
          "fechaCreacion" => date("Y-m-d H:i:s"),
          "fechaActualizacion" => date("Y-m-d H:i:s"),
          "usuarioCreacion" => $idUsuario,
          "usuarioActualizacion" => $idUsuario
        );
        $dataAllCronoPago[] = $dataCronoPagoPension;
      }
      foreach ($dataAllCronoPago as $dataAdmisionCronoPago) {
        $response = ModelAdmisionAlumno::mdlCrearCronogramaPago($tabla, $dataAdmisionCronoPago);
        if ($response != "ok") {
          return "error";
        }
      }
      // Actualizar el campo en la tabla admision_alumno
      $table = "admision_alumno";
      $dataActualizarEstadoAdAlum = array(
        "idAdmisionAlumno" => $codAdmisionAlumno,
        "estadoAdmisionAlumno" => 2, //estado por defecto 1 = registrado 2 = establecido 3 = cancelado
        "fechaActualizacion" => date("Y-m-d H:i:s"),
        "usuarioActualizacion" => $idUsuario
      );
      $response = ModelAdmisionAlumno::mdlActualizarestadoAdmisionAlumno($table, $dataActualizarEstadoAdAlum);
      if ($response == "ok") {
        return "ok";
      } else {
        return "error";
      }
    } else {
      return "error";
    }
  }

  /**
   * Obtiene el código de admisión del alumno por admisión.
   *
   * @param string $codAdmisioon El código de admisión.
   * @return mixed El código de admisión del alumno o null si no se encuentra.
   */
  public static function ctrGetCodAdmisionAlumnoByAdmision($codAdmisioon)
  {
    $tabla = "admision_alumno";
    $result = ModelAdmisionAlumno::mdlGetCodAdmisionAlumnoByAdmision($tabla, $codAdmisioon);
    return $result;
  }

  /**
   * Obtiene el código del cronograma de matrícula por código de admisión de alumno.
   *
   * @param int $codAdmisionAlumno El código de admisión del alumno.
   * @return mixed El código del cronograma de matrícula o null si no se encuentra.
   */
  public static function ctrGetCodeCronogramaMatriculaByCodAdmisionAlumno($codAdmisionAlumno)
  {
    $tabla = "cronograma_pago";
    $result = ModelAdmisionAlumno::mdlGetCodeCronogramaMatriculaByCodAdmisionAlumno($tabla, $codAdmisionAlumno);
    return $result;
  }

  /**
   * Obtiene el código del cronograma de cuota inicial por código de admisión de alumno.
   * 
   * @param int $codAdmisionAlumno El código de admisión del alumno.
   * @return mixed El código del cronograma de cuota inicial o null si no se encuentra.
   */
  public static function ctrGetCodeCronogramaCuotaInicialByCodAdmisionAlumno($codAdmisionAlumno)
  {
    $tabla = "cronograma_pago";
    $result = ModelAdmisionAlumno::mdlGetCodeCronogramaCuotaInicialByCodAdmisionAlumno($tabla, $codAdmisionAlumno);
    return $result;
  }

  /**
   * Obtener el id del postulante de la tabla admision_alumno por el código de admisión del alumno.
   * 
   * @param int $codAdmisionAlumno El código de admisión del alumno.
   * @return mixed El id del postulante o null si no se encuentra.
   */

  public static function ctrGetIdPostulanteByCodAdmisionAlumno($codAdmisionAlumno)
  {
    $tabla = "admision_alumno";
    $result = ModelAdmisionAlumno::mdlGetIdPostulanteByCodAdmisionAlumno($tabla, $codAdmisionAlumno);
    return $result;
  }

  /**
   * Editar el estado de admisión del alumno.
   * 
   * @param array $data Los datos del estado de admisión del alumno.
   * @return string "ok" si se actualiza correctamente o "error" si no se actualiza.
   */
  public static function ctrEditarEstadoAdmisionAlumno($data)
  {
    $tabla = "admision_alumno";
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    // acceder a la variable de sesión
    $idUsuario = $_SESSION["idUsuario"];

    $dataActualizarEstadoAdAlum = array(
      "idAdmisionAlumno" => $data["codAdmisionAlumno"],
      "estadoAdmisionAlumno" => $data["estado"], //estado por defecto 1 = registrado 2 = establecido 3 = cancelado
      "fechaActualizacion" => date("Y-m-d H:i:s"),
      "usuarioActualizacion" => $idUsuario
    );
    $result = ModelAdmisionAlumno::mdlActualizarestadoAdmisionAlumno($tabla, $dataActualizarEstadoAdAlum);
    return $result;
  }
}
