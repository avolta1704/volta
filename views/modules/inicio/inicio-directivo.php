<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <div id="gradoNivelDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Alumnos <span class="filtro-seleccionado-alumnos-nuevo-antiguo"></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-rolodex"></i>
                </div>
                <div class="ps-3">
                  <h6 class="total-alumnos-nuevos"></h6>
                  <h6 class="total-alumnos-antiguos"></h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card revenue-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <div id="tipoDocenteDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Docentes <span class="filtro-seleccionado-tipo-docente"></span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-workspace"></i>
                </div>
                <div class="ps-3">
                  <h6 class="total-docentes-tipo"></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Reports -->
        <div class="col-12">
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">Docentes / Cursos <span>| Grado</span></h5>

              <!-- Line Chart -->
              <div id="reportsChartDocentesCursos"></div>
            </div>

          </div>
        </div>


      </div>

    </div>

    <div class="col-lg-4">
      <div class="row">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Customers Card -->
        <div class="col-xxl-12 col-xl-8">
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

        <!-- Reports -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Informacion <span>| Grado</span></h5>
              <!-- Line Chart -->
              <div id="informacionCursos" style="max-height: 440px; overflow-y: auto;">
                <!-- Contenido generado dinámicamente por JavaScript -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <!-- Recent Sales -->
      <div class="col-12">
        <div class="card recent-sales overflow-auto">

          <div class="card-body">
            <h5 class="card-title">Docentes<span>| Conexión</span></h5>

            <!--  Titulo DataTableAlumnosAdmin-->
            <table id="dataTablePersonalInicio" class="display dataTableAlumnos" style="width: 97%" align="center">
              <thead>
                <!-- DataTableAlumnosAdmin -->
              </thead>
              <tbody>
                <!-- DataTableAlumnosAdmin -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>