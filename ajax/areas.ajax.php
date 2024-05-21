<?php
require_once "../controller/areas.controller.php";
require_once "../model/areas.model.php";
require_once "../model/cursos.model.php";
require_once "../functions/areas.functions.php";

class AreasAjax
{
  /**
   * Función para mostrar todas las áreas mediante una petición AJAX.
   */
  public function ajaxMostrarTodasLasAreas()
  {
    $todasLasAreas = ControllerAreas::ctrGetAllAreas();
    foreach ($todasLasAreas as &$area) {
      $area['descripcion'] = $area['descripcionArea'];
      $area['buttons'] = FunctionAreas::getBtnAreas($area["idArea"]);
    }
    echo json_encode($todasLasAreas);
  }

  /**
   * Método para agregar un área mediante una petición AJAX.
   *
   * @param $dataRegistrarAreaModal Los datos del área a registrar.
   */
  public function ajaxAgregarArea($dataRegistrarAreaModal)
  {
    $dataRegistrarAreaModal = json_decode($dataRegistrarAreaModal, true);
    $respuesta = ControllerAreas::ctrAddArea($dataRegistrarAreaModal);
    echo  json_encode($respuesta);
  }

  /**
   * Elimina un área mediante una petición AJAX.
   *
   * @param int $idArea El ID del área a eliminar.
   */
  public function ajaxEliminarArea($idArea)
  {
    $respuesta = ControllerAreas::ctrEliminarArea($idArea);
    echo json_encode($respuesta);
  }

  /**
   * Obtiene un área mediante una petición AJAX.
   * 
   * @param int $idArea El ID del área a obtener.
   */
  public function ajaxObtenerArea($idArea)
  {
    $respuesta = ControllerAreas::ctrGetArea($idArea);
    echo json_encode($respuesta);
  }

  /**
   * Edita un área mediante una petición AJAX.
   * 
   * @param $dataEditarAreaModal Los datos del área a editar.
   */
  public function ajaxEditarArea($dataEditarAreaModal)
  {
    $dataEditarAreaModal = json_decode($dataEditarAreaModal, true);
    $respuesta = ControllerAreas::ctrEditarArea($dataEditarAreaModal);
    echo json_encode($respuesta);
  }
}

if (isset($_POST["mostrarTodasLasAreas"])) {
  $mostrarTodasLasAreas = new AreasAjax();
  $mostrarTodasLasAreas->ajaxMostrarTodasLasAreas();
}

if (isset($_POST["dataRegistrarAreaModal"])) {
  $agregarArea = new AreasAjax();
  $agregarArea->ajaxAgregarArea($_POST["dataRegistrarAreaModal"]);
}

if (isset($_POST["idArea"])) {
  $eliminarArea = new AreasAjax();
  $eliminarArea->ajaxEliminarArea($_POST["idArea"]);
}

if (isset($_POST["idAreaEditar"])) {
  $obtenerArea = new AreasAjax();
  $obtenerArea->ajaxObtenerArea($_POST["idAreaEditar"]);
}

if (isset($_POST["dataEditarAreaModal"])) {
  $editarArea = new AreasAjax();
  $editarArea->ajaxEditarArea($_POST["dataEditarAreaModal"]);
}
