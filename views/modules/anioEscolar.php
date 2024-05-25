<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloAnio"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item">Seguimiento</li>
        <li class="breadcrumb-item active">Año Lectivo</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary gap-2 justify-content-center d-flex btnAgregarCurso" data-bs-target="#modalAgregarAnio" data-bs-toggle="modal">
            <i class="bi bi-plus-circle"></i> Año Escolar</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTable Años lectivos-->
              <table id="dataTableAnios" class="display dataTableAnios " style="width: 100%">
                <thead>
                  <!-- dataTable Años lectivos -->
                </thead>
                <tbody>
                  <!--dataTable Años lectivos-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal crear año -->
<div class="modal fade" id="modalAgregarAnio" tabindex="-1" aria-labelledby="modalAgregarAnio" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight:bold">Agregar Nuevo Año Escolar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formRegistrarAnio">
          <div class="mb-3">
            <label for="descripcionAnio" class="form-label" style="font-weight:bold">Nuevo Año Escolar</label>
            <input type="number" step="1" class="form-control" id="descripcionAnio" name="descripcionAnio" required />
          </div>

          <div class="mb-3">
            <label for="cuotaIngreso" class="form-label" style="font-weight:bold">Cuota de Ingreso</label>
            <input type="number" step="0.1" class="form-control" id="cuotaIngreso" name="cuotaIngreso" required />
          </div>

          <div class="mb-3">
            <label for="matriculaInicial" class="form-label" style="font-weight:bold">Matrícula Inicial</label>
            <input type="number" step="0.1" class="form-control" id="matriculaInicial" name="matriculaInicial" required />
          </div>

          <div class="mb-3">
            <label for="pensionInicial" class="form-label" style="font-weight:bold">Pensión Inicial</label>
            <input type="number" step="0.1" class="form-control" id="pensionInicial" name="pensionInicial" required />
          </div>

          <div class="mb-3">
            <label for="matriculaPrimaria" class="form-label" style="font-weight:bold">Matrícula Primaria</label>
            <input type="number" step="0.1" class="form-control" id="matriculaPrimaria" name="matriculaPrimaria" required />
          </div>

          <div class="mb-3">
            <label for="pensionPrimaria" class="form-label" style="font-weight:bold">Pensión Primaria</label>
            <input type="number" step="0.1" class="form-control" id="pensionPrimaria" name="pensionPrimaria" required />
          </div>

          <div class="mb-3">
            <label for="matriculaSecundaria" class="form-label" style="font-weight:bold">Matrícula Secundaria</label>
            <input type="number" step="0.1" class="form-control" id="matriculaSecundaria" name="matriculaSecundaria" required />
          </div>

          <div class="mb-3">
            <label for="pensionSecundaria" class="form-label" style="font-weight:bold">Pensión Secundaria</label>
            <input type="number" step="0.1" class="form-control" id="pensionSecundaria" name="pensionSecundaria" required />
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnRegistrarAnioEscolar" id="btnRegistrarAnioEscolar" name="btnRegistrarAnioEscolar">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal editar año -->
<div class="modal fade" id="modalEditarAnio" tabindex="-1" aria-labelledby="modalEditarAnioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarAnioLabel" style="font-weight:bold">Editar Año Escolar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarAnio">
          <div class="mb-3">
            <label for="editarDescripcionAnio" class="form-label" style="font-weight:bold">Nuevo Año Escolar</label>
            <input type="number" step="1" class="form-control" id="editarDescripcionAnio" name="editarDescripcionAnio" required />
          </div>

          <div class="mb-3">
            <label for="editarCuotaIngreso" class="form-label" style="font-weight:bold">Cuota de Ingreso</label>
            <input type="number" step="0.1" class="form-control" id="editarCuotaIngreso" name="editarCuotaIngreso" required />
          </div>

          <div class="mb-3">
            <label for="editarMatriculaInicial" class="form-label" style="font-weight:bold">Matrícula Inicial</label>
            <input type="number" step="0.1" class="form-control" id="editarMatriculaInicial" name="editarMatriculaInicial" required />
          </div>

          <div class="mb-3">
            <label for="editarPensionInicial" class="form-label" style="font-weight:bold">Pensión Inicial</label>
            <input type="number" step="0.1" class="form-control" id="editarPensionInicial" name="editarPensionInicial" required />
          </div>

          <div class="mb-3">
            <label for="editarMatriculaPrimaria" class="form-label" style="font-weight:bold">Matrícula Primaria</label>
            <input type="number" step="0.1" class="form-control" id="editarMatriculaPrimaria" name="editarMatriculaPrimaria" required />
          </div>

          <div class="mb-3">
            <label for="editarPensionPrimaria" class="form-label" style="font-weight:bold">Pensión Primaria</label>
            <input type="number" step="0.1" class="form-control" id="editarPensionPrimaria" name="editarPensionPrimaria" required />
          </div>

          <div class="mb-3">
            <label for="editarMatriculaSecundaria" class="form-label" style="font-weight:bold">Matrícula Secundaria</label>
            <input type="number" step="0.1" class="form-control" id="editarMatriculaSecundaria" name="editarMatriculaSecundaria" required />
          </div>

          <div class="mb-3">
            <label for="editarPensionSecundaria" class="form-label" style="font-weight:bold">Pensión Secundaria</label>
            <input type="number" step="0.1" class="form-control" id="editarPensionSecundaria" name="editarPensionSecundaria" required />
          </div>

          <div class="modal-footer">
            <input type="hidden" class="codAnioEscolar" name="codAnioEscolar" id="codAnioEscolar">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnEditarAnioEscolar" id="btnEditarAnioEscolar" name="btnEditarAnioEscolar">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal visualizar año -->
