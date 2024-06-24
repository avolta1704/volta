<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">

        <!-- Revenue Card -->
        <div class="col-xxl-8 col-xl-12">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Datos del Alumno</h5>
              <form role="form" class="row g-2 m-2">
                <!-- Nombre Completo -->
                <div class="form-group col-md-12">
                  <label for="nombreAlumnoApoderado" class="col-form-label" style="font-weight: bold">Nombre
                    Alumno:</label>
                  <input type="text" class="form-control" id="nombreAlumnoApoderado" name="nombreAlumnoApoderado"
                    readonly>
                </div>

                <!-- Nivel y Grado en la misma fila con espacio entre ellos -->
                <div class="form-group col-md-6">
                  <label for="nivelAlumnoApoderado" class="col-form-label" style="font-weight: bold">Nivel:</label>
                  <input type="text" class="form-control" id="nivelAlumnoApoderado" name="nivelAlumnoApoderado"
                    readonly>
                </div>
                <div class="form-group col-md-6">
                  <label for="gradoAlumnoApoderado" class="col-form-label" style="font-weight: bold">Grado:</label>
                  <input type="text" class="form-control" id="gradoAlumnoApoderado" name="gradoAlumnoApoderado"
                    readonly>
                </div>
                <!-- Fecha de Nacimiento -->
                <div class="form-group col-md-6">
                  <label for="fechaNacimientoAlumnoApoderado" class="col-form-label" style="font-weight: bold">Fecha de Nacimiento:</label>
                  <input type="text" class="form-control" id="fechaNacimientoAlumnoApoderado" name="fechaNacimientoAlumnoApoderado" readonly>
                </div>
                <!-- DNI -->
                <div class="form-group col-md-6">
                  <label for="dniAlumnoApoderado" class="col-form-label" style="font-weight: bold">DNI:</label>
                  <input type="text" class="form-control" id="dniAlumnoApoderado" name="dniAlumnoApoderado" readonly>
                </div>

                <!-- Dirección -->
                <div class="form-group col-md-12">
                  <label for="direccionAlumnoApoderado" class="col-form-label"
                    style="font-weight: bold">Dirección:</label>
                  <input type="text" class="form-control" id="direccionAlumnoApoderado" name="direccionAlumnoApoderado"
                    readonly>
                </div>

                <!-- Fecha de Ingreso -->
                <div class="form-group col-md-12">
                  <label for="fechaIngresoAlumnoApoderado" class="col-form-label" style="font-weight: bold">Fecha de
                    Ingreso:</label>
                  <input type="text" class="form-control" id="fechaIngresoAlumnoApoderado"
                    name="fechaIngresoAlumnoApoderado" readonly>
                </div>
              </form>
            </div>
          </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Revenue Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card revenue-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <div id="mesesAsistenciaApoderadoDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Asistencia <span class="filtro-seleccionado-asistencia-mes"></span></h5>

              <canvas id="asistenciaApoderadoChart" style="max-width: 400px; max-height: 427px;"></canvas>
            </div>
          </div>
        </div>






        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <div id="mesesDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Pagos Vencidos <span id="filtroSeleccionado"></span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-x"></i>
                </div>
                <div class="ps-3">
                  <h6 id="totalPagosVencidos">0</h6>
                  <span class="text-success small pt-1 fw-bold" id="porcentajeVencidas">12%</span>
                  <span class="text-muted small pt-2 ps-1">de <span id="totalPensiones"></span></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filtro</h6>
                </li>
                <div id="aniosDropdown"></div> <!-- Contenedor para poblar desde JavaScript -->
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Alumnos <span class="filtro-seleccionado"></span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-up"></i>
                </div>
                <div class="ps-3">
                  <h6 class="total-alumnos"></h6>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">


            <div class="card-body">
              <h5 class="card-title">Fecha de Pago <span class="filtro-seleccionado-mes-pago-apoderado"></span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar"></i>
                </div>
                <div class="ps-3">
                  <h6 class="proxima-fecha"></h6>
                </div>
              </div>
            </div>
          </div>

        </div>


        <!-- Recent Sales -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="card-body">
              <h5 class="card-title">Pagos<span>| Pendientes</span></h5>

              <!--  Titulo dataTablePagosPendientesApoderadoInicio-->
              <table id="dataTablePagosPendientesApoderadoInicio"
                class="display dataTablePagosPendientesApoderadoInicio" style="width: 100%">
                <thead>
                  <!-- dataTablePagosPendientesApoderadoInicio -->
                </thead>
                <tbody>
                  <!-- dataTablePagosPendientesApoderadoInicio -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>