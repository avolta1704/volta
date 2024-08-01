<?php

require_once "../controller/admisionalumno.controller.php";
require_once "../model/admisionalumno.model.php";
require_once "../functions/admisionAlumno.functions.php";
require_once "../functions/pagos.functions.php";
require_once "../controller/admision.controller.php";
require_once "../model/admision.model.php";
require_once "../controller/usuarios.controller.php";
require_once "../model/usuarios.model.php";
class AdmisionAlumnosAjax
{
  //mostar todos los registros de admision dataTableAdmisionAlumnos
  public function ajaxMostrarRegistrosAdmisionAlumnos()
  {
    $registrosAdmisionAlumnos = ControllerAdmisionAlumno::ctrGetAdmisionAlumnos();

    $tipoUsuario = ControllerUsuarios::ctrGetTipoUsuario()["descripcionTipoUsuario"];

    $isAdministrativo = $tipoUsuario == "Administrativo";


    foreach ($registrosAdmisionAlumnos as &$dataAdmision) {
      $dataAdmision['estadoAdmisionAlumno'] = FunctionAdmisionAlumnos::getEstadoAdmisionAlumno($dataAdmision["estadoAdmisionAlumno"]);
      $dataAdmision['buttonsAdmisionAlumno'] = FunctionAdmisionAlumnos::getBotonesAdmisionAlumnos($dataAdmision["idAdmisionAlumno"], $dataAdmision["estadoAdmisionAlumno"], $dataAdmision["idAlumno"], $isAdministrativo, $dataAdmision["idAnioEscolar"]);
    }
    echo json_encode($registrosAdmisionAlumnos);
  }
  // Actualizar estado admision_alumno
  public $codAdmisionAlumno;
  public function ajaxActualizarEstado()
  {
    $codAdmisionAlumno = $this->codAdmisionAlumno;
    $response = ControllerAdmisionAlumno::ctrActualizarestadoAdmisionAlumno($codAdmisionAlumno);
    echo json_encode($response);
  }
  // ver calendario cronograma pago de la tabla  admision_alumno
  public $codAdAlumCronograma;
  public function ajaxDataCronoPagoAdAlumEstado()
  {
    $codAdAlumCronograma = $this->codAdAlumCronograma;
    $responseCronoPago = ControllerAdmisionAlumno::ctrDataCronoPagoAdAlumEstado($codAdAlumCronograma);
    foreach ($responseCronoPago as &$dataCronoPago) {
      $dataCronoPago['estadoCronogramaPago'] = FunctionPagos::getEstadoCronogramaPago($dataCronoPago["estadoCronograma"]);
      $dataCronoPago['fechaPago'] = FunctionPagos::getFechaPagoModal($dataCronoPago["fechaPago"]);
    }
    echo json_encode($responseCronoPago);
  }
  //  eliminar Postulante Matriculado
  public $codAlumnoEliminar;
  public function ajaxElimnarAlumno()
  {
    $codAlumnoEliminar = $this->codAlumnoEliminar;
    $response = ControllerAdmision::ctrElimarDataMatriculaPostulante($codAlumnoEliminar);
    echo json_encode($response);
  }

  /**
   * Actualizar estado de admision alumno
   * 
   * @param string $_POST["editarEstadoAdmisionAlumno"]
   */
  public function ajaxEditarEstadoAdmisionAlumno($data)
  {

    $data = json_decode($data, true);
    $response = ControllerAdmisionAlumno::ctrEditarEstadoAdmisionAlumno($data);
    echo json_encode($response);
  }

  /**
   * Ajax para mostrar a todos los alumnos de un año escolar
   * 
   * @param int idAnioEscolar id del año escolar
   */
  public function ajaxMostrarTodosPostulantesAnioEscolar($idAnioEscolar)
  {
    // Verificar si el año escolar es 0 para mostrar todos los registros de admision alumnos.
    if ($idAnioEscolar == 0)
      $response = ControllerAdmisionAlumno::ctrGetAdmisionAlumnos();
    else {
      $response = ControllerAdmisionAlumno::ctrGetAdmisionAlumnosAnioEscolar($idAnioEscolar);
    }

    $tipoUsuario = ControllerUsuarios::ctrGetTipoUsuario()["descripcionTipoUsuario"];
    $isAdministrativo = $tipoUsuario == "Administrativo";

    foreach ($response as &$dataAdmision) {
      $dataAdmision['buttonsAdmisionAlumno'] = FunctionAdmisionAlumnos::getBotonesAdmisionAlumnos($dataAdmision["idAdmisionAlumno"], $dataAdmision["estadoAdmisionAlumno"], $dataAdmision["idAlumno"], $isAdministrativo, $dataAdmision["idAnioEscolar"]);
      $dataAdmision['estadoAdmisionAlumno'] = FunctionAdmisionAlumnos::getEstadoAdmisionAlumno($dataAdmision["estadoAdmisionAlumno"]);
    }
    echo json_encode($response);
  }

