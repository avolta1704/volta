<main id="main" class="main">

  <div class="pagetitle">
    <h1>Editar Pago</h1>

  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>
      <?php
      $codPago = $_GET["codPago"];
      $datosPago = ControllerPagos::ctrGetIdEditPago($codPago);
      ?>
      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2 formEditPagoAlumno">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Pago a Editar</h3>

              <div class="form-group col-md-6 mb-3">
                <label for="formatipoPagoEditEdit" class="form-label" style="font-weight: bold">Pago: </label>
                <select class="form-control" id="formatipoPagoEditEdit" name="formatipoPagoEditEdit" disabled>
                  <?php
                  $getTipoPagoEdit = new FunctionPagos();
                  $tipoPago = $getTipoPagoEdit->getTipoPagoEdit($datosPago["idTipoPago"]);
                  ?>
                  <option value="<?php echo $datosPago["idTipoPago"] ?>">
                    <?php echo $tipoPago ?>
                  </option>
                  <option value="1">Matricula</option>
                  <option value="2">Pension</option>
                </select>
              </div>

              <div class="form-group col-md-2">
                <label for="cronogramaPagoEdit" class="form-label" style="font-weight: bold">Cronograma Pago: </label>
                <input type="text" class="form-control" id="cronogramaPagoEdit" name="cronogramaPagoEdit"
                  value="<?php echo $datosPago["mesPago"] ?>" disabled>
              </div>

              <div class="row  mb-3">

                <div class="col-md-4">
                  <label for="dniAlumnoEdit" class="form-label" style="font-weight: bold">DNI: </label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="dniAlumnoEdit" name="dniAlumnoEdit"
                      value="<?php echo $datosPago["dniAlumno"] ?>" placeholder="Alumno Dni" disabled>
                    <div class="input-group-append">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <label for="apellidoAlumnoPagoEdit" class="form-label" style="font-weight: bold">Apellidos: </label>
                  <input type="text" class="form-control" id="apellidoAlumnoPagoEdit" name="apellidoAlumnoPagoEdit"
                    value="<?php echo $datosPago["apellidosAlumno"] ?>" placeholder="Apellido Alumno" disabled>
                </div>

                <div class="col-md-4">
                  <label for="nombreAlumnoPagoEdit" class="form-label" style="font-weight: bold">Nombres: </label>
                  <input type="text" class="form-control" id="nombreAlumnoPagoEdit" name="nombreAlumnoPagoEdit"
                    value="<?php echo $datosPago["nombresAlumno"] ?>" placeholder="Nombre Alumno" disabled>
                </div>
              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="codCajaPagoEdit" class="form-label" style="font-weight: bold">Codigo Caja: </label>
                  <input type="text" class="form-control" id="codCajaPagoEdit" name="codCajaPagoEdit"
                    value="<?php echo $datosPago["codAlumnoCaja"] ?>" placeholder="Codigo Caja Alumno" disabled>
                </div>

                <div class="col-md-4">
                  <label for="v" class="form-label" style="font-weight: bold">Año: </label>
                  <input type="text" class="form-control" id="anioPagoEdit" name="anioPagoEdit" value=""
                    placeholder="Año Escolar" >
                </div>

                <div class="col-md-4">
                  <label class="form-label" style="font-weight: bold">Grado Alumno: </label>

                  <div class="row">
                    <div class="form-group col-md-6 ">
                      <select class="form-control" id="nivelAlumnoPagoEdit" name="nivelAlumnoPagoEdit" disabled>
                        <?php
                        $getNivelEdit = new FunctionPagos();
                        $nivelAlum = $getNivelEdit->getNivelAlumno($datosPago["idNivel"]);
                        ?>
                        <option value="<?php echo $datosPago["idNivel"] ?>">
                          <?php echo $nivelAlum ?>
                        </option>
                        <option value="1">Inicial</option>
                        <option value="2">Primaria</option>
                        <option value="3">Secundaria</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6 ">
                      <input type="text" class="form-control" name="gradoAlumnoPagoEdit" id="gradoAlumnoPagoEdit"
                        value="<?php echo $datosPago["descripcionGrado"] ?>" placeholder="Grado Alumno" disabled>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row  mb-3">

                <div class="col-md-4">
                  <label for="fechaLimitePagoEdit" class="form-label" style="font-weight: bold">Fecha Limite Pago
                    : </label>
                  <input type="date" class="form-control" id="fechaLimitePagoEdit" name="fechaLimitePagoEdit"
                    value="<?php echo $datosPago["fechaLimite"] ?>" disabled>
                </div>

                <div class="col-md-4">
                  <label for="tipoPagoEdit" class="form-label" style="font-weight: bold">Tipo Pago: </label>
                  <input type="text" class="form-control" id="tipoPagoEdit" name="tipoPagoEdit"
                    value="<?php echo $datosPago["conceptoPago"] ?>" placeholder="Matricula / Pencion" disabled>
                </div>

                <div class="col-md-4">
                  <label for="montoPagoEdit" class="form-label" style="font-weight: bold">Monto Pago: </label>
                  <input type="text" class="form-control" id="montoPagoEdit" name="montoPagoEdit"
                    value="<?php echo $datosPago["cantidadPago"] ?>" placeholder="S/ Total Pago">
                </div>

              </div>

              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="fechaRegistroPagoEdit" class="form-label" style="font-weight: bold">Fecha Registro
                    Actualizacion:
                  </label>
                  <input type="date" class="form-control" id="fechaRegistroPagoEdit" name="fechaRegistroPagoEdit"
                    value="" required>
                </div>

                <div class="col-md-4">
                  <label for="metodoPagoEdit" class="form-label" style="font-weight: bold">Metodo Pago: </label>
                  <input type="text" class="form-control" id="metodoPagoEdit" name="metodoPagoEdit"
                    value="<?php echo $datosPago["metodoPago"] ?>" placeholder="Efectivo / Caja IEE / Caja Aqp / Otro">
                </div>

                <div class="col-md-4">
                  <label for="estadoPagoEdit" class="form-label" style="font-weight: bold">Estado: </label>
                  <select class="form-control" id="estadoPagoEdit" name="estadoPagoEdit">
                    <?php
                    $getEstadoPagoEdit = new FunctionPagos();
                    $estadoPago = $getEstadoPagoEdit->getEstadoPagoEdit($datosPago["estadoCronograma"]);
                    ?>
                    <option value="<?php echo $datosPago["estadoCronograma"] ?>">
                      <?php echo $estadoPago ?>
                    </option>
                    <!-- <option value="1">Registrado</option> -->
                    <option value="2">Cancelado</option>
                    <option value="3">Anulado</option>
                  </select>
                </div>

                
              <!-- Numero de Comprobante -->
              </div>
              <div class="row  mb-3">
                <div class="col-md-4">
                  <label for="numeroComprobanteEdit" class="form-label" style="font-weight: bold">Numero de Comprobante: </label>
                  <input type="text" class="form-control" id="numeroComprobanteEdit" name="numeroComprobanteEdit"
                    value="<?php echo $datosPago["numeroComprobante"] ?>" placeholder="Codigo Caja Alumno">
                </div>
                </div>

            </div>
          </span>
          <!-- id cronogramaPago -->
          <input type="hidden" class="form-control" id="cronogramaPagoEdit" name="cronogramaPagoEdit"
            value="<?php echo $datosPago["idCronogramaPago"] ?>">
          <!--    id pago -->
          <input type="hidden" class="form-control" id="pagoEdit" name="pagoEdit"
            value="<?php echo $datosPago["idPago"] ?>">
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
$editarPago = new ControllerPagos();
$editarPago->ctrEditarPagoAlumno();
?>