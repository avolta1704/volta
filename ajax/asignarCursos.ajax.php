<?php
//controller
require_once "../functions/cursos.functions.php";
require_once "../functions/asignarCursos.functions.php";
require_once "../controller/cursos.controller.php";
require_once "../model/cursos.model.php";

class ajaxAsignarCursos
{
  /**
   * Obtiene todos los grados por nivel.
   * 
   * @return array Retorna un array con los grados por nivel.
   */
  public function todosLosGradosPorNivel()
  {
    $todosLosGradosPorNivel = ControllerCursos::ctrGetGradosPorNivel();
    foreach ($todosLosGradosPorNivel as &$data) {
      $data['descripcionNivel'] = strval($data['descripcionNivel']);
      $data['descripcionGrado'] = strval($data['descripcionGrado']);
      $data['listaCursos'] = FunctionAsignarCursos::getButtonListarCursos($data['idGrado']);
    }
    echo json_encode($todosLosGradosPorNivel);
  }

  /**
   * Obtiene todos los cursos por grado.
   * 
   * @param int $idGrado El ID del grado.
   * @return array Retorna un array con los cursos por grado.
   */
  public function todosLosCursosPorGrado($idGrado)
  {
    $todosLosCursosPorGrado = ControllerCursos::ctrGetCursosPorGrado($idGrado);
    foreach ($todosLosCursosPorGrado as &$data) {
      $data['descripcionCurso'] = strval($data['descripcionCurso']);
      $data['buttons'] = FunctionAsignarCursos::getButtonDeleteCurso($data['idCurso']);
    }
    echo json_encode($todosLosCursosPorGrado);
  }

  /**
   * Obtiene todos los cursos sin asignar.
   * 
   * @param int $idGrado El ID del grado.
   * @return array Retorna un array con los cursos sin asignar.
   */
  public function todosLosCursosSinAsignar($idGrado)
  {
    $todosLosCursosSinAsignar = ControllerCursos::ctrGetCursosSinAsignar($idGrado);
    echo json_encode($todosLosCursosSinAsignar);
  }

  /**
   * Asigna un curso a un grado.
   * 
   * @param array $dataAsignarCurso El array con los datos para asignar un curso a un grado.
   * @return string Retorna un mensaje de éxito o error.
   */
  public function asignarCursoAGrado($dataAsignarCurso)
  {
    $response = ControllerCursos::ctrAsignarCursoAGrado($dataAsignarCurso);
    echo json_encode($response);
  }
}


if (isset($_POST["todosLosAsignarCursosAdmin"])) {
  $todosLosGradosPorNivel = new ajaxAsignarCursos();
  $todosLosGradosPorNivel->todosLosGradosPorNivel();
}

if (isset($_POST["idGrado"])) {
  $todosLosCursosPorGrado = new ajaxAsignarCursos();
  $todosLosCursosPorGrado->todosLosCursosPorGrado($_POST["idGrado"]);
}

if (isset($_POST["idGradoAsignar"])) {
  $todosLosCursosSinAsignar = new ajaxAsignarCursos();
  $todosLosCursosSinAsignar->todosLosCursosSinAsignar($_POST["idGradoAsignar"]);
}

if (isset($_POST["dataAsignarCurso"])) {
  $asignarCursoAGrado = new ajaxAsignarCursos();
  $asignarCursoAGrado->asignarCursoAGrado($_POST["dataAsignarCurso"]);
}
