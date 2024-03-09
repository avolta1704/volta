<main id="main" class="main">

  <div class="pagetitle">
    <h1>Editar Personal</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Editar Personal</li>
      </ol>
    </nav> 
    <?php
    $codPersonal = $_GET["codPersonal"];
    $datosPersonal = ControllerPersonal::ctrGetIdEditPersonal($codPersonal);
    ?>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>

      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2 formeditarPersonal">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Personal</h3>

              <div class="form-group col-md-6">
                <label for="editarNombrePersonal" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="editarNombrePersonal" name="editarNombrePersonal"
                  value="<?php echo $datosPersonal["nombrePersonal"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarApellidoPersonal" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="editarApellidoPersonal" name="editarApellidoPersonal"
                  value="<?php echo $datosPersonal["apellidoPersonal"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarNumPersonal" class="form-label" style="font-weight: bold">Numero: </label>
                <input type="text" class="form-control" id="editarNumPersonal" name="editarNumPersonal"
                  value="<?php echo $datosPersonal["celularPersonal"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarCorreoPersonal" class="form-label" style="font-weight: bold">Correo: </label>
                <input type="text" class="form-control" id="editarCorreoPersonal" name="editarCorreoPersonal"
                  value="<?php echo $datosPersonal["correoPersonal"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechContrPersonal" class="form-label" style="font-weight: bold">Fecha Contratacion:</label>
                <input type="date" class="form-control" id="editarFechContrPersonal" name="editarFechContrPersonal"
                  value="<?php echo $datosPersonal["fechaContratacion"] ?>">
              </div>

              <div class="form-group col-md-6 ">
                <label for="editarTipoPersonal" class="col-form-label">Tipo Personal:</label>
                <select class="form-control" name="editarTipoPersonal" id="editarTipoPersonal" required>
                  <?php
                  $getTipoPersonal = new FunctionPersonal();
                  $tipoPersonal = $getTipoPersonal->getTipoPersonal($datosPersonal["idTipoPersonal"]);
                  ?>
                  <option value="<?php echo $datosPersonal["idTipoPersonal"] ?>"><?php echo $tipoPersonal ?></option>
                  <option value="1">Docente Inicial</option>
                  <option value="2">Docente Primaria</option>
                  <option value="3">Docente Secundaria</option>
                  <option value="4">Docente General</option>
                  <option value="5">Dirección</option>
                  <option value="6">Administrativo</option>

                </select>
              </div>

            </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <input type="hidden" class="codPersonal" name="codPersonal" id="codPersonal"
              value="<?php echo $codPersonal ?>">
            <button type="button"
              class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarEditarPersonal">Cerrar</button>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Editar Personal</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
$editarPersonal = new ControllerPersonal();
$editarPersonal->ctrIdEditarPersonal();
?>