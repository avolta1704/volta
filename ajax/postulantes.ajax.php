<?php
//controller
require_once "../functions/postulantes.functions.php";
require_once "../controller/postulantes.controller.php";
require_once "../controller/admisionalumno.controller.php";
require_once "../controller/admision.controller.php";
require_once "../controller/anioescolar.controller.php";
require_once "../controller/alumnos.controller.php";
require_once "../controller/gradoAlumno.controller.php";
require_once "../controller/anioAdmision.controller.php";
require_once "../controller/apoderadoAlumno.controller.php";
require_once "../controller/apoderado.controller.php";
require_once "../controller/pagos.controller.php";
require_once "../controller/postulantes.controller.php";
//Modelo
require_once "../model/postulantes.model.php";
require_once "../model/admisionalumno.model.php";
require_once "../model/admision.model.php";
require_once "../model/anioescolar.model.php";
require_once "../model/alumnos.model.php";
require_once "../model/gradoAlumno.model.php";
require_once "../model/anioAdmision.model.php";
require_once "../model/apoderadoAlumno.model.php";
require_once "../model/apoderado.model.php";
require_once "../model/pagos.model.php";
require_once "../model/postulantes.model.php";

class PostulantesAjax
{
  //mostar todos los Postulantes DataTablePostulantesAdmin
  public function ajaxMostrarTodosLosPostulantesAdmin()
  {
    $todosLosPostulantesAdmin = ControllerPostulantes::ctrGetAllPostulantes();
    foreach ($todosLosPostulantesAdmin as &$postulantes) {
      $postulantes['statePostulante'] = FunctionPostulantes::getestadoPostulantes($postulantes["estadoPostulante"]);
      $postulantes['buttonsPostulante'] = FunctionPostulantes::getBotonesPostulante($postulantes["idPostulante"], $postulantes["estadoPostulante"], $postulantes["pagoMatricula"]);
      //$postulantes['estadoMatricula'] = FunctionPostulantes::getestadoPostulantes($postulantes["pagoMatricula"]);
    }
    echo json_encode($todosLosPostulantesAdmin);
  }
  // Actualizar estado postulante
  public $codPostulanteEdit;
  public $estadoPostulanteEdit;
  public function ajaxActualizarEstado()
  {
    $codPostulanteEdit = $this->codPostulanteEdit;
    $estadoPostulanteEdit = $this->estadoPostulanteEdit;
    $response = ControllerPostulantes::ctrActualizarestadoPostulante($codPostulanteEdit, $estadoPostulanteEdit);
    echo json_encode($response);
  }

  //  Buscar postulante para vista de buscarPostulante
  public $codPostulanteBusqueda;
  public function ajaxBuscarPostulante()
  {
    $codPostulanteBusqueda = $this->codPostulanteBusqueda;
    $response = ControllerPostulantes::ctrBuscarPostulanteById($codPostulanteBusqueda);
    echo json_encode($response);
  }
  //  Insertar URL de descarga
  public $obtenerDownloadURL;
  public $codPostulanteUrl;
  public function ajaxObtenerDownloadURL()
  {
    $obtenerDownloadURL = $this->obtenerDownloadURL;
    $codPostulanteUrl = $this->codPostulanteUrl;
    $response = ControllerPostulantes::ctrObtenerDownloadURL($obtenerDownloadURL, $codPostulanteUrl);
    echo json_encode($response);
  }

  //  Obtener la URL desde la base de datos
  public $codPostulanteDownloadUrl;
  public function ajaxDownloadURL()
  {
    $codPostulanteDownloadUrl = $this->codPostulanteDownloadUrl;
    $response = ControllerPostulantes::ctrDownloadURL($codPostulanteDownloadUrl);
    echo json_encode($response);
  }


  //  Insertar URL de descarga psicologico
  public $obtenerDownloadURLPsicologico;
  public $codPostulanteUrlPsicologico;
  public function ajaxObtenerDownloadURLPsicologico()
  {
    $obtenerDownloadURLPsicologico = $this->obtenerDownloadURLPsicologico;
    $codPostulanteUrlPsicologico = $this->codPostulanteUrlPsicologico;
    $response = ControllerPostulantes::ctrObtenerDownloadURLPsicologico($obtenerDownloadURLPsicologico, $codPostulanteUrlPsicologico);
    echo json_encode($response);
  }

