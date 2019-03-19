SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE USERS(
	id Integer auto_increment,
	correo varchar(32) unique not null,
	password varchar(32) not null,
	primary key(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE PERFILES(
	id Integer,
	nombre varchar(16),
	apellidos varchar(32),
	dni varchar(9),
	company varchar(32),
	tlf varchar(15),
	primary key(dni),
	foreign key(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE HISTORIALES(
	dni varchar(32),
	fecha date,
	medico varchar(48),
	foreign key(dni, medico)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE MEDICOS(
	id Integer,
	nombre varchar(48),
	especialidad varchar(32),
	primary key(id)
	foreign key(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE PERIODO_ACTUAL(
	fecha date,
	hora time,
	medico varchar(48),
	foreign key(medico)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

