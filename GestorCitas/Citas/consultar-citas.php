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
			if (empty($_SESSION['anticsrf'])) {
				$_SESSION['anticsrf'] = bin2hex(random_bytes(32));
			}
			$anticsrf = $_SESSION['anticsrf'];
		?>
			<link rel="stylesheet" href="../Compartido/colores.css"/>
			<link rel="stylesheet" href="consultar-citas.css"/>
	</head>
	<body>
		<header>
      <h1 id="titulo" style='margin-bottom:3.5%;'>Consultar citas</h1>	
	  
	    
		</header>
		<main>
			<form id="formulario-citas" name="formulario-citas" method="post" action="">
        		<fieldset id="area-cedula">
         			<label>Cédula</label>
          			<input type="number" id="cedula"  name="cedula" style="width: 6em;" placeholder="116540419"/>
            		<label>Profesional</label>
            		<select required id="idProfesional" name="idProfesional"></select>
					<br>
            		<label>Fecha de inicio </label>
            		<input type="date" id="fecha-inicio" name="fecha-inicio" >
            

			
            		<label>Fecha limite </label>
            		<input type="date" id="fecha-final" name="fecha-final" >

					<input type="hidden" name="anticsrf" value="<?php echo $anticsrf; ?>" />
            

					<button type="submit" id="buscar" >
						Filtrar <img class="icono" id="icono-buscar" src="icono-buscar.png" alt="icono buscar"></img>
					</button>
					<a id="agregar"  href="registrar-citas.php">Agregar citas <img id="icono-agregar" src="icono-agregar.png" alt="icono agregar"></a>
          
        		</fieldset>
       		</form>
			<label id="mensaje-error" class="error">
				<p class="requerido" id="error"> </p>
			</label>
			<div id="contenedor-tabla">
				<table id="tabla">
					<tr class="titulo-columna">
						<td>Nombre</td>
						<td>Cédula</td>
						<td>Teléfono</td>
						<td>Fecha</td>
						<td>Hora</td>
						<td>Profesional de la salud</td>
					</tr>
					<tbody id="citas"></tbody>
				</table>
			</div>
		</main>
		<script
			src="https://code.jquery.com/jquery-3.3.1.min.js"
			integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			crossorigin="anonymous">
		</script>
    <script src="consultar-citas.js"></script>
	</body>
</html>