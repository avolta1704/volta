<main id="main" class="main">
  <div class="pagetitle">
    <h2 class="mt-4 tituloReportesPensiones"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Reportes Pensiones</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
          <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle d-flex gap-3 align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download"></i> Descargar Reporte
            </button>
            <ul class="dropdown-menu">
              <li><button class="dropdown-item" id="btnDescargarReportePagos"><i class="bi bi-file-earmark-excel"></i> Descargar reporte de pagos</button></li>
              <li><button class="dropdown-item" id="btnDescargarReporteInicial"><i class="bi bi-file-earmark-excel"></i> Descargar retrasos de inicial</button></li>
              <li><button class="dropdown-item" id="btnDescargarReportePrimaria"><i class="bi bi-file-earmark-excel"></i> Descargar retrasos de primaria</button></li>
              <li><button class="dropdown-item" id="btnDescargarReporteSecundaria"><i class="bi bi-file-earmark-excel"></i> Descargar retrasos de secundaria</button></li>
              <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#seleccionarRangoFechas"><i class="bi bi-file-earmark-excel"></i> Descargar deudores por rango de meses</button></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableReportesPensionesAdmin-->
              <table id="dataTableReportesPensiones" class="display dataTableReportesPensiones" style="width: 100%">
                <thead>
                  <!-- dataTableReportesPensionesAdmin -->
                </thead>
                <tbody>
                  <!--dataTableReportesPensionesAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal Cronograma Pagos Deuda-->
<div class="modal fade" id="cronogramaPagoDeuda" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cronogramaPagoDeudaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cronogramaPagoDeudaLabel">Cronograma Pagos Deuda</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Genera 11 inputs para cada registro de Cronograma pago de estudiante -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Seleccionar Rango de Data -->
<div class="modal fade" id="seleccionarRangoFechas" data-bs-keyboard="false" tabindex="-1" aria-labelledby="seleccionarRangoFechasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="seleccionarRangoFechasLabel">Selecciona el Rango de Meses</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeModalRangeMonth" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <select class="form-select" id="selectMonth" data-placeholder="Choose anything" multiple>
          <option>Matricula</option>
          <option>Marzo</option>
          <option>Abril</option>
          <option>Mayo</option>
          <option>Junio</option>
          <option>Julio</option>
          <option>Agosto</option>
          <option>Septiembre</option>
          <option>Octubre</option>
          <option>Noviembre</option>
          <option>Diciembre</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModalRangeMonth">Cerrar</button>
        <button class="btn btn-primary d-flex gap-2" id="btnDescargarReporteRangoFecha"><i class="bi bi-file-earmark-excel"></i> Descargar archivo</button>
      </div>
    </div>
  </div>
</div>