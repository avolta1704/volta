<?php

require_once "../controller/notas.controller.php";
require_once "../model/notas.model.php";
require_once "../controller/alumnos.controller.php";
require_once "../model/alumnos.model.php";
require_once "../controller/competencia.controller.php";
require_once "../model/competencia.model.php";

class AjaxCerrarNotas
{
  /**
   * Cerrar las notas de los criterios
   * 
   * @param string $data Id de la informacion
   */
  public function ajaxCerrarNotasCriterios($data)
  {
    $data = json_decode($data, true);
    $response = ControllerNotas::ctrCerrarNotasCriterios($data);
    echo json_encode($response);
  }
}

if (isset($_POST["cerrarNotasCriterios"])) {
  $cerrarNotas = new AjaxCerrarNotas();
  $cerrarNotas->ajaxCerrarNotasCriterios($_POST["cerrarNotasCriterios"]);
}
