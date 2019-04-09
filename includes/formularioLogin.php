<?php

require_once('form.php');
require_once('usuario.php');
require_once('medico.php');


class formularioLogin extends Form{

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
        $html .= '<label>Email:</label> <input type="text" name="email" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control">';
        $html .= '<label>Contraseña:</label> <input type="password" name="password" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control"><button type="submit" name="login">Entrar</button></div>';

        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $email = isset($datos['email']) ? $datos['email'] : null;

        if ( empty($email) ) {
            $erroresFormulario[] = "El email no puede estar vacío";
        }

        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }

        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php


            $usuario = Usuario::buscaUsuario($email);
			
            if (!$usuario) {
                $erroresFormulario[] = "El usuario o el password no coinciden";
				$medico = Medico::buscaUsuario($email)
				if(!$medico){
					$erroresFormulario[] = "El usuario o el password no coinciden";
				}else{
					if ($medico->compruebaPassword($password)) {
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $email;
                    $_SESSION['esAdmin'] = strcmp($fila['rol'], 'admin') == 0 ? true : false;
                    //header('Location: index.php');
                    return "medicoView.php";
                } else {
                    $erroresFormulario[] = "El usuario o el password no coinciden";
                }
					
				}
            }
            else{
                if ($usuario->compruebaPassword($password)) {
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $email;
                    $_SESSION['esAdmin'] = strcmp($fila['rol'], 'admin') == 0 ? true : false;
                    //header('Location: index.php');
                    return "usuarioView.php";
                } else {
                    $erroresFormulario[] = "El usuario o el password no coinciden";
                }
            }
        }

        return $erroresFormulario;
    }

}