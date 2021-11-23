CREATE DATABASE IF NOT EXISTS VITALES;
USE VITALES;

-- Creación DDL
-- ------------------

-- Creación de Tabla RH
CREATE TABLE RH
(
	idRH TINYINT NOT NULL AUTO_INCREMENT,
	nombreRH VARCHAR(3) NOT NULL UNIQUE KEY,
	PRIMARY KEY (idRH)
);
-- ------------------

-- Creación de Tabla Rol
CREATE TABLE Rol
(
	idRol TINYINT NOT NULL AUTO_INCREMENT,
	nombreRol VARCHAR(20) NOT NULL UNIQUE KEY,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (idRol)
);
-- ------------------

-- Creación de Tabla Categoria Licencia
CREATE TABLE Categoria_licencia
(
	idCategoria TINYINT NOT NULL AUTO_INCREMENT,
	nombreCategoria VARCHAR(2) NOT NULL UNIQUE KEY,
	descripcion VARCHAR(150) NOT NULL,
	PRIMARY KEY (idCategoria)
);
-- ------------------

-- Creación de Tabla Tipo Norma
CREATE TABLE Tipo_Norma
(
	idTipo TINYINT NOT NULL AUTO_INCREMENT,
	nombreTipo VARCHAR(20) NOT NULL UNIQUE KEY,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (idTipo)
);
-- ------------------

-- Creación de Tabla Normas
CREATE TABLE Norma
(
	idNorma INT NOT NULL AUTO_INCREMENT,
	idTipo TINYINT NOT NULL,
	descripcion TEXT NOT NULL,
	valor TINYINT NOT NULL,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (idNorma),
	CONSTRAINT PK_NORMA_TIPO FOREIGN KEY (idTipo) REFERENCES Tipo_Norma(idTipo)
);
-- ------------------

-- Creación de Tabla Usuario
CREATE TABLE Usuario
(
	idUsuario INT(20) NOT NULL UNIQUE,
	nombre VARCHAR(60) NOT NULL,
	apellido VARCHAR(60) NOT NULL,
	fechaNacimiento DATE NOT NULL,
	idRH TINYINT NOT NULL,
	fotoPerfil LONGBLOB NULL,
	registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (idUsuario),
	CONSTRAINT PK_USUARIO_RH FOREIGN KEY (idRH) REFERENCES RH(idRH)
);
-- ------------------

-- Creación de Tabla LogIn
CREATE TABLE LogIn
(
	idUsuario INT(20) NOT NULL,
	telefono VARCHAR(10) NULL,
	contraseña VARCHAR(100) NOT NULL,
	hash VARCHAR(32) NOT NULL,
   	activo BOOLEAN NOT NULL DEFAULT 0,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	ultimoLog TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (idUsuario),
	CONSTRAINT PK_LOGIN_USUARIO FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE
);
-- ------------------

-- Creación de Tabla Licencia Usuario
CREATE TABLE Licencia_Usuario
(
	idUsuario INT(20) NOT NULL,
	idCategoria TINYINT NOT NULL,
	fechaExpedicion DATE NOT NULL,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (idUsuario, idCategoria),
	KEY LICENCIA_CATEGORIA (idCategoria),
	CONSTRAINT PK_LICENCIA_USUARIO FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT PK_LICENCIA_CATEGORIA FOREIGN KEY (idCategoria) REFERENCES Categoria_licencia(idCategoria) ON UPDATE CASCADE ON DELETE CASCADE
);
-- ------------------

-- Creación de Tabla Perfil Usuario
CREATE TABLE Rol_Usuario
(
	idUsuario INT(20) NOT NULL,
	idRol TINYINT NOT NULL,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (idUsuario, idRol),
	KEY ROL_TIPO  (idRol),
	CONSTRAINT PK_ROL_USUARIO FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT PK_ROL_TIPO FOREIGN KEY (idRol) REFERENCES Rol(idRol) ON UPDATE CASCADE ON DELETE CASCADE
);
-- ------------------

