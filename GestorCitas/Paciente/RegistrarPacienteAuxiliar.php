<?php
    function desplegarMensaje() {
        if(isset( $_SESSION["mensajePaciente"]) && isset( $_SESSION["mensajePacienteTipo"]) ) {
            if($_SESSION["mensajePacienteTipo"] == 'error') {
                echo '<script language="javascript">
                document.getElementById("mensaje").innerHTML="'.$_SESSION["mensajePaciente"].'";
                document.getElementById("mensaje").classList.add("error");
                document.getElementById("mensaje").style.visibility="visible";
                </script>';
            }  
            else {
                echo '<script language="javascript">
                document.getElementById("mensaje").innerHTML="'.$_SESSION["mensajePaciente"].'";
                document.getElementById("mensaje").style.visibility="visible";
                </script>';
            }
            $_SESSION["mensajePaciente"] = null;
            $_SESSION["mensajePacienteTipo"] = null;
        }
    }
    desplegarMensaje();
?>