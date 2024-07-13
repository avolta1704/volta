<?php

require_once "../controller/anioescolar.controller.php";
require_once "../model/anioescolar.model.php";
require_once "../functions/anioescolar.functions.php";
require_once "../controller/alumnoAnioEscolar.controller.php";
require_once "../model/alumnoAnioEscolar.model.php";
require_once "../model/postulantes.model.php";
require_once "../controller/postulantes.controller.php"; 
require_once "../controller/admision.controller.php";
require_once "../model/admision.model.php";
require_once "../controller/admisionalumno.controller.php";
require_once "../model/admisionalumno.model.php";
require_once "../controller/anioAdmision.controller.php";
require_once "../model/anioAdmision.model.php";

class AnioEscolarAjax
{
  //  Listar todos los años escolares
  public static function ajaxMostrarTodosLosAnios()
  {
    $listaAnios = ControllerAnioEscolar::ctrGetTodosAniosEscolar();

    foreach ($listaAnios as &$anio) {
      $anio['descripcionAnio'] = strval($anio['descripcionAnio']);
      $anio['cuotaInicial'] = strval($anio['cuotaInicial']);
      $anio['botonesAnio'] = FunctionAnioEscolar::getButtonsAnioEscolar($anio["idAnioEscolar"], $anio["estadoAnio"]);
      // Definir el estado del anioescolar en numeros
      $anio['statusAnio'] = $anio['estadoAnio'];
      $anio['estadoAnio'] = FunctionAnioEscolar::getEstadoAnioEscolar($anio['estadoAnio']);

    }
    echo json_encode($listaAnios);
  }

  //  Crear un nuevo año escolar
  public function ajaxAgregarAnio($dataRegistrarAnio)
  {
    $dataRegistrarAnio = json_decode($dataRegistrarAnio, true);
    $respuesta = ControllerAnioEscolar::ctrCrearAnioEscolar($dataRegistrarAnio);
    echo json_encode($respuesta);
  }

  //  Buscar año escolar para luego editarlo
  public function ajaxBuscarAnio($codAnioBuscar)
  {
    $codAnioBuscar = json_decode($codAnioBuscar, true);
    $respuesta = ControllerAnioEscolar::ctrBuscarAnioEscolar($codAnioBuscar);
    echo json_encode($respuesta);
  }

  //  Editar un año escolar
  public function ajaxEditarAnio($dataEditarAnioEscolar)
  {
    $dataEditarAnioEscolar = json_decode($dataEditarAnioEscolar, true);
    $respuesta = ControllerAnioEscolar::ctrEditarAnioEscolar($dataEditarAnioEscolar);
    echo json_encode($respuesta);
  }

  //  Activar o Desactivar año escolar
  public function ajaxActivarAnio($dataActivarAnioEscolar)
  {
    $dataActivarAnioEscolar = json_decode($dataActivarAnioEscolar, true);
    $respuesta = ControllerAnioEscolar::ctrActivarAnioEscolar($dataActivarAnioEscolar);
    echo json_encode($respuesta);
  }

