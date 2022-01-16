-- CREATE DATABASE gestorcitas; --

CREATE table Usuario (
	id INTEGER AUTO_INCREMENT,
    cedula varchar(15),
    rol varchar(20),
    intentos int,
    estado varchar(30),
    clave varchar(200),
    PRIMARY KEY (id)
);

create table Profesional(
 id int,
 nombre varchar(100),
 PRIMARY KEY (id),
 FOREIGN KEY (id) REFERENCES Usuario(id) ON DELETE CASCADE
);

CREATE TABLE Paciente
(
    cedula varchar(15),
    nombre varchar(30),
    apellidos varchar(50),
    telefono varchar (30),
    PRIMARY KEY (cedula)
);

create table Procedimiento(
 	id  INTEGER AUTO_INCREMENT,
	cedulaPaciente varchar(15),
 	nombreProcedimiento varchar(30),
	descripcionProcedimiento varchar (200),
	fecha date,
	idProfesional int,
 	PRIMARY KEY (id),
 	FOREIGN KEY (cedulaPaciente) REFERENCES Paciente(cedula) ON DELETE CASCADE,
	FOREIGN KEY (idProfesional) REFERENCES Profesional(id) ON DELETE CASCADE
);

CREATE TABLE Citas
(
    id INTEGER AUTO_INCREMENT,
    fecha datetime,
    idProfesional int,
    cedulaPaciente varchar(15),
    PRIMARY KEY (id),
    FOREIGN KEY (cedulaPaciente) REFERENCES Paciente(cedula) ON DELETE CASCADE,
    FOREIGN KEY (idProfesional) REFERENCES Profesional(id) ON DELETE CASCADE
);

/*

DROP TABLE citas;
DROP TABLE Procedimiento;
DROP TABLE Paciente;
DROP TABLE Profesional;
DROP TABLE Usuario;

*/