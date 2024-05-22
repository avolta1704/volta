<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloAsignarCursos"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Asignar Cursos</li>
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
              <!--  Titulo dataTableAsignarCursosAdmin-->
              <table id="dataTableAsignarCursos" class="display dataTableAsignarCursos " style="width: 100%">
                <thead>
                  <!-- dataTableAsignarCursosAdmin -->
                </thead>
                <tbody>
                  <!--dataTableAsignarCursosAdmin-->
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
<div class="modal fade" id="modalListarCursos" tabindex="-1" aria-labelledby="modalListarCursosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalListarCursosLabel">Listado de Cursos Asignados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-lg-4">
          <div class="row mb-2">
            <button type="button" class="btn btn-primary btnAsignarNuevoCurso gap-2 justify-content-center d-flex" data-bs-target="#modalAsignarNuevoCurso" data-bs-toggle="modal" id="btnAsignarNuevoCurso" idGrado="">
              <i class="bi bi-plus-circle"></i> Asignar nuevo curso
            </button>
          </div>
        </div>

        <!--  Titulo dataTableCursosPorGradoAdmin-->
        <table id="dataTableCursosPorGrado" class="display dataTableCursosPorGrado" style="width: 100%">
          <thead>
            <!-- dataTableCursosPorGradoAdmin -->
          </thead>
          <tbody>
            <!--dataTableCursosPorGradoAdmin-->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Asignar Curso -->
<div class="modal fade" id="modalAsignarNuevoCurso" tabindex="-1" aria-labelledby="modalAsignarNuevoCursoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAsignarNuevoCursoLabel">Asignar Curso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAgregarCurso">
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="idCurso" class="form-label">Curso</label>
                <select class="form-select" id="selectCursos" name="selectCursos" required>
                  <option value="">Seleccione una opción</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnGuardarAsignacionCurso" id="btnGuardarAsignacionCurso" name="btnGuardarAsignacionCurso" btnGuardarAsignacionCurso="">Guardar</button>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>