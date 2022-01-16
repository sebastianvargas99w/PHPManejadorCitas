<?php 
include_once '../login/connect.php';

session_start();

$connect = new Connect();
$conn = $connect->connectar();
if(isset($_SESSION["mensaje"])) {
    echo '<script language="javascript">
    console.log('.$_SESSION["mensaje"].');
    </script>';
}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>Gestor de citas Softville</title>
		<?php
				include_once '../Compartido/navbar.php';
                if (empty($_SESSION['token'])) {
                    $_SESSION['token'] = bin2hex(random_bytes(32));
                }
                $token = $_SESSION['token'];
			?>
			<link rel="stylesheet" href="../Compartido/colores.css"/>
			<link rel="stylesheet" href="registrar-citas.css"/>
	</head>
	<body>
		<header>
            <h1 id="titulo">Registrar citas</h1>	
		</header>
		<main>
            <h2 id="mensaje" > </h2>  
			<form id="formulario-cita" name="formulario-cita" method="post" action="cita-function.php">
            
                <fieldset class="input-registrar-cita">
                    <label>Cédula</label>
                    <input type="text" id="cedula" name="cedula" placeholder=" " required/>
                </fieldset>
                
                <fieldset class="input-registrar-cita">
                    <label>Profesional encargado</label>
                    <select required id="idProfesional" name="idProfesional">
                        <option value = 0>Seleccione uno</option>
                    <?php 
                    // @codeCoverageIgnoreStart
                    $sqli ="Select * from profesional";
                    $resultado=mysqli_query($conn,$sqli);
                    while($row =mysqli_fetch_array($resultado)){
                        echo '<option value='.$row['id'].' >'.$row['nombre'].'</option>';
                    }
                    // @codeCoverageIgnoreEnd
                    ?>
                    </select>
                </fieldset>

                <fieldset class="input-registrar-cita">
                    <label>Fecha de la cita </label>
                    <input type="date" id="fecha_cita" name="fecha_cita" required>
                </fieldset>

                <fieldset class="input-registrar-cita">
                    <label>Hora de la cita </label>
                    <input type="time" id="hora_cita" name="hora_cita" min="08:00" max="18:00" required>
                </fieldset>

                <input type="hidden" name="anti-csrf-token" value="<?php echo $token; ?>" />

                <div id="button-box">
                    <button type="submit" id="registrar">Registrar</button>
                </div>
            </form>
			
		</main>
	</body>
</html>

<?php 
    // @codeCoverageIgnoreStart
    if(isset( $_SESSION["mensaje"])){
    if($_SESSION["mensaje"]== 1){
      $_SESSION["mensaje"] = 0;
      echo '<script language="javascript">
      document.getElementById("mensaje").innerHTML="Se registró la cita exitosamente";
      document.getElementById("mensaje").style.visibility="visible";
      </script>';
    }
    if($_SESSION["mensaje"]== 2){
      $_SESSION["mensaje"] = 0;
      echo '<script language="javascript">
      document.getElementById("mensaje").innerHTML="Error: Paciente no existe";
      document.getElementById("mensaje").classList.add("error");
      document.getElementById("mensaje").style.visibility="visible";
      </script>';
    }
    if($_SESSION["mensaje"]== 3){
      $_SESSION["mensaje"] = 0;
      echo '<script language="javascript">
      document.getElementById("mensaje").innerHTML="Error: Profesional no existe";
      document.getElementById("mensaje").classList.add("error");
      document.getElementById("mensaje").style.visibility="visible";
      </script>';
    }
    if($_SESSION["mensaje"]== 4){
        $_SESSION["mensaje"] = 0;
        echo '<script language="javascript">
        document.getElementById("mensaje").innerHTML="Error: No se puede registrar una cita en una fecha del pasado";
        document.getElementById("mensaje").classList.add("error");
        document.getElementById("mensaje").style.visibility="visible";
        </script>';
    }
    if($_SESSION["mensaje"]== 5){
        $_SESSION["mensaje"] = 0;
        echo '<script language="javascript">
        document.getElementById("mensaje").innerHTML="Error: La fecha y hora escogidas ya estan reservadas";
        document.getElementById("mensaje").classList.add("error");
        document.getElementById("mensaje").style.visibility="visible";
        </script>';
    }

	}else{
		$_SESSION["mensaje"] = 0;
	} 
    // @codeCoverageIgnoreEnd
    ?>
