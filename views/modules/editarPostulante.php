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
      $codPostulante = $_GET["codPostulanteEditar"];
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
                <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="<?php echo $datosPostulante["nombrePostulante"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarApellido" class="form-label" style="font-weight: bold">Apellidos: </label>
                <input type="text" class="form-control" id="editarApellido" name="editarApellido" value="<?php echo $datosPostulante["apellidoPostulante"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarDNI" class="form-label" style="font-weight: bold">DNI: </label>
                <input type="text" class="form-control" id="editarDNI" name="editarDNI" value="<?php echo $datosPostulante["dniPostulante"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaPostulacion" class="form-label" style="font-weight: bold">Fecha Postulación: </label>
                <input type="date" class="form-control" id="editarFechaPostulacion" name="editarFechaPostulacion" value="<?php echo $datosPostulante["fechaPostulacion"] ?>" required>
              </div>

              <div class="form-group col-md-6">
                <label for="editarFechaNacimiento" class="form-label" style="font-weight: bold">Fecha Nacimiento: </label>
                <input type="date" class="form-control" id="editarFechaNacimiento" name="editarFechaNacimiento" value="<?php echo $datosPostulante["fechaNacimiento"] ?>" required>
              </div>

              <div class="form-group col-md-6 nivelAdmision">
                <label for="editarNivel" class="col-form-label">Nivel:</label>
                <select class="form-control" name="editarNivel" id="editarNivel" required>
                  <option value="<?php echo $datosPostulante["idNivel"] ?>"><?php echo $datosPostulante["descripcionNivel"] ?></option>
                  <option value="1">Inicial</option>
                  <option value="2">Primaria</option>
                  <option value="3">Secundaria</option>
                </select>
              </div>
              
              <div class="form-group col-md-6 gradoAdmision">
                <label for="editarGrado" class="col-form-label">Grado:</label>
                <select class="form-control" name="editarGrado" id="editarGrado" required>
                  <option value="<?php echo $datosPostulante["idGrado"] ?>"><?php echo $datosPostulante["descripcionGrado"] ?></option>
                </select>
              </div>
            </div>
          </span>

          <div class="container row g-3 p-3 justify-content-between">
            <input type="hidden" class="codPostulante" name="codPostulante" id="codPostulante" value="<?php echo $codPostulante ?>">
            <button type="button" class="col-1 d-inline-flex-center p-2 btn btn-secondary cerrarCrearPostulante">Cerrar</button>
            <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-primary ">Editar Postulante</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<?php
$editarPostulante = new ControllerPostulantes();
$editarPostulante->ctrEditarPostulante();
?>
