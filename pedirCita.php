<?php

//Inicio del procesamiento
require_once("includes/usuario.php");
require_once("includes/config.php");
require_once("includes/formularioRegistro.php");
require_once("includes/formularioBuscaEspecialidad.php");


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
					<h1>Seleccione una especialidad</h1>

					<?php
						$formulario = new formularioBuscaEspecialidad("registro", array('action' => 'pedirCita.php'));
						$formulario->gestiona();
					?>
				</div>


			</div>

		<?php
			require("includes/comun/pie.php");
		?>

	</div>

</body>
</html>