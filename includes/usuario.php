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

    public static function historial($id){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT fecha, nombre, especialidad FROM periodo_actual U join medicos V ON U.id_medico=V.id WHERE U.id_paciente = '%s'", $conn->real_escape_string($id));

        $rs = $conn->query($query);
        $result = false;

        if($rs){
			
			$html="<table class='egt'>";
			$html.="<tr>";
			$html.="<th>Fecha</th>";
			$html.="<th>Nombre</th>";
			$html.="<th>Especialidad</th>";
			$html.="</tr>";
			
			
			while ($row = $rs->fetch_assoc()) {
				$html.= "<tr>";
				$html.= "<td>".$row['fecha']. "</td> <td>" . $row['nombre']. "</td> <td>" . $row['especialidad']. "</td>";
				$html.= "</tr>";
				
			}
			
			$html.="</table>";

                
            $rs->free();
			
		}else{
			$html = '<h3>No ha tenido citas aún</h3>';
		}
		
		return $html;

    }

    public static function citasPorMedico($id_medico, $fecha){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
		
		$date = DateTime::createFromFormat('!H:i', '9:00');
		//echo $date->format('H:i');
		
		//bucle para rellenar el array $horas con todas las horas del día indexadas por la hora y valor booleano
		for ($i = 0; $i < 17; $i++) {
			$horas[$date->format('H:i:s')] = false;
			$date->modify("+30 minutes");
		}
		
		

        $query = sprintf("SELECT hora FROM periodo_actual U  WHERE U.id_medico = '%s' AND U.fecha = '%s' ORDER BY hora ASC", 
				$conn->real_escape_string($id_medico),
				$conn->real_escape_string($fecha));

        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
			
			$i = 0;
			
			while ($row = $rs->fetch_assoc()) {
				$horas[$row['hora']] = true;
			}
			
			

                
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
		
		return $horas;
    }

    public static function medicosPorEspecialidad($especialidad){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT id, nombre FROM medicos U WHERE U.especialidad = '%s'", $conn->real_escape_string($especialidad));

        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
			
			$i = 0;
			
			while ($row = $rs->fetch_assoc()) {
				$medicos[$i][0] = $row['id'];
				$medicos[$i][1] = $row['nombre'];
				$i = $i + 1;
			}

                
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
		
		return $medicos;
    }

    public static function concertarCita($id_usuario, $id_medico, $fecha, $hora){
		
		$app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("INSERT INTO periodo_actual(fecha, hora, id_medico, id_paciente) VALUES('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($fecha)
            , $conn->real_escape_string($hora)
            , $conn->real_escape_string($id_medico)
            , $conn->real_escape_string($id_usuario));

        if ( $conn->query($query) ){
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
	
	public static function especialidades(){
		
		$app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT DISTINCT especialidad FROM medicos ");

        $rs = $conn->query($query);
        $result = false;
		
		if ($rs) {
			
			$i = 0;
			
			while ($row = $rs->fetch_assoc()) {
				$espec[$i] = $row['especialidad'];
				$i = $i + 1;
			}

                
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
		
		return $espec;
	}
    
}
