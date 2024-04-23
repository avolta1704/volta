<main id="main" class="main">

  <div class="pagetitle">
    <h1>Editar Postulante</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listPostulantes">Postulantes</a></li>
        <li class="breadcrumb-item"><a href="listPostulantes">Lista Postulantes</a></li>
        <li class="breadcrumb-item active">Editar Postulante</li>
      </ol>
    </nav>
    <?php
    $codPostulante = $_GET["codPostulante"];
    $datosPostulante = ControllerPostulantes::ctrGetPostulanteById($codPostulante);
    ?>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>

      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2 formEditarPostulante">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Postulante</h3>

              <div class="form-group col-md-6">
                <label for="editarNombre" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="<?php echo $datosPostulante["nombrePostulante"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarApellido" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="editarApellido" name="editarApellido" value="<?php echo $datosPostulante["apellidoPostulante"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarSexo" class="form-label" style="font-weight: bold">Sexo: </label>
                <input type="text" class="form-control" id="editarSexo" name="editarSexo" value="<?php echo $datosPostulante["sexoPostulante"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDni" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="editarDni" name="editarDni" value="<?php echo $datosPostulante["dniPostulante"] ?>" disabled>
              </div>

              <div class="form-group col-md-6 nivelAdmision">
                <label for="nivelAlumno" class="col-form-label" style="font-weight: bold">Nivel:</label>
                <input type="text" class="form-control" id="nivelAlumno" name="nivelAlumno" value="<?php echo $datosPostulante["descripcionNivel"] ?>" disabled>
              </div>

              <div class="form-group col-md-6 gradoAdmision">
                <label for="gradoAlumno" class="col-form-label" style="font-weight: bold">Grado:</label>
                <input type="text" class="form-control" id="gradoAlumno" name="gradoAlumno" value="<?php echo $datosPostulante["descripcionGrado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaPostulacion" class="form-label" style="font-weight: bold">Fecha Postulación: </label>
                <input type="date" class="form-control" id="editarFechaPostulacion" name="editarFechaPostulacion" value="<?php echo $datosPostulante["fechaPostulacion"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaNacimiento" class="form-label" style="font-weight: bold">Fecha Nacimiento: </label>
                <input type="date" class="form-control" id="editarFechaNacimiento" name="editarFechaNacimiento" value="<?php echo $datosPostulante["fechaNacimiento"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarLugarNacimiento" class="form-label" style="font-weight: bold">Lugar Nacimiento: </label>
                <input type="text" class="form-control" id="editarLugarNacimiento" name="editarLugarNacimiento" value="<?php echo $datosPostulante["lugarNacimiento"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDomicilio" class="form-label" style="font-weight: bold">Domicilio: </label>
                <input type="text" class="form-control" id="editarDomicilio" name="editarDomicilio" value="<?php echo $datosPostulante["domicilioPostulante"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarColegioProced" class="form-label" style="font-weight: bold">Colegio Procedencia: </label>
                <input type="text" class="form-control" id="editarColegioProced" name="editarColegioProced" value="<?php echo $datosPostulante["colegioProcedencia"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDificultad" class="form-label" style="font-weight: bold">Tiene alguna dificultad: </label>
                <div class="form-check">
                  <?php
                  echo FunctionApoderado::getRadioDificultad($datosPostulante["dificultadPostulante"]);
                  ?>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDetalleDif" class="form-label" style="font-weight: bold">Especifique: </label>
                <input type="text" class="form-control" id="editarDetalleDif" name="editarDetalleDif" value="<?php echo $datosPostulante["dificultadObservacion"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarTipoSalud" class="form-label" style="font-weight: bold">Tipo de atención de salud tiene el estudiante (SIS, ESSALUD u otro): </label>
                <input type="text" class="form-control" id="editarTipoSalud" name="editarTipoSalud" value="<?php echo $datosPostulante["tipoAtencionPostulante"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarTratamiento" class="form-label" style="font-weight: bold">Recibe un tipo de tratamiento o terapia, especificar: </label>
                <input type="text" class="form-control" id="editarTratamiento" name="editarTratamiento" value="<?php echo $datosPostulante["tratamientoPostulante"] ?>" disabled>
              </div>
            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Padre</h3>
              <div class="form-group col-md-6">
                <label for="editarNombrePadre" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="editarNombrePadre" name="editarNombrePadre" value="<?php echo $datosPostulante["dataPadre"]["nombreApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarApellidoPadre" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="editarApellidoPadre" name="editarApellidoPadre" value="<?php echo $datosPostulante["dataPadre"]["apellidoApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDniPadre" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="editarDniPadre" name="editarDniPadre" value="<?php echo $datosPostulante["dataPadre"]["dniApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaPadre" class="form-label" style="font-weight: bold">Fecha de Nacimiento: </label>
                <input type="date" class="form-control" id="editarFechaPadre" name="editarFechaPadre" value="<?php echo $datosPostulante["dataPadre"]["fechaNacimiento"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarConvivePadre" class="form-label" style="font-weight: bold">Convive con el postulante: </label>
                <div class="form-check">
                  <?php
                  echo FunctionApoderado::getRadioConvivencia($datosPostulante["dataPadre"]["convivenciaAlumno"], "Padre");
                  ?>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="editarGradoPadre" class="form-label" style="font-weight: bold">Grado de Instrucción: </label>
                <input type="text" class="form-control" id="editarGradoPadre" name="editarGradoPadre" value="<?php echo $datosPostulante["dataPadre"]["gradoInstruccion"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarProfesionPadre" class="form-label" style="font-weight: bold">Profesión: </label>
                <input type="text" class="form-control" id="editarProfesionPadre" name="editarProfesionPadre" value="<?php echo $datosPostulante["dataPadre"]["profesionAlumno"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarCorreoPadre" class="form-label" style="font-weight: bold">Correo Electrónico: </label>
                <input type="text" class="form-control" id="editarCorreoPadre" name="editarCorreoPadre" value="<?php echo $datosPostulante["dataPadre"]["correoApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarCelularPadre" class="form-label" style="font-weight: bold">Numero Celular: </label>
                <input type="text" class="form-control" id="editarCelularPadre" name="editarCelularPadre" value="<?php echo $datosPostulante["dataPadre"]["celularApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDepenPadre" class="form-label" style="font-weight: bold">Independiente/Dependiente: </label>
                <input type="text" class="form-control" id="editarDepenPadre" name="editarDepenPadre" value="<?php echo $datosPostulante["dataPadre"]["dependenciaApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarCentroPadre" class="form-label" style="font-weight: bold">Centro Laboral: </label>
                <input type="text" class="form-control" id="editarCentroPadre" name="editarCentroPadre" value="<?php echo $datosPostulante["dataPadre"]["centroLaboral"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarNumTrabajoPadre" class="form-label" style="font-weight: bold">Teléfono de Trabajo: </label>
                <input type="text" class="form-control" id="editarNumTrabajoPadre" name="editarNumTrabajoPadre" value="<?php echo $datosPostulante["dataPadre"]["telefonoTrabajo"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarIngresoPadre" class="form-label" style="font-weight: bold">Ingreso Mensual: </label>
                <input type="text" class="form-control" id="editarIngresoPadre" name="editarIngresoPadre" value="<?php echo $datosPostulante["dataPadre"]["ingresoMensual"] ?>" disabled>
              </div>
            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos de la Madre</h3>
              <div class="form-group col-md-6">
                <label for="editarNombreMadre" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="editarNombreMadre" name="editarNombreMadre" value="<?php echo $datosPostulante["dataMadre"]["nombreApoderado"] ?>" disabled>
                <input type="hidden" class="form-control" id="codMadre" name="codMadre" value="<?php echo $datosPostulante["dataMadre"]["idApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarApellidoMadre" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="editarApellidoMadre" name="editarApellidoMadre" value="<?php echo $datosPostulante["dataMadre"]["apellidoApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDniMadre" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="editarDniMadre" name="editarDniMadre" value="<?php echo $datosPostulante["dataMadre"]["dniApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaMadre" class="form-label" style="font-weight: bold">Fecha de Nacimiento: </label>
                <input type="date" class="form-control" id="editarFechaMadre" name="editarFechaMadre" value="<?php echo $datosPostulante["dataMadre"]["fechaNacimiento"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarConviveMadre" class="form-label" style="font-weight: bold">Convive con el postulante: </label>
                <div class="form-check">
                  <?php
                  echo FunctionApoderado::getRadioConvivencia($datosPostulante["dataMadre"]["convivenciaAlumno"], "Madre");
                  ?>
                </div>
              </div>

              <div class="form-group col-md-6">
                <label for="editarGradoMadre" class="form-label" style="font-weight: bold">Grado de Instrucción: </label>
                <input type="text" class="form-control" id="editarGradoMadre" name="editarGradoMadre" value="<?php echo $datosPostulante["dataMadre"]["gradoInstruccion"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarProfesionMadre" class="form-label" style="font-weight: bold">Profesión: </label>
                <input type="text" class="form-control" id="editarProfesionMadre" name="editarProfesionMadre" value="<?php echo $datosPostulante["dataMadre"]["profesionAlumno"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarCorreoMadre" class="form-label" style="font-weight: bold">Correo Electrónico: </label>
                <input type="text" class="form-control" id="editarCorreoMadre" name="editarCorreoMadre" value="<?php echo $datosPostulante["dataMadre"]["correoApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarCelularMadre" class="form-label" style="font-weight: bold">Numero Celular: </label>
                <input type="text" class="form-control" id="editarCelularMadre" name="editarCelularMadre" value="<?php echo $datosPostulante["dataMadre"]["celularApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDepenMadre" class="form-label" style="font-weight: bold">Independiente/Dependiente: </label>
                <input type="text" class="form-control" id="editarDepenMadre" name="editarDepenMadre" value="<?php echo $datosPostulante["dataMadre"]["dependenciaApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarCentroMadre" class="form-label" style="font-weight: bold">Centro Laboral: </label>
                <input type="text" class="form-control" id="editarCentroMadre" name="editarCentroMadre" value="<?php echo $datosPostulante["dataMadre"]["centroLaboral"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarNumTrabajoMadre" class="form-label" style="font-weight: bold">Teléfono de Trabajo: </label>
                <input type="text" class="form-control" id="editarNumTrabajoMadre" name="editarNumTrabajoMadre" value="<?php echo $datosPostulante["dataMadre"]["telefonoTrabajo"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarIngresoMadre" class="form-label" style="font-weight: bold">Ingreso Mensual: </label>
                <input type="text" class="form-control" id="editarIngresoMadre" name="editarIngresoMadre" value="<?php echo $datosPostulante["dataMadre"]["ingresoMensual"] ?>" disabled>
              </div>
            </div>
          </span>
        </form>
      </div>
    </div>
  </section>
</main>
