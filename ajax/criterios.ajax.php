<?php

require_once "../controller/criterios.controller.php";
require_once "../model/criterios.model.php";
require_once "../functions/criterios.functions.php";

class CriteriosAjax
{
  /**
   * Obtiene todos los criterios de una competencia mediante una petición AJAX.
   * 
   * @param int $idCompetencia El ID de la competencia.
   * @return array Los criterios de la competencia.
   */
  public function ajaxTodoLosCriterios($idCompetencia)
  {
    $todosLosCriterios = ControllerCriterios::ctrGetAllCriterios($idCompetencia);
    echo json_encode($todosLosCriterios);
  }

  /**
   * Obtiene todas las técnicas mediante una petición AJAX.
   * 
   * @return array Las técnicas.
   */
  public function ajaxTodasLasTecnicas()
  {
    $allTecnicas = ControllerCriterios::ctrGetAllTecnicas();
    echo json_encode($allTecnicas);
  }

  /**
   * Obtiene los instrumentos de una técnica mediante una petición AJAX.
   * 
   * @param int $idTecnica El ID de la técnica.
   * @return array Los instrumentos de la técnica.
   */
  public function ajaxInstrumentosByIdTecnica($idTecnica)
  {
    $instrumentosByIdTecnica = ControllerCriterios::ctrGetInstrumentosByIdTecnica($idTecnica);
    echo json_encode($instrumentosByIdTecnica);
  }

  /**
   * Crea un criterio mediante una petición AJAX.
   * 
   * @param int $idCompetencia El ID de la competencia.
   * @param string $nuevoCriterio El criterio a crear.
   * @return string $respuesta La respuesta de la creación del criterio ok si se creo y error si hubo un error.
   */
  public function ajaxCrearCriterio($idCompetencia, $nuevoCriterio)
  {
    $nuevoCriterio = json_decode($nuevoCriterio, true);
    $respuesta = ControllerCriterios::ctrCrearCriterio($idCompetencia, $nuevoCriterio);
    echo json_encode($respuesta);
  }
}


if (isset($_POST["idCompetencia"])) {
  $todosLosCriterios = new CriteriosAjax();
  $todosLosCriterios->ajaxTodoLosCriterios($_POST["idCompetencia"]);
}

if (isset($_POST["allTecnicas"])) {
  $allTecnicas = new CriteriosAjax();
  $allTecnicas->ajaxTodasLasTecnicas();
}

if (isset($_POST["idTecnicaEvaluacion"])) {
  $instrumentosByIdTecnica = new CriteriosAjax();
  $instrumentosByIdTecnica->ajaxInstrumentosByIdTecnica($_POST["idTecnicaEvaluacion"]);
}

if (isset($_POST["idCompetenciaNuevoCriterio"]) && isset($_POST["nuevoCriterio"])) {
  $crearCriterio = new CriteriosAjax();
  $crearCriterio->ajaxCrearCriterio($_POST["idCompetenciaNuevoCriterio"], $_POST["nuevoCriterio"]);
}
