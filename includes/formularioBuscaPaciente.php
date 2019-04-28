<?php

require_once('form.php');
require_once('paciente.php');

class formularioBuscaPaciente extends Form{

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

        $html .= '<div class="grupo-control"><button type="submit" name="registro">Buscar historial</button></div>';

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
            $paciente = Paciente::buscaUsuario($dni, $name);
            
            //var_dump($paciente);
            //exit();

            if (is_null( $paciente) ) {
                $erroresFormulario[] = "No se ha encontrado un paciente con esos datos.";
            } else {
                //$_SESSION['paciente'] = $paciente;
                echo $paciente->mostrar();
                exit();
                //$_SESSION['nombre'] = $username;
                //header('Location: index.php');

                /*Crea la carpeta correspondiente al usuario en /mysql/img/ (relacionado con
                el procesamiento del formularioSubirMeme)*/


                return "mostrarPaciente.php";
            }
        }
        return $erroresFormulario;

    }

}