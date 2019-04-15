<?php
	require_once("includes/usuario.php");
	require_once("includes/medico.php");
	require_once("includes/config.php");
	

?>
<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="css/estilo.css" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Perfil | Asteyo</title>
		</head>
		<body>
			<?php

			require("includes/comun/cabecera.php");

		?>

			<div class="principal">

				<?php require("includes/comun/sidebarIzq.php"); ?>

				<div id="contenido">						
					<div id="panel-perfil">
						
	                	</div>
	                	<div id="perfil">
							<?php
								if(isset($_SESSION["rol"]) && ($_SESSION["rol"]==="usuario")){
									
									$usuario = Usuario::BuscaUsuario($_SESSION["nombre"]);
									echo "<p>Nombre: ".$usuario->name()." ".$usuario->last()."</p></br>";
									echo "<p>DNI: ".$usuario->dni()."</p></br>";
									echo "<p>Compañía: ".$usuario->company()."</p></br>";
									
								}else if (isset($_SESSION["rol"]) && ($_SESSION["rol"]==="medico")){
									
									$medico = Medico::BuscaUsuario($_SESSION["nombre"]);
									echo "<p>Nombre: ".$medico->name()."</p></br>";
									echo "<p>Especialidad: ".$medico->especialidad()."</p>";
									
								}else{
									
									echo "Error al mostrar usuario";
									
								}
								//echo "Nombre: ".$_SESSION["nombre"];

								

							?>
						</div>
				</div>

			</div>

		<?php require("includes/comun/pie.php"); ?>
		</body>
	</html>

