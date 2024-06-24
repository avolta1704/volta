<?php

require_once "../controller/inicio.controller.php";
require_once "../model/inicio.model.php";
require_once "../functions/usuarios.functions.php";

class InicioAjax
{
  public function ajaxObtenertodoslosAlumnosporGrandos()
  {
    $response = ControllerInicio::ctrObtenertodoslosAlumnosporGrandos();
    echo json_encode($response);
  }
  public function ajaxObtenertodaslasPensionesPendientes()
  {
    $response = ControllerInicio::ctrObtenertodaslasPensionesPendientes();
    echo json_encode($response);
  }
  public function ajaxObtenerTodoslosAlumnosporAnio()
  {
    $response = ControllerInicio::ctrObtenerTodoslosAlumnosporAnio();
    echo json_encode($response);
  }
  public function ajaxObtenerMontoRecaudadoporMeses()
  {
    $response = ControllerInicio::ctrObtenerMontoRecaudadoporMeses();
    echo json_encode($response);
  }
  public function ajaxObtenertodostodosPersonalInicio()
  {
    $response = ControllerInicio::ctrObtenerPersonalInicio();
    foreach ($response as &$personalInicio) {
      $personalInicio['state'] = FunctionUsuario::getEstadoUsuarios($personalInicio["estadoUsuario"]);
    }
    echo json_encode($response);
  }
  public $idUsuarioAsistenciaporMeses;
  public function ajaxObtenerAsistenciaporMeses()
  {
    $idUsuarioAsistenciaporMeses = $this->idUsuarioAsistenciaporMeses;
    $response = ControllerInicio::ctrObtenerAsistenciaporMeses($idUsuarioAsistenciaporMeses);
    echo json_encode($response);
  }
  public $idUsuarioCompetenciasNotas;
  public function ajaxObtenerCompetenciasNotas()
  {
    $idUsuarioCompetenciasNotas = $this->idUsuarioCompetenciasNotas;
    $response = ControllerInicio::ctrObtenerTodaslasCompetenciasNotas($idUsuarioCompetenciasNotas);
    $filteredResponse = [];
    foreach ($response as $competenciasNotas) {
      if ($competenciasNotas['notaCompetencia'] === null || $competenciasNotas['notaCompetencia'] === "") {
        $competenciasNotas['notaCompetencia'] = '<span class="badge rounded-pill bg-warning">Sin Asignar</span>';
        $filteredResponse[] = $competenciasNotas;
      }
    }
    echo json_encode($filteredResponse);
  }
  public $idUsuarioAlumnosAsignadosDocentes;
  public function ajaxObtenerTodoslosAlumnosAsignadosDocente()
  {
    $idUsuarioAlumnosAsignadosDocentes = $this->idUsuarioAlumnosAsignadosDocentes;
    $response = ControllerInicio::ctrObtenerTodoslosAlumnosAsignadosDocente($idUsuarioAlumnosAsignadosDocentes);
    echo json_encode($response);
  }
  public $idUsuarioCursosAsignadosDocentes;
  public function ajaxObtenerTotaldeCursosAsignados()
  {
    $idUsuarioCursosAsignadosDocentes = $this->idUsuarioCursosAsignadosDocentes;
    $response = ControllerInicio::ctrObtenerTotaldeCursosAsignados($idUsuarioCursosAsignadosDocentes);
    echo json_encode($response);
  }
  public function ajaxObtenerTotalDocenterCursosporGrado()
  {
    $response = ControllerInicio::ctrObtenerTotalDocenterCursosporGrado();
    echo json_encode($response);
  }
  public function ajaxObtenerNombreDocenteyCurso()
  {
    $response = ControllerInicio::ctrObtenerNombreDocenteyCurso();
    echo json_encode($response);
  }
  public function ajaxObtenerTodoslosDocentesporTipo()
  {
    $response = ControllerInicio::ctrObtenerTodoslosDocentesporTipo();
    echo json_encode($response);
  }
  public function ajaxObtenerTotalMasculinoFemeniniporGrados()
  {
    $response = ControllerInicio::ctrObtenerTotalMasculinoFemeniniporGrados();
    echo json_encode($response);
  }
  public function ajaxObtenerTodoslosAlumnosNuevosAntiguos()
  {
    $response = ControllerInicio::ctrObtenerTodoslosAlumnosNuevosAntiguos();
    echo json_encode($response);
  }
  public $idAlumnoApoderadoPagosPendientes;
  public function ajaxObtenerTodosPagosPendientesAlumnosApoderado()
  {
    $idAlumnoApoderadoPagosPendientes = $this->idAlumnoApoderadoPagosPendientes;
    $response = ControllerInicio::ctrObtenerTodosPagosPendientesAlumnosApoderado($idAlumnoApoderadoPagosPendientes);
    foreach ($response as &$pagosPendientesApoderado) {
      $pagosPendientesApoderado['status'] = FunctionUsuario::getEstadoPagos($pagosPendientesApoderado["estadoPago"]);
    }
    echo json_encode($response);
  }
  public $idAlumnoApoderadoFechaPago;
  public function ajaxObtenerFechaPagoApoderado()
  {
    $idAlumnoApoderadoFechaPago = $this->idAlumnoApoderadoFechaPago;
    $response = ControllerInicio::ctrObtenerFechaPagoApoderado($idAlumnoApoderadoFechaPago);
    echo json_encode($response);
  }
  public $idAlumnoAsistenciaporMesesApoderado;
  public function ajaxObtenerRegistroAsitenciaAlumnoApoderado()
  {
    $idAlumnoAsistenciaporMesesApoderado = $this->idAlumnoAsistenciaporMesesApoderado;
    $response = ControllerInicio::ctrObtenerRegistroAsitenciaAlumnoApoderado($idAlumnoAsistenciaporMesesApoderado);
    echo json_encode($response);
  }
  public $idAlumnoDetallesVistaApoderado;
  public function ajaxObtenerDetallesAlumnoApoderado()
  {
    $idAlumnoDetallesVistaApoderado = $this->idAlumnoDetallesVistaApoderado;
    $response = ControllerInicio::ctrObtenerDetallesAlumnoApoderado($idAlumnoDetallesVistaApoderado);
    echo json_encode($response);
  }
  public $idAlumnoCursosAsignados;
  public function ajaxObtenerTodoslosCursosAsignadosAlumno()
  {
    $idAlumnoCursosAsignados = $this->idAlumnoCursosAsignados;
    $response = ControllerInicio::ctrObtenerTodoslosCursosAsignadosAlumno($idAlumnoCursosAsignados);
    echo json_encode($response);
  }
  public $idAlumnoNotasBimestrePorCurso;
  public function ajaxObtenerTodasNotasBimestresporCursos()
  {
    $idAlumnoNotasBimestrePorCurso = $this->idAlumnoNotasBimestrePorCurso;
    $response = ControllerInicio::ctrObtenerTodasNotasBimestresporCursos($idAlumnoNotasBimestrePorCurso);
    foreach ($response as &$todaslNotasBimestrePorCurso) {
      $todaslNotasBimestrePorCurso['notaCambiada'] = FunctionUsuario::getNotasAsignadas($todaslNotasBimestrePorCurso["nota"]);
    }
    echo json_encode($response);
  }
}
// Obtener todos los Alumnos por Grado
if (isset($_POST["AlumnosporGrandos"])) {
  $todosAlumnosporGrandos = new InicioAjax();
  $todosAlumnosporGrandos->ajaxObtenertodoslosAlumnosporGrandos();
}
// Obtener todas las pensiones pendientes
if (isset($_POST["PensionesPendientes"])) {
  $todasPensionesPendientes = new InicioAjax();
  $todasPensionesPendientes->ajaxObtenertodaslasPensionesPendientes();
}
// Obtener todos los Alumnos por anio
if (isset($_POST["AlumnosporAnio"])) {
  $todosAlumnosporAnio = new InicioAjax();
  $todosAlumnosporAnio->ajaxObtenerTodoslosAlumnosporAnio();
}
// Obtener todo el monto recaudado por meses
if (isset($_POST["MontoRecaudadoporMeses"])) {
  $todosMontoRecaudadoporMeses = new InicioAjax();
  $todosMontoRecaudadoporMeses->ajaxObtenerMontoRecaudadoporMeses();
}
// Obtener todo el personal
if (isset($_POST["personalInicio"])) {
  $todosPersonalInicio = new InicioAjax();
  $todosPersonalInicio->ajaxObtenertodostodosPersonalInicio();
}
// Obtener el porcentaje de asistencia por meses
if (isset($_POST["idUsuarioAsistenciaporMeses"])) {
  $asistenciaporMeses = new InicioAjax();
  $asistenciaporMeses->idUsuarioAsistenciaporMeses = $_POST["idUsuarioAsistenciaporMeses"];
  $asistenciaporMeses->ajaxObtenerAsistenciaporMeses();
}
// Obtener todas las competencias y notas
if (isset($_POST["idUsuarioCompetenciasNotas"])) {
  $competenciasNotas = new InicioAjax();
  $competenciasNotas->idUsuarioCompetenciasNotas = $_POST["idUsuarioCompetenciasNotas"];
  $competenciasNotas->ajaxObtenerCompetenciasNotas();
}
// Obtener todos los alumnos asignados al docente
if (isset($_POST["idUsuarioAlumnosAsignadosDocentes"])) {
  $alumnosAsignadosDocentes = new InicioAjax();
  $alumnosAsignadosDocentes->idUsuarioAlumnosAsignadosDocentes = $_POST["idUsuarioAlumnosAsignadosDocentes"];
  $alumnosAsignadosDocentes->ajaxObtenerTodoslosAlumnosAsignadosDocente();
}
// Obtener el total de cursos asignados al docente
if (isset($_POST["idUsuarioCursosAsignadosDocentes"])) {
  $cursosAsignadosDocentes = new InicioAjax();
  $cursosAsignadosDocentes->idUsuarioCursosAsignadosDocentes = $_POST["idUsuarioCursosAsignadosDocentes"];
  $cursosAsignadosDocentes->ajaxObtenerTotaldeCursosAsignados();
}
// Obtener el total de docentes y cursos por grado
if (isset($_POST["docentesCursosporGrado"])) {
  $docentesCursosporGrado = new InicioAjax();
  $docentesCursosporGrado->ajaxObtenerTotalDocenterCursosporGrado();
}
// Obtener los nombres de los docentes y cursos
if (isset($_POST["nombreDocenteyCurso"])) {
  $nombreDocenteyCurso = new InicioAjax();
  $nombreDocenteyCurso->ajaxObtenerNombreDocenteyCurso();
}
// Obtener todos los docentes por tipo
if (isset($_POST["totalDocenteporTipo"])) {
  $totalDocentesporTipo = new InicioAjax();
  $totalDocentesporTipo->ajaxObtenerTodoslosDocentesporTipo();
}
// Obtener el total de masculino y femenino por grados
if (isset($_POST["totalMasculinoFemenino"])) {
  $totalMasculinoFemenino = new InicioAjax();
  $totalMasculinoFemenino->ajaxObtenerTotalMasculinoFemeniniporGrados();
}
// Obtener todos los alumnos nuevos y antiguos
if (isset($_POST["alumnosNuevosAntiguos"])) {
  $alumnosNuevosAntiguos = new InicioAjax();
  $alumnosNuevosAntiguos->ajaxObtenerTodoslosAlumnosNuevosAntiguos();
}
// Obtener todos los pagos pendientes de los alumnos por apoderado
if (isset($_POST["idAlumnoApoderadoPagosPendientes"])) {
  $pagosAlumnoApoderado = new InicioAjax();
  $pagosAlumnoApoderado->idAlumnoApoderadoPagosPendientes = $_POST["idAlumnoApoderadoPagosPendientes"];
  $pagosAlumnoApoderado->ajaxObtenerTodosPagosPendientesAlumnosApoderado();
}
// Obtener la fecha de pago por apoderado
if(isset($_POST["idAlumnoApoderadoFechaPago"])){
  $fechaPagoApoderado = new InicioAjax();
  $fechaPagoApoderado->idAlumnoApoderadoFechaPago = $_POST["idAlumnoApoderadoFechaPago"];
  $fechaPagoApoderado->ajaxObtenerFechaPagoApoderado();
}
// Obtener el registro de asistencia por meses por apoderado
if (isset($_POST["idAlumnoAsistenciaporMesesApoderado"])) {
  $asistenciaporMesesApoderado = new InicioAjax();
  $asistenciaporMesesApoderado->idAlumnoAsistenciaporMesesApoderado = $_POST["idAlumnoAsistenciaporMesesApoderado"];
  $asistenciaporMesesApoderado->ajaxObtenerRegistroAsitenciaAlumnoApoderado();
}
// Obtener los detalles del alumno por apoderado
if(isset($_POST["idAlumnoDetallesVistaApoderado"])){
  $detallesAlumnoApoderado = new InicioAjax();
  $detallesAlumnoApoderado->idAlumnoDetallesVistaApoderado = $_POST["idAlumnoDetallesVistaApoderado"];
  $detallesAlumnoApoderado->ajaxObtenerDetallesAlumnoApoderado();
}
// Obtener todos los cursos asignados al alumno
if (isset($_POST["idAlumnoCursosAsignados"])) {
  $cursosAsignadosAlumno = new InicioAjax();
  $cursosAsignadosAlumno->idAlumnoCursosAsignados = $_POST["idAlumnoCursosAsignados"];
  $cursosAsignadosAlumno->ajaxObtenerTodoslosCursosAsignadosAlumno();
}
// Obtener todas las notas bimestrales por cursos
if (isset($_POST["idAlumnoNotasBimestrePorCurso"])){
  $todasNotasBimestrePorCurso = new InicioAjax();
  $todasNotasBimestrePorCurso->idAlumnoNotasBimestrePorCurso = $_POST["idAlumnoNotasBimestrePorCurso"];
  $todasNotasBimestrePorCurso->ajaxObtenerTodasNotasBimestresporCursos();
}