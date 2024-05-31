<?php

require_once "../controller/docentes.controller.php";
require_once "../model/docentes.model.php";
require_once "../functions/docentes.functions.php";
require_once "../controller/nivelGrado.controller.php";
require_once "../model/nivelGrado.model.php";
require_once "../controller/cursos.controller.php";
require_once "../model/cursos.model.php";
require_once "../controller/anioescolar.controller.php";
require_once "../model/anioescolar.model.php";
require_once "../controller/anioCursoGrado.controller.php";
require_once "../model/anioCursoGrado.model.php";
require_once "../functions/cursosDocente.functions.php";

class DocentesAjax
{
  //mostar todos los usuarios DataTable
  public function ajaxMostrarTodosLosDocentes()
  {
    $todosLosDocentes = ControllerDocentes::ctrGetAllDocentes();
    foreach ($todosLosDocentes as &$docente) {
      $docente['state'] = FunctionDocente::getEstadoocentes($docente["estadoUsuario"]);
      $getGrado = ControllerDocentes::ctrGetGrado($docente['idPersonal']);
      $docente['buttons'] = FunctionDocente::getBtnUsuarios($docente["idPersonal"], $docente["estadoUsuario"], $docente["idTipoPersonal"], $docente["idUsuario"]);
      $docente["grado"] = FunctionDocente::getGrado($getGrado);
    }
    echo json_encode($todosLosDocentes);
  }

  //mostar todos los usuarios DataTable
  public function ajaxMostrarGradosPorTipoDocente()
  {
    $tipoDocente = $_POST["tipoDocente"];
    if ($tipoDocente == 4) {
      $listaGrados = ControllerNivelGrado::ctrGetAllGrados();
    } else {
      $listaGrados = ControllerNivelGrado::ctrGetGradosByNivel($tipoDocente);
    }
    echo json_encode($listaGrados);
  }
  public function ajaxMostrarCursosporNivel()
  {
    $todosLosCursos = ControllerDocentes::ctrGetCurso();
    echo json_encode($todosLosCursos);
  }

  //  Obtener Id Curso Grado
  public $gradoSeleccionado;
  public $cursoSeleccionado;
  public $idPersonal;
  public function ajaxobtenerIdCursogrado()
  {
    $gradoSeleccionado = $this->gradoSeleccionado;
    $cursoSeleccionado = $this->cursoSeleccionado;
    $idPersonal = $this->idPersonal;
    if ($cursoSeleccionado == null) {
      $TodoslosidCursos = ControllerDocentes::ctroObteneridCursos($gradoSeleccionado);
      $idPersonal = $this->idPersonal;
      foreach ($TodoslosidCursos as $todosid) {
        $descripcionArea = $todosid['descripcionArea'];
        if ($descripcionArea != "General") {
          $idcursoGrado = $todosid['idCursoGrado'];
          $response1 = ControllerDocentes::ctroAsignarCurso($idPersonal, $idcursoGrado);
        }
      }
      echo json_encode($response1);

    } else {
      $idPersonal = $this->idPersonal;
      $response = ControllerDocentes::ctrobtenerIdCursogrado($gradoSeleccionado, $cursoSeleccionado);
      foreach ($response as &$cursoGrado) {
        $idcursoGrado = $cursoGrado;
      }
      $response1 = ControllerDocentes::ctroAsignarCurso($idPersonal, $idcursoGrado);
      echo json_encode($response1);
    }
  }

  //  Cambiar estado del docente
  public $cambiarEstadoDocente;
  public $idUsuarioEstado;
  public function ajaxCambiarEstadoDocente()
  {
    $cambiarEstadoDocente = $this->cambiarEstadoDocente;
    $idUsuarioEstado = $this->idUsuarioEstado;
    $response = ControllerDocentes::ctrCambiarEstadoDocente($idUsuarioEstado, $cambiarEstadoDocente);
    echo json_encode($response);
  }

