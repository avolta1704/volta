<?php

require_once "../controller/docentes.controller.php";
require_once "../model/docentes.model.php";
require_once "../functions/docentes.functions.php";
require_once "../controller/nivelGrado.controller.php";
require_once "../model/nivelGrado.model.php";

class DocentesAjax
{
  //mostar todos los usuarios DataTable
  public function ajaxMostrarTodosLosDocentes()
  {
    $todosLosDocentes = ControllerDocentes::ctrGetAllDocentes();
    foreach ($todosLosDocentes as &$docente) {
      $docente['state'] = FunctionDocente::getEstadoocentes($docente["estadoUsuario"]);
      $getGrado = ControllerDocentes::ctrGetGrado($docente['idPersonal']);
      $docente['buttons'] = FunctionDocente::getBtnUsuarios($docente["idPersonal"], $docente["estadoUsuario"], $docente["idTipoPersonal"]);
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

