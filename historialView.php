<?php

//Inicio del procesamiento
require_once("includes/usuario.php");
require_once("includes/config.php");


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
				<?php
				$user=$_SESSION['usuario'];
				$id = $user->id();
				$html= $user->historial($id);
				echo $html;
				?>
			</div>

		</div>

		<?php require("includes/comun/pie.php"); ?>


	</div>

</body>
</html>