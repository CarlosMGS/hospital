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
		
		$i = sizeof($espec);
        $html = "<select name='especialidad'>";
		$i = $i - 1;
		while($i >= 0){
			$html .= "<option value='". $espec[$i]. "'>". $espec[$i] ."</option>";
			$i = $i-1;
		}
		$html .= "</select>";
		$html .= '<div class="grupo-control"><button type="submit" name="buscar">Buscar</button></div>';
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $espec = isset($datos['especialidad']) ? $datos['especialidad'] : null;
		
		

        

        return $erroresFormulario;
    }

}