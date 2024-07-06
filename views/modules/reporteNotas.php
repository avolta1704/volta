<?php
$idUsuario = $_SESSION["idUsuario"];
$cursos = ControllerDocentes::ctrObtenerCursosAsignados();
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h2 class="mt-4">Reporte Notas</h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Notas</li>
      </ol>
    </nav>
  </div>
  <section class="section dashboard">
    <div class="row">
      <!-- Sección de filtros -->
      <div class="col-12">
        <div class="card">
          <!-- Header de la tarjeta con margen inferior para espacio -->
          <div class="card-header" style="margin-bottom: 8px;">
            Filtros
          </div>
          <!-- Body de la tarjeta con padding reducido -->
          <div class="card-body" style="padding: 10px;">
            <div class="row">
              <div class="mb-2 col-6">
                <label for="selectCursoToReport">Cursos:</label>
                <select id="selectCursoToReport" class="form-select form-select-sm" style="width: 100%;">
                  <?php
                  foreach ($cursos as $curso) : ?>
                    <option value="<?php echo $curso['idCurso'] . "-" . $curso['idGrado']; ?>">
                      <?php echo $curso['descripcionCurso']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-2 col-6">
                <label for="selectBimestreToReport">Bimestres:</label>
                <select id="selectBimestreToReport" class="form-select form-select-sm" style="width: 100%;">
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="row mb-2 justify-content-end">
          <div class="col-3 d-flex justify-content-end">
            <button class="btn btn-outline-primary d-flex gap-3 align-items-center" type="button" id="btnDescargarReporteNotas">
              <i class="bi bi-download"></i> Descargar Reporte
            </button>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <!-- Sección de la tabla -->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap" style="margin-bottom: 25px;">
              Registro de Notas
            </div>
            <div class="card-body table-responsive">
              <!-- Contenedor de la tabla de asistencia -->
              <div id="reporteNotas"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>