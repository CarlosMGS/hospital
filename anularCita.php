<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/formularioAnularCita.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Portada</title>
</head>

<body>

	<div class="contenedor">

		<?php require("includes/comun/cabecera.php"); ?>

		<div class="principal">
			<?php require("includes/comun/sidebarIzq.php");?>

			<div id="contenido">
                <h1>Anulación de cita</h1>

                <?php
                    $formulario = new formularioAnularCita("registro", array('action' => 'anularCita.php'));
                    $formulario->gestiona();
                ?>
			</div>

		</div>

		<?php require("includes/comun/pie.php"); ?>


	</div>

</body>
</html>