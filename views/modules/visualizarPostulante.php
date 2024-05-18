<main id="main" class="main">

  <div class="pagetitle">
    <h1>Visualizar Postulante</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="listaPostulantes">Postulantes</a></li>
        <li class="breadcrumb-item"><a href="listaPostulantes">Lista Postulantes</a></li>
        <li class="breadcrumb-item active">Visualizar Postulante</li>
      </ol>
    </nav>
    <?php
    $codPostulante = $_GET["codPostulante"];
    $datosPostulante = ControllerPostulantes::ctrGetPostulanteById($codPostulante);
    $dataChecklist = ControllerPostulantes::ctrGetChecklistPostulante($codPostulante);
    ?>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>

      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2 formvisualizarPostulante">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Postulante</h3>

              <div class="form-group row">
                <label for="visualizarNombre" class="col-sm-2 col-form-label" style="font-weight: bold">Nombres: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarNombre" name="visualizarNombre" value="<?php echo $datosPostulante["nombrePostulante"] ?>" disabled>
                </div>
                <label for="visualizarFechaPostulacion" class="col-sm-2 col-form-label" style="font-weight: bold">Fecha Postulación: </label>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="visualizarFechaPostulacion" name="visualizarFechaPostulacion" value="<?php echo $datosPostulante["fechaPostulacion"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarApellido" class="col-sm-2 col-form-label" style="font-weight: bold">Apellidos: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarApellido" name="visualizarApellido" value="<?php echo $datosPostulante["apellidoPostulante"] ?>" disabled>
                </div>
                <label for="visualizarFechaNacimiento" class="col-sm-2 col-form-label" style="font-weight: bold">Fecha Nacimiento: </label>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="visualizarFechaNacimiento" name="visualizarFechaNacimiento" value="<?php echo $datosPostulante["fechaNacimiento"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarSexo" class="col-sm-2 col-form-label" style="font-weight: bold">Sexo: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarSexo" name="visualizarSexo" value="<?php echo $datosPostulante["sexoPostulante"] ?>" disabled>
                </div>
                <label for="visualizarLugarNacimiento" class="col-sm-2 col-form-label" style="font-weight: bold">Lugar Nacimiento: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarLugarNacimiento" name="visualizarLugarNacimiento" value="<?php echo $datosPostulante["lugarNacimiento"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarDni" class="col-sm-2 col-form-label" style="font-weight: bold">DNI: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarDni" name="visualizarDni" value="<?php echo $datosPostulante["dniPostulante"] ?>" disabled>
                </div>
                <label for="visualizarDomicilio" class="col-sm-2 col-form-label" style="font-weight: bold">Domicilio: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarDomicilio" name="visualizarDomicilio" value="<?php echo $datosPostulante["domicilioPostulante"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row nivelAdmision">
                <label for="nivelAlumno" class="col-sm-2 col-form-label" style="font-weight: bold">Nivel:</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="nivelAlumno" name="nivelAlumno" value="<?php echo $datosPostulante["descripcionNivel"] ?>" disabled>
                </div>
                <label for="visualizarColegioProced" class="col-sm-2 col-form-label" style="font-weight: bold">Colegio Procedencia: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarColegioProced" name="visualizarColegioProced" value="<?php echo $datosPostulante["colegioProcedencia"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row gradoAdmision">
                <label for="gradoAlumno" class="col-sm-2 col-form-label" style="font-weight: bold">Grado:</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="gradoAlumno" name="gradoAlumno" value="<?php echo $datosPostulante["descripcionGrado"] ?>" disabled>
                </div>
                <label for="visualizarDificultad" class="col-sm-2 col-form-label" style=" font-weight: bold">Tiene alguna dificultad: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarColegioProced" name="visualizarColegioProced" value="<?php echo $datosPostulante["dificultadPostulante"] ?>" disabled>
                </div>
              </div>

              <div class="form-group col-md-11">
                <label for="visualizarDetalleDif" class="form-label" style="font-weight: bold">Especifique la Dificultad: </label>
                <input type="text" class="form-control" id="visualizarDetalleDif" name="visualizarDetalleDif" value="<?php echo $datosPostulante["dificultadObservacion"] ?>" disabled>
              </div>

              <div class="form-group col-md-11">
                <label for="visualizarTipoSalud" class="form-label" style="font-weight: bold">Tipo de atención de salud tiene el estudiante (SIS, ESSALUD u otro): </label>
                <input type="text" class="form-control" id="visualizarTipoSalud" name="visualizarTipoSalud" value="<?php echo $datosPostulante["tipoAtencionPostulante"] ?>" disabled>
              </div>

              <div class="form-group col-md-11">
                <label for="visualizarTratamiento" class="form-label" style="font-weight: bold">Recibe un tipo de tratamiento o terapia, especificar: </label>
                <input type="text" class="form-control" id="visualizarTratamiento" name="visualizarTratamiento" value="<?php echo $datosPostulante["tratamientoPostulante"] ?>" disabled>
              </div>
            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Padre</h3>

              <div class="form-group row">
                <label for="visualizarNombrePadre" class="col-sm-2 col-form-label" style="font-weight: bold">Nombres: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarNombrePadre" name="visualizarNombrePadre" value="<?php echo $datosPostulante["dataPadre"]["nombreApoderado"] ?>" disabled>
                </div>
                <label for="visualizarProfesionPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Profesión: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarProfesionPadre" name="visualizarProfesionPadre" value="<?php echo $datosPostulante["dataPadre"]["profesionApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarApellidoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Apellidos: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarApellidoPadre" name="visualizarApellidoPadre" value="<?php echo $datosPostulante["dataPadre"]["apellidoApoderado"] ?>" disabled>
                </div>
                <label for="visualizarCorreoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Correo Electrónico: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarCorreoPadre" name="visualizarCorreoPadre" value="<?php echo $datosPostulante["dataPadre"]["correoApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarDniPadre" class="col-sm-2 col-form-label" style="font-weight: bold">DNI: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarDniPadre" name="visualizarDniPadre" value="<?php echo $datosPostulante["dataPadre"]["dniApoderado"] ?>" disabled>
                </div>
                <label for="visualizarCelularPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Numero Celular: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarCelularPadre" name="visualizarCelularPadre" value="<?php echo $datosPostulante["dataPadre"]["celularApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarFechaPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Fecha de Nacimiento: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarFechaPadre" name="visualizarFechaPadre" value="<?php echo $datosPostulante["dataPadre"]["fechaNacimiento"] ?>" disabled>
                </div>
                <label for="visualizarDepenPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Independiente / Dependiente: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarDepenPadre" name="visualizarDepenPadre" value="<?php echo $datosPostulante["dataPadre"]["dependenciaApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarConvivePadre" class="col-sm-2 col-form-label" style="font-weight: bold">Convive con el postulante: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarFechaPadre" name="visualizarFechaPadre" value="<?php echo $datosPostulante["dataPadre"]["convivenciaAlumno"] ?>" disabled>
                </div>
                <label for="visualizarCentroPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Centro Laboral: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarCentroPadre" name="visualizarCentroPadre" value="<?php echo $datosPostulante["dataPadre"]["centroLaboral"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarGradoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Grado de Instrucción: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarGradoPadre" name="visualizarGradoPadre" value="<?php echo $datosPostulante["dataPadre"]["gradoInstruccion"] ?>" disabled>
                </div>
                <label for="visualizarNumTrabajoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Teléfono de Trabajo: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarNumTrabajoPadre" name="visualizarNumTrabajoPadre" value="<?php echo $datosPostulante["dataPadre"]["telefonoTrabajo"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarIngresoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Ingreso Mensual: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarIngresoPadre" name="visualizarIngresoPadre" value="<?php echo $datosPostulante["dataPadre"]["ingresoMensual"] ?>" disabled>
                </div>
              </div>
            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos de la Madre</h3>

              <div class="form-group row">
                <label for="visualizarNombrePadre" class="col-sm-2 col-form-label" style="font-weight: bold">Nombres: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarNombrePadre" name="visualizarNombrePadre" value="<?php echo $datosPostulante["dataMadre"]["nombreApoderado"] ?>" disabled>
                </div>
                <label for="visualizarProfesionPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Profesión: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarProfesionPadre" name="visualizarProfesionPadre" value="<?php echo $datosPostulante["dataMadre"]["profesionApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarApellidoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Apellidos: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarApellidoPadre" name="visualizarApellidoPadre" value="<?php echo $datosPostulante["dataMadre"]["apellidoApoderado"] ?>" disabled>
                </div>
                <label for="visualizarCorreoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Correo Electrónico: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarCorreoPadre" name="visualizarCorreoPadre" value="<?php echo $datosPostulante["dataMadre"]["correoApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarDniPadre" class="col-sm-2 col-form-label" style="font-weight: bold">DNI: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarDniPadre" name="visualizarDniPadre" value="<?php echo $datosPostulante["dataMadre"]["dniApoderado"] ?>" disabled>
                </div>
                <label for="visualizarCelularPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Numero Celular: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarCelularPadre" name="visualizarCelularPadre" value="<?php echo $datosPostulante["dataMadre"]["celularApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarFechaPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Fecha de Nacimiento: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarFechaPadre" name="visualizarFechaPadre" value="<?php echo $datosPostulante["dataMadre"]["fechaNacimiento"] ?>" disabled>
                </div>
                <label for="visualizarDepenPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Independiente / Dependiente: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarDepenPadre" name="visualizarDepenPadre" value="<?php echo $datosPostulante["dataMadre"]["dependenciaApoderado"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarConvivePadre" class="col-sm-2 col-form-label" style="font-weight: bold">Convive con el postulante: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarFechaPadre" name="visualizarFechaPadre" value="<?php echo $datosPostulante["dataMadre"]["convivenciaAlumno"] ?>" disabled>
                </div>
                <label for="visualizarCentroPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Centro Laboral: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarCentroPadre" name="visualizarCentroPadre" value="<?php echo $datosPostulante["dataMadre"]["centroLaboral"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarGradoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Grado de Instrucción: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarGradoPadre" name="visualizarGradoPadre" value="<?php echo $datosPostulante["dataMadre"]["gradoInstruccion"] ?>" disabled>
                </div>
                <label for="visualizarNumTrabajoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Teléfono de Trabajo: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="visualizarNumTrabajoPadre" name="visualizarNumTrabajoPadre" value="<?php echo $datosPostulante["dataMadre"]["telefonoTrabajo"] ?>" disabled>
                </div>
              </div>

              <div class="form-group row">
                <label for="visualizarIngresoPadre" class="col-sm-2 col-form-label" style="font-weight: bold">Ingreso Mensual: </label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" id="visualizarIngresoPadre" name="visualizarIngresoPadre" value="<?php echo $datosPostulante["dataMadre"]["ingresoMensual"] ?>" disabled>
                </div>
              </div>
            </div>
          </span>

          <span id="checklistPostulante" class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Checklist Postulante</h3>

              <!-- CHECHLIST -->
              <?php
              FunctionPostulantes::renderCheckList("Ficha Postulante", "checkFichaPostulante", "fechaFichaPostulante", $dataChecklist["estadoFichaPostulante"], $dataChecklist["fechaFichaPost"], true);
              FunctionPostulantes::renderCheckList("Entrevista", "checkEntrevista", "fechaEntrevista", $dataChecklist["estadoEntrevista"], $dataChecklist["fechaEntrevista"], false);
              FunctionPostulantes::renderCheckList("Informe Psicológico", "checkInformePsico", "fechaInformePsico", $dataChecklist["estadoInformePsicologico"], $dataChecklist["fechaInformePsicologico"], true);
              FunctionPostulantes::renderCheckList("Constancia Adeudo", "checkConstAdeudo", "fechaConstAdeudo", $dataChecklist["constanciaAdeudo"], $dataChecklist["fechaConstanciaAdeudo"], false);
              FunctionPostulantes::renderCheckList("Carta de Admisión", "checkCartaAdmision", "fechaCartaAdmision", $dataChecklist["cartaAdmision"], $dataChecklist["fechaCartaAdmision"], false);
              FunctionPostulantes::renderCheckList("Contrato", "checkContrato", "fechaContrato", $dataChecklist["contrato"], $dataChecklist["fechaContrato"], false);
              FunctionPostulantes::renderCheckList("Constancia de Vacante", "checkConstVacante", "fechaConstVacante", $dataChecklist["constanciaVacante"], $dataChecklist["fechaConstanciaVacante"], false);
              ?>

              <!-- PAGO MATRÍCULA -->
              <div class="form-group row">
                <label for="checkPagoMatricula" class="col-sm-3 col-form-label" style="font-weight: bold">Pago Matrícula: </label>
                <?php
                //  En este caso en particular se evalúa con null, debido a que en la bd se guarda un identificador del pago, si no se tiene el pago, por defecto es null
                if ($dataChecklist["pagoMatricula"] != null) {
                ?>
                  <div class="col-sm-2">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="checkPagoMatricula" name="checkPagoMatricula" checked>
                      <label class="form-check-label" for="checkPagoMatricula"></label>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <input type="date" name="fechaPagoMatricula" id="fechaPagoMatricula" class="form-control fechaPagoMatricula" value="<?php echo $dataChecklist['fechaPagoMatricula']; ?>">
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn btn-success"><i class="bi bi-cloud-arrow-up-fill"></i></button>
                    <button type="button" class="btn btn-warning"><i class="bi bi-cloud-arrow-down-fill"></i></button>
                  </div>

                <?php
                } else {
                ?>
                  <div class="col-sm-2">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="checkPagoMatricula" name="checkPagoMatricula">
                      <label class="form-check-label" for="checkPagoMatricula">Presentado</label>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <input type="date" name="fechaPagoMatricula" id="fechaPagoMatricula" class="form-control fechaPagoMatricula">
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn btn-success"><i class="bi bi-cloud-arrow-up-fill"></i></button>
                    <button type="button" class="btn btn-warning"><i class="bi bi-cloud-arrow-down-fill"></i></button>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>

            <div class="container row g-3 p-3 justify-content-between">
              <input type="hidden" class="codPostulanteCheck" name="codPostulanteCheck" id="codPostulanteCheck" value="<?php echo $codPostulante ?>">
              <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarVisualizarPostulante">Cerrar</button>
              <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary btnActualizarChecklistPostulante">Actualizar Checklist</button>
            </div>
          </span>
        </form>
   
      </div>
    </div>
  </section>
</main>