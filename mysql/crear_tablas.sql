SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*

TABLA USERS para almacenar toda la información referente a los usuarios de la aplicación

*/

/*
CREATE TABLE USERS(
	id Integer,
	correo varchar(32) unique not null,
	password varchar() not null,
	rol ENUM('paciente','medico')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE USERS
	ADD PRIMARY KEY (id);
	
ALTER TABLE USERS
	 MODIFY id Integer NOT NULL AUTO_INCREMENT;
	 
*/	 
/*

TABLA PACIENTES para almacenar toda la información referente a los pacientes de la aplicación

*/


CREATE TABLE PACIENTES(
	id Integer,
	nombre varchar(16),
	apellidos varchar(32),
	correo varchar(32) unique not null,
	dni varchar(9),
	company varchar(32),
	tlf varchar(15),
	password varchar(80) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE PACIENTES
	ADD PRIMARY KEY (id);
/*	
ALTER TABLE PACIENTES
	ADD CONSTRAINT pacientes_ibfk_1 FOREIGN KEY (id) REFERENCES USERS (id) ON DELETE CASCADE;
*/

ALTER TABLE PACIENTES
	 MODIFY id Integer NOT NULL AUTO_INCREMENT;


/*

TABLA MEDICOS para almacenar toda la información referente a los médicos del hospital

*/


CREATE TABLE MEDICOS(
	id Integer,
	nombre varchar(48),
	correo varchar(32) unique not null,
	especialidad varchar(32),
	password varchar(80) not null

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE MEDICOS
	ADD PRIMARY KEY (id);
	
ALTER TABLE MEDICOS
	 MODIFY id Integer NOT NULL AUTO_INCREMENT;
/*	
ALTER TABLE MEDICOS
	ADD CONSTRAINT medicos_ibfk_1 FOREIGN KEY (id) REFERENCES USERS (id) ON DELETE CASCADE;
*/

/*

TABLA HISTORIALES para almacenar toda la información referente a los historiales de los pacientes de la aplicación

*/

/*
CREATE TABLE HISTORIALES(
	id Integer,
	fecha date,
	id_medico Integer
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE HISTORIALES
	ADD PRIMARY KEY (id, fecha, id_medico);
	
ALTER TABLE HISTORIALES	 
	ADD CONSTRAINT historiales_ibfk_1 FOREIGN KEY (id) REFERENCES PACIENTES (id),
	ADD CONSTRAINT historiales_ibfk_2 FOREIGN KEY (id_medico) REFERENCES MEDICOS (id);

*/

	


/*

TABLA PERIODO_ACTUAL para saber las citas disponibles en cada día

*/



CREATE TABLE PERIODO_ACTUAL(
	fecha date,
	hora time,
	id_medico Integer,
	id_paciente Integer
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE PERIODO_ACTUAL
	ADD PRIMARY KEY (fecha, id_medico, id_paciente);
	
ALTER TABLE PERIODO_ACTUAL	 
	ADD CONSTRAINT periodo_ibfk_1 FOREIGN KEY (id_medico) REFERENCES MEDICOS (id),
	ADD CONSTRAINT periodo_ibfk_2 FOREIGN KEY (id_paciente) REFERENCES PACIENTES (id);



COMMIT;