  //  Eliminar un año escolar
  public function ajaxEliminarAnio($codAnioEliminar)
  {
    $codAnioEliminar = json_decode($codAnioEliminar, true);
    $respuesta = ControllerAnioEscolar::ctrEliminarAnioEscolar($codAnioEliminar);
    echo json_encode($respuesta);
  }
  // Mostrar todos los grados para cerrar el año escolar
  public function ajaxMostrarGradosCerrarAnioEscolar()
  {
    $respuesta = ControllerAnioEscolar::ctrMostrarGradosCerrarAnioEscolar();

    foreach ($respuesta as &$grado) {
      $validarFinAnioEscolarAlumnosCerrarAnio =  ControllerAnioEscolar::ctrValidarFinAnioGradoAnioEscolar($grado["idGrado"]);
      if ($validarFinAnioEscolarAlumnosCerrarAnio == "error") {
        $status = 1;
      } else {
        $status = 0;
      }
      $grado['botonesGrado'] = FunctionAnioEscolar::getButtonsGradoCerrarAnioEscolar($grado["idGrado"],$status);
    }
    echo json_encode($respuesta);
  }
  public $idGradoCerrarAnioAlumnos;
  public function ajaxMostrarTodoAlumnosGradoCerrarAnioEscolar()
  {
    $idGradoCerrarAnioAlumnos = $this->idGradoCerrarAnioAlumnos;
    $respuesta = ControllerAnioEscolar::ctrMostrarAlumnosGradoCerrarAnio($idGradoCerrarAnioAlumnos);
    foreach ($respuesta as &$alumno) {
      $alumno['acciones'] = FunctionAnioEscolar::getSelectAlumnoCerrarAnioEscolar($alumno["idAlumno"], $alumno["idAnioEscolar"], $alumno["idGrado"], $alumno["estadoFinal"]);
    }
    echo json_encode($respuesta);
  }
  public static function ajaxActualizarEstadoFinalAlumnoAnioEscolarCerrarAnio($data)
  {
    $dataAlumnoAnioEscolarCerrarAnio = json_decode($data, true);
    $idGradoCerrarAnio = $dataAlumnoAnioEscolarCerrarAnio["idGrado"];
    $idAlumnoCerrarAnio = $dataAlumnoAnioEscolarCerrarAnio["idAlumno"];
    $idAnioEscolarCerrarAnio = $dataAlumnoAnioEscolarCerrarAnio["idAnioEscolar"];
    $estadoFinalCerrarAnio = $dataAlumnoAnioEscolarCerrarAnio["estadoFinal"];
    $respuesta = ControllerAnioEscolar::ctrActualizarEstadoFinalAlumnoAnioEscolarCerrarAnio($idGradoCerrarAnio, $idAnioEscolarCerrarAnio, $idAlumnoCerrarAnio, $estadoFinalCerrarAnio);
    echo json_encode($respuesta);
  }
  public $idGradoValidarDatosAlumnosCerrarAnio;
  public function ajaxValidarDatosSubidosAlumnoCerrarAnio()
  {
    $idGradoValidarDatosAlumnosCerrarAnio = $this->idGradoValidarDatosAlumnosCerrarAnio;
    $tabla = "alumno";
    $todosAlumnosMatriculadosGrado = ControllerAnioEscolar::ctrGetAlumnosMatriculadosGrado($tabla, $idGradoValidarDatosAlumnosCerrarAnio);

    foreach ($todosAlumnosMatriculadosGrado as &$alumno) {
      $idAlumno = $alumno["idAlumno"];
      $validacionNotas = ControllerAnioEscolar::ctrValidarNotasAlumnosSubidosCorrectamenteCerrarAnioAlumno($idAlumno, $tabla);
      $validacionEstadoFinal = ControllerAnioEscolar::ctrValidarEstadoFinalAlumnosSubidosCorrectamenteCerrarAnioAlumno($idAlumno, $tabla);

      if ($validacionNotas == "error" || $validacionEstadoFinal == "error") {
        if ($validacionNotas == "error") {
          $response = "errorNota";
        } else if ($validacionEstadoFinal == "error") {
          $response = "errorEstadoFinal";
        }
        echo json_encode($response);
        return; // Termina la función y el bucle
      }
    }
    // Si no hubo errores, retorna "ok"
    $response = "ok";
    echo json_encode($response);
  }
  public $idGradoCrearAlumnoAnioEscolarNuevo;
  public $idAnioEscolarNuevo;
  public function ajaxCrearAlumnoAnioEscolarNuevo()
  {
    $idGradoCrearAlumnoAnioEscolarNuevo = $this->idGradoCrearAlumnoAnioEscolarNuevo;
    $idAnioEscolarNuevo = $this->idAnioEscolarNuevo;
    $idGradoOriginal = $idGradoCrearAlumnoAnioEscolarNuevo;
    $idAnioEscolarActivo = ControllerAnioEscolar::ctrGetAnioEscolarActivo();

    $tabla = "alumno";
    $todosAlumnosMatriculadosGrado = ControllerAnioEscolar::ctrGetAlumnosMatriculadosGrado($tabla, $idGradoCrearAlumnoAnioEscolarNuevo);
    foreach ($todosAlumnosMatriculadosGrado as &$alumno) {
      $estadoFinal = $alumno["estadoFinal"];
      $idPostulante = ControllerPostulantes::mdlGetIdPostulanteporAlumno($alumno["idAlumno"]);
      if ($idGradoCrearAlumnoAnioEscolarNuevo != 14 && $estadoFinal == 1) {
        $idGradoCrearAlumnoAnioEscolarNuevo = $idGradoCrearAlumnoAnioEscolarNuevo + 1;
      } else if ($idGradoCrearAlumnoAnioEscolarNuevo == 14 && $estadoFinal == 1) {
        $response = ControllerAnioEscolar::ctrActualizarFinAnioAlumnoAnioEscolarCerrarAnio($idGradoOriginal, $idAnioEscolarActivo["idAnioEscolar"], $alumno["idAlumno"], 0);
        if ($response == "ok"){
          continue; // Pasar al siguiente alumno en el foreach
        }
      } else if ($estadoFinal == 3){
        $response = ControllerAnioEscolar::ctrActualizarFinAnioAlumnoAnioEscolarCerrarAnio($idGradoOriginal, $idAnioEscolarActivo, $alumno["idAlumno"], 0);
        if ($response == "ok"){
          continue; // Pasar al siguiente alumno en el foreach
        }
      }

      $arrayAnio = array(
        "idAnioEscolar" => $idAnioEscolarNuevo,
        "idAlumno" => $alumno["idAlumno"],
        "idGrado" => $idGradoCrearAlumnoAnioEscolarNuevo
      );
      $respuesta = ControllerAlumnoAnioEscolar::ctrCrearAlumnoAnioEscolar($arrayAnio);
      if ($respuesta == "ok"){
        $response = ControllerAnioEscolar::ctrActualizarFinAnioAlumnoAnioEscolarCerrarAnio($idGradoOriginal, $idAnioEscolarActivo, $alumno["idAlumno"], $idAnioEscolarNuevo);
        $idAdmisionNuevo = ControllerAdmision::ctrAdmisionEscolarActivaRegistroPostulante($idAnioEscolarNuevo, $idPostulante["idPostulante"], 1);
        $crearAdmisionAlumnoNuevo = ControllerAdmisionAlumno::ctrCrearAdmisionAlumnoCerrarAnio($idAdmisionNuevo, $alumno["idAlumno"]);
        if ($crearAdmisionAlumnoNuevo == "ok"){
          $idAdmisionAlumnoNuevo = ControllerAdmisionAlumno::ctrObtenerUltimoAdmisionAlumno();
          $respuesta = ControllerAnioAdmision::ctrCrearAnioAdmision($idAdmisionAlumnoNuevo["idAdmisionAlumno"], $idAnioEscolarNuevo);
        }
      } 
    }
    echo json_encode($respuesta);
  }
  public function ajaxCerrarAnioEscolarFinalDesactivar(){
    $respuesta = ControllerAnioEscolar::ctrCerrarAnioEscolarFinalDesactivar();
    echo json_encode($respuesta);
    
  }
}

