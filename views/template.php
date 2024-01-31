<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php require "modules/header.php" ?>
</head>

<body>

  <?php
  if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") {
    require "modules/navbar.php";
    require "modules/menu.php";

    if (isset($_GET["route"])) {
      if (
        $_GET["route"] == "inicio" ||
        $_GET["route"] == "usuarios" ||
        $_GET["route"] == "listaAlumnos" ||
        $_GET["route"] == "nuevoAlumno" ||
        $_GET["route"] == "cerrarSesion
        "
      ) {
        include "modules/" . $_GET["route"] . ".php";
      } else {
        include "web/404.html";
      }
    } else {
      include "modules/inicio.php";
    }
    echo '<footer>';
    include "modules/footer.php";
    echo '</footer>';
    echo '</div>';
    echo '</div>';
  } else {
    include "modules/login.php";
  }

  ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <!-- Template Main JS File -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="assets/js/main.js"></script>

  <script src="views/js/usuarios.js"></script>
  <script src="views/js/alumnos.js"></script>

</body>

</html>