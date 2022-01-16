<?php
  include_once 'usuario-class.php';

  /**
   * @codeCoverageIgnore
   */
  function llamarControladorLogin() {
    session_start();

    if (!empty($_POST['anticsrf'])) {
      if (hash_equals($_SESSION['anticsrf'], $_POST['anticsrf'])) {
        controladorLogin();
      } else {
        //Token anti CRSFT fue modificado por un intermediario, se rechaza el login
        $_SESSION["logeo"] = 4;
      }
    }

    if($_SESSION["logeo"] == 1){
      header('Location: ../Citas/consultar-citas.php');
    }
    else{
      header('Location: login.php');
    }
  }

  function controladorLogin() {
    $usuario = new Usuario();
    /*Revisa que no se inyecte código*/
    $cedula = filter_var($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT);
    $clave = filter_var($_POST["contrasena"], FILTER_SANITIZE_STRING);
    echo $cedula."  ".$clave;
    $_POST["cedula"]= array();
    $_POST["contrasena"]= array();
    if($usuario->permisoIngresar($cedula,$clave)) {
      $_SESSION["logeo"] = 1;
      $usuario->resetIntentos($cedula);
    }else{
      $usuario->reducirIntento($cedula);
      $_SESSION["logeo"] = 2;

    }
    if($usuario->obtenerIntentos($cedula)=='0') {
      $_SESSION["logeo"] = 3;
    }
  }
  llamarControladorLogin();
?>