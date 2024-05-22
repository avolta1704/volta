<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloPostulantesReportAnio"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Reporte de Admiciones por Fecha</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
          <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle d-flex gap-3 align-items-center" type="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download"></i> Descargar Reportes
            </button>
            <ul class="dropdown-menu">
              <li><button class="dropdown-item" id="btnDescargarAllReport"><i class="bi bi-file-earmark-excel"></i>
                  Descargar todos los registros</button></li>
              <li><button class="dropdown-item" id="btnDescargarMmReport"><i class="bi bi-file-earmark-excel"></i>
                  Descargar Reporte Mes</button></li>
              <li><button class="dropdown-item" id="btnDescargarYyReport"><i class="bi bi-file-earmark-excel"></i>
                  Descargar Reporte por año</button></li>
              <!-- //boton de decargar del modal btnDescargarReporteAnio  que funciona despues de precionar el btoon de btnDescargarYyReport que abre el modal -->

            </ul>
          </div>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTablePostulantesReporteAnio-->
              <table id="dataTablePostulantesReporteAnio" class="display dataTablePostulantesReporteAnio"
                style="width: 100%">
                <thead>
                  <!-- dataTablePostulantesReporteAnio -->
                </thead>
                <tbody>
                  <!--dataTablePostulantesReporteAnio-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
$postulante = new ControllerPostulantes();
$postulante->ctrBorrarPostulante();
?>

<div class="modal fade" id="actualizarEstado" aria-hidden="true" aria-labelledby="actualizarEstado" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content tablaActualizaEstadoPostulante">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Actualizar Postulante</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="codPostulante">
        <select class="form-control" name="estadoPostulante" id="estadoPostulante">
          <!-- <option value=""></option> -->
          <option value="1">Registrado</option>
          <option value="2">En Revisión</option>
          <option value="3">Aprobado</option>
          <option value="4">Rechazado</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btnActualizarEstado"
          id="btnActualizarEstadoPostulante">Actualizar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalFechasAnio" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Descarga de reportes Postulantes Anual</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <h4>Desde</h4>
            <select class="form-control" name="rangoAnio1" id="rangoAnio1">
              <!--   <option value="">2024</option> -->
            </select>
          </div>
          <div class="col">
            <h4>Hasta</h4>
            <select class="form-control" name="rangoAnio2" id="rangoAnio2">
              <!--    -->
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnDescargarReporteAnio">Descargar</button>
      </div>
    </div>
  </div>
</div>