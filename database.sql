DROP TABLE IF EXISTS `attractions`;

CREATE TABLE `attractions` (
                               `id` mediumint(8) unsigned NOT NULL auto_increment,
                               `artist` varchar(255) default NULL,
                               `place` varchar(255),
                               `date` varchar(255),
                               `title` varchar(255) default NULL,
                               PRIMARY KEY (`id`)
) AUTO_INCREMENT=1;

INSERT INTO `attractions` (`artist`,`place`,`date`,`title`)
VALUES
    ("Afonso Padilha","Espaço Cultural Urca","2023-02-21 16:14:08","Espalhando a Palavra"),
    ("Rodrigo Marques","Espaço Cultural Urca","2023-02-21 22:50:59","O Problema é meu"),
    ("Thiago Ventura","Clube do Minhoca","2023-01-20 19:37:20","Só Agradece"),
    ("Danilo Gentilli","My Fucking Comedy Club","2023-01-17 09:55:17","Politicamente Incorreto"),
    ("Bruna Louise","Hillarius","2023-01-05 09:55:17","Desbocada"),
    ("Nando Vianna","Hillarius","2022-12-10 17:06:40","Processo de Brisa");
