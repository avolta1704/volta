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
                <div class="table-responsive">
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
      </div>
    </section>
</main>

<!-- Modal Listar Cursos -->
<div class="modal fade" id="modalCompetenciaUnidad" tabindex="-1" aria-labelledby="modalCompetenciaUnidadLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCompetenciaUnidadLabel">Competencias Asignadas a la Unidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-auto">
            <button type="button" class="btn btn-primary btnAgregarCompetencia gap-2 justify-content-center d-flex me-2"
              data-bs-target="#modalIngresarCompetencia" data-bs-toggle="modal" id="btnAgregarCompetencia" idUnidad="">
              <i class="bi bi-plus-circle"></i> Agregar Competencia
            </button>
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-warning btnDuplicarCompetencia gap-2 justify-content-center d-flex"
              data-bs-target="#modalDuplicarCompetencia" data-bs-toggle="modal" id="btnDuplicarCompetencia" idUnidad="">
              <i class="bi bi-files"></i> Duplicar Competencias
            </button>
          </div>
        </div>
        <!--  Titulo dataTableCompetencias-->
        <div class="table-responsive">
          <table id="dataTableCompetencias" class="display dataTableCompetencias" style="width: 100%">
            <thead>
              <!-- dataTableCompetencias -->
            </thead>
            <tbody>
              <!--dataTableCompetencias-->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ingresar Competencias-->
<div class="modal fade" id="modalIngresarCompetencia" tabindex="-1" aria-labelledby="modalIngresarCompetenciaLabel"
  aria-hidden="true">
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
        <button type="button" class="btn btn-secondary" id="btnCerrarModalCompetencia"
          data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnCrearCompetencia" idUnidad="">Crear Competencia</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Modificar Competencias -->
<div class="modal fade" id="modalEditarCompetencia" tabindex="-1" aria-labelledby="modalEditarCompetenciaLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarCompetenciaLabel">Editar Competencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="notaForm">
          <div class="form-group">
            <label for="notaText">Competencia:</label>
            <textarea class="form-control" id="notaTextEditar" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCerrarModalEditarCompetencia"
          data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCompetencia">Guardar Competencia</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Duplicar Competencia -->
<div class="modal fade" id="modalDuplicarCompetencia" tabindex="-1" aria-labelledby="modalDuplicarCompetenciaLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDuplicarCompetenciaLabel">Duplicar Competencias</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Seleccione Competencias para Duplicar</label>
            <div id="competenciasContainer" class="ml-5">
              <!-- Aquí se agregarán las opciones desde JavaScript -->
              <div id="competenciasContainer">
                <input type="checkbox" id="competencia1">
                <label for="competencia1">Competencia 1</label>
                <input type="checkbox" id="competencia2">
                <label for="competencia2">Competencia 2</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnDuplicarCompetenciaModal">Insertar</button>
        <button type="button" class="btn btn-secondary" id="btnCerrarmodalDuplicarCompetencia"
          data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>