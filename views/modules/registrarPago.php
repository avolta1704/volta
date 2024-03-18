<main id="main" class="main">

  <div class="pagetitle">
    <h1>Registrar Pago</h1>

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
              <h3 style="font-weight: bold">Datos del Pago a Registrar</h3>

              <div class="form-group col-md-6 mb-3">
                <label for="formaPago" class="form-label" style="font-weight: bold">Forma de Pago: </label>
                <select class="form-control" id="formaPago" name="formaPago" required>
                  <option value="">Elige una opción</option>
                  <option value="1">Opción 1</option>
                  <option value="2">Opción 2</option>
                  <option value="3">Opción 3</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label for="distrito" class="form-label" style="font-weight: bold">Cronograma Pago: </label>
                <input type="text" class="form-control" id="distrito" name="distrito" value="" required>
              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="dniAlumno" class="form-label" style="font-weight: bold">DNI: </label>
                  <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="apellidosAlumno" class="form-label" style="font-weight: bold">Apellidos: </label>
                  <input type="text" class="form-control" id="apellidosAlumno" name="apellidosAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="nombresAlumno" class="form-label" style="font-weight: bold">Nombres: </label>
                  <input type="text" class="form-control" id="nombresAlumno" name="nombresAlumno" value="" required>
                </div>
              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="dniAlumno" class="form-label" style="font-weight: bold">Codigo Caja: </label>
                  <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="apellidosAlumno" class="form-label" style="font-weight: bold">Año: </label>
                  <input type="text" class="form-control" id="apellidosAlumno" name="apellidosAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="nombresAlumno" class="form-label" style="font-weight: bold">Grado: </label>

                  <div class="row">
                    <div class="form-group col-md-6 nivelAdmision">
                      <select class="form-control" name="nivelAlumno" id="nivelAlumno" required>
                        <option value="">Eliga una opción</option>
                        <option value="1">Inicial</option>
                        <option value="2">Primaria</option>
                        <option value="3">Secundaria</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6 gradoAdmision">
                      <select class="form-control" name="gradoAlumno" id="gradoAlumno" required>
                        <option value="">Eliga una opción</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="dniAlumno" class="form-label" style="font-weight: bold">Fecha de Pago: </label>
                  <input type="date" class="form-control" id="dniAlumno" name="dniAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="apellidosAlumno" class="form-label" style="font-weight: bold">Fecha de Pago Limite: </label>
                  <input type="date" class="form-control" id="apellidosAlumno" name="apellidosAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="nombresAlumno" class="form-label" style="font-weight: bold">Tipo Pago: </label>
                  <input type="text" class="form-control" id="nombresAlumno" name="nombresAlumno" value="" required>
                </div>
              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="dniAlumno" class="form-label" style="font-weight: bold">Fecha de Registro: </label>
                  <input type="date" class="form-control" id="dniAlumno" name="dniAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="apellidosAlumno" class="form-label" style="font-weight: bold">Metodo Pago: </label>
                  <input type="text" class="form-control" id="apellidosAlumno" name="apellidosAlumno" value="" required>
                </div>

                <div class="col-md-4">
                  <label for="nombresAlumno" class="form-label" style="font-weight: bold">Monto Pago: </label>
                  <input type="text" class="form-control" id="nombresAlumno" name="nombresAlumno" value="" required>
                </div>
              </div>

            </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <button type="button"
              class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarRegistroPago">Cerrar</button>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Registrar Pago</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
$crearAlumnoExtraordinario = new ControllerAdmisionAlumno();
$crearAlumnoExtraordinario->ctrCrearAlumnoExtraordinaria();
?>
