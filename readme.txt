========== PHP Forum - Tim de Wilde ==========

Deze code gebruikt mail van XAMPP, waarvoor via gmail een verificatiemail gestuurd wordt. ->
Hierbij is configuratie nodig in de php.ini file en xampp 'sendmail.ini' file.

Werkt alleen met gmail i.v.m. het niet gezien wordt als een veilige verbinding.

!! ANDERS DE CODE IN `verify` KOLOM VAN DE TABEL `users` NAAR 'true' VERANDEREN OM IN HET FORUM TE KOMEN. !!
-> Daarnaast is er e en standaard account gemaakt met admin permissions.
    -> username: admin
    -> password: admin

-> PERMISSIONS
Wanneer de `permissions` kolom in tabel `users` naar '1' veranderd wordt, krijgt de user permissie om:
    - Een topic toe te voegen en verwijderen
    - Alle threads verwijderen van alle users (zonder permissions alleen je eigen threads)

-> Wachtwoorden zijn beschermd met md5 encryptie en een salt voor extra veiligheid.


DATABASE STRUCTUUR{

CREATE DATABASE `php_forum`;

CREATE TABLE `php_forum`.`users`(
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `gebruikersnaam` VARCHAR(20) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `wachtwoord` VARCHAR(50) NOT NULL,
    `verify` VARCHAR(50) NOT NULL,
    `salt` VARCHAR(50) NOT NULL,
    `permissions` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`ID`),
    UNIQUE (`gebruikersnaam`),
    UNIQUE (`email`)
);

CREATE TABLE `php_forum`.`topics`(
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `topic` VARCHAR(24) NOT NULL,
    PRIMARY KEY (`ID`)
);

CREATE TABLE `php_forum`.`threads`(
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `topic_ID` INT(11) NOT NULL,
    `title` TEXT NOT NULL,
    `content` TEXT NOT NULL,
    `user_created` VARCHAR(20) NOT NULL,
    `date_created` TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`)
);

CREATE TABLE `php_forum`.`reacties`(
    `ID` INT(11) NOT NULL AUTO_INCREMENT,
    `thread_ID` INT(11) NOT NULL,
    `user_created` VARCHAR(20) NOT NULL,
    `content` TEXT NOT NULL,
    `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`)
);

}