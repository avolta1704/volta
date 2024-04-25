<main id="main" class="main" style="display: flex; justify-content: center; align-items: center;">
  <section class="section dashboard">
    <div class="row">
      <div class="container-fluid w-100">
        <form role="form" method="post" class="row g-3 m-2 formBusquedaPostulante" style="display: flex; justify-content: center; align-items: center;">
          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h2 style="font-weight: bold; text-align: center;">Buscar Postulante</h2><br>
            </div>

            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos de Postulante</h3>
              <!-- datos para filtrar datos de busqueda -->
              <div class="form-group col-md-12">
                <label for="apellidoPostulante" class="form-label" style="font-weight: bold"> Postulante:</label>
                <select class="form-control input-lg busquedaPostulante" id="apellidoPostulante" name="apellidoPostulante">
                  <option value="0">Seleccione Postulante</option>
                  <?php
                  $listaPostulantes = ControllerPostulantes::ctrGetPostulantesBusqueda();
                  foreach($listaPostulantes as $value) {
                    echo "<option value='" . $value["idPostulante"] . "'>" . $value["apellidoPostulante"] . " " . $value["nombrePostulante"] . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="container row g-3">
              <div class="col-md-3">
                <label for="sexoPostulante" class="form-label" style="font-weight: bold">Sexo:</label>
                <input type="text" class="form-control" id="sexoPostulante" name="sexoPostulante" readonly>
              </div>

              <div class="col-md-3">
                <label for="dniPostulante" class="form-label" style="font-weight: bold">DNI:</label>
                <input type="text" class="form-control" id="dniPostulante" name="dniPostulante" readonly>
              </div>

              <div class="col-md-3">
                <label for="nivelPostulante" class="form-label" style="font-weight: bold">Nivel:</label>
                <input type="text" class="form-control" id="nivelPostulante" name="nivelPostulante" readonly>
              </div>

              <div class="col-md-3">
                <label for="gradoBusqueda" class="form-label" style="font-weight: bold">Grado:</label>
                <input type="text" class="form-control" id="gradoBusqueda" name="gradoBusqueda" readonly>
              </div>

              <div class="col-md-2">
                <label for="fechaPostulacion" class="form-label" style="font-weight: bold">Fecha Postulación:</label>
                <input type="date" class="form-control" id="fechaPostulacion" name="fechaPostulacion" readonly>
              </div>

              <div class="col-md-2">
                <label for="fechaNacimiento" class="form-label" style="font-weight: bold">Fecha Nacimiento:</label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" readonly>
              </div>

              <div class="col-md-4">
                <label for="lugarNacimiento" class="form-label" style="font-weight: bold">Lugar Nacimiento:</label>
                <input type="text" class="form-control" id="lugarNacimiento" name="lugarNacimiento" readonly>
              </div>

              <div class="col-md-4">
                <label for="domicilioPostulante" class="form-label" style="font-weight: bold">Domicilio:</label>
                <input type="text" class="form-control" id="domicilioPostulante" name="domicilioPostulante" readonly>
              </div>

              <div class="col-md-4">
                <label for="colegioProcedencia" class="form-label" style="font-weight: bold">Colegio Procedencia:</label>
                <input type="text" class="form-control" id="colegioProcedencia" name="colegioProcedencia" readonly>
              </div>

              <div class="col-md-4">
                <label for="dificultadPostulante" class="form-label" style="font-weight: bold">Dificultad:</label>
                <input type="text" class="form-control" id="dificultadPostulante" name="dificultadPostulante" readonly>
              </div>

              <div class="col-md-4">
                <label for="obsDificultad" class="form-label" style="font-weight: bold">Observación Dificultad:</label>
                <input type="text" class="form-control" id="obsDificultad" name="obsDificultad" readonly>
              </div>

              <div class="col-md-3">
                <label for="tipoAtencion" class="form-label" style="font-weight: bold">Tipo Salud:</label>
                <input type="text" class="form-control" id="tipoAtencion" name="tipoAtencion" readonly>
              </div>

              <div class="col-md-3">
                <label for="obsTratamiento" class="form-label" style="font-weight: bold">Observación de Tratamiento:</label>
                <input type="text" class="form-control" id="obsTratamiento" name="obsTratamiento" readonly>
              </div>
            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Padre</h3>

              <div class="form-group col-md-6">
                <label for="nombrePadre" class="form-label" style="font-weight: bold">Nombre: </label>
                <input type="text" class="form-control" id="nombrePadre" name="nombrePadre" readonly>
              </div>

              <div class="col-md-6">
                <label for="apellidoPadre" class="form-label" style="font-weight: bold">Apellido:</label>
                <input type="text" class="form-control" id="apellidoPadre" name="apellidoPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="dniPadre" class="form-label" style="font-weight: bold">DNI:</label>
                <input type="text" class="form-control" id="dniPadre" name="dniPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="nacimientoPadre" class="form-label" style="font-weight: bold">Fecha Nacimiento:</label>
                <input type="date" class="form-control" id="nacimientoPadre" name="nacimientoPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="convivePadre" class="form-label" style="font-weight: bold">Convive con el Postulante:</label>
                <input type="text" class="form-control" id="convivePadre" name="convivePadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="gradoPadre" class="form-label" style="font-weight: bold">Grado de Instrucción:</label>
                <input type="text" class="form-control" id="gradoPadre" name="gradoPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="profesionPadre" class="form-label" style="font-weight: bold">Profesión:</label>
                <input type="text" class="form-control" id="profesionPadre" name="profesionPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="correoPadre" class="form-label" style="font-weight: bold">Correo Electrónico:</label>
                <input type="text" class="form-control" id="correoPadre" name="correoPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="numeroPadre" class="form-label" style="font-weight: bold">Número Celular:</label>
                <input type="text" class="form-control" id="numeroPadre" name="numeroPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="dependenciaPadre" class="form-label" style="font-weight: bold">Independiente/Dependiente:</label>
                <input type="text" class="form-control" id="dependenciaPadre" name="dependenciaPadre" readonly>
              </div>

              <div class="col-md-6">
                <label for="centroPadre" class="form-label" style="font-weight: bold">Centro Laboral</label>
                <input type="text" class="form-control" id="centroPadre" name="centroPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="tlfTrabajoPadre" class="form-label" style="font-weight: bold">Teléfono Padre</label>
                <input type="text" class="form-control" id="tlfTrabajoPadre" name="tlfTrabajoPadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="ingresoPadre" class="form-label" style="font-weight: bold">Ingreso Mensual </label>
                <input type="text" class="form-control" id="ingresoPadre" name="ingresoPadre" readonly>
              </div>
            </div>
          </span>

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos de la Madre</h3>

              <div class="form-group col-md-6">
                <label for="nombreMadre" class="form-label" style="font-weight: bold">Nombre: </label>
                <input type="text" class="form-control" id="nombreMadre" name="nombreMadre" readonly>
              </div>

              <div class="col-md-6">
                <label for="apellidoMadre" class="form-label" style="font-weight: bold">Apellido:</label>
                <input type="text" class="form-control" id="apellidoMadre" name="apellidoMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="dniMadre" class="form-label" style="font-weight: bold">DNI:</label>
                <input type="text" class="form-control" id="dniMadre" name="dniMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="nacimientoMadre" class="form-label" style="font-weight: bold">Fecha Nacimiento:</label>
                <input type="date" class="form-control" id="nacimientoMadre" name="nacimientoMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="conviveMadre" class="form-label" style="font-weight: bold">Convive con el Postulante:</label>
                <input type="text" class="form-control" id="conviveMadre" name="conviveMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="gradoMadre" class="form-label" style="font-weight: bold">Grado de Instrucción:</label>
                <input type="text" class="form-control" id="gradoMadre" name="gradoMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="profesionMadre" class="form-label" style="font-weight: bold">Profesión:</label>
                <input type="text" class="form-control" id="profesionMadre" name="profesionMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="correoMadre" class="form-label" style="font-weight: bold">Correo Electrónico:</label>
                <input type="text" class="form-control" id="correoMadre" name="correoMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="numeroMadre" class="form-label" style="font-weight: bold">Número Celular:</label>
                <input type="text" class="form-control" id="numeroMadre" name="numeroMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="dependenciaMadre" class="form-label" style="font-weight: bold">Independiente/Dependiente:</label>
                <input type="text" class="form-control" id="dependenciaMadre" name="dependenciaMadre" readonly>
              </div>

              <div class="col-md-6">
                <label for="centroMadre" class="form-label" style="font-weight: bold">Centro Laboral</label>
                <input type="text" class="form-control" id="centroMadre" name="centroMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="tlfTrabajoMadre" class="form-label" style="font-weight: bold">Teléfono Madre</label>
                <input type="text" class="form-control" id="tlfTrabajoMadre" name="tlfTrabajoMadre" readonly>
              </div>

              <div class="col-md-3">
                <label for="ingresoMadre" class="form-label" style="font-weight: bold">Ingreso Mensual </label>
                <input type="text" class="form-control" id="ingresoMadre" name="ingresoMadre" readonly>
              </div>
            </div>
          </span>
          <div class="container row g-3 p-3 justify-content-between">
            <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarBusqueda">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>