<div class="cabecera">

	<div id="logo">
		<?php 
			if(isset($_SESSION["login"]) && ($_SESSION["login"]===true)){
				if(isset($_SESSION["rol"]) && ($_SESSION["rol"]==="medico")){
					echo "<a href='medicoView.php' id='logo'>Clinica Ygeia</a>";
				}else if(isset($_SESSION["rol"])&&($_SESSION["rol"]==="usuario")){
					echo "<a href='usuarioView.php' id='logo'>Clinica Ygeia</a>";
				}else{
					echo "<a href='index.php' id='logo'>Clinica Ygeia</a>";
				}
			}else{
				echo "<a href='index.php' id='logo'>Clinica Ygeia</a>";
			}
		?>
		
	</div>
	<div id="link">
		<?php
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
				echo "Bienvenido " . $_SESSION['nombre']  .
				"<a href='perfil.php' class='perfil'>Perfil</a>
				<a href='logout.php' class='salir'>Salir</a>";		
			} else {
				echo "<a href='login.php' class='login'>Iniciar sesión</a> 
				<a href='registro.php' class='registro'>Registrarse</a>";
			}
		?>
	</div>
</div>
