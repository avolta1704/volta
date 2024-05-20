<?php
date_default_timezone_set('America/Lima');

class ControllerReportesComunicados
{

  /**
   * Obtiene todos los alumnos con comunicados.
   *
   * @return array Retorna un array con los datos de los alumnos que tienen comunicados.
   */
  public static function ctrGetAllAlumnosConComunicados()
  {
    $table = "comunicacion_pago";
    $comunicados = ModelReportesComunicados::mdlGetAllAlumnosConComunicados($table);
    return $comunicados;
  }

  /**
   * Obtiene los comunicados por alumnos.
   *
   * @return array Retorna un array con los datos de los comunicados por alumnos.
   */
  public static function ctrGetComunicadosPorAlumnos()
  {
    $table = "comunicacion_pago";
    $comunicadosPorAlumno = ModelReportesComunicados::mdlGetComunicadosPorAlumno($table);
    if (empty($comunicadosPorAlumno)) {
      return $comunicadosPorAlumno;
    }
    $comunicadosPorAlumno = self::ctrAgruparPorAlumno($comunicadosPorAlumno);
    return $comunicadosPorAlumno;
  }

  /**
   * Obtiene los comunicados por rango de fechas.
   *
   * @return array Retorna un array con los datos de los comunicados por rango de fechas.
   */
  public static function ctrGetComunicadosPorRangoFechas($fechaInicio, $fechaFin)
  {
    $table = "comunicacion_pago";
    $comunicadosPorRangoFechas = ModelReportesComunicados::mdlGetComunicadosPorRangoFechas($table, $fechaInicio, $fechaFin);
    $comunicadosFormat = self::ctrAgruparPorAlumno($comunicadosPorRangoFechas);
    return $comunicadosFormat;
  }

  /**
   * Agrupa los datos por alumno.
   *
   * @param array $data Los datos a agrupar.
   * @return void
   */
  public static function ctrAgruparPorAlumno($data)
  {
    $result = [];

    foreach ($data as $alumno) {
      $pension = ModelReportesComunicados::mdlGetPensionAlumno($alumno['idAdmisionAlumno']);
      $id = $alumno['idAlumno'];
      if (!isset($result[$id])) {
        $result[$id] = [
          'idAlumno' => $alumno['idAlumno'],
          'Nombres' => $alumno['apellidosAlumno'] . ", " . $alumno['nombresAlumno'],
          "Nivel" => $alumno['descripcionNivel'] . " " . $alumno['descripcionGrado'],
          "Pension" => $pension['montoPago'],
          'Mes Deuda' => [],
          'Monto Deuda' => 0,
        ];
      }
      // Añadir solo las tres primeras letras del mes
      $result[$id]['Mes Deuda'][] = $alumno['mesPago'] == "Matricula" ? $alumno['mesPago'] : substr($alumno['mesPago'], 0, 3);
      $result[$id]['Monto Deuda'] += $alumno['montoPago'];

      // Añadir comunicado enumerado
      $comunicadoIndex = count(array_filter(array_keys($result[$id]), fn ($key) => strpos($key, 'Comunicado') === 0)) + 1;
      $result[$id]["Comunicado $comunicadoIndex"] = $alumno['fechaComunicacion'] . ': ' . $alumno['tituloComunicacion'] . ', ' . $alumno['detalleComunicacion'];
    }

    // Convertir mesesPago a una cadena de texto separada por comas
    foreach ($result as &$alumno) {
      $alumno['Mes Deuda'] = implode(', ', $alumno['Mes Deuda']);
    }

    return $result;
  }
}
