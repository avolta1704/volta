<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">



        <!-- Revenue Card -->
        <div class="col-xxl-6 col-md-12">
          <div class="card info-card revenue-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <div id="gradoDropdownDocente"></div> <!-- Contenedor para poblar desde JavaScript -->
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Alumnos <span class="filtro-seleccionado-Docente"></span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-workspace"></i>
                </div>
                <div class="ps-3">
                  <h6 class="total-alumnos-docentes"></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Customers Card -->
        <div class="col-xxl-6 col-xl-12">

          <div class="card info-card customers-card">

            <div class="card-body">
              <h5 class="card-title">Cursos <span class="filtro-seleccionado-Cursos"></span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <div class="ps-3">
                  <h6 class="total-cursos-docentes"></h6>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Reports -->
        <div class="col-12">
          <div class="card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <div id="gradoDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Asistencia <span>/Meses</span></h5>

              <!-- Line Chart -->
              <div id="asistenciaChart"></div>
            </div>

          </div>
        </div>

        <!-- Recent Sales -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="card-body">
              <h5 class="card-title">Notas<span>| Faltantes</span></h5>

              <!--  Titulo DataTableAlumnosAdmin-->
              <table id="dataTableNotaCompetenciaInicio" class="display dataTableAlumnos" style="width: 97%"
                align="center">
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

  </div>
</section>