<?php
//requiere llamar session_start(); antes de usarse
/**
* @codeCoverageIgnore
*/
function manejarUsuarioNoLogeado(){
    if(isset( $_SESSION["logeo"])){
        if($_SESSION["logeo"] !== 1){
            header('Location: ../Compartido/AccesoDenegado.html');
        }
    }
    else {
        header('Location: ../Compartido/AccesoDenegado.html');
    }
}
?>