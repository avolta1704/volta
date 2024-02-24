<main id="main" class="main">

  <div class="pagetitle">
    <h1>Todos los Postulantes</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listaPostulantes">Postulantes</a></li>
        <li class="breadcrumb-item active">Todos los Postulantes</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary btnAgregarPostulante" id="btnAgregarPostulante">Nuevo Postulante</button>
        </div>
      </div>
      
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Todos los Postulantes</h5>

              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha Postulación</th>
                    <th scope="col">Grado Postulación</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $listaPostulantes = ControllerPostulantes::ctrGetAllPostulantes();
                  foreach ($listaPostulantes as $key => $value) {
                    echo '
                    <tr>
                      <th scope="row">' . ($key + 1) . '</th>
                      <td>' . ($value["nombrePostulante"]) . '</td>
                      <td>' . ($value["apellidoPostulante"]) . '</td>
                      <td>' . ($value["dniPostulante"]) . '</td>
                      <td>' . ControllerFunciones::getEstadoPostulantes($value["estadoPostulante"]) . '</td>
                      <td>' . ($value["fechaPostulacion"]) . '</td>
                      <td>' . ($value["descripcionGrado"]) . '</td>
                      <td>' . ControllerFunciones::getBotonesPostulante($value["idPostulante"], $value["estadoPostulante"]) . '</td>
                    </tr>
                    ';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
$postulante = new ControllerPostulantes();
$postulante->ctrBorrarPostulante();
?>

<div class="modal fade" id="actualizarEstado" aria-hidden="true" aria-labelledby="actualizarEstado" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content tablaActualizrEstado">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Actualizar Estado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <select class="form-control" name="estadoPostulante" id="estadoPostulante">
          <option value="2">En Revisión</option>
          <option value="3">Presentado</option>
          <option value="4">Presentado</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn-primary btnActualizarEstado" id="btnActualizarPostulante">Actualizar</button>
      </div>
    </div>
  </div>
</div>