//  Visualizar todos los años Escolares en el datatable
if (isset($_POST["todoslosAnios"])) {
  $mostrarAnios = new AnioEscolarAjax();
  $mostrarAnios->ajaxMostrarTodosLosAnios();
}

//  Registrar un nuevo año escolar
if (isset($_POST["dataRegistrarAnio"])) {
  $agregarAnio = new AnioEscolarAjax();
  $agregarAnio->ajaxAgregarAnio($_POST["dataRegistrarAnio"]);
}

//  Otener los datos del año escolar
if (isset($_POST["codAnioBuscar"])) {
  $buscarAnio = new AnioEscolarAjax();
  $buscarAnio->ajaxBuscarAnio($_POST["codAnioBuscar"]);
}

//  Editar un año escolar
if (isset($_POST["dataEditarAnioEscolar"])) {
  $editarAnio = new AnioEscolarAjax();
  $editarAnio->ajaxEditarAnio($_POST["dataEditarAnioEscolar"]);
}

//  Activar o desactivar un año escolar
if (isset($_POST["dataActivarAnioEscolar"])) {
  $activarAnioEscolar = new AnioEscolarAjax();
  $activarAnioEscolar->ajaxActivarAnio($_POST["dataActivarAnioEscolar"]);
}

//  Eliminar un año escolar
if (isset($_POST["codAnioEliminar"])) {
  $eliminarAnio = new AnioEscolarAjax();
  $eliminarAnio->ajaxEliminarAnio($_POST["codAnioEliminar"]);
}
// Todos los grados para cerrar anio escolar
if (isset($_POST["todosLosGradosCerrarAnioEscolar"])) {
  $mostrarGradoCerrarAnioEscolar = new AnioEscolarAjax();
  $mostrarGradoCerrarAnioEscolar->ajaxMostrarGradosCerrarAnioEscolar();
}
if (isset($_POST["idGradoCerrarAnioAlumnos"])) {
  $mostrarTodoAlumnosGradoCerrarAnioEscolar = new AnioEscolarAjax();
  $mostrarTodoAlumnosGradoCerrarAnioEscolar->idGradoCerrarAnioAlumnos = $_POST["idGradoCerrarAnioAlumnos"];
  $mostrarTodoAlumnosGradoCerrarAnioEscolar->ajaxMostrarTodoAlumnosGradoCerrarAnioEscolar();
}
if (isset($_POST["cambiarEstadoFinalAnioAlumno"])) {
  $actualizarEstadoFinalAlumnoAnioEscolar = new AnioEscolarAjax();
  $actualizarEstadoFinalAlumnoAnioEscolar->ajaxActualizarEstadoFinalAlumnoAnioEscolarCerrarAnio($_POST["cambiarEstadoFinalAnioAlumno"]);
}
if (isset($_POST["idGradoValidarDatosAlumnosCerrarAnio"])) {
  $validarDatosSubidosAlumnoCerrarAnio = new AnioEscolarAjax();
  $validarDatosSubidosAlumnoCerrarAnio->idGradoValidarDatosAlumnosCerrarAnio = $_POST["idGradoValidarDatosAlumnosCerrarAnio"];
  $validarDatosSubidosAlumnoCerrarAnio->ajaxValidarDatosSubidosAlumnoCerrarAnio();
}
if (isset($_POST["idGradoCrearAlumnoAnioEscolarNuevo"]) && isset($_POST["idAnioEscolarNuevo"])) {
  $crearAlumnoAnioEscolarNuevo = new AnioEscolarAjax();
  $crearAlumnoAnioEscolarNuevo->idGradoCrearAlumnoAnioEscolarNuevo = $_POST["idGradoCrearAlumnoAnioEscolarNuevo"];
  $crearAlumnoAnioEscolarNuevo->idAnioEscolarNuevo = $_POST["idAnioEscolarNuevo"];
  $crearAlumnoAnioEscolarNuevo->ajaxCrearAlumnoAnioEscolarNuevo();
}
if (isset($_POST["cerrarAnioEscolarFinalDesactivar"])){
  $cerrarAnioEscolarFinalDesactivar = new AnioEscolarAjax();
  $cerrarAnioEscolarFinalDesactivar->ajaxCerrarAnioEscolarFinalDesactivar();
}
