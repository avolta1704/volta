<?php
$idCurso = $_GET["idCurso"];
$idGrado = $_GET["idGrado"];
$idPersonal = $_GET["idPersonal"];

$nombreCurso = ControllerCursos::ctrGetCurso($idCurso)["descripcionCurso"];
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4">Asistencia de los Alumnos para el curso <?php echo $nombreCurso ?></h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="cursosDocente">Cursos Asignados</a></li>
        <li class="breadcrumb-item active">Todos los Alumnos</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTableCursosDocenteAdmin-->
              <table id="dataTableAsistenciaAlumnos" class="display dataTableAsistenciaAlumnos " style="width: 100%">
                <thead>

                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>