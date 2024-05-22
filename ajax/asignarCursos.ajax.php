<?php
//controller
require_once "../functions/cursos.functions.php";
require_once "../functions/asignarCursos.functions.php";
require_once "../controller/cursos.controller.php";
require_once "../model/cursos.model.php";

class ajaxAsignarCursos
{
  public function todosLosGradosPorNivel()
  {
    $todosLosGradosPorNivel = ControllerCursos::ctrGetGradosPorNivel();
    foreach ($todosLosGradosPorNivel as &$data) {
      $data['descripcionNivel'] = strval($data['descripcionNivel']);
      $data['descripcionGrado'] = strval($data['descripcionGrado']);
      $data['listaCursos'] = FunctionAsignarCursos::getButtonListarCursos();
    }
    echo json_encode($todosLosGradosPorNivel);
  }
}


if (isset($_POST["todosLosAsignarCursosAdmin"])) {
  $todosLosGradosPorNivel = new ajaxAsignarCursos();
  $todosLosGradosPorNivel->todosLosGradosPorNivel();
}
