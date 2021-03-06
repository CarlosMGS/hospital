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


    public function mostrar(){
        $html = '<h2>Datos del Paciente</h2></br>';
        $html.= '<p>Nombre: '.$this->name.'<p></br>';
        $html.= '<p>DNI: '.$this->dni.'<p></br>';
        $html.= '<p>Edad: '.$this->edad.'<p></br>';
        $html.= '<p>Alergias: '.$this->alergias.'<p></br>';
        $html.= '<p>Operaciones: '.$this->operaciones.'<p></br>';
        $html.= '<p>Enfermedades: '.$this->enfermedades.'<p></br>';
        return $html;
    }

    
    public static function buscaUsuario($dni, $name){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionMongo();
		//print_r($conn);
		$colec = $conn->hospital->pacientes;
		
        
		$cursor = $colec->find( ['0.dni' => $dni , '0.nombre' => $name]);
        
        $datos = $cursor->toArray()[0];

        //var_dump($datos[0]);
        //exit();

        $datos = $datos[0];

		$result = false;
        if ($datos) {
            
            
                
                /*return new Paciente($datos['nombre'], $datos['dni'], $datos['edad'], $datos['alergias'], 
                                     $datos['operaciones'], $datos['enfermedades']);*/
                return new Paciente($datos->nombre, $datos->dni, $datos->edad, $datos->alergias, 
                                     $datos->operaciones, $datos->enfermedades);
            
            //$result = $cursor;
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    
    
    public static function crea($name, $dni, $edad, $alergias, $operaciones, $enfermedades){
        $user = self::buscaUsuario($dni, $name);
        if ($user) {
            return false;
        }
        $user = new Paciente($name, $dni, $edad, $alergias, $operaciones, $enfermedades);
        return self::guarda($user);
    }
    
    
    public static function guarda($usuario){

        return self::inserta($usuario);
    }
    
    private static function inserta($usuario){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionMongo();

        $colec = $conn->hospital->pacientes;

        $persona = array(["nombre" => $usuario->name, "edad" => $usuario->edad, "dni" => $usuario->dni,
                        "alergias" => $usuario->alergias, "operaciones" => $usuario->operaciones,
                        "enfermedades" => $usuario->enfermedades]);
        $colec->insertOne($persona);

        return true;
        
    }


    
}