-- Creación de Tabla Licencia Vial
CREATE TABLE Licencia_Vial
(
	idUsuario INT(20) NOT NULL,
	puntos SMALLINT NOT NULL DEFAULT 12,
	proximoPunto DATE NOT NULL,
	actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (idUsuario),
	CONSTRAINT PK_VIAL_USUARIO FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE
);
-- ------------------

-- Creación de Tabla Historial vial
CREATE TABLE Historial
(
	idUsuario INT(20) NOT NULL,
	idNorma INT NOT NULL,
	idEvaluador INT(20) NOT NULL,
	fechaInfraccion DATE NOT NULL,
	registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (idUsuario, idEvaluador, idNorma),
	KEY HISTORIAL_NORMA  (idNorma),
	CONSTRAINT PK_HISTORIAL_USUARIO FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT PK_HISTORIAL_NORMA FOREIGN KEY (idNorma) REFERENCES Norma(idNorma) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT PK_HISTORIAL_EVALADOR FOREIGN KEY (idEvaluador) REFERENCES Usuario(idUsuario) ON UPDATE CASCADE
);
-- ------------------

-- DISPARADORES

-- CREACION DE DISPARADOR ROL CONDUCTOR
DELIMITER $$
CREATE TRIGGER TR_NUEVO_CONDUCTOR
	AFTER INSERT ON Usuario
	FOR EACH ROW
	BEGIN
		INSERT INTO 
			Rol_Usuario (idUsuario, idRol)
		VALUES
			(NEW.idUsuario, 1);
	END$$
DELIMITER ;
-- ------------------

-- CREACION DE DISPARADOR ACTIVAR LICENCIA
DELIMITER $$
CREATE TRIGGER TR_ACTIVAR_LICENCIA
	BEFORE INSERT ON Licencia_Usuario
	FOR EACH ROW
	BEGIN
		IF NOT EXISTS (SELECT 1 FROM Licencia_Vial WHERE Licencia_Vial.idUsuario = NEW.idUsuario) THEN
			INSERT INTO 
				Licencia_Vial (idUsuario, proximoPunto)
			VALUES
				(NEW.idUsuario, DATE_ADD(CURDATE(), INTERVAL 1 YEAR));
		END IF;
	END$$
DELIMITER ;
-- ------------------
	
-- CREACION DE DISPARADOR RESTAR PUNTOS (LICENCIA VIAL)
DELIMITER $$
CREATE TRIGGER TR_RESTAR_PUNTOS
	BEFORE INSERT ON Historial
	FOR EACH ROW
	BEGIN
    	DECLARE puntosLicencia SMALLINT;
    	DECLARE valorModificar TINYINT;

	    SET puntosLicencia = (SELECT puntos FROM Licencia_Vial WHERE Licencia_Vial.idUsuario = NEW.idUsuario);
	    SET valorModificar = (SELECT valor FROM Norma WHERE Norma.idNorma = NEW.idNorma);

		IF NOT EXISTS (SELECT 1 FROM Norma AS N INNER JOIN Tipo_Norma AS T ON N.idTipo = T.idTipo WHERE N.idNorma = NEW.idNorma AND nombreTipo = 'Beneficio') THEN
			UPDATE Licencia_Vial 
	    		SET Licencia_Vial.puntos = Licencia_Vial.puntos - valorModificar
	    		WHERE Licencia_Vial.idUsuario = NEW.idUsuario;
	    ELSE
	    	UPDATE Licencia_Vial
	    		SET Licencia_Vial.puntos = Licencia_Vial.puntos + valorModificar
	    		WHERE Licencia_Vial.idUsuario = NEW.idUsuario;
		END IF;
	END$$
DELIMITER ;
-- ------------------

