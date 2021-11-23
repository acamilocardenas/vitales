INSERT INTO 
	Usuario (idUsuario, nombre, apellido, fechaNacimiento, idRH)
VALUES
	('13718749','Carlos Julian','Cornejo gamboa','1979-03-19','5'),
	('79624414','Luis Carlos','Peña Rincon ','1973-07-28','3'),
	('80047345','Manuel Antonio','Salazar Castrillon','1979-07-06','5'),
	('88234887','Yonnalber','Bautista Espitia','1979-01-01','3'),
	('1017140933','Sebastian Camilo ','Gaviria Alvarez ','1986-09-10','1'),
	('1077032775','Cindy Lorena','Rodriguez Romero','1988-07-21','5'),
	('1094858232','César Andrés','Bayona Suárez','1987-11-26 ','5');

INSERT INTO 
	LogIn (idUsuario, contraseña, hash)
VALUES 
	('13718749','$2y$10$a9FTOoxFP0oa4EoVwDDqhe8A8Wig3VmeBCV9RzzJ/iFm7EA1RQelm','6cd67d9b6f0150c77bda2eda01ae484c'),
	('79624414','$2y$10$up8v5vbaE1hQJeQXEVReqekvCJew.WOHaV4RNhPCaj6U7HewfTyIS','85fc37b18c57097425b52fc7afbb6969'),
	('80047345','$2y$10$npMXTjRstijWcjtt05PQl.I4TAFi0CJqR9FPI8KQmdh/sKLHxFc6O','069d3bb002acd8d7dd095917f9efe4cb'),
	('88234887','$2y$10$2nK9O4EktpBm9o3/NldDLesPYiQP2HkKn9Fx9rVenuywfQPMG2OOu','f033ab37c30201f73f142449d037028d'),
	('1017140933','$2y$10$vQy/NJcsiz5hQuZk6FDwpOywrsqhXVg.0zRBFu5jXS2p29eZYMale','285e19f20beded7d215102b49d5c09a0'),
	('1077032775','$2y$10$ocx5B.aDboKzqGxadjcp8.E1LKsjA3pUrmpIcSvFpqgHsG4VpH1M.','6602294be910b1e3c4571bd98c4d5484'),
	('1094858232','$2y$10$z3iR0T.T1lbwY47DZ2hAL.y39oCIpZbOdAwIm0JXxUEwkS/bPgyk6','02a32ad2669e6fe298e607fe7cc0e1a0');

INSERT INTO 
	Licencia_Usuario (idUsuario, idCategoria, fechaExpedicion)
VALUES
	('13718749',7,'2019-01-18'),
	('79624414',3,'2024-04-23'),
	('80047345',6,'2018-01-07'),
	('88234887',3,'2018-03-23'),
	('1017140933',3,'2021-07-18'),
	('1077032775',6,'2021-03-24'),
	('1094858232',3,'2015-04-24');

INSERT INTO 
		Rol_Usuario (idUsuario, idRol)
VALUES
	('13718749',2),
	('79624414',2),
	('80047345',2),
	('88234887',2),
	('1017140933',2),
	('1077032775',2),
	('1094858232',2);

