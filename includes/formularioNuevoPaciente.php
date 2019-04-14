<?php

require_once('form.php');
require_once('paciente.php');

class formularioNuevoPaciente extends Form{

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

        $html = '<fieldset>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Nombre completo:</label> <input class="control" type="text" name="name" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>DNI:</label> <input class="control" type="text" name="dni" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Edad:</label> <input class="control" type="text" name="edad" />';
        $html .= '</div>';
        
        $html .= '<div class="grupo-control">';
        $html .= '<label>Alergias:</label> <input class="control" type="text" name="alergias" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Operaciones:</label> <input class="control" type="text" name="operaciones" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Enfermedades:</label> <input class="control" type="text" name="enfermedades" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control"><button type="submit" name="registro">Crear historial de paciente</button></div>';

        $html .= '</fieldset>';
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $name = isset($_POST['name']) ? $_POST['name'] : null;
        if ( empty($name)) {
            $erroresFormulario[] = "Debe introducir un nombre.";
        }
 
        $dni = isset($_POST['dni']) ? $_POST['dni'] : null;
        if ( empty($dni) || mb_strlen($dni) < 9 ) {
            $erroresFormulario[] = "Debe introducir un dni válido.";
        }

        
        if (count($erroresFormulario) === 0) {
            $paciente = Paciente::creaUsuario($dni, $name);
            
            if (! $paciente ) {
                $erroresFormulario[] = "Ya existe un paciente con esos datos.";
            } else {
                $_SESSION['paciente'] = $paciente;
                //$_SESSION['nombre'] = $username;
                //header('Location: index.php');

                /*Crea la carpeta correspondiente al usuario en /mysql/img/ (relacionado con
                el procesamiento del formularioSubirMeme)*/


                return "crearConsulta.php";
            }
        }
        return $erroresFormulario;

    }

}