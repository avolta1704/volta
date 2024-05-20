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
              <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#seleccionarRangoFechas"><i class="bi bi-file-earmark-excel"></i> Descargar comunicaciones por rango de fechas</button></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
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