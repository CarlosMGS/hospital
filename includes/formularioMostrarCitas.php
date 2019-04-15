<?php

require_once('form.php');
require_once('usuario.php');
require_once('medico.php');
require_once('formularioSeleccionaMedico.php');


class formularioMostrarCitas extends Form{

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
		
		$html = '<div class="grupo-control">';                            
        $html .= '<label>Introduzca una fecha (Formato YYYY-MM-DD):</label> <input type="text" name="fecha" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control"><button type="submit" name="citas">Mostrar Citas</button></div>';
		
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $fecha = isset($datos['fecha']) ? $datos['fecha'] : null;
		if ( empty($fecha) ) {
            $erroresFormulario[] = "Debe introducir una fecha";
        }
		if (count($erroresFormulario) === 0) {
			$_SESSION['fecha'] = $fecha;
			return "viewCitas.php";
		}
		
        return $erroresFormulario;
    }

}