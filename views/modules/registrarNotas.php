<?php

require_once 'controller/bimestre.controller.php';
require_once 'controller/cursos.controller.php';
require_once 'controller/gradoAlumno.controller.php';
require_once 'controller/unidad.controller.php';

$idBimestre = $_GET['idBimestre'];
$idCurso = $_GET['idCurso'];
$idGrado = $_GET['idGrado'];
$idUnidad = $_GET['idUnidad'];

$bimestre = ControllerBimestre::ctrObtenerBimestreById($idBimestre);
$unidad = ControllerUnidad::ctrObtenerUnidadById($idUnidad);
$curso = ControllerCursos::ctrGetCurso($idCurso);
$grado = ControllerGrado::ctrGetGradoById($idGrado);

?>
<main id="main" class="main">
  <div class="pagetitle">
    <h2 class="mt-4">Registrar Notas</h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="cursosDocente">Cursos Docente</a></li>
        <li class="breadcrumb-item active">Registrar notas</li>
      </ol>
    </nav>
  </div>
  <!-- Seccion para mostrar los datos del curso, grado, unidad y bimestre -->
  <section>
    <div class="card" style="width: 100%;">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <h4><i class="bi bi-bookmarks"></i> <?php echo $bimestre["descripcionBimestre"] ?></h4>
        </li>
        <li class="list-group-item">
          <h3> <i class="bi bi-bookmark"></i> <?php echo $unidad["descripcionUnidad"] ?></h3>
        </li>
        <li class="list-group-item">
          <h2><i class="bi bi-journal-bookmark"></i> <?php echo $grado["descripcionGrado"] ?></h2>
        </li>
        <li class="list-group-item">
          <h1><i class="bi bi-journal-text"></i> <?php echo $curso["descripcionCurso"] ?></h1>
        </li>
      </ul>
    </div>
  </section>

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableNotasAlumnosAdmin-->
              <table id="dataTableNotasAlumnos" class="display dataTableNotasAlumnos" style="width: 100%">
                <thead>
                  <!-- dataTableNotasAlumnosAdmin -->
                </thead>
                <tbody>
                  <!--dataTableNotasAlumnosAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>