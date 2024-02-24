<main id="main" class="main">

  <div class="pagetitle">
    <h1>Usuarios</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
        <li class="breadcrumb-item"><a href="usuarios">Usuarios</a></li>
        <li class="breadcrumb-item active">Todos los Usuarios</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-2">
        <div class="row mb-2">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuario">Agregar Usuario</button>
        </div>
      </div>
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Todas las Empresas</h5>

              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Tipo Usuario</th>
                    <th scope="col">Ultima Conexión</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $listaUsuarios = ControllerUsuarios::ctrGetAllUsuarios();
                  foreach ($listaUsuarios as $key => $value) {
                    echo '
                    <tr>
                      <th scope="row">' . ($key + 1) . '</th>
                      <td>' . ($value["correoUsuario"]) . '</td>
                      <td>' . ($value["nombreUsuario"]) . '</td>
                      <td>' . ($value["apellidoUsuario"]) . '</td>
                      <td>' . ControllerFunciones::getEstadoUsuarios($value["estadoUsuario"]) . '</td>
                      <td>' . ($value["descripcionTipoUsuario"]) . '</td>
                      <td>' . ($value["ultimaConexion"]) . '</td>
                      <td>
                        <button type="button" class="btn btn-warning btnEditarUsuario" data-bs-toggle="modal" data-bs-target="#editarUsuario" codUsuario="' . ($value["idUsuario"]) . '"><i class="bi bi-pencil"></i></button>
                        <button type="button" class="btn btn-primary btnActualizarUsuario" codUsuario="' . ($value["idUsuario"]) . '"><i class="bi bi-person-fill-check"></i></button>
                      </td>
                    </tr>
                    ';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="agregarUsuario" tabindex="-1" role="dialog" aria-labelledby="agregarUsuario" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Correo Electrónico -->
          <div class="form-group">
            <label for="usuarioCorreo" class="col-form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="usuarioCorreo" name="usuarioCorreo" required>
          </div>

          <!-- Nombre -->
          <div class="form-group">
            <label for="nombreUsuario" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
          </div>

          <!-- Apellido -->
          <div class="form-group">
            <label for="apellidoUsuario" class="col-form-label">Apellido:</label>
            <input type="text" class="form-control" id="apellidoUsuario" name="apellidoUsuario" required>
          </div>

          <!-- DNI -->
          <div class="form-group">
            <label for="dniUsuario" class="col-form-label">DNI:</label>
            <input type="text" class="form-control" id="dniUsuario" name="dniUsuario" required>
          </div>

          <!-- Contraseña -->
          <div class="form-group">
            <label for="passwordUsuario" class="col-form-label">Contraseña:</label>
            <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" required>
          </div>

          <!-- Perfil -->
          <div class="form-group">
            <label for="tipoUsuario" class="col-form-label">Perfil:</label>
            <select class="form-control" name="tipoUsuario">
              <?php
              $tipoUsuarios = ControllerUsuarios::ctrGetTipoUsuarios();
              foreach ($tipoUsuarios as $key => $value) {
                echo '<option value="' . $value["idTipoUsuario"] . '">' . $value["descripcionTipoUsuario"] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
          </div>
          <?php
          $crearUsuario = new ControllerUsuarios();
          $crearUsuario->ctrCrearUsuarioPersonal();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal editar usuario -->
<div class="modal fade" id="editarUsuario" tabindex="-1" role="dialog" aria-labelledby="editarUsuario" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <div class="modal-body">
            <!-- Correo Electrónico -->
            <div class="form-group">
              <label for="correoEditar" class="col-form-label">Correo Electrónico:</label>
              <input type="email" class="form-control" id="correoEditar" name="correoEditar" required>
            </div>

            <!-- Nombre -->
            <div class="form-group">
              <label for="nombreEditar" class="col-form-label">Nombre:</label>
              <input type="text" class="form-control" id="nombreEditar" name="nombreEditar" required>
            </div>

            <!-- Apellido -->
            <div class="form-group">
              <label for="apellidoEditar" class="col-form-label">Apellido:</label>
              <input type="text" class="form-control" id="apellidoEditar" name="apellidoEditar" required>
            </div>

            <!-- DNI -->
            <div class="form-group">
              <label for="dniEditar" class="col-form-label">DNI:</label>
              <input type="text" class="form-control" id="dniEditar" name="dniEditar" required>
            </div>

            <!-- Perfil -->
            <div class="form-group">
              <label for="tipoEditar" class="col-form-label">Perfil:</label>
              <select class="form-control" name="tipoEditar" id="tipoEditar">
                <?php
                $tipoUsuarios = ControllerUsuarios::ctrGetTipoUsuarios();
                foreach ($tipoUsuarios as $key => $value) {
                  echo '<option value="' . $value["idTipoUsuario"] . '">' . $value["descripcionTipoUsuario"] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="codUsuario" name="codUsuario" class="codUsuario">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar Usuario</button>
          </div>
          <?php
          $editarUsuario = new ControllerUsuarios();
          $editarUsuario->ctrEditarUsuarioPersonal();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>