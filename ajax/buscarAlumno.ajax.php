<?php

require_once "../controller/buscarAlumno.controller.php";
require_once "../model/buscarAlumno.model.php";
require_once "../functions/buscarAlumno.functions.php";
require_once "../model/apoderado.model.php";

class BuscarAlumnoAjax
{
  //mostar todos los Apoderados DataTable
  public function ajaxMostrartodasLasBusquedas()
  {
    $todasLasBusquedas = ControllerBuscarAlumno::ctrGetAllBusquedaAlumno();
    foreach ($todasLasBusquedas as &$dataBsucar) {
      $tabla = "apoderado";
      $todoslosApoderados = ModelApoderados::mdlGetAllApoderadosByAlumno($tabla, $dataBsucar["idAlumno"]);

      if (isset($todoslosApoderados[0])) {
        $dataBsucar['apoderado1Busqueda'] = $todoslosApoderados[0]["nombreApoderado"] . " " . $todoslosApoderados[0]["apellidoApoderado"];
        $dataBsucar['celularApoderado1'] = $todoslosApoderados[0]["celularApoderado"];
      } else {
        $dataBsucar['apoderado1Busqueda'] = 'No registrado';
        $dataBsucar['celularApoderado1'] = 'No registrado';
      }

      if (isset($todoslosApoderados[1])) {
        $dataBsucar['apoderado2Busqueda'] = $todoslosApoderados[1]["nombreApoderado"] . " " . $todoslosApoderados[1]["apellidoApoderado"];
        $dataBsucar['celularApoderado2'] = $todoslosApoderados[1]["celularApoderado"];
      } else {
        $dataBsucar['apoderado2Busqueda'] = 'No registrado';
        $dataBsucar['celularApoderado2'] = 'No registrado';
      }

      $dataBsucar['estadoAdmisionAlumno'] = FunctionBuscarAlumno::getEstadoAlumnoBuscar($dataBsucar["estadoAdmisionAlumno"]);
      $dataBsucar['estadoSiagie'] = FunctionBuscarAlumno::getEstadosBuscarSiagiue($dataBsucar["estadoSiagie"]);
    }
    echo json_encode($todasLasBusquedas);
  }
}
//mostar todos los Apoderados DataTable
if (isset($_POST["buscarAlumnos"])) {
  $mostrartodasLasBusquedas = new BuscarAlumnoAjax();
  $mostrartodasLasBusquedas->ajaxMostrartodasLasBusquedas();
}
