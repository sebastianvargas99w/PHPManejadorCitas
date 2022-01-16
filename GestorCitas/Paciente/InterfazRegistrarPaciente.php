<!DOCTYPE html>
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>Gestor de citas Softville</title>
		<?php
			include_once '../Compartido/RevisarPermisos.php';
			session_start();
			manejarUsuarioNoLogeado();
			include_once '../Compartido/navbar.php';
			if (empty($_SESSION['token'])) {
				$_SESSION['token'] = bin2hex(random_bytes(32));
			}
			$token = $_SESSION['token'];
		?>
		<link rel="stylesheet" href="../Compartido/colores.css"/>
		<link rel="stylesheet" href="../Citas/registrar-citas.css"/>
		<link rel="stylesheet" href="EstiloRegistrarPaciente.css"/>
	</head>
	<body>
		<header>
            <h1 id="titulo">Registrar pacientes</h1>	
		</header>
		<main>
            <label id="mensaje"></label>  
			<form id="formulario-cita" name="formulario-cita" method="post" action="controlador-registrar-paciente.php">
            
                <fieldset class="input-registrar-cita">
                    <label>Cédula</label>
                    <input type="text" id="cedula" name="cedula" placeholder="116540419" required/>
                </fieldset>

				<fieldset class="input-registrar-cita">
                    <label>Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del paciente" required />
                </fieldset>

				<fieldset class="input-registrar-cita">
                    <label>Apellido</label>
                    <input type="text" id="apellido" name="apellido" placeholder="Ingrese el apellido del paciente" required/>
                </fieldset>

				<fieldset class="input-registrar-cita">
                    <label>Teléfono</label>
                    <input type="number" id="telefono" name="telefono" placeholder="Ingrese el teléfono del paciente" required/>
                </fieldset>

				<input type="hidden" name="anti-csrf-token" value="<?php echo $token; ?>" />


                <div id="button-box">
                    <button type="submit" id="registrar">Registrar</button>
                </div>
            </form>
			
		</main>
	</body>
	<?php
		include_once 'RegistrarPacienteAuxiliar.php';
	?>
</html>