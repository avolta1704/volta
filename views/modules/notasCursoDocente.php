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

<!-- Modal Listar Cursos -->
<div class="modal fade" id="modalCompetenciaUnidad" tabindex="-1" aria-labelledby="modalCompetenciaUnidadLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCompetenciaUnidadLabel">Competencias Asiganadas a la Unidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-lg-4">
          <div class="row mb-2">
            <button type="button" class="btn btn-primary btnAgregarCompetencia gap-2 justify-content-center d-flex"
              data-bs-target="#modalIngresarCompetencia" data-bs-toggle="modal" id="btnAgregarCompetencia" idUnidad="">
              <i class="bi bi-plus-circle"></i> Agregar Competencia
            </button>
          </div>
        </div>

        <!--  Titulo dataTableCompetencias-->
        <table id="dataTableCompetencias" class="display dataTableCompetencias" style="width: 100%">
          <thead>
            <!-- dataTableCompetencias -->
          </thead>
          <tbody>
            <!--dataTableCompetencias-->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ingresar Competencias-->
<div class="modal fade" id="modalIngresarCompetencia" tabindex="-1" aria-labelledby="modalIngresarCompetenciaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalIngresarCompetenciaLabel">Inserte la Competencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="notaForm">
          <div class="form-group">
            <label for="notaText">Competencia:</label>
            <textarea class="form-control" id="notaText" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCerrarModalCompetencia" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnCrearCompetencia" idUnidad="">Crear Competencia</button>
      </div>
    </div>
  </div>
</div>