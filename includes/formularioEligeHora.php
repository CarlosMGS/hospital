<?php

require_once('form.php');
require_once('usuario.php');
require_once('medico.php');
require_once('formularioSeleccionaMedico.php');


class formularioEligeHora extends Form{

    public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }


    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales){
		
		$horas=Usuario::citasPorMedico($_SESSION['id_medico'], $_SESSION['fecha']);
		
		$html = "<h3>Horas disponibles</h3>";
        $html .= "<select name='hora'>";
		$date = DateTime::createFromFormat('!H:i', '9:00');
		$i = 0;
		while($i < 17){
			if(!$horas[$date->format('H:i:s')]){
				$html .= "<option value='". $date->format('H:i:s'). "'>". $date->format('H:i') ."</option>";
			}
			$date->modify("+30 minutes");
			$i = $i+1;
		}
		$html .= "</select>";
		$html .= '<div class="grupo-control"><button type="submit" name="buscar">Confirmar cita</button></div>';
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $hora = isset($datos['hora']) ? $datos['hora'] : null;
		
		$_SESSION['hora']=$hora;
		$fecha = $_SESSION['fecha'];
		$id_medico = $_SESSION['id_medico'];
		$id_usuario = $_SESSION['usuario']->id();
		
		Usuario::concertarCita($id_usuario, $id_medico, $fecha, $hora);
		
        return "exito.php";
    }

}