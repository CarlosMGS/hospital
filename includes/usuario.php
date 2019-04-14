<?php

require_once('aplicacion.php');

class Usuario {

    private $id;
    private $name;
    private $last;
    private $email;
    private $dni;
    private $company;
    private $tlf;
    private $password;
    


    private function __construct($name, $last, $email, $dni, $company, $tlf, $password){
        $this->name= $name;
        $this->email = $email;
        $this->password = $password;
        $this->last = $last;
        $this->dni = $dni;
        $this->company = $company;
        $this->tlf= $tlf;
        
    }

    public function id(){ 
        return $this->id; 
    }

    public function name(){
        return $this->name;
    }

    public function email(){
        return $this->email;
    }

    public function dni(){
        return $this->dni;
    }

    public function company(){
        return $this->company;
    }

    public function tlf(){
        return $this->tlf;
    }

    public function last(){
        return $this->last;
    }

    public function cambiaPassword($nuevoPassword){
        $this->password = self::hashPassword($nuevoPassword);
    }


    /* Devuelve un objeto Usuario con la información del usuario $name,
     o false si no lo encuentra*/
    public static function buscaUsuario($email){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT * FROM pacientes U WHERE U.correo = '%s'", $conn->real_escape_string($email));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['nombre'], $fila['apellidos'],$fila['correo'], $fila['dni'], $fila['company'], $fila['tlf'], $fila['password']);
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
    public static function login($email, $password){
        $user = self::buscaUsuario($email);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }
    
    /* Crea un nuevo usuario con los datos introducidos por parámetro. */
    public static function crea($name, $last, $email, $dni, $company, $tlf, $password){
        $user = self::buscaUsuario($email);
        if ($user) {
            return false;
        }
        $user = new Usuario($name, $last, $email, $dni, $company, $tlf,password_hash($password, PASSWORD_DEFAULT));
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
        $query=sprintf("INSERT INTO pacientes(nombre, apellidos, correo, dni, company, tlf, password) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->name)
            , $conn->real_escape_string($usuario->last)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->dni)
            , $conn->real_escape_string($usuario->company)
            , $conn->real_escape_string($usuario->tlf)
            , $conn->real_escape_string($usuario->password));

        if ( $conn->query($query) ){
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }

    public function citasRecientes($id){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT fecha, nombre, especialidad FROM periodo_actual U join medicos V ON U.id_medico=V.id WHERE U.id_usuario = '%s'", $conn->real_escape_string($id));

        $rs = $conn->query($query);
        $result = false;

        //completar

    }

    public function citasPorMedico($id_medico){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT fecha FROM periodo_actual U  WHERE U.id_medico = '%s'", $conn->real_escape_string($id_medico));

        $rs = $conn->query($query);
        $result = false;

        //completar
    }

    public function medicosPorEspecialidad($especialidad){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT id, nombre, especialidad FROM medicos U WHERE U.especialidad = '%s'", $conn->real_escape_string($especialidad));

        $rs = $conn->query($query);
        $result = false;

        //completar
    }

    public function concertarCita(){

    }
    
}
