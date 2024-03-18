<?php

require_once "../controller/pagos.controller.php";
require_once "../model/pagos.model.php";
require_once "../functions/pagos.functions.php";

class PagosAjax
{ 
  //mostar todos los Alumno dataTablePagosAdmin
/*   public function ajaxMostrarTodosLosPagosAdmin()
  {
    $todosLosPagosAdmin = ControllerPagos::ctrGetAllPagos();
    foreach ($todosLosPagosAdmin as &$dataPagos) {
      $dataPagos['stateAlumno'] = FunctionPagos::getEstadosAlumnos($dataPagos["estadoAlumno"]);
      $dataPagos['buttonsAlumno'] = FunctionPagos::getBotonesAlumnos($dataPagos["idAlumno"],$dataPagos["estadoAlumno"]);
    }
    echo json_encode($todosLosPagosAdmin);
  } */

}
//mostar todos los Alumnos DataTableAdmin
/* if (isset($_POST["todosLosPagosAdmin"])) {
  $mostrarTodosLosPagosAdmin = new PagosAjax();
  $mostrarTodosLosPagosAdmin->ajaxMostrarTodosLosPagosAdmin();
}
 */