  //  Obtener la URL psicologico desde la base de datos 
  public $codPostulanteDownloadUrlPsicologico;
  public function ajaxDownloadURLPsicologico()
  {
    $codPostulanteDownloadUrlPsicologico = $this->codPostulanteDownloadUrlPsicologico;
    $response = ControllerPostulantes::ctrDownloadURLPsicologico($codPostulanteDownloadUrlPsicologico);
    echo json_encode($response);
  }

  //  editar checlist del postulante
  public $dataActualizarCheclist;
  public function ajaxEditarCheclistPostulante()
  {
    $dataActualizarCheclist = $this->dataActualizarCheclist;
    $response = ControllerPostulantes::ctrActualizarChecklist($dataActualizarCheclist);
    echo json_encode($response);
  }

  // vista de pagos detalles de pago
  public $codPago;
  public function ajaxMostrarDetallesPago()
  {
    $codPago = $this->codPago;
    $mostrarDetallesPago = ControllerPostulantes::ctrGetIdEditPago($codPago);
    $mostrarDetallesPago['idTipoPago'] = FunctionPostulantes::getTipoPagoEdit($mostrarDetallesPago["idTipoPago"]);
    echo json_encode($mostrarDetallesPago);
  }

  //  Obtener todos los postulantesRepostesAnio
  public function ajaxMostrarTodosLosPostulantesReportesAnio()
  {
    $todosLosPostulantesReportesAnio = ControllerPostulantes::ctrGetAllPostulantesReportesAnio();
    foreach ($todosLosPostulantesReportesAnio as &$postulantesReportAnio) {
      $postulantesReportAnio['apellidoNombre'] = FunctionPostulantes::getUnirNombreApellidoPostulantes($postulantesReportAnio["nombrePostulante"], $postulantesReportAnio["apellidoPostulante"]);
      $postulantesReportAnio['nivelAnioPostulante'] = FunctionPostulantes::separarTextoNivelPostulante($postulantesReportAnio["descripcionGrado"]);
      $postulantesReportAnio['GradoAnioPostulante'] = FunctionPostulantes::separarTextoGradoPostulante($postulantesReportAnio["descripcionGrado"]);
      $postulantesReportAnio['statePostulante'] = FunctionPostulantes::getestadoPostulantes($postulantesReportAnio["estadoPostulante"]);
      $postulantesReportAnio['buttonsPostulante'] = FunctionPostulantes::getBotonesPostulante($postulantesReportAnio["idPostulante"], $postulantesReportAnio["estadoPostulante"], $postulantesReportAnio["pagoMatricula"]);
      // Eliminar los campos nombrePostulante y apellidoPostulante y gradoPostulante despues de usarlos
      unset($postulantesReportAnio["nombrePostulante"]);
      unset($postulantesReportAnio["apellidoPostulante"]);
      unset($postulantesReportAnio["descripcionGrado"]);
    }
    echo json_encode($todosLosPostulantesReportesAnio);
  }
  //descargar todo el reporte de postulantes
  public function ajaxDescargarReportePostulantes($datos)
  {
    $todosLosRegistrosPostualntes = ControllerPostulantes::ctrGetAllRegistrosPostulantesReport($datos);
    echo json_encode($todosLosRegistrosPostualntes);
  }


}

