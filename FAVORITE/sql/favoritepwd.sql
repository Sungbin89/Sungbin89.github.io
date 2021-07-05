DROP TABLE IF EXISTS `listpwd`;
CREATE TABLE `listpwd`(
    `idx` tinyint(4) NOT NULL AUTO_INCREMENT,
    `id` char(20) NOT NULL,
    `name` char(30) NOT NULL,
    `nickname` char(10) NOT NULL,
    `pwd` char(100) NOT NULL,
    `pn` char(30) NOT NULL,
    `email` char(50) NOT NULL,
    `date` date NOT NULL,
    `authorize` enum("0","1") NOT NULL,
    PRIMARY KEY(`idx`),
    UNIQUE KEY `list_id` (`id`),
    UNIQUE KEY `list_nickname` (`nickname`)
) AUTO_INCREMENT=1;
INSERT INTO `listpwd` VALUES('','admin','서영윤', '고등어마트', '81dc9bdb52d04dc20036dbd8313ed055', '01055335137', 'highfishmarket@gmail.com', '1970-01-01','1');

