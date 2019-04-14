<?php

require_once('aplicacion.php');

class Paciente {

    private $id;
    private $name;
    private $edad;
    private $dni;
    private $alergias;
    private $operaciones;
    private $enfermedades;

	
    


    private function __construct($name, $dni, $edad, $alergias, $operaciones, $enfermedades){
        $this->name= $name;
        $this->dni = $dni;
        $this->operaciones = $operaciones;
        $this->alergias = $alergias;
        $this->enfermedades= $enfermedades;    
        $this->edad = $edad;    
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

    public function operaciones(){
        return $this->operaciones;
    }

    public function alergias(){
        return $this->alergias;
    }

    public function enfermedades(){
        return $this->enfermedades;
    }

    public function edad(){
        return $this->edad;
    }


    /* Devuelve un objeto Usuario con la información del usuario $name,
     o false si no lo encuentra*/
    public static function buscaUsuario($dni, $name){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionMongo();
		print_r($conn);
		$colec = $conn->hospital->pacientes;
		
		$consulta = array( 'dni' => $dni , 'name' => $name);
		$cursor = $colec->find( $consulta );
        
		$result = false;
        if ($cursor) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Paciente($fila['nombre'], $fila['dni'],$fila['alergias'], $fila['operaciones'], $file['enfermedades']);
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

    
    /* Crea un nuevo usuario con los datos introducidos por parámetro. */
    public static function crea($name, $dni, $edad, $alergias, $operaciones, $enfermedades){
        $user = self::buscaUsuario($dni, $name);
        if ($user) {
            return false;
        }
        $user = new Paciente($name, $dni, $edad, $alergias, $operaciones, $enfermedades);
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
        $conn = $app->conexionMongo();

        $colec = $conn->hospital->pacientes;

        $persona = array("nombre" => $usuario->name, "edad" => $usuario->edad, "dni" => $usuario->dni,
                        "alergias" => $usuario->alergias, "operaciones" => $usuario->operaciones,
                        "enfermedades" => $usuario->enfermedades);
        $colección->insert($persona);
        

        if ( $conn->query($query) ){
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }


    
}
