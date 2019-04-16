<?php

require_once('form.php');
require_once('usuario.php');
require_once('medico.php');


class formularioSeleccionaMedico extends Form{

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
		
		$medicos=Usuario::medicosPorEspecialidad($_SESSION['especialidad']);
		
		$i = sizeof($medicos);
		

        $html = "<select name='medico'>";
		$i = $i - 1;
		while($i >= 0){
			$html .= "<option value='". $medicos[$i][0]. "'>". $medicos[$i][1] ."</option>";
			$i = $i-1;
		}
		$html .= "</select>";
		
		$html .= '<div class="grupo-control">';                            
        $html .= '<label>Introduzca una fecha (Formato YYYY-MM-DD):</label> <input type="text" name="fecha" />';
        $html .= '</div>';
		
		$html .= '<div class="grupo-control"><button type="submit" name="buscar">Buscar</button></div>';
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $medico = isset($datos['medico']) ? $datos['medico'] : null;
		
		$fecha = isset($datos['fecha']) ? $datos['fecha'] : null;
		if ( empty($fecha) ) {
            $erroresFormulario[] = "La fecha no puede estar vacía.";
        }
		
		if (count($erroresFormulario) === 0) {
			$_SESSION['id_medico']=$medico;
			$_SESSION['fecha']=$fecha;
			return "solicitarCita.php";
		}

        

        return $erroresFormulario;
    }

}