  //  Todos los cursos asiganados al docente
  public $codPersonal;
  public function ajaxCursosporDocente()
  {
    $codPersonal = $this->codPersonal;
    $todoslosCursosDocentes = ControllerDocentes::ctrCursosporDocente($codPersonal);
    foreach ($todoslosCursosDocentes as &$data) {
      $data['descripcionCurso'] = strval($data['descripcionCurso']);
      $data['descripcionNivelGrado'] = $data['descripcionNivel'] . ' - ' . $data['descripcionGrado'];
      $data['buttons'] = FunctionDocente::getButtonDeleteCurso($data['idCursogradoPersonal']);
    }
    echo json_encode($todoslosCursosDocentes);
  }
  //  Eliminar curso asignado al docente
  public $idCursogradoPersonal;
  public function ajaxEliminarIdCursoGrado()
  {
    $idCursogradoPersonal = $this->idCursogradoPersonal;
    $response = ControllerDocentes::ctrEliminarCursoGradoPersonal($idCursogradoPersonal);
    echo json_encode($response);
  }

  //  Verificar si exsite un docente asignado
  public $gradoSeleccionadoVerificar;
  public $cursoSeleccionadoVerificar;
  public function ajaxobtenerIdPersonalDocenteAsignado()
  {
    $gradoSeleccionadoVerificar = $this->gradoSeleccionadoVerificar;
    $cursoSeleccionadoVerificar = $this->cursoSeleccionadoVerificar;
    if ($cursoSeleccionadoVerificar != null) {
      $idPersonaldeCursos = ControllerDocentes::ctroObteneridPersonal($gradoSeleccionadoVerificar, $cursoSeleccionadoVerificar);
    } else {
      $idPersonaldeCursos = ControllerDocentes::ctroObteneridPersonalGrado($gradoSeleccionadoVerificar);
    }
    echo json_encode($idPersonaldeCursos);
  }

  //  Reasignar Docente
  public $gradoSeleccionadoCambio;
  public $cursoSeleccionadoCambio;
  public $idPersonalCambio;
  public function ajaxReasignarDocente()
  {
    $gradoSeleccionadoCambio = $this->gradoSeleccionadoCambio;
    $cursoSeleccionadoCambio = $this->cursoSeleccionadoCambio;
    $idPersonaldeCursos = ControllerDocentes::ctroObteneridPersonal($gradoSeleccionadoCambio, $cursoSeleccionadoCambio);
    $idPersonalCambio = $this->idPersonalCambio;
    if ($cursoSeleccionadoCambio != null) {
      foreach ($idPersonaldeCursos as $todosid) {
        $idPersonalRepetido = $idPersonaldeCursos['idPersonal'];
        $idcursogradoRepetido = $idPersonaldeCursos['idCursoGrado'];
        $response1 = ControllerDocentes::ctroCambiarIdPersonal($idPersonalRepetido, $idPersonalCambio, $idcursogradoRepetido);
      }
      echo json_encode($response1);
    } else {
      $TodoslosidCursos = ControllerDocentes::ctroObteneridCursosReemplaza($gradoSeleccionadoCambio);
      $idPersonalCambio = $this->idPersonalCambio;
      foreach ($TodoslosidCursos as $todosid) {
        $descripcionArea = $todosid['descripcionArea'];
        if ($descripcionArea != "General") {
          $idcursoGrado = $todosid['idCursoGrado'];
          $idPersonalExistente = $todosid['idPersonal'];
          $response1 = ControllerDocentes::ctroCambiarIdPersonal($idPersonalExistente, $idPersonalCambio, $idcursoGrado);
        }
      }
      echo json_encode($response1);
    }
  }

  /**
   * Obtener los cursos asignados al docente
   *
   * @return array $response Array con los cursos asignados al docente
   */
  public function ajaxObtenerCursosAsignados()
  {
    $response = ControllerDocentes::ctrObtenerCursosAsignados();
    // Verificar si $response es un array antes de usarlo en foreach
    if (is_array($response)) {
      foreach ($response as &$curso) {
        $curso["acciones"] = FunctionCursosDocente::getAccionesCursosDocente($curso["idCurso"], $curso["idGrado"], $curso["idPersonal"]);
      }

      // Enviar la respuesta como JSON
      echo json_encode($response);
    } else {
      // Manejar el caso en que $response no es un array
      echo json_encode(array("error" => "No se recibieron los datos esperados."));
    }
  }
}