-- CREACION DE DISPARADOR SUMAR PUNTOS (LICENCIA VIAL)
DELIMITER $$
CREATE TRIGGER TR_SUMAR_PUNTOS
	BEFORE DELETE ON Historial
	FOR EACH ROW
	BEGIN
    	DECLARE puntosLicencia SMALLINT;
    	DECLARE valorModificar TINYINT;

	    SET puntosLicencia = (SELECT puntos FROM Licencia_Vial WHERE Licencia_Vial.idUsuario = OLD.idUsuario);
	    SET valorModificar = (SELECT valor FROM Norma WHERE Norma.idNorma = OLD.idNorma);

		IF NOT EXISTS (SELECT 1 FROM Norma AS N INNER JOIN Tipo_Norma AS T ON N.idTipo = T.idTipo WHERE N.idNorma = OLD.idNorma AND nombreTipo = 'Beneficio') THEN
			UPDATE Licencia_Vial 
	    		SET Licencia_Vial.puntos = Licencia_Vial.puntos + valorModificar
	    		WHERE Licencia_Vial.idUsuario = OLD.idUsuario;
	    ELSE
	    	UPDATE Licencia_Vial
	    		SET Licencia_Vial.puntos = Licencia_Vial.puntos - valorModificar
	    		WHERE Licencia_Vial.idUsuario = OLD.idUsuario;
		END IF;
	END$$
DELIMITER ;
-- ------------------

-- VISTAS

-- Vista para saber obtener todos los datos de los ussuarios
DROP VIEW IF EXISTS VW_Datos_Usuario;
CREATE VIEW VW_Datos_Usuario AS 
(
	SELECT
		U.idUsuario AS idUsuario,
		U.nombre AS nombre,
		U.apellido AS apellido,
		U.fechaNacimiento AS fechaNacimiento,
		RH.nombreRH AS RH,
		L.telefono AS telefono,
		L.activo AS activo,
		U.fotoPerfil AS fotoPerfil,
		GROUP_CONCAT(DISTINCT R.nombreRol ORDER BY R.nombreRol ASC) AS roles,
		LV.puntos AS puntos,
		LV.proximoPunto AS proximoPunto,
		U.registro AS registro,
		L.ultimoLog AS ultimoLog
	FROM Usuario AS U
	INNER JOIN RH AS RH ON U.idRH = RH.idRH
    INNER JOIN LogIn AS L ON U.idUsuario = L.idUsuario
	INNER JOIN Rol_Usuario AS RLU ON U.idUsuario = RLU.idUsuario
    INNER JOIN Rol AS R ON RLU.idRol = R.idRol
	INNER JOIN Licencia_Vial AS LV ON U.idUsuario = LV.idUsuario 
	GROUP BY (U.idUsuario)
	ORDER BY ultimoLog DESC
);
-- ------------------

-- Vista para saber obtener todos los datos de los ussuarios
DROP VIEW IF EXISTS VW_Usuarios_Evaluaciones;
CREATE VIEW VW_Usuarios_Evaluaciones AS 
(
	SELECT 
		U.idUsuario AS idUsuario, 
		U.nombre AS nombre, 
		U.apellido AS apellido, 
		U.fotoPerfil AS fotoPerfil, 
		L.hash AS hash,
		L.ultimoLog AS ultimoLog,
		U.registro AS fechaActivo, 
		LV.puntos AS puntos, 
		COUNT(IF(H.idNorma != 28,1, null)) AS Infracciones 
	FROM Usuario AS U 
	LEFT JOIN Historial AS H ON U.idUsuario = H.idUsuario 
	INNER JOIN LogIn AS L ON U.idUsuario = L.idUsuario 
	INNER JOIN Licencia_Vial AS LV ON U.idUsuario = LV.idUsuario
	WHERE L.estado = 1
	GROUP BY (U.idUsuario) 
	ORDER BY ultimoLog DESC
);

