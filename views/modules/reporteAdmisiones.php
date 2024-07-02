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
        <div class="row mb-4">
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
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-12">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title">Matriculados</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-fill-add"></i>
                  </div>
                  <div class="ps-3">
                    <h6 class="total-alumnos-matriculados-reporte"></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-12">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Trasladados</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-fill-down"></i>
                  </div>
                  <div class="ps-3">
                    <h6 class="total-alumnos-trasladados-reporte"></h6>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">


              <div class="card-body">
                <h5 class="card-title">Retirados</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-fill-x"></i>
                  </div>
                  <div class="ps-3">
                    <h6 class="total-alumnos-retirados-reporte"></h6>
                  </div>
                </div>
              </div>
            </div>
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
      <!-- Customers Card -->
      <div class="col-xxl-6 col-xl-8">
        <div class="card info-card customers-card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filtro</h6>
              </li>
              <div id="gradoSexoDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
            </ul>
          </div>
          <div class="card-body">
            <h5 class="card-title">Alumnos <span class="filtro-seleccionado-grado-sexo">| </span></h5>
            <div class="d-flex align-items-center">
            </div>
            <!-- Contenedor para el gráfico -->
            <div>
              <canvas id="pieChart" width="200" height="200"></canvas>
            </div>
          </div>
        </div>
      </div>
      <!-- Customers Card -->
      <div class="col-xxl-6 col-xl-8">
        <div class="card info-card customers-card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filtro</h6>
              </li>
              <div id="gradoNuevoAntiguoDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
            </ul>
          </div>
          <div class="card-body">
            <h5 class="card-title">Alumnos <span class="filtro-seleccionado-grado-nuevo-antiguo">| </span></h5>
            <div class="d-flex align-items-center">
            </div>
            <!-- Contenedor para el gráfico -->
            <div>
              <canvas id="pieChartNuevoAntiguo" width="200" height="200"></canvas>
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