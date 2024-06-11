<main id="main" class="main">
  <div class="pagetitle">
    <h2 class="mt-4 tituloReportesComunicaciones"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Reportes de Comunicaciones</li>
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
              <li><button class="dropdown-item" id="btnDescargarReporteComunicados"><i class="bi bi-file-earmark-excel"></i> Descargar reporte de comunicaciones</button></li>
              <li><button class="dropdown-item" id="btnDescargarMmReport"><i class="bi bi-file-earmark-excel"></i> Descargar comunicaciones por rango de fechas</button></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableReportesComunicacionesAdmin-->
              <table id="dataTableReportesComunicaciones" class="display dataTableReportesComunicaciones" style="width: 100%">
                <thead>
                  <!-- dataTableReportesComunicacionesAdmin -->
                </thead>
                <tbody>
                  <!--dataTableReportesComunicacionesAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal Seleccionar Rango de Fecha -->
<div class="modal fade" id="seleccionarRangoFechasComunicados" data-bs-keyboard="false" tabindex="-1" aria-labelledby="seleccionarRangoFechasComunicadosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="seleccionarRangoFechasComunicadosLabel">Selecciona el Rango de Fechas</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeModalRangeMonth" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="daterangecomunicados" id="daterangecomunicados" value="<?php echo date('Y-m-d'); ?>" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModalRangeMonth">Cerrar</button>
        <button class="btn btn-primary d-flex gap-2" id="btnDescargarReporteComunicadosFechas"><i class="bi bi-file-earmark-excel"></i> Descargar archivo</button>
      </div>
    </div>
  </div>
</div>