<main id="main" class="main">

  <div class="pagetitle">
    <h1>Registrar Pago</h1>
    <?php
    $existCodePostulante = isset($_GET["codPostulante"]);
    if ($existCodePostulante) {
      $codPostulante = $_GET["codPostulante"];
      $datosPostulante = ControllerPostulantes::ctrGetPostulanteById($codPostulante);
    }
    ?>
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
              <h3 style="font-weight: bold">Datos del Pago</h3>

              <div class="row mb-3">

                <?php
                if ($existCodePostulante) {
                  echo '<div class="col-md-12">
                  <label for="apellidoPostulante" class="form-label" style="font-weight: bold">Nombres y Apellidos: </label>
                  <div class="input-group-append">
                    <input type="text" class="form-control" id="apellidoPostulante" name="apellidoPostulante" value="' . $datosPostulante["nombrePostulante"] . ' ' . $datosPostulante["apellidoPostulante"] .
                    '" readonly>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="tipoPago" class="form-label" style="font-weight: bold">Tipo Pago: </label>';
                  $tipoPago = ControllerPagos::ctrGetIdTipoPago();
                  echo '<input type="hidden" class="form-control" id="tipoPago" name="tipoPago" value="' . $tipoPago["idTipoPago"] . '" readonly>
                  <input type="text" class="form-control" id="descripcionTipo" name="descripcionTipo" value="' . $tipoPago["descripcionTipo"] . '" readonly>
                  </div>
                  <div class="col-md-4">';
                  $montoMatricula = ControllerAnioEscolar::ctrGetAnioEscolarActivo();
                  echo '
                    <label for="montoPago" class="form-label" style="font-weight: bold">Monto Pago: </label>
                    <input type="text" class="form-control" id="montoPago" name="montoPago" value="' . $montoMatricula["costoMatricula"] . '" readonly>
                  </div>
                </div>
                <div class="row  mb-3">
                  <div class="col-md-4">
                    <label for="dniCajaArequipa" class="form-label" style="font-weight: bold">DNI: </label>
                    <input type="text" class="form-control" id="dniCajaArequipa" name="dniCajaArequipa" value="' . $datosPostulante["dniPostulante"] .
                    '" readonly>
                  </div>
                  <div class="col-md-4">
                    <label for="anioPago" class="form-label" style="font-weight: bold">Año: </label>
                    <input type="text" class="form-control" id="anioPago" name="anioPago" value="' . date('Y') .
                    '" readonly>
                  </div>

                  <div class="col-md-4">
                    <div class="row">
                      <div class="form-group col-md-6 ">
                        <label class="form-label" style="font-weight: bold">Nivel: </label>
                        <input type="text" class="form-control" name="nivelAlumnoPago" id="nivelAlumnoPago" value="' . $datosPostulante["descripcionNivel"] . '" readonly>
                      </div>

                      <div class="form-group col-md-6 ">
                        <label class="form-label" style="font-weight: bold">Grado: </label>
                        <input type="text" class="form-control" name="gradoAlumnoPago" id="gradoAlumnoPago"  value="' . $datosPostulante["descripcionGrado"] . '" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="fechaLimitePago" class="form-label" style="font-weight: bold">Fecha Limite Pago:</label>
                    <input type="date" class="form-control" id="fechaLimitePago" name="fechaLimitePago" value="' . date('Y-03-31') . '" readonly>
                  </div>                 
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="fechaRegistroPago" class="form-label" style="font-weight: bold">Fecha Registro Pago:</label>
                    <input type="date" class="form-control" id="fechaRegistroPago" name="fechaRegistroPago" value="' . date('Y-m-d') . '">
                  </div>

                  <div class="col-md-4">
                    <label for="metodoPago" class="form-label" style="font-weight: bold">Método Pago: </label>
                    <input type="text" class="form-control" id="metodoPago" name="metodoPago" value="Pago en caja" placeholder="Efectivo / Caja Aqp / Otro">
                  </div>

                  <div class="col-md-4">
                    <label for="nroComprobante" class="form-label" style="font-weight: bold">Nro Comprobante: </label>
                    <input type="text" class="form-control" id="nroComprobante" name="nroComprobante" value="" placeholder="Número de Comprobante">
                  </div>
                </div>';
                } else {
                  echo '<div class="col-md-12">
                  <label for="apellidoPostulante" class="form-label" style="font-weight: bold">Nombres y Apellidos: </label>
                  <div class="input-group-append">
                    <select class="form-control input-lg busquedaAlumPago" id="apellidoPostulante" name="apellidoPostulante">
                      <option value="0">Seleccione Alumno</option>';
                  $listaAlumnos = ControllerAlumnos::ctrGetAlumnosPago();
                  foreach ($listaAlumnos as $value) {
                    echo "<option value='" . $value["idAlumno"] . "'>" . $value["apellidosAlumno"] . " " . $value["nombresAlumno"] . "</option>";
                  }
                  echo '</select>
                  </div>
                </div>
                <div class="row mb-3">

                  <div class="col-md-4">
                    <label for="cronogramaPago" class="form-label" style="font-weight: bold">Cronograma Pago: </label>
                    <select class="form-control" id="cronogramaPago" name="cronogramaPago">
                      <option value="">Selecione Mes: </option>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label for="montoPago" class="form-label" style="font-weight: bold">Monto Pago: </label>
                    <input type="text" class="form-control" id="montoPago" name="montoPago" value="" placeholder="S/ Total Pago" readonly>
                  </div>
                </div>

                <div class="row  mb-3">
                  <div class="col-md-4">
                    <label for="dniCajaArequipa" class="form-label" style="font-weight: bold">DNI: </label>
                    <input type="text" class="form-control" id="dniCajaArequipa" name="dniCajaArequipa" value="" placeholder="DNI del Alumno" disabled>
                  </div>

                  <div class="col-md-4">
                    <label for="anioPago" class="form-label" style="font-weight: bold">Año: </label>
                    <input type="text" class="form-control" id="anioPago" name="anioPago" value="" disabled>
                  </div>

                  <div class="col-md-4">
                    <div class="row">
                      <div class="form-group col-md-6 ">
                        <label class="form-label" style="font-weight: bold">Nivel: </label>
                        <input type="text" class="form-control" name="nivelAlumnoPago" id="nivelAlumnoPago" disabled>
                      </div>

                      <div class="form-group col-md-6 ">
                        <label class="form-label" style="font-weight: bold">Grado: </label>
                        <input type="text" class="form-control" name="gradoAlumnoPago" id="gradoAlumnoPago" disabled>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="fechaLimitePago" class="form-label" style="font-weight: bold">Fecha Limite Pago:</label>
                    <input type="date" class="form-control" id="fechaLimitePago" name="fechaLimitePago" value="" disabled>
                  </div>

                  <div class="col-md-4">
                    <label for="tipoPago" class="form-label" style="font-weight: bold">Tipo Pago: </label>
                    <input type="text" class="form-control" id="tipoPago" name="tipoPago" value="Matrícula" readonly>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="fechaRegistroPago" class="form-label" style="font-weight: bold">Fecha Registro Pago:</label>
                    <input type="date" class="form-control" id="fechaRegistroPago" name="fechaRegistroPago" value="">
                  </div>

                  <div class="col-md-4">
                    <label for="metodoPago" class="form-label" style="font-weight: bold">Método Pago: </label>
                    <input type="text" class="form-control" id="metodoPago" name="metodoPago" value="" placeholder="Efectivo / Caja Aqp / Otro">
                  </div>

                  <div class="col-md-4">
                    <label for="nroComprobante" class="form-label" style="font-weight: bold">Nro Comprobante: </label>
                    <input type="text" class="form-control" id="nroComprobante" name="nroComprobante" value="" placeholder="Número de Comprobante">
                  </div>
                </div>';
                }
                ?>


              </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarRegistroPago">Cerrar</button>
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