<main id="main" class="main">

  <div class="pagetitle">
    <h2 class="mt-4 tituloCursosDocente"></h2>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active" id="idNavegacionNombreCursos">Todos mis Alumnos</li>
      </ol>
    </nav>
  </div>

  <?php
  $listaIdentificadores = ControllerDocentes::ctrGetIdentificadoresDocente($_SESSION["idUsuario"]);
  $listaIdentificadores = json_encode($listaIdentificadores);
  $tipoDocente = $_SESSION["tipoDocente"];
  ?>
  <section class="section dashboard">
    <div class="row gap-3">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <table id='dataTableAlumnosDocente' class='display dataTableAlumnosDocente'
                data-tipo-docente='<?php echo $tipoDocente ?>'
                data-identificadores='<?php echo $listaIdentificadores ?>' style="width: 100%">
                <thead>
                  <!-- datatTableAlumnosDocente -->
                </thead>
                <tbody>
                  <!--datatTableAlumnosDocente-->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<div class="modal fade" id="modalViewAlumnoDocente" tabindex="-1" role="dialog" aria-labelledby="modalViewAlumnoDocente"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="font-weight: bold">Datos Alumno</h5>
      </div>
      <div class="modal-body">
        <!-- Datos del alumno -->
        <div class="form-group">
          <label for="nombresAlumno" class="col-form-label" style="font-weight: bold">Alumno:</label>
          <input type="text" class="form-control" id="nombresAlumno" name="nombresAlumno" style="border:none" disabled>
        </div>
        <div class="form-group row">
          <div class="col">
            <label for="dniAlumno" class="col-form-label" style="font-weight: bold">DNI:</label>
            <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" style="border:none" disabled>
          </div>
          <div class="col">
            <label for="fechaNacimientoAlumno" class="col-form-label" style="font-weight: bold">Fecha de
              Nacimiento:</label>
            <input type="text" class="form-control" id="fechaNacimientoAlumno" name="fechaNacimientoAlumno"
              style="border:none" disabled>
          </div>
        </div>
        <div class="form-group">
          <label for="direccionAlumno" class="col-form-label" style="font-weight: bold">Dirección:</label>
          <input type="text" class="form-control" id="direccionAlumno" name="direccionAlumno" style="border:none"
            disabled>
        </div>

        <!-- Datos del padre -->
        <div class="form-group">
          <label for="nombrePadre" class="col-form-label" style="font-weight: bold">Nombre del Padre:</label>
          <input type="text" class="form-control" id="nombrePadre" name="nombrePadre" style="border:none" disabled>
        </div>
        <div class="form-group row">
          <div class="col">
            <label for="celularPadre" class="col-form-label" style="font-weight: bold">Celular del Padre:</label>
            <input type="text" class="form-control" id="celularPadre" name="celularPadre" style="border:none" disabled>
          </div>
          <div class="col">
            <label for="convivenciaPadre" class="col-form-label" style="font-weight: bold">Convivencia con el
              Padre:</label>
            <input type="text" class="form-control" id="convivenciaPadre" name="convivenciaPadre" style="border:none"
              disabled>
          </div>
        </div>

        <!-- Datos de la madre -->
        <div class="form-group">
          <label for="nombreMadre" class="col-form-label" style="font-weight: bold">Nombre de la Madre:</label>
          <input type="text" class="form-control" id="nombreMadre" name="nombreMadre" style="border:none" disabled>
        </div>
        <div class="form-group row">
          <div class="col">
            <label for="celularMadre" class="col-form-label" style="font-weight: bold">Celular de la Madre:</label>
            <input type="text" class="form-control" id="celularMadre" name="celularMadre" style="border:none" disabled>
          </div>
          <div class="col">
            <label for="convivenciaMadre" class="col-form-label" style="font-weight: bold">Convivencia con la
              Madre:</label>
            <input type="text" class="form-control" id="convivenciaMadre" name="convivenciaMadre" style="border:none"
              disabled>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>