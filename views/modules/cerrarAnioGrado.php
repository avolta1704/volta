<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloCerraAnioGrado"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item">Seguimiento</li>
        <li class="breadcrumb-item"><a href="anioEscolar">Año Lectivo</a></li>
        <li class="breadcrumb-item active">Grados</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row gap-3">
      <div class="col-lg-2">
        <div class="row mb-2">
          <div class="col">
            <button type="button" class="btn btn-primary w-100" id="btnCerrarAñoEscolarActualFinal">
              <i class="bi bi-fast-forward-circle-fill"></i> Cerrar Año Escolar
            </button>
          </div>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body table-responsive">
              <!--  Titulo dataTableCerrarAnioGrados-->
              <table id="dataTableCerrarAnioGrados" class="display dataTableCerrarAnioGrados " style="width: 100%">
                <thead>
                  <!-- dataTableCerrarAnioGrados -->
                </thead>
                <tbody>
                  <!--dataTableCerrarAnioGrados-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<!-- Modal Listar Cursos -->
<div class="modal fade" id="modalCerrarAnioAlumnos" tabindex="-1" aria-labelledby="modalCerrarAnioAlumnosLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCompetenciaUnidadLabel">Alumnos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-auto">
            <button type="button"
              class="btn btn-primary btnCerrarAnioAlumnosGrado gap-2 justify-content-center d-flex me-2">
              <i class="bi bi-fast-forward-circle" idGradoCerrarAnio=""></i> Cerrar Año Escolar
            </button>
          </div>
        </div>
        <!--  Titulo dataTableCompetencias-->
        <div class="table-responsive">
          <table id="dataTableCerrarAnioAlumnos" class="display dataTableCerrarAnioAlumnos" style="width: 100%">
            <thead>
              <!-- dataTableCompetencias -->
            </thead>
            <tbody>
              <!--dataTableCompetencias-->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Listar Cursos -->
<div class="modal fade" id="modalCerrarAnioValidacionCorrecta" tabindex="-1"
  aria-labelledby="modalCerrarAnioValidacionCorrectaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Clase modal-dialog-centered agregada -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCompetenciaUnidadLabel">Año Siguiente</h5>
      </div>
      <div class="modal-body">
        <!-- Select agregado -->
        <div class="form-group">
          <label for="selectAnioSiguiente">Seleccione el Año</label>
          <select class="form-control" id="selectAnioSiguiente" name="selectAnioSiguiente">
            <option value="0">Ninguna Opción</option>
            <?php
            // Llamar al controlador para obtener los años escolares
            $listaAnios = ControllerAnioEscolar::ctrGetTodosAniosEscolar();
            $anioActivo = null;

            // Encontrar el año activo
            foreach ($listaAnios as $anio) {
              if ($anio['estadoAnio'] == 1) {
                $anioActivo = $anio;
                break;
              }
            }

            // Generar las opciones del select para años posteriores al año activo
            foreach ($listaAnios as $anio) {
              if ($anioActivo && $anio['descripcionAnio'] > $anioActivo['descripcionAnio']) {
                echo '<option value="' . $anio['idAnioEscolar'] . '">' . $anio['descripcionAnio'] . '</option>';
              }
            }
            ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnGuardarEleccionAnioEscolarNuevo"
          idGradoElegirAnioBtnElegir="">Elegir Año</button>
        <button type="button" class="btn btn-secondary" id="btnCerrarModalEleccionAnioEscolarNuevo"
          data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>