<?php
  include_once 'cita-class.php';
  include_once 'profesional-class.php';
  include_once 'paciente-class.php';

  function controladorConsultarCitas(){
    $cita = new Cita();
    $paciente = new Paciente();
    $profesional = new Profesional();
    $profesionalNuevo = new Profesional();
    
    //obtiene el valor del post
    if(isset($_POST["idProfesional"])){
      $idProfesional = $_POST["idProfesional"];
    } else { // si el campo está vacío
      //se omite esta parte porque es parte de la interfaz
      // @codeCoverageIgnoreStart
      $profesionales = $profesional->obtenerProfesionales();
      $primeraVez = false;
      foreach ( $profesionales as $profesional ) {
        if($primeraVez == false){
          $idProfesional = $profesional['id'];
          $primeraVez = true;
        }
      }
      // @codeCoverageIgnoreEnd
    }
    
    $fechaInicial='';
    $fechaLimite='';
    $citas='';
    $antiCSRFToken = $_POST['anti-csrf-token'];
    if(isset($_POST['fechaInicio'])){
      $fechaInicial=$_POST['fechaInicio'];
    }

    if(isset($_POST['fechaFinal'])){
      $fechaLimite=$_POST['fechaFinal'];
    }

    if(($fechaInicial!='') &&($fechaLimite !='')){

      if($_POST['fechaInicio']>$_POST['fechaFinal']){
        
        $citas='fechaInvalida';

      }

    }

    if($citas != 'fechaInvalida'){
      if(isset($_POST['cedula'])){
        $cedula = filter_var($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT);
        $citas = $cita->buscaCitasCedula($cedula,$idProfesional,$fechaInicial,$fechaLimite);
      }
      else{
        $citas = $cita->buscaCitasCedula("",$idProfesional, $fechaInicial,$fechaLimite);
      }
      if($citas !== false){
        foreach ( $citas as $cita ) {
          $citasString[] = array(
            'fecha' => $cita['fecha'],
            'hora' =>  $cita['hora'],
            'nombreProfesional'=> $profesionalNuevo->obtenerNombre($cita['idProfesional']),
            'nombrePaciente'=> $paciente->obtenerNombre($cita['cedulaPaciente']),
            'cedulaPaciente' => $cita['cedulaPaciente'],
            'telefono'=> $paciente->obtenerTelefono($cita['cedulaPaciente']),
          );
        }
        if(isset($citasString)){
          $citas = json_encode($citasString);
        }else{
          if($citas!="fechaInvalida"){
            $citas = "SinCita";
          }
          
        }
      }else{
        $citas = json_encode($citas);
      }

    }
    echo $citas;
    return $citas;
  }
  controladorConsultarCitas();
?>