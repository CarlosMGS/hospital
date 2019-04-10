<?php

require_once('form.php');
require_once('usuario.php');

class formularioRegistro extends Form{

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
        $html .= '<label>Nombre:</label> <input class="control" type="text" name="name" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Apellidos:</label> <input class="control" type="text" name="last_name" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Email:</label> <input class="control" type="text" name="email" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>DNI:</label> <input class="control" type="text" name="dni" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Compañía:</label> <input class="control" type="text" name="company" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Teléfono:</label> <input class="control" type="text" name="tlf" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Password:</label> <input class="control" type="password" name="password" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control"><label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" /><br /></div>';

        $html .= '<div class="grupo-control">';
        $html .= '<input class="control" type="checkbox" name="accept"/><label>Acepto los términos y condiciones.</label>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<input class="control" type="checkbox" name="robot"/><label>No soy un robot.</label>';
        $html .= '</div>';

        $html .= '<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>';

        $html .= '</fieldset>';
        return $html;
    }

    protected function procesaFormulario($datos){
		echo salchicha;

        $erroresFormulario = array();

        $name = isset($_POST['name']) ? $_POST['name'] : null;
        if ( empty($name)) {
            $erroresFormulario[] = "Debe introducir un nombre.";
        }

        $last = isset($_POST['last_name']) ? $_POST['last_name'] : null;
        if ( empty($last)) {
            $erroresFormulario[] = "Debe introducir al menos un apellido.";
        }
        
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        if ( empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $erroresFormulario[] = "El email no tiene un formato valido.";
        }

        $dni = isset($_POST['dni']) ? $_POST['dni'] : null;
        if ( empty($dni) || mb_strlen($dni) < 9 ) {
            $erroresFormulario[] = "Debe introducir un dni válido.";
        }

        $company = isset($_POST['company']) ? $_POST['company'] : null;
        if ( empty($company)) {
            $erroresFormulario[] = "Debe introducir una compañía.";
        }

        $tlf = isset($_POST['tlf']) ? $_POST['tlf'] : null;
        if ( empty($tlf)) {
            $erroresFormulario[] = "Debe introducir un teléfono.";
        }

        $password = isset($_POST['password']) ? $_POST['password'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Los passwords deben coincidir";
        }

        $accept = isset($_POST['accept']) ? $_POST['accept'] : null; 
        if (empty($accept) || !$accept){
            $erroresFormulario[] = "Debes acceptar los términos y condiciones.";
        }

        $robot = isset($_POST['robot']) ? $_POST['robot'] : null;
        if (empty($robot) || !$robot){
            $erroresFormulario[] = "Debes confirmar que no eres un robot.";
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::crea($name, $last, $email, $dni, $company, $tlf, $password);
            
            if (! $usuario ) {
                $erroresFormulario[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $username;
				$_SESSION['rol'] = "usuario";
                //header('Location: index.php');

                /*Crea la carpeta correspondiente al usuario en /mysql/img/ (relacionado con
                el procesamiento del formularioSubirMeme)*/

                $carpeta = './mysql/img/'.$username;
            
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }


                return "usuarioView.php";
            }
        }
		echo "salchicha";
        return $erroresFormulario;

    }

}