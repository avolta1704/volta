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

    if (isset($_GET["ruta"])) {
      if (
        $_GET["ruta"] == "inicio" ||
        $_GET["ruta"] == "usuarios" ||
        $_GET["ruta"] == "apoderado" ||
        $_GET["ruta"] == "personal" ||
        $_GET["ruta"] == "perfil" ||
        $_GET["ruta"] == "listaAlumnos" ||
        $_GET["ruta"] == "admisionExtraordinaria" ||
        $_GET["ruta"] == "listaPostulantes" ||
        $_GET["ruta"] == "listaPagos" ||
        $_GET["ruta"] == "registrarPago" ||
        $_GET["ruta"] == "listaAdmisionAlumnos" ||
        $_GET["ruta"] == "docPostulantes" ||
        $_GET["ruta"] == "nuevoPostulante" ||
        $_GET["ruta"] == "editarPostulante" ||
        $_GET["ruta"] == "editarApoderado" ||
        $_GET["ruta"] == "editarPersonal" ||
        $_GET["ruta"] == "editarPago" ||
        $_GET["ruta"] == "editarAlumno" ||


        $_GET["ruta"] == "cerrarSesion"
      ) {
        include "modules/" . $_GET["ruta"] . ".php";
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
  <script src="assets/js/main.js"></script>
 <!--  <script src="assets/js/styleDarck.js"></script> -->

  <!-- funciones js -->
  <script src="views/js/usuarios.js"></script>
  <script src="views/js/personal.js"></script>
  <script src="views/js/alumnos.js"></script>
  <script src="views/js/nivelGrado.js"></script>
  <script src="views/js/postulantes.js"></script>
  <script src="views/js/admision.js"></script>
  <script src="views/js/apoderado.js"></script>
  <script src="views/js/admisionAlumno.js"></script>
  <!-- <script src="views/js/calendario.js"></script> -->
  <script src="views/js/pagos.js"></script>
  <script src="views/js/excelUploadJson.js"></script>
  
  <!-- datatables js -->
  <script src="views/dataTables/dt-usuarios.js"></script>
  <script src="views/dataTables/dt-personal.js"></script>
  <script src="views/dataTables/dt-postulantes-admin.js"></script>
  <script src="views/dataTables/dt-alumnos-admin.js"></script>
  <script src="views/dataTables/dt-apoderado.js"></script>
  <script src="views/dataTables/dt-admision-alumnos.js"></script>
  <script src="views/dataTables/dt-pagos-admin.js"></script>
</body>

</html>