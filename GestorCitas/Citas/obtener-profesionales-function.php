<?php
  include_once 'cita-class.php';
  include_once 'profesional-class.php';
  include_once 'paciente-class.php';

  function controladorObtenerProfesionales(){
    $profesional = new Profesional();
    /*Revisa que no se inyecte código*/
    $profesionales = $profesional->obtenerProfesionales();
    if($profesionales !== false){
      foreach ( $profesionales as $profesional ) {
        $profesionalesString[] = array(
          'id' => $profesional['id'],
          'nombre' =>  $profesional['nombre']
        );
      }
      if(isset($profesionalesString)){
        $profesionales = json_encode($profesionalesString);
      }else{
        $profesionales = "SinProfesionales";
      }
    }else{
      $profesionales = json_encode($profesionales);
    }
    echo $profesionales;
  }
  controladorObtenerProfesionales();
?>