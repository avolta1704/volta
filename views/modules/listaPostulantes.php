<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloPostulantes"></h2><br>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Todos los Postulantes</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary btnAgregarPostulante" id="btnAgregarPostulante">Nuevo
            Postulante</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <!--  Titulo dataTablePostulantesAdmin-->
              <table id="dataTablePostulantes" class="display dataTablePostulantes" style="width: 100%">
                <thead>
                  <!-- dataTablePostulantesAdmin -->
                </thead>
                <tbody>
                  <!--dataTablePostulantesAdmin-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<div class="modal fade" id="actualizarEstado" aria-hidden="true" aria-labelledby="actualizarEstado" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content tablaActualizaEstadoPostulante">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Actualizar Postulante</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="codPostulante">
        <select class="form-control" name="estadoPostulante" id="estadoPostulante">
          <!-- <option value=""></option> -->
          <option value="1">Registrado</option>
          <option value="2">En Revisión</option>
          <option value="3">Matriculado</option>
          <option value="5">Desestimado</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btnActualizarEstado"
          id="btnActualizarEstadoPostulante">Actualizar</button>
      </div>
    </div>
  </div>
</div>
<!-- eliminar postulante sin matricula  -->
<?php
if (isset($_GET['codPostulanteEliminar']) && !isset($_GET['pagoMatricula'])) {
  $postulante = new ControllerPostulantes();
  $codPostulante = $_GET['codPostulanteEliminar'];
  $postulante->ctrBorrarPostulante($codPostulante);
}
?>
<!-- eliminar postulante si tiene pago matricula  -->
<?php
if (isset($_GET['codPostulanteEliminar']) && isset($_GET['pagoMatricula'])) {
  $postulanteMatricula = new ControllerPostulantes();
  $codPostulante = $_GET['codPostulanteEliminar'];
  $pagoMatricula = $_GET['pagoMatricula'];
  $postulanteMatricula->ctrBorrarPostulantePagoMatricula($codPostulante, $pagoMatricula);
}
?>