<div class="modal fade" id="modalVisualizarAnio" tabindex="-1" aria-labelledby="modalVisualizarAnioLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVisualizarAnioLabel" style="font-weight:bold">Visualizar Año Escolar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formVisualizarAnio">
          <div class="row mb-4">
            <label for="visualizarDescripcionAnio" class="col-sm-4 col-form-label" style="font-weight:bold">Año Escolar</label>
            <div class="col-sm-8">
              <input type="number" step="1" class="form-control" id="visualizarDescripcionAnio" name="visualizarDescripcionAnio" readonly />
            </div>
          </div>

          <div class="row mb-4">
            <label for="visualizarEstadoAnio" class="col-sm-4 col-form-label" style="font-weight:bold">Estado</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="visualizarEstadoAnio" name="visualizarEstadoAnio" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <label for="visualizarCuotaIngreso" class="col-sm-4 col-form-label" style="font-weight:bold">Cuota de Ingreso</label>
            <div class="col-sm-8">
              <input type="number" step="0.1" class="form-control" id="visualizarCuotaIngreso" name="visualizarCuotaIngreso" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <label for="visualizarMatriculaInicial" class="col-sm-4 col-form-label" style="font-weight:bold">M. Inicial</label>
            <div class="col-sm-8">
              <input type="number" step="0.1" class="form-control" id="visualizarMatriculaInicial" name="visualizarMatriculaInicial" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <label for="visualizarPensionInicial" class="col-sm-4 col-form-label" style="font-weight:bold">P. Inicial</label>
            <div class="col-sm-8">
              <input type="number" step="0.1" class="form-control" id="visualizarPensionInicial" name="visualizarPensionInicial" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <label for="visualizarMatriculaPrimaria" class="col-sm-4 col-form-label" style="font-weight:bold">M. Primaria</label>
            <div class="col-sm-8">
              <input type="number" step="0.1" class="form-control" id="visualizarMatriculaPrimaria" name="visualizarMatriculaPrimaria" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <label for="visualizarPensionPrimaria" class="col-sm-4 col-form-label" style="font-weight:bold">P. Primaria</label>
            <div class="col-sm-8">
              <input type="number" step="0.1" class="form-control" id="visualizarPensionPrimaria" name="visualizarPensionPrimaria" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <label for="visualizarMatriculaSecundaria" class="col-sm-4 col-form-label" style="font-weight:bold">M. Secundaria</label>
            <div class="col-sm-8">
              <input type="number" step="0.1" class="form-control" id="visualizarMatriculaSecundaria" name="visualizarMatriculaSecundaria" readonly />
            </div>
          </div>

          <div class="row mb-3">
            <label for="visualizarPensionSecundaria" class="col-sm-4 col-form-label" style="font-weight:bold">P. Secundaria</label>
            <div class="col-sm-8">
              <input type="number" step="0.1" class="form-control" id="visualizarPensionSecundaria" name="visualizarPensionSecundaria" readonly />
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>