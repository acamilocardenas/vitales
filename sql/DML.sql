USE VITALES;

-- Creacion del DML
-- ---------------------------

-- Inserción de registros en la tabla Rh
INSERT INTO 
	RH (nombreRH)
VALUES 
	('A+'),
	('A-'),
	('B+'),
	('B-'),
	('O+'),
	('O-'),
	('AB+'),
	('AB-');
-- ---------------------------

-- Inserción de registros en la tabla Rol
INSERT INTO 
	Rol (nombreRol)
VALUES 
	('Conductor'),
	('Administrador');
-- ---------------------------

-- Inserción de registros en la tabla Categoria Licencia
INSERT INTO 
	Categoria_licencia (nombreCategoria, descripcion)
VALUES 
	('A1', 'Conductores de motocicletas de cilindraje igual o menor a 125 c.c.'),
	('A2', 'Conductores de motocicletas, motociclos y mototriciclos de cilindrajes superiores a 125 c.c.  Válida para categoría A1.'),
	('B1', 'Conductores de automóviles, motocarros, camperos, camionetas, vehículos cuatrimotor y microbuses de servicio particular.'),
	('B2', 'Conductores de camiones, buses y busetas de servicio particular. Válida para categoría B1'),
	('B3', 'Conductores de vehículos particulares articulados o tractocamiones. Válida para las categoría B1 y B2'),
	('C1', 'Conductores de automóviles, motocarros, cuatrimotor, camperos, camionetas y microbuses de servicio público.'),
	('C2', 'Conductores de camiones rígidos, buses y busetas de servicio público. Válida para categoría C1'),
	('C3', 'Conductores de vehículos articulados de servicio público. Válida para las categoría C1 y C2');
	-- ---------------------------

-- Inserción de registros en la tabla Tipo Norma
INSERT INTO 
	Tipo_Norma (nombreTipo)
VALUES 
	('Política'),
	('Compartendo'),
	('Beneficio');
-- ---------------------------

-- Inserción de registros en la tabla Norma
INSERT INTO 
	Norma (idTipo, descripcion, valor)
VALUES 
	(1, 'Daños presentados a los vehículos por mal manejo del equipo (Excesos de velocidad, sobre revolución del vehículo, suspensión, trasmisión, motor, llantas o por golpes) se deberá realizar y analizar el estudio técnico por parte de la aseguradora o por el proceso de mantenimiento de flota; si se evidencia que el daño o golpe fue ocasionado por responsabilidad del conductor se ejecutará la sanción establecida.', 6),
	(1, 'Está prohibido el transporte de pasajeros, personal contratista, aliados, expendios o puntos de venta en el vehículo asignado por la empresa.', 6),
	(1, 'Los vehículos operativos de la compañía únicamente deben transportar GLP, elementos de material de impulso y mercadeo corporativos autorizados.', 6),
	(1, 'Los conductores y ayudantes directos, por ningún motivo pueden ingresar a las instalaciones de la compañía o donde clientes en estado de embriaguez o bajo los efectos de resaca (guayabo) ni de sustancias psicoactivas o drogas. No está permitido fumar dentro del vehículo o cerca al mismo.', 6),
	(1, 'Los conductores y auxiliares autorizados para cumplir la función de conductor deben tener la licencia de conducción vigente.', 6),
	(1, 'El conductor principal es el responsable directo de la operación del vehículo durante su ruta, no está permitido la cesión en la conducción a los auxiliares sin licencia.', 6),
	(1, 'Los teléfonos móviles y otros equipos electrónicos solo pueden utilizarse con dispositivo de manos libres para recepción de llamadas, acatando la Normatividad Legal Vigente que aplique para el caso. En el evento que se requiera realizar una llamada o enviar/recibir un mensaje el conductor deberá detenerse en un lugar seguro y permitido, luego de realizar la llamada o el mensaje reanudar nuevamente la marcha.', 4),
	(1, 'Los conductores no deberán tener reincidencia en calificaciones bajas por sus malos hábitos de conducción como: giros y frenadas bruscas, aceleraciones, ralentí, exceso de velocidad ni mucho menos golpes. La reincidencia estará definida a través del monitoreo realizado por la central establecida para este fin.', 4),
	(1, 'Cualquier choque simple, sanción vial, documental o comparendo emitido por las autoridades competentes, debe ser informado el mismo día por parte del conductor y auxiliar al Administrador, Coordinador de Rutas y Jefe de Logística.', 4),
	(1, 'Serán sancionadas las denuncias presentadas a la línea "#767 Como Conduzco" cuando se evidencie responsabilidad en el evento.', 4),
	(1, 'Los conductores deben cumplir con las normas y políticas de seguridad industrial, salud en el trabajo y deben usar los elementos de protección personal.', 3),
	(1, 'Todo conductor debe acatar las señales de tránsito y reglamentaciones existentes en las zonas y rutas asignadas, es responsabilidad del conductor el pago de la infracción si se evidencia responsabilidad en ella, debe entregar el soporte de pago al Jefe de Mantenimiento de Flota o Administrador Logístico. El plazo máximo del pago es de 5 días.', 3),
	(1, 'El Conductor debe estar al día o con acuerdos de pago con los comparendos que tenga cargados en el SIMIT. El plazo para estar al día es de 5 días después de emitido el comparendo.', 3),
	(1, 'Todos los conductores y ayudantes deben usar el cinturón de seguridad en todo momento, debe ser ajustado antes de la puesta en marcha del vehículo y solo será desajustado cuando el vehículo se encuentre en total detención.', 3),
	(1, 'El conductor debe salir a operación de ruta portando la documentación vial exigible para el vehículo.', 3),
	(1, 'Todo Conductor debe hacer su inspección preoperacional en el vehículo sin excepción antes de salir a operación.', 2),
	(2, 'Conducir en estado de embriaguez, resaca, y/o presencia de estupefacientes, psicotrópicos, estimulantes y otras sustancias de efectos análogos.', 6),
	(2, 'Exceso de velocidad.', 6),
	(2, 'Transporte de pasajeros, personal contratista, aliados o expendios en el vehículo asignado por la empresa.', 6),
	(2, 'Sobrepeso (en basculas).', 4),
	(2, 'Violación a las señales de tránsito, pasar semáforos en rojo, incumplir señal de stop.', 4),
	(2, 'No se debe adelantar a otros vehículos en los siguientes casos:<ul><li>En intersecciones.</li><li>En los tramos de la vía donde exista línea separadora central continua o sea prohibido adelantar.</li><li>En curvas o pendientes.</li><li>Cuando la visibilidad sea desfavorable.</li><li>En las proximidades de pasos de peatones.</li><li>En las intersecciones de las vías férreas, por una berma o por la derecha de un vehículo, en general, cuando la maniobra ofrezca un posible peligro inminente.</li></ul>', 4),
	(2, 'La separación entre dos (2) vehículos que circulen uno tras de otro en el mismo carril de una calzada, será de acuerdo con la velocidad:<ul><li>Para velocidades de hasta treinta (30) Km/hr, diez (10) mts.</li><li>Para velocidades entre treinta (30) y sesenta (60) Km/hr, veinte (20) mts.</li><li>Para velocidades entre sesenta (60) y ochenta (80) Km/hr, veinticinco (25) mts.</li><li>Para velocidades de ochenta (80) kilómetros en adelante, treinta (30) mts o la que la autoridad competente indique.</li></ul>', 4),
	(2, 'EPor conducir un vehículo sin llevar consigo la licencia de conducción o que se encuentre vencida la misma.', 4),
	(2, 'Por usar sistemas móviles de comunicación o teléfonos instalados en los vehículos al momento de conducir, exceptuando si estos son utilizados con accesorios o equipos auxiliares, los cuales permitan tener las manos libres.', 3),
	(2, 'Es obligatorio el uso del cinturón de seguridad por parte del conductor y del auxiliar, los cuales están ubicados en los asientos delanteros del vehículo, El cinturón se debe utilizar dentro de todas las vías del territorio nacional, incluyendo las urbanas y rurales', 2),
	(2, 'Estacionar un vehículo en sitios prohibidos.', 2),
	(3, 'Anualmente quien no presente comportamientos negativos tendrá derecho a recibir 1 punto positivo.', 1);
