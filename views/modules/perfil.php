<!-- //varaibles para la solicitud de datos -->
<?php
$idTipoUsuario = $_SESSION["tipoUsuario"];
$idUsuario = $_SESSION["idUsuario"];
// Si el tipo de usuario es 1 o 4, obtener el perfil de usuario
if ($idTipoUsuario == 1 || $idTipoUsuario == 5 || $idTipoUsuario == 4) {
  $perfilUsuario = ControllerPerfil::ctrGetAllPerfilUsuario($idUsuario);
  $perfilUsuarioDataEdit = ControllerPerfil::ctrGetAllPerfilUsuarioDataEdit($idUsuario);
} else {
  // Si el tipo de usuario es cualquier otro número, obtener el perfil del personal
  $perfilPersonal = ControllerPerfil::ctrGetAllPerfilPersonal($idUsuario);
  $perfilPersonalDataEdit = ControllerPerfil::ctrGetAllPerfilPersonalDataEdit($idUsuario);
}
?>

<?php if ($idTipoUsuario == 1 || $idTipoUsuario == 5 || $idTipoUsuario == 4) { ?>
  <!-- Si el tipo de usuario es 1 o 4, se muestra el perfil de usuario -->
  <!-- perfil Usuario -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Perfil Usuario</h1><br>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/usuario.png" alt="Profile" class="rounded-circle">
              <h2>
                <?php echo $perfilUsuario["nombreUsuario"] . " " . $perfilUsuario["apellidoUsuario"]; ?>
              </h2>
              <h3>
                <?php echo FunctionPerfil::getTipoPerfilUsuario($perfilUsuario["idTipoUsuario"]); ?>
              </h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Perfil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Cambiar
                    Contraseña</button>
                </li>

              </ul>

              <div class="tab-content pt-2">
                <!-- datos de perfil -->
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <br>
                  <h3>Datos de Usuario</h3><br>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nombre Completo</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilUsuario["nombreUsuario"] . " " . $perfilUsuario["apellidoUsuario"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">DNI</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilUsuario["dniUsuario"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Cargo</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo FunctionPerfil::getTipoPerfilUsuarioTxt($perfilUsuario["idTipoUsuario"]); ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Correo</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilUsuario["correoUsuario"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Estado</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo FunctionPerfil::getEstadoPerfil($perfilUsuario["estadoUsuario"]); ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Ultima Conexion</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilUsuario["ultimaConexion"]; ?>
                    </div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form>
                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <img src="assets/img/usuario.png" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" id="fullName" value="<?php echo $perfilUsuario["nombreUsuario"]; ?>">

                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullLastName" class="col-md-4 col-lg-3 col-form-label">Apellido</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullLastName" type="text" id="fullLastName" value="<?php echo $perfilUsuario["apellidoUsuario"]; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">DNI</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" id="company" autocomplete="off" value="<?php echo $perfilUsuario["dniUsuario"]; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Correo</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" id="Email" autocomplete="email" value="<?php echo $perfilUsuario["correoUsuario"]; ?>" disabled>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="twitter" type="text" id="Twitter" value="https://twitter.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" id="Facebook" value="https://facebook.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" id="Instagram" value="https://instagram.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="linkedin" type="text" id="Linkedin" value="https://linkedin.com/#">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <form id="formUpdatePassword">
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Contraseña Anterior</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" id="currentPassword">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva Contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" id="newPassword">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmar Contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" id="renewPassword">
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="button" class="btn btn-primary btnUpdatePassword" id="btnUpdatePassword">Cambiar Contraseña</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </main>
  <!-- End #main -->
<?php } else { ?>
  <!-- Si el tipo de usuario es cualquier otro número, se muestra el perfil personal -->
  <!-- perfil personal -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Perfil Usuario</h1><br>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="assets/img/usuario.png" alt="Profile" class="rounded-circle">
              <h2>
                <?php echo $perfilPersonal["nombrePersonal"] . " " . $perfilPersonal["apellidoPersonal"]; ?>
              </h2>
              <h3>
                <?php echo FunctionPerfil::getTipoPerfilPersonal($perfilPersonal["idTipoPersonal"]); ?>
              </h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Perfil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar Perfil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Cambiar
                    Contraseña</button>
                </li>

              </ul>

              <div class="tab-content pt-2">
                <!-- datos de perfil -->
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <br>
                  <h3>Datos de Usuario</h3><br>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nombre Completo</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilPersonal["nombrePersonal"] . " " . $perfilPersonal["apellidoPersonal"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">DNI</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilPersonal["dniUsuario"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Cargo</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo FunctionPerfil::getTipoPerfilPersonalTxt($perfilPersonal["idTipoPersonal"]); ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Fecha Ingreso</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilPersonal["fechaContratacion"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Telefono</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilPersonal["celularPersonal"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Correo</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilPersonal["correoPersonal"]; ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Estado</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo FunctionPerfil::getEstadoPerfil($perfilPersonal["estadoUsuario"]); ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Ultima Conexion</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $perfilPersonal["ultimaConexion"]; ?>
                    </div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form>
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="assets/img/usuario.png" alt="Profile">
                        <div class="pt-2">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nombre</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" id="fullName" value="<?php echo $perfilPersonalDataEdit["nombrePersonal"]; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Apellido</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="company" type="text" id="company" value="<?php echo $perfilPersonalDataEdit["apellidoPersonal"]; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Dni</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="country" type="text" id="Country" value="<?php echo $perfilPersonalDataEdit["dniUsuario"]; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Celular</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" id="Phone" value="<?php echo $perfilPersonalDataEdit["celularPersonal"]; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Correo</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" id="Email" value="<?php echo $perfilPersonalDataEdit["correoPersonal"]; ?>" disabled>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="twitter" type="text" id="Twitter" value="https://twitter.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="facebook" type="text" id="Facebook" value="https://facebook.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="instagram" type="text" id="Instagram" value="https://instagram.com/#">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="linkedin" type="text" id="Linkedin" value="https://linkedin.com/#">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <form id="formUpdatePassword">
                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Contraseña Anterior</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" id="currentPassword">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva Contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" id="newPassword">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmar Contraseña</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" id="renewPassword">
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="button" class="btn btn-primary btnUpdatePassword" id="btnUpdatePassword">Cambiar Contraseña</button>
                    </div>
                  </form>
                </div>

              </div>

            </div>
          </div>

        </div>
      </div>
    </section>
  </main>
<?php } ?>