//mostar todos los usuarios DataTable
if (isset($_POST["todosLosDocentes"])) {
  $mostrarTodosLosDocentes = new DocentesAjax();
  $mostrarTodosLosDocentes->ajaxMostrarTodosLosDocentes();
}

//  Obtener grados por tipo de docente
if (isset($_POST["tipoDocente"])) {
  $obtenerGrados = new DocentesAjax();
  $obtenerGrados->ajaxMostrarGradosPorTipoDocente();
}

//  Obtener grados por tipo de docente
if (isset($_POST["todosloscursos"])) {
  $obtenerGrados = new DocentesAjax();
  $obtenerGrados->ajaxMostrarCursosporNivel();
}

//  Obtener el idCursoGrado
if (isset($_POST["gradoSeleccionado"]) && isset($_POST["cursoSeleccionado"]) && isset($_POST["idPersonal"])) {
  $obtenerIdCursogrado = new DocentesAjax();
  $obtenerIdCursogrado->gradoSeleccionado = $_POST["gradoSeleccionado"];
  $obtenerIdCursogrado->cursoSeleccionado = $_POST["cursoSeleccionado"];
  $obtenerIdCursogrado->idPersonal = $_POST["idPersonal"];
  $obtenerIdCursogrado->ajaxobtenerIdCursogrado();
}

//  Cambiar estado del docente
if (isset($_POST["idUsuarioEstado"]) && isset($_POST["docenteEstado"])) {
  $cambiarEstadoDocente = new DocentesAjax();
  $cambiarEstadoDocente->idUsuarioEstado = $_POST["idUsuarioEstado"];
  $cambiarEstadoDocente->cambiarEstadoDocente = $_POST["docenteEstado"];
  $cambiarEstadoDocente->ajaxCambiarEstadoDocente();

}

//  Obtener todos los cursos asignados al docente
if (isset($_POST["codPersonal"]) && isset($_POST["btnListarCursosPorGrado"])) {
  $todoslosCursosporDocente = new DocentesAjax();
  $todoslosCursosporDocente->codPersonal = $_POST["codPersonal"];
  $todoslosCursosporDocente->ajaxCursosporDocente();

}

//  Eliminar Curso asiganado al docente
if (isset($_POST["idCursogradoPersonal"])) {
  $eliminaridCursoGrado = new DocentesAjax();
  $eliminaridCursoGrado->idCursogradoPersonal = $_POST["idCursogradoPersonal"];
  $eliminaridCursoGrado->ajaxEliminarIdCursoGrado();

}

//  Verificar si existe un docente asignado al curso
if (isset($_POST["gradoSeleccionado"]) && isset($_POST["cursoSeleccionado"]) && isset($_POST["validarSiExsite"])) {
  $validarSiExsiteDocenteAsignado = new DocentesAjax();
  $validarSiExsiteDocenteAsignado->gradoSeleccionadoVerificar = $_POST["gradoSeleccionado"];
  $validarSiExsiteDocenteAsignado->cursoSeleccionadoVerificar = $_POST["cursoSeleccionado"];
  $validarSiExsiteDocenteAsignado->ajaxobtenerIdPersonalDocenteAsignado();
}

//  Reasignar Docente
if (isset($_POST["gradoSeleccionadoCambio"]) && isset($_POST["cursoSeleccionadoCambio"]) && isset($_POST["idPersonalCambio"])) {
  $reasignarDocente = new DocentesAjax();
  $reasignarDocente->gradoSeleccionadoCambio = $_POST["gradoSeleccionadoCambio"];
  $reasignarDocente->cursoSeleccionadoCambio = $_POST["cursoSeleccionadoCambio"];
  $reasignarDocente->idPersonalCambio = $_POST["idPersonalCambio"];
  $reasignarDocente->ajaxReasignarDocente();
}



// Obtener los cursos asignados al docente
if (isset($_POST["todosLosCursosAsignados"])) {
  $obtenerCursosAsignados = new DocentesAjax();
  $obtenerCursosAsignados->ajaxObtenerCursosAsignados();
}
