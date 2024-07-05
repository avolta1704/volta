<?php
$idUsuario = $_SESSION["idUsuario"];
$grados = ControllerNivelGrado::ctrGetGradosByPersonal($idUsuario);
$result = eliminarDuplicadosPorIdGrado($grados);
function eliminarDuplicadosPorIdGrado($array)
{
  $uniqueArray = [];
  $idGradoMap = [];

  foreach ($array as $item) {
    if (!isset($idGradoMap[$item['idGrado']])) {
      $idGradoMap[$item['idGrado']] = true;
      $uniqueArray[] = $item;
    }
  }

  return $uniqueArray;
}
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h2 class="mt-4">Reporte Asistencias Alumno</h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Asistencias</li>
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
                <label for="selectGradoToReport">Grados:</label>
                <select id="selectGradoToReport" class="form-select form-select-sm" style="width: 100%;">
                  <?php
                  foreach ($result as $grado) : ?>
                    <option value="<?php echo $grado['idGrado']; ?>">
                      <?php echo $grado['descripcionGrado']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-2 col-6"> <!-- Reducción del margen aquí -->
                <label for="selectMesToReport">Meses:</label>
                <select class="form-select" id="selectMonthToReportA" data-placeholder="Selecciona los meses" multiple>
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
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="row mb-2 justify-content-end">
          <div class="col-3 d-flex justify-content-end">
            <button class="btn btn-outline-primary d-flex gap-3 align-items-center" type="button" id="btnDescargarReporteAsistencias">
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
              Registro de Asistencia
              <ul class="list-unstyled d-flex column-gap-5 flex-wrap">
                <li><strong style="color: green;">A:</strong> ASISTIÓ</li>
                <li><strong style="color: red;">F:</strong> FALTÓ</li>
                <li><strong style="color: orange;">T:</strong> INASISTENCIA INJUSTIFICADA</li>
                <li><strong style="color: blue;">J:</strong> FALTA JUSTIFICADA</li>
                <li><strong style="color: purple;">U:</strong> TARDANZA JUSTIFICADA</li>
              </ul>
            </div>
            <div class="card-body table-responsive">
              <!-- Contenedor de la tabla de asistencia -->
              <div id="reporteAsistencias"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="">
          <!-- Revenue Card -->
          <div class="col-xxl-12 col-xl-8">

            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Asistencia <span class="filtro-seleccionado-asistencia-mes"></span></h5>
                <div id="reporteAsistenciasChart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>