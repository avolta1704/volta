<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloTecnica"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item">Tipos de Evaluación</li>
        <li class="breadcrumb-item active">Técnicas e Instrumentos</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary gap-2 justify-content-center d-flex" data-bs-target="#modalAgregarTecnica" data-bs-toggle="modal">
            <i class="bi bi-plus-circle"></i> Agregar Técnica</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTable Tecnicas e Instrumentos-->
              <table id="dataTableTecnicas" class="display dataTableTecnicas " style="width: 100%">
                <thead>
                  <!-- dataTable Tecnicas e Instrumentos -->
                </thead>
                <tbody>
                  <!--dataTable Tecnicas e Instrumentos-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal crear técnicas -->
<div class="modal fade" id="modalAgregarTecnica" tabindex="-1" aria-labelledby="modalAgregarTecnica" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight:bold">Agregar Nueva Técnica</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formRegistrarAnio">
          <div class="mb-3">
            <label for="descripcionTecnica" class="form-label" style="font-weight:bold">Descripción Técnica</label>
            <input type="text" class="form-control" id="descripcionTecnica" name="descripcionTecnica" required />
          </div>

          <div class="mb-3">
            <label for="codigoTecnica" class="form-label" style="font-weight:bold">Código Técnica</label>
            <input type="text" class="form-control" id="codigoTecnica" name="codigoTecnica" required />
          </div>

          <div class="mb-3">
            <button type="button" class="btn btn-primary btnAgregarInstrumento" id="btnAgregarInstrumento">
              <i class="bi bi-plus-circle"></i> Agregar Instrumento</button>
              <input type="hidden" name="listaInstrumentosPorTecnica" class="listaInstrumentosPorTecnica" id="listaInstrumentosPorTecnica">
          </div>

          <div class="mb-3 listaInstrumentos">
            <label for="lista" class="form-label" style="font-weight:bold">Lista de Instrumentos</label>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnRegistrarTecnica" id="btnRegistrarTecnica" name="btnRegistrarTecnica">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>