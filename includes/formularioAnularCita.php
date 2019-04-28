<?php

require_once('form.php');
require_once('usuario.php');
require_once('medico.php');
require_once('formularioSeleccionaMedico.php');


class formularioAnularCita extends Form{

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
		
		$citas=Usuario::citas($_SESSION['id']);
		
		$html = "<h3>Citas</h3>";
        $html .= "<select name='cita'>";
		
		
		foreach($citas as $entry){
			
			$html .= "<option value='". $entry[0]. ' ' .$entry[1]. "'>". $entry[2] ."</option>";

		}
		$html .= "</select>";
		$html .= '<div class="grupo-control"><button type="submit" name="buscar">Anular cita</button></div>';
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $fecha_hora = isset($datos['cita']) ? $datos['cita'] : null;
        $partes = explode(" ", $fecha_hora);
        $fecha = $partes[0];
        $hora = $partes[1];
        
        
		Usuario::borraCita($_SESSION['id'], $fecha, $hora);
		
        return "usuarioView.php";
    }

}