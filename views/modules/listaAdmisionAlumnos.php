<?php
$aniosEscolar = ControllerAnioEscolar::ctrGetTodosAniosEscolar();
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloAdmisionAlumnos"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Lista Matriculados</li>
      </ol>
    </nav>
  </div>
  <section class="section AdmisionAlumno w-100">
    <div class="row">
      <div class="col-2">
        <div class="row mb-2">

        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-12">
        <div class="row">
          <div class="card AdmisionAlumno py-4">
            <div class="card-header">
              <!-- Botones para filtrar -->
              <div class="row justify-content-end">
                <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                  <div class="input-group">
                    <label class="input-group-text" for=""><i class="bi bi-calendar-event"></i></label>
                    <select class="form-select" id="selectAnioEscolarAdmisionAlumnos" aria-label=" Seleccionar año escolar">
                      <?php
                      foreach ($aniosEscolar as $anio) {
                        $anioActivo = $anio["estadoAnio"] == 1 ? 'selected' : '';
                        echo "<option value='" . $anio['idAnioEscolar'] . "' '" . $anioActivo . "' >" . $anio['descripcionAnio'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div id="tableContainer" class="card-body AdmisionAlumno table-responsive">
              <!--  Titulo dataTableAdmisionAlumnosAdmin-->
              <table id="dataTableAdmisionAlumnos" class="display dataTableAdmisionAlumnos" style="width: 100%">
                <thead>

                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal Actualizar Admision Alumno-->
<div class="modal fade" id="actualizarEstadoAdmisionAlumno" aria-hidden="true" aria-labelledby="actualizarEstadoAdmisionAlumno" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content ">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Actualizar Estado del Alumno Matriculado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="codAdmisionAlumno">
        <select class="form-control" name="estadoMatricula" id="estadoMatricula">
          <option value="1">Anulado</option>
          <option value="2">Matriculado</option>
          <option value="3">Trasladado</option>
          <option value="4">Retirado</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btnActualizarEstadoMatricula" id="btnActualizarEstadoMatricula">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Cronograma Pagos Admision Alumno-->
<div class="modal fade" id="cronogramaAdmisionPago" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cronogramaAdmisionPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 770px;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cronogramaAdmisionPagoLabel" style="padding-left: 150px; font-weight: bold;">
          Cronograma Pagos Admision Alumno</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Genera 11 inputs para cada registro de Cronograma pago de estudiante -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal editar  -->
<div class="modal fade" id="modalEditCronoPago" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEditCronoPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalEditCronoPagoLabel">Editar Cronograma Pago</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="mesEditCrono" class="col-form-label">Mes:</label>
            <input type="text" class="form-control form-control-sm" id="mesEditCrono" name="mesEditCrono" disabled>
          </div>
          <div class="mb-3">
            <label for="fechaLimtEditCrono" class="col-form-label">Fecha Limite:</label>
            <input type="date" class="form-control form-control-sm" id="fechaLimtEditCrono" name="fechaLimtEditCrono" fechaLimtEditCrono="" disabled>
          </div>
          <div class="mb-3">
            <label for="montoEditCrono" class="col-form-label">Monto Pago:</label>
            <input type="number" step="0.01" class="form-control form-control-sm" id="montoEditCrono" name="montoEditCrono" montoEditCrono="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnCerrarEditCronoModal" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btnEditCronoModal" id="btnEditCronoModal" name="btnEditCronoModal" btnEditCronoModal=" ">Editar</button>
      </div>
    </div>
  </div>
</div>