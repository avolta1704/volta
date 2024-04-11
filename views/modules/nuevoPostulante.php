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
                <label for="sexoPostulante" class="form-label" style="font-weight: bold">Sexo: </label>
                <input type="text" class="form-control" id="sexoPostulante" name="sexoPostulante" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="dniPostulante" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="dniPostulante" name="dniPostulante" value="" required>
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

              <div class="form-group col-md-6">
                <label for="fechaPostulacion" class="form-label" style="font-weight: bold">Fecha Postulación: </label>
                <input type="date" class="form-control" id="fechaPostulacion" name="fechaPostulacion" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="fechaNacimiento" class="form-label" style="font-weight: bold">Fecha Nacimiento: </label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="lugarNacimiento" class="form-label" style="font-weight: bold">Lugar Nacimiento: </label>
                <input type="text" class="form-control" id="lugarNacimiento" name="lugarNacimiento" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="domicilioPostulante" class="form-label" style="font-weight: bold">Domicilio: </label>
                <input type="text" class="form-control" id="domicilioPostulante" name="domicilioPostulante" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="colegioProcedencia" class="form-label" style="font-weight: bold">Colegio Procedencia: </label>
                <input type="text" class="form-control" id="colegioProcedencia" name="colegioProcedencia" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="dificultadAprendizaje" class="form-label" style="font-weight: bold">Tiene alguna dificultad: </label>
                <div class="form-check">
                  <label for="cbxDificultad" style="font-weight: 600;"><input type="radio" id="cbxDificultad" value="Dificultad" name="dificultadAprendizaje">Dificultad de aprendizaje/lenguaje</label>
                  <label for="cbxImpedimento" style="font-weight: 600;"><input type="radio" id="cbxImpedimento" value="Impedimento" name="dificultadAprendizaje">Impedimento físico/motoras</label>
                  <label for="cbxEnfermedad" style="font-weight: 600;"><input type="radio" id="cbxEnfermedad" value="Enfermedad" name="dificultadAprendizaje">Enfermedad Crónica</label>
                  <label for="cbxNinguno" style="font-weight: 600;"><input type="radio" id="cbxNinguno" value="Ninguna" name="dificultadAprendizaje">Ninguna</label>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="detalleDificultad" class="form-label" style="font-weight: bold">Especifique: </label>
                <input type="text" class="form-control" id="detalleDificultad" name="detalleDificultad" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="tipoSalud" class="form-label" style="font-weight: bold">Tipo de atención de salud tiene el estudiante (SIS, ESSALUD u otro): </label>
                <input type="text" class="form-control" id="tipoSalud" name="tipoSalud" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="tratamientoPostulante" class="form-label" style="font-weight: bold">Recibe un tipo de tratamiento o terapia, especificar: </label>
                <input type="text" class="form-control" id="tratamientoPostulante" name="tratamientoPostulante" value="" required>
              </div>
            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Padre</h3>
              <div class="form-group col-md-6">
                <label for="nombrePadre" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="nombrePadre" name="nombrePadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="apellidoPadre" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="apellidoPadre" name="apellidoPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="dniPadre" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="dniPadre" name="dniPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="fechaNacimientoPadre" class="form-label" style="font-weight: bold">Fecha de Nacimiento: </label>
                <input type="date" class="form-control" id="fechaNacimientoPadre" name="fechaNacimientoPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="convivePadre" class="form-label" style="font-weight: bold">Convive con el postulante: </label>
                <div class="form-check">
                  <label for="cbxSiConvive" style="font-weight: 600;"><input type="radio" id="cbxSiConvive" value="Si" name="convivePadre">Si</label>
                  <label for="cbxNoConvive" style="font-weight: 600;"><input type="radio" id="cbxNoConvive" value="No" name="convivePadre">No</label>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="gradoPadre" class="form-label" style="font-weight: bold">Grado de Instrucción: </label>
                <input type="text" class="form-control" id="gradoPadre" name="gradoPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="profesionPadre" class="form-label" style="font-weight: bold">Profesión: </label>
                <input type="text" class="form-control" id="profesionPadre" name="profesionPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="emailPadre" class="form-label" style="font-weight: bold">Correo Electrónico: </label>
                <input type="text" class="form-control" id="emailPadre" name="emailPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="numeroPadre" class="form-label" style="font-weight: bold">Numero Celular: </label>
                <input type="text" class="form-control" id="numeroPadre" name="numeroPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="dependenciaPadre" class="form-label" style="font-weight: bold">Independiente/Dependiente: </label>
                <input type="text" class="form-control" id="dependenciaPadre" name="dependenciaPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="centroPadre" class="form-label" style="font-weight: bold">Centro Laboral: </label>
                <input type="text" class="form-control" id="centroPadre" name="centroPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="numeroTrabajoPadre" class="form-label" style="font-weight: bold">Teléfono de Trabajo: </label>
                <input type="text" class="form-control" id="numeroTrabajoPadre" name="numeroTrabajoPadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="ingresoPadre" class="form-label" style="font-weight: bold">Ingreso Mensual: </label>
                <input type="text" class="form-control" id="ingresoPadre" name="ingresoPadre" value="" required>
              </div>

            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos de la Madre</h3>
              <div class="form-group col-md-6">
                <label for="nombreMadre" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="nombreMadre" name="nombreMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="apellidoMadre" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="apellidoMadre" name="apellidoMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="dniMadre" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="dniMadre" name="dniMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="fechaNacimientoMadre" class="form-label" style="font-weight: bold">Fecha de Nacimiento: </label>
                <input type="date" class="form-control" id="fechaNacimientoMadre" name="fechaNacimientoMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="conviveMadre" class="form-label" style="font-weight: bold">Convive con el postulante: </label>
                <div class="form-check">
                  <label for="cbxSiConvive" style="font-weight: 600;"><input type="radio" id="cbxSiConvive" value="Si" name="conviveMadre">Si</label>
                  <label for="cbxNoConvive" style="font-weight: 600;"><input type="radio" id="cbxNoConvive" value="No" name="conviveMadre">No</label>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="gradoMadre" class="form-label" style="font-weight: bold">Grado de Instrucción: </label>
                <input type="text" class="form-control" id="gradoMadre" name="gradoMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="profesionMadre" class="form-label" style="font-weight: bold">Profesión: </label>
                <input type="text" class="form-control" id="profesionMadre" name="profesionMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="emailMadre" class="form-label" style="font-weight: bold">Correo Electrónico: </label>
                <input type="text" class="form-control" id="emailMadre" name="emailMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="numeroMadre" class="form-label" style="font-weight: bold">Numero Celular: </label>
                <input type="text" class="form-control" id="numeroMadre" name="numeroMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="dependenciaMadre" class="form-label" style="font-weight: bold">Independiente/Dependiente: </label>
                <input type="text" class="form-control" id="dependenciaMadre" name="dependenciaMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="centroMadre" class="form-label" style="font-weight: bold">Centro Laboral: </label>
                <input type="text" class="form-control" id="centroMadre" name="centroMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="numeroTrabajoMadre" class="form-label" style="font-weight: bold">Teléfono de Trabajo: </label>
                <input type="text" class="form-control" id="numeroTrabajoMadre" name="numeroTrabajoMadre" value="" required>
              </div>

              <div class="form-group col-md-6">
                <label for="ingresoMadre" class="form-label" style="font-weight: bold">Ingreso Mensual: </label>
                <input type="text" class="form-control" id="ingresoMadre" name="ingresoMadre" value="" required>
              </div>
            </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarCrearPostulante">Cerrar</button>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary">Registrar Postulante</button>
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