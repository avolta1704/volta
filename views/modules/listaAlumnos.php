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
          <div class="card">
            <div class="card-body">
              <!--  Titulo DataTableAlumnosAdmin-->
              <table id="dataTableAlumnos" class="display dataTableAlumnos" style="width: 100%">6
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
        <!-- Nombre Alumno -->
        <div class="form-group">
          <label for="verNombreAlumno" class="col-form-label" style="font-weight: bold">Nombre Alumno:</label>
          <input type="text" class="form-control" id="verNombreAlumno" name="verNombreAlumno" style="border:none" disabled>
        </div>
        <!-- Apellido Alumno -->
        <div class="form-group">
          <label for="verApellidoAlumno" class="col-form-label" style="font-weight: bold">Apellido Alumno:</label>
          <input type="text" class="form-control" id="verApellidoAlumno" name="verApellidoAlumno" style="border:none" disabled>
        </div>
        <!-- Código de Caja Arequipa -->
        <div class="form-group">
          <label for="verCodCajaAlumno" class="col-form-label" style="font-weight: bold">Código Caja Arequipa:</label>
          <input type="text" class="form-control" id="verCodCajaAlumno" name="verCodCajaAlumno" style="border:none" disabled>
        </div>
        <!-- DNI -->
        <div class="form-group">
          <label for="verDniAlumno" class="col-form-label" style="font-weight: bold">DNI:</label>
          <input type="text" class="form-control" id="verDniAlumno" name="verDniAlumno" style="border:none" disabled>
        </div>
        <!-- Nivel -->
        <div class="form-group">
          <label for="verNivelAlumno" class="col-form-label" style="font-weight: bold">Nivel:</label>
          <input type="text" class="form-control" id="verNivelAlumno" name="verNivelAlumno" style="border:none" disabled>
        </div>
        <!-- Grado -->
        <div class="form-group">
          <label for="verGradoAlumno" class="col-form-label" style="font-weight: bold">Grado:</label>
          <input type="text" class="form-control" id="verGradoAlumno" name="verGradoAlumno" style="border:none" disabled>
        </div>
        <!-- Estado Siagie -->
        <div class="form-group">
          <label for="verEstadoSiagie" class="col-form-label" style="font-weight: bold">Estado Siagie:</label>
          <input type="text" class="form-control" id="verEstadoSiagie" name="verEstadoSiagie" style="border:none" disabled>
        </div>
        <!-- Estado Alumno -->
        <div class="form-group">
          <label for="verEstadoAlumno" class="col-form-label" style="font-weight: bold">Estado Alumno:</label>
          <input type="text" class="form-control" id="verEstadoAlumno" name="verEstadoAlumno" style="border:none" disabled>
        </div>
        <!-- Estado Matrícula -->
        <div class="form-group">
          <label for="verEstadoMatrícula" class="col-form-label" style="font-weight: bold">Estado Matrícula:</label>
          <input type="text" class="form-control" id="verEstadoMatrícula" name="verEstadoMatrícula" style="border:none" disabled>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>