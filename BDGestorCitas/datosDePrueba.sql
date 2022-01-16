DELETE FROM Profesional;
ALTER TABLE Profesional AUTO_INCREMENT = 1;

DELETE FROM Usuario;
ALTER TABLE Usuario AUTO_INCREMENT = 1;

DELETE FROM Paciente;
ALTER TABLE Usuario AUTO_INCREMENT = 1;

DELETE FROM Citas;
ALTER TABLE Citas AUTO_INCREMENT = 1;

-- Contraseña original es 12345678
INSERT INTO  Usuario (id, cedula, rol, intentos, estado, clave)
values (1, "123456789", "admin", 5, "activo", "$2y$10$J0ZTzje91yg57n7Ps8VsPOO.SA74GFD/ynPnod6L0W1M3vdyRoWMi");
INSERT INTO  Usuario (id, cedula, rol, intentos, estado, clave)
values (2, "987654321", "admin", 0, "bloqueado", "$2y$10$J0ZTzje91yg57n7Ps8VsPOO.SA74GFD/ynPnod6L0W1M3vdyRoWMi");
INSERT INTO  Usuario (id, cedula, rol, intentos, estado, clave)
values (3, "102030405", "admin", 5, "activo", "$2y$10$J0ZTzje91yg57n7Ps8VsPOO.SA74GFD/ynPnod6L0W1M3vdyRoWMi");
INSERT INTO  Usuario (id, cedula, rol, intentos, estado, clave)
values (4, "908070605", "admin", 5, "activo", "$2y$10$J0ZTzje91yg57n7Ps8VsPOO.SA74GFD/ynPnod6L0W1M3vdyRoWMi");
INSERT INTO  Usuario (id, cedula, rol, intentos, estado, clave)
values (5, "123454321", "admin", 5, "activo", "$2y$10$J0ZTzje91yg57n7Ps8VsPOO.SA74GFD/ynPnod6L0W1M3vdyRoWMi");



INSERT INTO  Profesional(id, nombre)
values (1, "José María Castro Madriz");
INSERT INTO  Profesional(id, nombre)
values (2, "Juan Rafael Mora Porras");
INSERT INTO  Profesional(id, nombre)
values (3, "Jesús Jiménez Zamora");
INSERT INTO  Profesional(id, nombre)
values (4, "Tomás Guardia Gutiérrez");


INSERT INTO  Paciente(cedula, nombre, apellidos, telefono)
values ("0011223344", "Ratón", "Perez" , "88888888");
INSERT INTO  Paciente(cedula, nombre, apellidos, telefono)
values ("4433221100", "Foo", "Bar" , "22222222");

/*
INSERT INTO  Citas(fecha, idProfesional, cedulaPaciente)
values ("2022-11-18 13:31:00", 1 , "0011223344");
*/
