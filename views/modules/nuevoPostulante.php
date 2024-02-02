<main id="main" class="main">

  <div class="pagetitle">
    <h1>Nuevo Postulante</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listPostulantes">Postulantes</a></li>
        <li class="breadcrumb-item"><a href="listPostulantes">Lista Postulantes</a></li>
        <li class="breadcrumb-item active">Nuevo Postulante</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>

      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2 formNuevoPostulante">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Postulante</h3>

              <div class="form-group col-md-6">
                <label for="nombrePostulante" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="nombrePostulante" name="nombrePostulante" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="apellidoPostulante" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="apellidoPostulante" name="apellidoPostulante" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="dniPostulante" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="dniPostulante" name="dniPostulante" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="fechaPostulacion" class="form-label" style="font-weight: bold">Fecha Postulación: </label>
                <input type="date" class="form-control" id="fechaPostulacion" name="fechaPostulacion" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="fechaNacimiento" class="form-label" style="font-weight: bold">Fecha Nacimiento: </label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="" required>
              </div>

              <div class="form-group col-md-6 nivelAdmision">
                <label for="nivelAlumno" class="col-form-label">Nivel:</label>
                <select class="form-control" name="nivelAlumno" id="nivelAlumno" required>
                  <option value="">Eliga una opción</option>
                  <option value="1">Inicial</option>
                  <option value="2">Primaria</option>
                  <option value="3">Secundaria</option>
                </select>
              </div>
              
              <div class="form-group col-md-6 gradoAdmision">
                <label for="gradoAlumno" class="col-form-label">Grado:</label>
                <select class="form-control" name="gradoAlumno" id="gradoAlumno" required>
                  <option value="">Eliga una opción</option>
                </select>
              </div>
            </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarCrearPostulante">Cerrar</button>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Registrar Postulante</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
$crearPostulante = new ControllerPostulantes();
$crearPostulante->ctrCrearPostulante();
?>
