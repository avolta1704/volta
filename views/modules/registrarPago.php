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
        <form role="form" method="post" class="row g-3 m-2 formPagoAlumno">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Pago a Registrar</h3>

              <div class="form-group col-md-6 mb-3">
                <label for="formaTipoPago" class="form-label" style="font-weight: bold">Pago: </label>
                <select class="form-control" id="formaTipoPago" name="formaTipoPago" required>
                  <option value="">Seleccione el tipo de Pago</option>
                  <?php
                  $tipoPago = ControllerPagos::ctrGetAllTipoPago();
                  foreach ($tipoPago as $key => $value) {
                    echo '<option value="' . $value["idTipoPago"] . '">' . $value["descripcionTipo"] . '</option>';
                  }
                  ?>
                </select>
              </div>

              <div class="form-group col-md-2">
                <label for="cronogramaPago" class="form-label" style="font-weight: bold">Cronograma Pago: </label>
                <select class="form-control" id="cronogramaPago" name="cronogramaPago">
                  <option value="">Selecione Mes </option>
                </select>
              </div>

              <div class="row  mb-3">

                <div class="col-md-4">
                  <label for="dniAlumno" class="form-label" style="font-weight: bold">DNI: </label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="dniAlumno" name="dniAlumno" placeholder="Buscar Alumno Dni">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary btnBuscarDniAlumno" type="button" id="buscarDniAlumno">
                        <i class="bi bi-search"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="apellidoAlumnoPago" class="form-label" style="font-weight: bold">Apellidos: </label>
                  <input type="text" class="form-control" id="apellidoAlumnoPago" name="apellidoAlumnoPago" value=""
                    placeholder="Apellido Alumno" disabled>
                </div>

                <div class="col-md-4">
                  <label for="nombreAlumnoPago" class="form-label" style="font-weight: bold">Nombres: </label>
                  <input type="text" class="form-control" id="nombreAlumnoPago" name="nombreAlumnoPago" value=""
                    placeholder="Nombre Alumno" disabled>
                </div>
              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="codCajaPago" class="form-label" style="font-weight: bold">Codigo Caja: </label>
                  <input type="text" class="form-control" id="codCajaPago" name="codCajaPago" value=""
                    placeholder="Codigo Caja Alumno">
                </div>

                <div class="col-md-4">
                  <label for="v" class="form-label" style="font-weight: bold">Año: </label>
                  <input type="text" class="form-control" id="anioPago" name="anioPago" value=""
                    placeholder="Año Escolar" disabled>
                </div>

                <div class="col-md-4">
                  <label class="form-label" style="font-weight: bold">Grado Alumno: </label>

                  <div class="row">
                    <div class="form-group col-md-6 ">
                      <input type="text" class="form-control" name="nivelAlumnoPago" id="nivelAlumnoPago"
                        placeholder="Nivel Alumno" disabled>
                    </div>

                    <div class="form-group col-md-6 ">
                      <input type="text" class="form-control" name="gradoAlumnoPago" id="gradoAlumnoPago"
                        placeholder="Grado Alumno" disabled>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row  mb-3">

                <div class="col-md-4">
                  <label for="fechaLimitePago" class="form-label" style="font-weight: bold">Fecha Limite Pago
                    : </label>
                  <input type="date" class="form-control" id="fechaLimitePago" name="fechaLimitePago" value="" disabled>
                </div>

                <div class="col-md-4">
                  <label for="tipoPago" class="form-label" style="font-weight: bold">Tipo Pago: </label>
                  <input type="text" class="form-control" id="tipoPago" name="tipoPago" value=""
                    placeholder="Matricula / Pencion" disabled>
                </div>

                <div class="col-md-4">
                  <label for="montoPago" class="form-label" style="font-weight: bold">Monto Pago: </label>
                  <input type="text" class="form-control" id="montoPago" name="montoPago" value=""
                    placeholder="S/ Total Pago" readonly>
                </div>

              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="fechaRegistroPago" class="form-label" style="font-weight: bold">Fecha Registro Pago:
                  </label>
                  <input type="date" class="form-control" id="fechaRegistroPago" name="fechaRegistroPago" value="">
                </div>

                <div class="col-md-4">
                  <label for="metodoPago" class="form-label" style="font-weight: bold">Metodo Pago: </label>
                  <input type="text" class="form-control" id="metodoPago" name="metodoPago" value=""
                    placeholder="Efectivo / Caja IEE / Caja Aqp / Otro">
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
$crearRegistroPagoAlumno = new ControllerPagos();
$crearRegistroPagoAlumno->ctrCrearRegistroPagoAlumno();
?>