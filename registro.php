<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/formularioRegistro.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Registro | Ygeia</title>
</head>

<body>

	<div id="contenedor">

		<?php
			require("includes/comun/cabecera.php");
		?>

			<div class="principal">

				<?php require("includes/comun/sidebarIzq.php"); ?>

				<div id="contenido">
					<a href="registroMedico.php">
						<b>Soy médico</b>
					</a>
					
					<a href="registroPaciente.php">
						<b>Soy paciente</b>
					</a>
					
				</div>


			</div>

		<?php
			require("includes/comun/pie.php");
		?>

	</div>

</body>
</html>