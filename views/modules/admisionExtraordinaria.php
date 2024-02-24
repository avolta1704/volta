<main id="main" class="main">

  <div class="pagetitle">
    <h1>Admisión Extraordinaria</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listaAlumnos">Usuarios</a></li>
        <li class="breadcrumb-item"><a href="listaAlumnos">Lista Alumnos</a></li>
        <li class="breadcrumb-item active">Admisión Extraordinaria</li>
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
        <form role="form" method="post" class="row g-3 m-2 formNuevoAlumno">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Alumno</h3>

              <div class="d-inline-flex m-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarApoderado">Agregar Apoderado</button>
              </div>

              <div class="form-group col-md-6">
                <label for="nombresAlumno" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="nombresAlumno" name="nombresAlumno" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="apellidosAlumno" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="apellidosAlumno" name="apellidosAlumno" value="" required>
              </div>

              <div class="col-md-6">
                <label for="sexoAlumno" class="form-label" style="font-weight: bold">Sexo: </label>
                <select class="form-control input-lg" name="sexoAlumno" id="sexoAlumno" required>
                  <option value="">Eliga una opción</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="dniAlumno" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" value="" required>
              </div>

              <div class="col-md-6">
                <label for="fechaNacimiento" class="form-label" style="font-weight: bold">Fecha de Nacimiento: </label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="direccionAlumno" class="form-label" style="font-weight: bold">Dirección: </label>
                <input type="text" class="form-control" id="direccionAlumno" name="direccionAlumno" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="distrito" class="form-label" style="font-weight: bold">Distrito: </label>
                <input type="text" class="form-control" id="distrito" name="distrito" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="iepProcedencia" class="form-label" style="font-weight: bold">IEP Procedencia: </label>
                <input type="text" class="form-control" id="iepProcedencia" name="iepProcedencia" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="seguroSalud" class="form-label" style="font-weight: bold">Seguro Salud: </label>
                <input type="text" class="form-control" id="seguroSalud" name="seguroSalud" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="fechaIngreso" class="form-label" style="font-weight: bold">Fecha Ingreso: </label>
                <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="numeroEmergencia" class="form-label" style="font-weight: bold">Numero Emergencia: </label>
                <input type="text" class="form-control" id="numeroEmergencia" name="numeroEmergencia" value="" required>
              </div>

              <div class="form-group col-md-12">
                <label for="enfermedadesAlumno" class="form-label" style="font-weight: bold">Enfermedades: </label>
                <input type="text" class="form-control" id="enfermedadesAlumno" name="enfermedadesAlumno" value="" required>
              </div>

              <div class="form-group col-md-6 nivelAdmision">
                <label for="nivelAlumno" class="col-form-label" style="font-weight: bold">Nivel:</label>
                <select class="form-control" name="nivelAlumno" id="nivelAlumno" required>
                  <option value="">Eliga una opción</option>
                  <option value="1">Inicial</option>
                  <option value="2">Primaria</option>
                  <option value="3">Secundaria</option>
                </select>
              </div>

              <div class="form-group col-md-6 gradoAdmision">
                <label for="gradoAlumno" class="col-form-label" style="font-weight: bold">Grado:</label>
                <select class="form-control" name="gradoAlumno" id="gradoAlumno" required>
                  <option value="">Eliga una opción</option>
                </select>
              </div>

            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Apoderado</h3>

              <div class="form-group row nuevoApoderado">
                <input type="hidden" class="listaApoderados" id="listaApoderados" name="listaApoderados">
              </div>

            </div>
          </span>
          <div class="container row g-3 p-3 justify-content-between">
            <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarCrearAlumno">Cerrar</button>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Registrar Admisión</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
$crearAlumnoExtraordinario = new ControllerAlumnos();
$crearAlumnoExtraordinario->ctrCrearAlumnoExtraordinaria();
?>

<!-- Modal Agregar Apoderado -->
<div class="modal fade" id="modalAgregarApoderado" tabindex="-1" role="dialog" aria-labelledby="modalAgregarApoderado" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Apoderado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post" class="formNuevoApoderado">
          <!-- Correo Electrónico -->
          <div class="form-group">
            <label for="nombreApoderado" class="col-form-label">Nombres:</label>
            <input type="text" class="form-control" id="nombreApoderado" name="nombreApoderado" required>
          </div>

          <!-- Nombre -->
          <div class="form-group">
            <label for="apellidoApoderado" class="col-form-label">Apellidos:</label>
            <input type="text" class="form-control" id="apellidoApoderado" name="apellidoApoderado" required>
          </div>

          <!-- Apellido -->
          <div class="form-group">
            <label for="correoApoderado" class="col-form-label">Correo Apoderado:</label>
            <input type="email" class="form-control" id="correoApoderado" name="correoApoderado" required>
          </div>

          <!-- Celular -->
          <div class="form-group">
            <label for="celularApoderado" class="col-form-label">Celular:</label>
            <input type="text" class="form-control" id="celularApoderado" name="celularApoderado" required>
          </div>

          <!-- Perfil -->
          <div class="form-group">
            <label for="tipoApoderado" class="col-form-label">Parentesco:</label>
            <select class="form-control" name="tipoApoderado" id="tipoApoderado" required>
              <option value="">Eliga una opción</option>
              <option value="Padre">Padre</option>
              <option value="Madre">Madre</option>
              <option value="Apoderado">Apoderado</option>
            </select>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnAgregarApoderado">Agregar Apoderado</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>