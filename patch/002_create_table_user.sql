CREATE TABLE `User` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `firstName` VARCHAR(100) NOT NULL,
                        `lastName` VARCHAR(100) NOT NULL,
                        `email` VARCHAR(255) NOT NULL,
                        `password` VARCHAR(255) NOT NULL,
                        `birthDate` DATE NOT NULL,
                        `isAdmin` BOOLEAN, ##0: NO, 1:YES
                        PRIMARY KEY (`id`),
                        UNIQUE `Unicite_Mail` (`email`)
) ENGINE = MyISAM;

LOCK TABLES User WRITE;
INSERT INTO `User` (`firstName`,`lastName`,`email`,`birthDate`,`password`,`isAdmin`)
VALUES
('Admin','','admin@framework.fr','1950-01-01','5f4dcc3b5aa765d61d8327deb882cf99',1); ##The password is : password
UNLOCK TABLES;
