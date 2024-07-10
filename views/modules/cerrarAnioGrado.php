<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloCerraAnioGrado"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item">Seguimiento</li>
        <li class="breadcrumb-item"><a href="anioEscolar">Año Lectivo</a></li>
        <li class="breadcrumb-item active">Grados</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableCerrarAnioGrados-->
              <table id="dataTableCerrarAnioGrados" class="display dataTableCerrarAnioGrados " style="width: 100%">
                <thead>
                  <!-- dataTableCerrarAnioGrados -->
                </thead>
                <tbody>
                  <!--dataTableCerrarAnioGrados-->
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
<div class="modal fade" id="modalCerrarAnioAlumnos" tabindex="-1" aria-labelledby="modalCerrarAnioAlumnosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCompetenciaUnidadLabel">Alumnos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-auto">
            <button type="button" class="btn btn-primary btnAgregarCompetencia gap-2 justify-content-center d-flex me-2">
              <i class="bi bi-plus-circle"></i> Agregar Competencia
            </button>
          </div>
        </div>
        <!--  Titulo dataTableCompetencias-->
        <div class="table-responsive">
          <table id="dataTableCerrarAnioAlumnos" class="display dataTableCerrarAnioAlumnos" style="width: 100%">
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
