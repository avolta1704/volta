<?php
date_default_timezone_set('America/Lima');

class ControllerReportesPensiones
{
  /**
   * Obtiene todos los cronogramas de pago de deuda pasada.
   *
   * @return mixed La respuesta de la consulta al modelo.
   */
  public static function ctrGetCronogramasPagoPendientes()
  {
    $respuesta = ModelReportesPensiones::mdlGetCronogramasPagoPendientes();
    return $respuesta;
  }

  /**
   * Obtiene los cronogramas de pago pendientes por alumno.
   *
   * @return array Retorna un array con los cronogramas de pago pendientes por alumno.
   */
  public static function ctrGetCronogramasPagoPendientesPorAlumno()
  {
    // Obtener todos los cronogramas de pago de deuda pasada por alumno
    // $respuesta = ModelReportesPensiones::mdlGetCronogramasPagoPendientesPorAlumno();
    $respuesta = ModelReportesPensiones::mdlGetCronogramasPagoPendientes();

    $alumnosAgrupados = self::ctrAgruparPorAlumno($respuesta);
    // Agrupar por idAlumno

    $dataFinal = array();
    foreach ($alumnosAgrupados as $alumno) {
      // obtener todos los cronogramas de todos los alumnos con deuda pasada
      $todosLosPensionesPendientes = ControllerPagos::ctrGetCronogramasPorIdAlumno($alumno["idAlumno"]);
      // Agrupar por mes de pago
      $mesesAlumno = self::ctrAgrupoMesesAlumno($todosLosPensionesPendientes);

      $mesesAlumno["Alumno"] = $alumno["nombresAlumno"] . " " . $alumno["apellidosAlumno"];
      $mesesAlumno["DNI"] = $alumno["dniAlumno"];
      $mesesAlumno["Grado"] = $alumno["descripcionGrado"];
      $mesesAlumno["Nivel"] = $alumno["descripcionNivel"];
      $dataFinal[] = $mesesAlumno;
    }

    return $dataFinal;
  }

  /**
   * Agrupa los datos de acuerdo al alumno.
   *
   * @param array $data Los datos a agrupar.
   * @return array Retorna un array con los datos agrupados.
   */
  public static function ctrAgruparPorAlumno($data)
  {
    $alumnosAgrupados = array();
    // Agrupar por idAlumno
    foreach ($data as $dataPensiones) {
      $idAlumno = $dataPensiones["idAlumno"];
      if (!isset($alumnosAgrupados[$idAlumno])) {
        $alumnosAgrupados[$idAlumno] = $dataPensiones;
      }
    }
    return $alumnosAgrupados;
  }

  /**
   * Agrupa los meses de pago de un alumno.
   *
   * Esta función estática recibe como parámetro el objeto del alumno y agrupa los meses de pago correspondientes.
   *
   * @param Alumno $alumno El objeto del alumno.
   * @return datosAlumno Retorna un objeto dentro un array de los meses.
   */
  public static function ctrAgrupoMesesAlumno($alumno)
  {
    $mesesAlumno = array();

    foreach ($alumno as $data) {


      $mesPago = $data["mesPago"];
      $estadoCronograma = $data["estadoCronograma"];

      $mesesAlumno[] = array(
        "mesPago" => $mesPago,
        "estadoCronograma" => $estadoCronograma
      );
    }

    // Agrega los meses y estados al array de datos del alumno
    $datosAlumno["meses"] = $mesesAlumno;

    return $datosAlumno;
  }
}
