<?php

require_once('aplicacion.php');

class Paciente {

    private $id;
    private $name;
    private $dni;
	
    


    private function __construct($name, $dni, $espec, $password){
        $this->name= $name;
        $this->dni = $dni;
        $this->password = $password;
        $this->espec = $espec;        
    }

    public function id(){ 
        return $this->id; 
    }

    public function name(){
        return $this->name;
    }
	
	public function dni(){
        return $this->dni;
    }


    /* Devuelve un objeto Usuario con la información del usuario $name,
     o false si no lo encuentra*/
    public static function buscaUsuario($dni, $name){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionMongo();
		
		$colec = $conn->hospital->pacientes;
		
		$consulta = array( 'dni' => $dni , 'name' => $name);
		$cursor = $colec->find( $consulta );
        
		$result = false;
        if ($cursor) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Medico($fila['nombre'], $fila['correo'],$fila['especialidad'], $fila['password']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    /*Comprueba si la contraseña introducida coincide con la del Usuario.*/
    public function compruebaPassword($password){
        return password_verify($password, $this->password);
    }

    /* Devuelve un objeto Usuario si el usuario existe y coincide su contraseña. En caso contrario,
     devuelve false.*/
    public static function login($dni, $password){
        $user = self::buscaUsuario($dni);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }
    
    /* Crea un nuevo usuario con los datos introducidos por parámetro. */
    public static function crea($name, $dni, $espec, $password){
        $user = self::buscaUsuario($dni);
        if ($user) {
            return false;
        }
        $user = new Medico($name, $dni, $espec, password_hash($password, PASSWORD_DEFAULT));
        return self::guarda($user);
    }
    
    
    public static function guarda($usuario){
        if ($usuario->id !== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }
    
    private static function inserta($usuario){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("INSERT INTO medicos(nombre, correo, especialidad, password) VALUES('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->name)
            , $conn->real_escape_string($usuario->dni)
            , $conn->real_escape_string($usuario->espec)
            , $conn->real_escape_string($usuario->password));

        if ( $conn->query($query) ){
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }


    
}
