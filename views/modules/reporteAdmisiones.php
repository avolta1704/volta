<main id="main" class="main">
  <div class="pagetitle">
    <h2 class="mt-4 tituloReportesAdmisiones"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Reportes de Matriculados</li>
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
              <i class="bi bi-download"></i> Descargar Reporte
            </button>
            <ul class="dropdown-menu">
              <li><button class="dropdown-item" data-bs-target="#modalAnioLectivo" data-bs-toggle="modal"><i
                    class="bi bi-file-earmark-excel"></i> Descargar reporte de Matriculados</button></li>
              <li><button class="dropdown-item" id="btnDescargarReporteNuevosAntiguos"><i
                    class="bi bi-file-earmark-excel"></i> Descargar reportes de Nuevos/Antiguos</button></li>
              <li><button class="dropdown-item" id="btnDescargarReporteEdadSexo"><i
                    class="bi bi-file-earmark-excel"></i> Descargar reportes de Edad/Sexo</button></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <div class="card">

            <div class="card-body">
              <h5 class="card-title"> Alumnos <span>| Grado</span></h5>

              <!-- Line Chart -->
              <div id="reportsChartGradoAlumnosTiposEstado"></div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
$aniosLectivos = ControllerAnioEscolar::ctrGetTodosAniosEscolar();
?>
<!-- Modal para seleccionar los años lectivos -->
<div class="modal fade" id="modalAnioLectivo" tabindex="-1" aria-labelledby="modalAnioLectivoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAnioLectivoLabel">Seleccionar Año Lectivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Contenido del modal -->
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group
            ">
              <label for="anioLectivo">Año Lectivo</label>
              <select class="form-select" id="anioLectivo" name="anioLectivo" multiple>
                <?php
                foreach ($aniosLectivos as $key => $value) {
                  echo '<option value="' . $value["idAnioEscolar"] . '">' . $value["descripcionAnio"] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="btnCerrarSeleccionarAnioLectivo"
          data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnDescargarAnioLectivo"
          data-bs-dismiss="modal">Descargar</button>
      </div>
    </div>
  </div>
</div>