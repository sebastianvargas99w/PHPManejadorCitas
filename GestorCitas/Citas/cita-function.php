<?php
    include_once 'cita-class.php';
    /** 
     * @codeCoverageIgnore
    */
    function llamarControlador() {
        session_start();
        controladorRegistrarCita();
        header('Location: registrar-citas.php');
    }

    function controladorRegistrarCita() {
        $hora = $_POST["hora_cita"];
        $fecha = $_POST["fecha_cita"]." ".$hora.":00";

        $idProfesional = filter_var($_POST["idProfesional"], FILTER_SANITIZE_NUMBER_INT);
        $cedula = filter_var($_POST["cedula"], FILTER_SANITIZE_NUMBER_INT);

        print_r($cedula);

        $_POST["fecha_cita"]= array();
        $_POST["hora_cita"]= array();
        $_POST["idProfesional"]= array();
        $_POST["cedula"]= array();

        $nuevaCita= new Cita();
        //$nuevaCita->crearCita($fecha,$idProfesional,$cedula);
        if(!$nuevaCita->pacienteExiste($cedula)){
            $_SESSION["mensaje"] = 2; //Paciente no existe
        }
        else if(!$nuevaCita->profesionalExiste($idProfesional)){
            $_SESSION["mensaje"] = 3; //Profesional no existe
        }
        else if(!$nuevaCita->verificarFechaCitaFutura($fecha)){
            $_SESSION["mensaje"] = 4; //Se esta intentando programar cita en el pasado
        }
        else if(!$nuevaCita->verificarFechaCita($fecha)){
            $_SESSION["mensaje"] = 5; //Se esta intentando programar cita en una fecha ya reservada
        }
        else{
            $_SESSION["mensaje"] = 1; //Se creo la cita exitosamente
            $nuevaCita->crearCita($fecha,$idProfesional,$cedula);
        }
    }
    llamarControlador();
?>