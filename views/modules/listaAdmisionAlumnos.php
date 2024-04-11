<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloAdmisionAlumnos"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listaAlumnos">Alumnos</a></li>
        <li class="breadcrumb-item active">Registros Admision Alumnos</li>
      </ol>
    </nav>
  </div>
  <section class="section AdmisionAlumno w-100">
    <div class="row">
      <div class="col-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary btnAgregarNuevoAlumno" id="btnAgregarNuevoAlumno">Admisión
            Extraordinaria</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-12">
        <div class="row">
          <div class="card AdmisionAlumno">
            <div id="tableContainer" class="card-body AdmisionAlumno">
              <!--  Titulo dataTableAdmisionAlumnosAdmin-->
              <table id="dataTableAdmisionAlumnos" class="display dataTableAdmisionAlumnos" style="width: 100%">
                <thead>
                  <!-- dataTableAdmisionAlumnosAdmin -->
                </thead>
                <tbody>
                  <!--dataTableAdmisionAlumnosAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<!-- Modal Cronograma Pagos Admision Alumno-->
<div class="modal fade" id="cronogramaAdmisionPago" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="cronogramaAdmisionPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 650px;">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cronogramaAdmisionPagoLabel">Cronograma Pagos Admision Alumno</h1>
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