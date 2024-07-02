<?php
$aniosEscolar = ControllerAnioEscolar::ctrGetTodosAniosEscolar();
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloAlumnos"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listaAlumnos">Alumnos</a></li>
        <li class="breadcrumb-item active">Todos los Alumnos</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card py-4">
            <div class="card-header">
              <!-- Botones para filtrar -->
              <div class="row justify-content-end">
                <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                  <div class="input-group">
                    <label class="input-group-text" for=""><i class="bi bi-calendar-event"></i></label>
                    <select class="form-select" id="selectAnioEscolarAlumnos" aria-label=" Seleccionar año escolar">
                      <?php
                      foreach ($aniosEscolar as $anio) {
                        $anioActivo = $anio["estadoAnio"] == 1 ? 'selected' : '';
                        echo "<option value='" . $anio['idAnioEscolar'] . "' '" . $anioActivo . "' >" . $anio['descripcionAnio'] . "</option>";
                      }
                      ?>
                      <option value="0">Todos los Años</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body table-responsive">
              <!--  Titulo DataTableAlumnosAdmin-->
              <table id="dataTableAlumnos" class="display dataTableAlumnos" style="width: 100%">
                <thead>
                  <!-- DataTableAlumnosAdmin -->
                </thead>
                <tbody>
                  <!--DataTableAlumnosAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<div class="modal fade" id="modalViewAlumno" tabindex="-1" role="dialog" aria-labelledby="modalViewAlumno" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: bold">Datos Alumno</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="fechaIngresoVoltaAlu" class="col-form-label" style="font-weight: bold">Ingreso a Volta:</label>
          <input type="text" class="form-control" id="fechaIngresoVoltaAlu" name="fechaIngresoVoltaAlu" style="border:none" disabled>
        </div>
        <div class="form-group">
          <label for="estadoSiagieAlu" class="col-form-label" style="font-weight: bold">Estado Siagie:</label>
          <input type="text" class="form-control" id="estadoSiagieAlu" name="estadoSiagieAlu" style="border:none" disabled>
        </div>
        <div class="form-group">
          <label for="IEPProcedenciaAlu" class="col-form-label" style="font-weight: bold">IEE Procedencia:</label>
          <input type="text" class="form-control" id="IEPProcedenciaAlu" name="IEPProcedenciaAlu" style="border:none" disabled>
        </div>
        <div class="form-group">
          <label for="numeroEmergenciaAlu" class="col-form-label" style="font-weight: bold">Numero emergencia:</label>
          <input type="text" class="form-control" id="numeroEmergenciaAlu" name="numeroEmergenciaAlu" style="border:none" disabled>
        </div>
        <div class="form-group">
          <label for="direccionAlumnoAlu" class="col-form-label" style="font-weight: bold">Direccion:</label>
          <input type="text" class="form-control" id="direccionAlumnoAlu" name="direccionAlumnoAlu" style="border:none" disabled>
        </div>
        <div class="form-group">
          <label for="seguroSaludAlu" class="col-form-label" style="font-weight: bold">Seguro de Salud:</label>
          <input type="text" class="form-control" id="seguroSaludAlu" name="seguroSaludAlu" style="border:none" disabled>
        </div>
        <div class="form-group">
          <label for="fechaNacimientoAlu" class="col-form-label" style="font-weight: bold">Fecha Nacimiento:</label>
          <input type="text" class="form-control" id="fechaNacimientoAlu" name="fechaNacimientoAlu" style="border:none" disabled>
        </div>
        <div class="form-group">
          <label for="enfermedadesAlu" class="col-form-label" style="font-weight: bold">Enfermedades:</label>
          <input type="text" class="form-control" id="enfermedadesAlu" name="enfermedadesAlu" style="border:none" disabled>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>