<!-- ======= Sidebar ======= -->
<?php
  //  Obtener el tipo de usuario para gestionar el menú
  $tipoUsuario = $_SESSION["tipoUsuario"];

  /**
   * 1 = Administrador
   * 2 = Docente
   * 3 = Administrativo
   * 4 = Apoderado
   * 5 = Directivo
   */
   
  if($tipoUsuario == 1){
    include "menu/menu-administrador.php";   
  }
  if($tipoUsuario == 2){
    include "menu/menu-docente.php";
  }
  if($tipoUsuario == 3){
    include "menu/menu-administrativo.php";
  }
  if($tipoUsuario == 4){
    include "menu/menu-apoderado.php";
  }
  if($tipoUsuario == 5){
    include "menu/menu-direccion.php";
  }
?>
