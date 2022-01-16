<?php
  include_once '../Citas/cita-class.php';
  include_once 'ValidadorDatosPaciente.php';

  /**
   * @codeCoverageIgnore
   */
  function llamarControladorRegistrarPaciente() {
    try {
      session_start();
    }
    catch(Exception $e){}
    ControladorRegistrarPaciente();
    header('Location: InterfazRegistrarPaciente.php');
  }

  function ControladorRegistrarPaciente() {
      $validador = new ValidadorDatosPaciente();
      $cedula = filter_var($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT);
      $nombre = filter_var($_POST["nombre"], FILTER_SANITIZE_STRING);
      $apellido = filter_var($_POST["apellido"], FILTER_SANITIZE_STRING);
      $telefono = filter_var($_POST["telefono"], FILTER_SANITIZE_NUMBER_INT);    

      if(!$validador->cedulaEsValida($cedula)) {
        $_SESSION['mensajePaciente'] = 'La cédula ingresada no es válida.';
        $_SESSION['mensajePacienteTipo'] = 'error';
      } else if (!$validador->nombreEsValido($nombre)) {
        $_SESSION['mensajePaciente'] = 'El nombre ingresado no es válido';
        $_SESSION['mensajePacienteTipo'] = 'error';
      } else if (!$validador->apellidoEsValido($apellido)) {
        $_SESSION['mensajePaciente'] = 'El apellido ingresado no es válido';
        $_SESSION['mensajePacienteTipo'] = 'error';
      } else if(!$validador->telefonoEsValido($telefono) && $telefono != null) {
        $_SESSION['mensajePaciente'] = 'El telefono ingresado no es válido';
        $_SESSION['mensajePacienteTipo'] = 'error';
      } else {
        $cita = new Cita();
        if(!$cita->pacienteExiste($cedula)) {
          $cita->crearPaciente($cedula, $nombre, $apellido, $telefono);
          $_SESSION['mensajePaciente'] = '¡El Paciente fue registrado exitosamente!';
          $_SESSION['mensajePacienteTipo'] = 'exito';
        } else{
          $_SESSION['mensajePaciente'] = 'El paciente ya está registrado.';
          $_SESSION['mensajePacienteTipo'] = 'error';
        }
      }

      $_POST["cedula"] = null;
      $_POST["nombre"] = null;
      $_POST["apellido"] = null;
      $_POST["telefono"] = null;
  }
  llamarControladorRegistrarPaciente();
?>