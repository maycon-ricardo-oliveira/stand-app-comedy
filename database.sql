DROP TABLE IF EXISTS `places`;
DROP TABLE IF EXISTS `attractions`;


CREATE TABLE `places` (
   `id` INT NOT  NULL AUTO_INCREMENT PRIMARY KEY ,
   `name` VARCHAR( 60 ) NOT NULL ,
   `address` VARCHAR( 80 ) NOT NULL ,
   `zipcode` VARCHAR(20) NOT NULL,
   `lat` FLOAT( 10, 6 ) NOT NULL ,
   `lng`  FLOAT( 10, 6 ) NOT NULL
);

INSERT INTO `places` (`name`,  `address`,`zipcode`, `lat`, `lng`) VALUES  ('Frankie Johnnie & Luigo Too','939  W El Camino Real, Mountain View, CA', '94040', '37.386339','-122.085823');
INSERT  INTO `places` (`name`, `address`,`zipcode`,  `lat`, `lng`) VALUES ('Amicis East  Coast Pizzeria','790 Castro St, Mountain  View, CA', '94041','37.38714','-122.083235');
INSERT  INTO `places` (`name`, `address`,`zipcode`,  `lat`, `lng`) VALUES ('Kapps Pizza Bar  & Grill','191 Castro St, Mountain  View, CA', '94041','37.393885','-122.078916');
INSERT  INTO `places` (`name`, `address`,`zipcode`,  `lat`, `lng`) VALUES ('Round Table  Pizza: Mountain View','570 N Shoreline  Blvd, Mountain View, CA','94043','37.402653','-122.079354');
INSERT  INTO `places` (`name`, `address`,`zipcode`,  `lat`, `lng`) VALUES ('Tony &  Albas Pizza & Pasta','619 Escuela  Ave, Mountain View, CA','94040', '37.394011','-122.095528');
INSERT  INTO `places` (`name`, `address`,`zipcode`,  `lat`, `lng`) VALUES ('Hillarius Comedy Bar','Av. Salim Farah Maluf, 1850 - Quarta Parada, SP','03157-200', '-23.546184','-46.5798771');

CREATE TABLE `attractions` (
            `id` INT NOT  NULL AUTO_INCREMENT PRIMARY KEY ,
           `artist` varchar(255) default NULL,
           `place` varchar(255),
           `date` varchar(255),
           `title` varchar(255) default NULL,
           `place_id` int,
           FOREIGN KEY (`place_id`) REFERENCES `places`(`id`)

) AUTO_INCREMENT=1;

INSERT INTO `attractions` (`artist`,`place`,`date`,`title`, `place_id`)
VALUES
    ('Afonso Padilha','Espaço Cultural Urca','2023-02-21 16:14:08','Espalhando a Palavra', 6),
    ('Rodrigo Marques','Espaço Cultural Urca','2023-02-21 22:50:59','O Problema é meu', 6),
    ('Thiago Ventura','Clube do Minhoca','2023-01-20 19:37:20','Só Agradece', 6),
    ('Danilo Gentilli','My Fucking Comedy Club','2023-01-17 09:55:17','Politicamente Incorreto', 6),
    ('Bruna Louise','Hillarius','2023-01-05 09:55:17','Desbocada', 6),
    ('Nando Vianna','Hillarius','2022-12-10 17:06:40','Processo de Brisa', 6);