-- Vista para saber obtener todos los datos de los ussuarios
DROP VIEW IF EXISTS VW_Usuarios_Admin;
CREATE VIEW VW_Usuarios_Admin AS 
(
	SELECT
		U.idUsuario AS idUsuario,
		U.nombre AS nombre,
		U.apellido AS apellido,
		L.telefono AS telefono,
		L.ultimoLog AS ultimoLog,
		L.estado AS estado,
		L.hash AS hash,
		U.fotoPerfil AS fotoPerfil,
		GROUP_CONCAT(DISTINCT R.nombreRol ORDER BY R.nombreRol ASC) AS roles,
		LV.puntos AS puntos,
		COUNT(IF(H.idNorma != 28,1, null)) AS Infracciones 
	FROM Usuario AS U
	LEFT JOIN Historial AS H ON U.idUsuario = H.idUsuario 
    INNER JOIN LogIn AS L ON U.idUsuario = L.idUsuario
	INNER JOIN Rol_Usuario AS RLU ON U.idUsuario = RLU.idUsuario
    INNER JOIN Rol AS R ON RLU.idRol = R.idRol
	INNER JOIN Licencia_Vial AS LV ON U.idUsuario = LV.idUsuario 
	GROUP BY (U.idUsuario)
	ORDER BY ultimoLog DESC, estado DESC
);
-- ------------------

-- Vista para saber los usuarios infractores
DROP VIEW IF EXISTS VW_Usuarios_Infractores;
CREATE VIEW VW_Usuarios_Infractores AS 
(
	SELECT
		U.idUsuario AS idUsuario,
		U.nombre AS nombre,
		U.apellido AS apellido,
		U.fotoPerfil AS fotoPerfil,
		L.hash AS hash,
		L.ultimoLog AS ultimoLog,
		LV.puntos AS puntos,
		COUNT(IF(H.idNorma != 28,1, null)) AS Infracciones,
		U.registro AS fechaActivo
	FROM Historial AS H
	INNER JOIN Usuario AS U ON H.idUsuario = U.idUsuario
	INNER JOIN LogIn AS L ON H.idUsuario = L.idUsuario 
	INNER JOIN Licencia_Vial AS LV ON H.idUsuario = LV.idUsuario 
	INNER JOIN Norma AS N ON H.idNorma = N.idNorma
	WHERE L.estado = 1
	GROUP BY (U.idUsuario)
	ORDER BY ultimoLog DESC, puntos ASC
);
-- ------------------ 

--  ELIMINAR TRIGGER
DROP TRIGGER IF EXISTS TR_DESCONTAR_PUNTOS
-- ------------------
--  ELIMINAR VISTA
DROP VIEW IF EXISTS Usuarios_sin_Infraciones_;




-- **************************************
-- actualización  1 de junio del 2021
-- **************************************

-- Actualización de Tabla LogIn
-- Adición columna de control estado usuario
ALTER TABLE LogIn
	ADD estado BOOLEAN NOT NULL DEFAULT 1
	AFTER activo;
-- ------------------ 


-- **************************************
-- actualización  30 de AGOSTO del 2021
-- **************************************
-- Actualización Implementación licencias a vencer y vencidas
-- Vista para conocer las licencias proximas a vencer
DROP VIEW IF EXISTS VW_Licencias_Expiradas;
CREATE VIEW VW_Licencias_Expiradas AS 
(
	SELECT
		U.idUsuario AS idUsuario,
		U.nombre AS nombre,
		U.apellido AS apellido,
		L.telefono AS telefono,
		L.activo AS activo,
		U.fotoPerfil AS fotoPerfil,
		CL.nombreCategoria AS categoria, 
		LU.fechaExpedicion AS expedicion,
		DATE_ADD(LU.fechaExpedicion, interval 5 year)AS expiracion,
		IF ( now() > DATE_ADD(LU.fechaExpedicion, interval 5 year), 1 , 0) AS estado,
		LU.actualizacion AS actualizacion,
		U.registro AS registro,
		L.ultimoLog AS ultimoLog
	FROM Usuario AS U 
    INNER JOIN LogIn AS L ON U.idUsuario = L.idUsuario
	INNER JOIN Licencia_Usuario AS LU ON U.idUsuario = LU.idUsuario 
	INNER JOIN Categoria_licencia AS CL ON LU.idCategoria = CL.idCategoria
	WHERE L.estado = 1 AND DATE_ADD(LU.fechaExpedicion, interval 5 year) < DATE_ADD(now(), interval 1 month)
	GROUP BY (U.idUsuario)
	ORDER BY expiracion DESC
);
-- ------------------