-- ---------------------------

-- Inserción de registros en la tabla Usuario
INSERT INTO 
	Usuario (idUsuario, nombre, apellido, fechaNacimiento, idRH)
VALUES
	('1012382370', 'Julio Cesar', 'Calderón Garcia', '1991-10-21', 5);
-- ---------------------------

-- Inserción de registros en la tabla logIn
INSERT INTO 
	LogIn (idUsuario, telefono, contraseña, hash)
VALUES 
	('1012382370', '3207036240', '$2y$10$8rYMT2uT1Tltun5gItiRm.YZCnB507PBsz7bvLGA3ShA29t61tSuO', '17c276c8e723eb46aef576537e9d56d0');
-- ---------------------------

-- Inserción de registros en la tabla Licencia_Usuario
INSERT INTO 
	Licencia_Usuario (idUsuario, idCategoria, fechaExpedicion)
VALUES
	('1012382370', 4, '2009-11-09'),
    ('1012382370', 3, '2019-08-14');
-- ---------------------------

-- Inserción de ADMINISTRADOR en la tabla Rol_Usuario
INSERT INTO 
		Rol_Usuario (idUsuario, idRol)
VALUES
	('1012382370', 2);
-- ---------------------------

-- Inserción de registros en la tabla Historial
INSERT INTO 
	Historial (idUsuario, idNorma,  idEvaluador, fechaInfraccion)
VALUES
	('1012382370', 16, '1012382370', '2019-06-26'),
	('1012382370', 28, '1012382370', '2019-04-28'),
	('1012382370', 26, '1012382370', '2020-11-09');
-- Mafe
INSERT INTO 
	Historial (idUsuario, idNorma, idEvaluador, fechaInfraccion)
VALUES
	('1073705533', 16, '1012382370', '2017-09-26'),
	('1073705533', 4, '1012382370', '2019-03-28'),
	('1073705533', 26, '1012382370', '2020-05-19');

-- ---------------------------

-- Eliminar roll administrador en la tabla Rol_Usuario
DELETE FROM Rol_Usuario WHERE  idUsuario = '1073705533' AND idRol = 2;
-- ---------------------------

-- Eliminar de registros de un usuario en la tabla Historial
DELETE FROM Historial WHERE  idUsuario = '1073705533';
