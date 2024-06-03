<main id="main" class="main">
  <?php
  $idCurso = $_GET['idCurso'];
  $curso = ControllerCursos::ctrGetCurso($idCurso);
  ?>

  <div class="container-fluid">
    <div class="pagetitle">
      <h2 class="mt-4">Alumnos del curso <?php echo $curso["descripcionCurso"] ?></h2>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
          <li class="breadcrumb-item"><a href="cursosDocente">Cursos Docente</a></li>
          <li class="breadcrumb-item active">Notas de los Alumnos</li>
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
                <!-- Espacio añadido antes de los botones -->
                <div class="mb-4"></div>
                <!-- Contenedor de botones -->
                <div id="buttonContainer" class="mb-3"></div>
                <!-- Espacio añadido después del primer botónContainer -->
                <div class="mb-4"></div>
                <!-- Segundo contenedor de botones -->
                <div id="secondButtonContainer" class="mb-3"></div>
                <!-- Espacio añadido después del segundo botónContainer -->
                <div class="mb-4"></div>
                <!-- Tercer contenedor de botones -->
                <div id="thirdButtonContainer" class="mb-3"></div>
                <!--  Titulo dataTableNotasCursoDocenteAdmin-->
                <table id="dataTableNotasCursoDocente" class="display dataTableNotasCursoDocente " style="width: 100%">
                  <thead>
                    <!-- dataTableNotasCursoDocenteAdmin -->
                  </thead>
                  <tbody>
                    <!--dataTableNotasCursoDocenteAdmin-->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>