//mostar todos los Postulantes DataTableAdmin
if (isset($_POST["todosLosPostulantesAdmin"])) {
  $mostrarTodosLosPostulantesAdmin = new PostulantesAjax();
  $mostrarTodosLosPostulantesAdmin->ajaxMostrarTodosLosPostulantesAdmin();
}
// Actualizar estado postulante
if (isset($_POST["codPostulanteEdit"]) && isset($_POST["estadoPostulanteEdit"])) {
  $actualizarEstado = new PostulantesAjax();
  $actualizarEstado->codPostulanteEdit = $_POST["codPostulanteEdit"];
  $actualizarEstado->estadoPostulanteEdit = $_POST["estadoPostulanteEdit"];
  $actualizarEstado->ajaxActualizarEstado();
}
//  Obtener datos del postulante por busqueda de postulante
if (isset($_POST["codPostulanteBusqueda"])) {
  $obtenerDataPostulante = new PostulantesAjax();
  $obtenerDataPostulante->codPostulanteBusqueda = $_POST["codPostulanteBusqueda"];
  $obtenerDataPostulante->ajaxBuscarPostulante();
}

//  Insertar URL de descarga
if (isset($_POST["downloadURL"]) && isset($_POST["codPostulante"])) {
  $obtenerDownloadURL = new PostulantesAjax();
  $obtenerDownloadURL->codPostulanteUrl = $_POST["codPostulante"];
  $obtenerDownloadURL->obtenerDownloadURL = $_POST["downloadURL"];
  $obtenerDownloadURL->ajaxObtenerDownloadURL();
}
// Obtener la URL desde la base de datos
if (isset($_POST["codPostulanteURL"])) {
  $DownloadURL = new PostulantesAjax();
  $DownloadURL->codPostulanteDownloadUrl = $_POST["codPostulanteURL"];
  $DownloadURL->ajaxDownloadURL();
}
//  Insertar URL de descarga
if (isset($_POST["downloadURLPsicologico"]) && isset($_POST["codPostulantePsicologico"])) {
  $obtenerDownloadURLPsicologico = new PostulantesAjax();
  $obtenerDownloadURLPsicologico->codPostulanteUrlPsicologico = $_POST["codPostulantePsicologico"];
  $obtenerDownloadURLPsicologico->obtenerDownloadURLPsicologico = $_POST["downloadURLPsicologico"];
  $obtenerDownloadURLPsicologico->ajaxObtenerDownloadURLPsicologico();
}

// Obtener la URL desde la base de datos
if (isset($_POST["codPostulanteURLPsicologico"])) {
  $obtenerDownloadURLPsicologico = new PostulantesAjax();
  $obtenerDownloadURLPsicologico->codPostulanteDownloadUrlPsicologico = $_POST["codPostulanteURLPsicologico"];
  $obtenerDownloadURLPsicologico->ajaxDownloadURLPsicologico();
}

// Obtener la URL desde la base de datos
if (isset($_POST["codPostulanteURLPsicologico"])) {
  $obtenerDownloadURLPsicologico = new PostulantesAjax();
  $obtenerDownloadURLPsicologico->codPostulanteDownloadUrlPsicologico = $_POST["codPostulanteURLPsicologico"];
  $obtenerDownloadURLPsicologico->ajaxDownloadURLPsicologico();
}
//  editar checlist del postulante
if (isset($_POST["actualizarCheclist"])) {
  $dataActualizarCheclist = new PostulantesAjax();
  $dataActualizarCheclist->dataActualizarCheclist = $_POST["actualizarCheclist"];
  $dataActualizarCheclist->ajaxEditarCheclistPostulante();
}
//  Obtener todos los postulantesRepostesAnio
if (isset($_POST["todosLosPostulantesReportesAnio"])) {
  $mostrarTodosLosPostulantesReportesAnio = new PostulantesAjax();
  $mostrarTodosLosPostulantesReportesAnio->ajaxMostrarTodosLosPostulantesReportesAnio();
}
// Descargar todo el reporte de postulantes
if (isset($_POST["reportesRegistrosPostualntes"])) {
  $todosLosRegistrosPostualntes = new PostulantesAjax();
  $todosLosRegistrosPostualntes->ajaxDescargarReportePostulantes($_POST["reportesRegistrosPostualntes"]);
}

// vista de pagos detalles de pago
if (isset($_POST["codPago"])) {
  $mostrarDetallesPago = new PostulantesAjax();
  $mostrarDetallesPago->codPago = $_POST["codPago"];
  $mostrarDetallesPago->ajaxMostrarDetallesPago();
}

