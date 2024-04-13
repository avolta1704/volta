<main id="main" class="main">

  <div class="pagetitle">
    <h1>Editar Postulante</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item active">Editar Apoderado</li>
      </ol>
    </nav>
    <?php
    $codApoderado = $_GET["codApoderadoEditar"];
    $datosApoderado = ControllerApoderados::ctrGetIdEditApoderado($codApoderado);
    ?>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
        </div>
      </div>

      <div class="container-fluid">
        <form role="form" method="post" class="row g-3 m-2 formeditarApoderado">

          <span class="border border-3 p-3">
            <div class="container row g-3">
              <h3 style="font-weight: bold">Datos del Apoderado</h3>

              <div class="form-group col-md-6">
                <label for="editarNombreAp" class="form-label" style="font-weight: bold">Nombres: </label>
                <input type="text" class="form-control" id="editarNombreAp" name="editarNombreAp"
                  value="<?php echo $datosApoderado["nombreApoderado"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarApellidoAp" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="editarApellidoAp" name="editarApellidoAp"
                  value="<?php echo $datosApoderado["apellidoApoderado"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarNumAp" class="form-label" style="font-weight: bold">Numero: </label>
                <input type="text" class="form-control" id="editarNumAp" name="editarNumAp"
                  value="<?php echo $datosApoderado["celularApoderado"] ?>">
              </div>

              <div class="form-group col-md-6">
                <label for="editarCorreoAp" class="form-label" style="font-weight: bold">Correo: </label>
                <input type="text" class="form-control" id="editarCorreoAp" name="editarCorreoAp"
                  value="<?php echo $datosApoderado["correoApoderado"] ?>" disabled>
              </div>

              <div class="form-group col-md-6">
                <label for="editarHijosAp" class="form-label" style="font-weight: bold">Hijos Matriculados:</label>
                <input type="number" class="form-control" id="editarHijosAp" name="editarHijosAp"
                  value="<?php echo $datosApoderado["listaAlumnos"] ?>" placeholder="0">
              </div>

              <div class="form-group col-md-6 ">
                <label for="editarComvivAp" class="col-form-label">Comvivencia con el/l@s Alumn@s:</label>
                <select class="form-control" name="editarComvivAp" id="editarComvivAp" required>
                  <option value="<?php echo $datosApoderado["convivenciaAlumno"] ?>">Selecione</option>
                  <option value="Si">Si</option>
                  <option value="No">No</option>
                </select>
              </div>

              <div class="form-group col-md-6 ">
                <label for="editarTipoApo" class="col-form-label">Tipo Apoderado:</label>
                <select class="form-control" name="editarTipoApo" id="editarTipoApo" required>
                  <option value="<?php echo $datosApoderado["tipoApoderado"] ?>">Apoderado</option>
                  <option value="2">Madre</option>
                  <option value="3">Padre</option>
                </select>
              </div>

            </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <input type="hidden" class="codApoderado" name="codApoderado" id="codApoderado"
              value="<?php echo $codApoderado ?>">
            <button type="button"
              class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarEditarApoderado">Cerrar</button>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Editar Apoderado</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
$editarApoderado = new ControllerApoderados();
$editarApoderado->ctrIdEditarApoderado();
?>