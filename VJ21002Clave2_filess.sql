-- Importar en Filess.io -> Restore/import SQL dump
-- Base de datos: salud_vj21002_atmosphere (ya creada en Filess.io)

CREATE TABLE IF NOT EXISTS especialidad (
    id_especialidad INT AUTO_INCREMENT PRIMARY KEY,
    nombre_especialidad VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS hospital (
    id_hospital INT AUTO_INCREMENT PRIMARY KEY,
    nombre_hospital VARCHAR(150) NOT NULL,
    direccion VARCHAR(200) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    id_especialidad INT NOT NULL,
    CONSTRAINT fk_hospital_especialidad
        FOREIGN KEY (id_especialidad) REFERENCES especialidad(id_especialidad)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS doctor (
    id_doctor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    apellido VARCHAR(80) NOT NULL,
    num_colegiado VARCHAR(20) NOT NULL UNIQUE,
    id_hospital INT NOT NULL,
    CONSTRAINT fk_doctor_hospital
        FOREIGN KEY (id_hospital) REFERENCES hospital(id_hospital)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO especialidad (nombre_especialidad) VALUES
    ('Medicina General'),
    ('Pediatria'),
    ('Cardiologia'),
    ('Traumatologia');

INSERT INTO hospital (nombre_hospital, direccion, telefono, id_especialidad) VALUES
    ('Hospital Nacional Rosales', 'Blvd. Arturo Castellanos, San Salvador', '2234-0125', 3),
    ('Hospital San Rafael', 'Santa Ana, El Salvador', '2447-0001', 2),
    ('Hospital Zacamil', 'Plan Maestro, San Salvador', '2235-3000', 1);

INSERT INTO doctor (nombre, apellido, num_colegiado, id_hospital) VALUES
    ('Carlos', 'Martinez', 'COL-10001', 1),
    ('Maria', 'Lopez', 'COL-10002', 1),
    ('Jose', 'Hernandez', 'COL-10003', 2);