  public function ajaxObtenerAlumnosPorTipoReportes()
  {
    $response = ControllerAdmisionAlumno::ctrObtenerAlumnosPorTipoReportes();
    echo json_encode($response);
  }
  public function ajaxObtenerTotalMatriculadosTrasladadosRetirados()
  {
    $response = ControllerAdmisionAlumno::ctrObtenerTotalMatriculadosTrasladadosRetirados();
    echo json_encode($response);
  }
  // Obtener todos los datos de los alumnos y apoderados para el reporte de excel
  public $idAnioEscolarReporteMatriculados;
  public function ajaxObtenerTodoslosDatosAlumnosApoderadosRegistroExcel()
  {
    // Obtener el id del año escolar para el reporte
    $idAnioEscolarReporteMatriculados = $this->idAnioEscolarReporteMatriculados;
    // Verificar si el año escolar es 0 para mostrar todos los registros de admision alumnos.
    if ($idAnioEscolarReporteMatriculados == 0) {
      $response = ControllerAdmisionAlumno::ctrObtenerTodoslosDatosAlumnosApoderadosRegistroExcel();
    } else {
      $response = ControllerAdmisionAlumno::ctrObtenerTodoslosDatosAlumnosApoderadosRegistroExcelAnioEscolar($idAnioEscolarReporteMatriculados);
    }
    // Recorrer los datos para obtener la edad, ek status, la matricula y el estado siagie
    foreach ($response as &$dataAdmision) {
      if (isset($dataAdmision["F. Nac."])) {
        $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $dataAdmision["F. Nac."]);
        $fechaActual = new DateTime();
        $anioNacimiento = $fechaNacimiento->format('Y');
        $anioActual = $fechaActual->format('Y');
        $dataAdmision['Edad'] = $anioActual - $anioNacimiento;
      }
      if (isset($dataAdmision["Status"])) {
        $dataAdmision['Status'] = $dataAdmision['Status'] == 1 ? 'N' : 'A';
      }
      if (isset($dataAdmision["Matric."])) {
        $dataAdmision["Matric."] = $dataAdmision["Matric."] == 1 ? 'Anulado' : ($dataAdmision["Matric."] == 2 ? 'Sí' : ($dataAdmision["Matric."] == 3 ? 'Traslado' : 'Retirado'));
      }
      if (isset($dataAdmision["Estado SIAGIE"])) {
        $dataAdmision["Estado SIAGIE"] = $dataAdmision["Estado SIAGIE"] == 1 ? 'Matriculado' : 'No Matriculado';
      }
    }
    echo json_encode($response);
  }
}

// Mostar todos los registros de admision  dataTableAdmisionAlumnos
if (isset($_POST["registrosAdmisionAlumnos"])) {
  $mostrarRegistrosAdmisionAlumnos = new AdmisionAlumnosAjax();
  $mostrarRegistrosAdmisionAlumnos->ajaxMostrarRegistrosAdmisionAlumnos();
}
// Actualizar estado admision_alumno
if (isset($_POST["codAdmisionAlumno"])) {
  $codAdmisionAlumno = new AdmisionAlumnosAjax();
  $codAdmisionAlumno->codAdmisionAlumno = $_POST["codAdmisionAlumno"];
  $codAdmisionAlumno->ajaxActualizarEstado();
}
// ver calendario cronograma pago de la tabla  admision_alumno
if (isset($_POST["codAdAlumCronograma"])) {
  $codAdAlumCronograma = new AdmisionAlumnosAjax();
  $codAdAlumCronograma->codAdAlumCronograma = $_POST["codAdAlumCronograma"];
  $codAdAlumCronograma->ajaxDataCronoPagoAdAlumEstado();
}

//  eliminar Postulante Matriculado
if (isset($_POST["codAlumnoEliminar"])) {
  $obtenerAlumnoDataEliminar = new AdmisionAlumnosAjax();
  $obtenerAlumnoDataEliminar->codAlumnoEliminar = $_POST["codAlumnoEliminar"];
  $obtenerAlumnoDataEliminar->ajaxElimnarAlumno();
}

// Editar estado de admision alumno
if (isset($_POST["editarEstadoAdmisionAlumno"])) {
  $codAdmisionAlumnoEditar = new AdmisionAlumnosAjax();
  $codAdmisionAlumnoEditar->ajaxEditarEstadoAdmisionAlumno($_POST["editarEstadoAdmisionAlumno"]);
}

// Mostrar todos los registros de postulantes por un año escolar
if (isset($_POST["todosLosAdmisionAlumnosAnio"])) {
  $mostrarRegistrosPostulantes = new AdmisionAlumnosAjax();
  $mostrarRegistrosPostulantes->ajaxMostrarTodosPostulantesAnioEscolar($_POST["todosLosAdmisionAlumnosAnio"]);
}
if (isset($_POST["todosAlumnosPorTipoReporte"])) {
  $mostrarTodoslosAlumnosPorEstado = new AdmisionAlumnosAjax();
  $mostrarTodoslosAlumnosPorEstado->ajaxObtenerAlumnosPorTipoReportes();
}
if (isset($_POST["todosAlumnosMatriculadosTrasladadosRetirados"])) {
  $mostrarTotalMatriculadosTrasladadosRetirados = new AdmisionAlumnosAjax();
  $mostrarTotalMatriculadosTrasladadosRetirados->ajaxObtenerTotalMatriculadosTrasladadosRetirados();
}
if (isset($_POST["idAnioEscolarReporteMatriculados"])) {
  $todosAlumnosApoderadoReporteMatriculados = new AdmisionAlumnosAjax();
  $todosAlumnosApoderadoReporteMatriculados->idAnioEscolarReporteMatriculados = $_POST["idAnioEscolarReporteMatriculados"];
  $todosAlumnosApoderadoReporteMatriculados->ajaxObtenerTodoslosDatosAlumnosApoderadosRegistroExcel();
}
