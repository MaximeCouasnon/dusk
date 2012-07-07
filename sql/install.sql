CREATE TABLE `db239491684`.`dusk_comptes` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`nom` VARCHAR( 20 ) NOT NULL ,
`pass` CHAR( 32 ) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE (`nom`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_acl_controleurs` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`code` VARCHAR(20) NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO dusk_acl_controleurs(code)
VALUES ('index'),('jeu');

CREATE TABLE `db239491684`.`dusk_acl_actions` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`controleur_id` INT UNSIGNED NOT NULL ,
`code` VARCHAR(20) NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO dusk_acl_actions(controleur_id,code)
VALUES (1,'index'),(2,'index'),(2,'recrut');

CREATE TABLE `db239491684`.`dusk_acl_profils` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`nom` VARCHAR(20) NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO dusk_acl_profils(nom)
VALUES ('admins');

CREATE TABLE `db239491684`.`dusk_acl_profils_actions` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`profil_id` INT UNSIGNED NOT NULL ,
`action_id` INT UNSIGNED NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO dusk_acl_profils_actions(profil_id,action_id)
VALUES (1,1),(1,2);

CREATE TABLE `db239491684`.`dusk_acl_comptes_profil` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`profil_id` INT UNSIGNED NOT NULL ,
`compte_id` INT UNSIGNED NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO dusk_acl_comptes_profil(profil_id,compte_id)
VALUES (1,1),(1,2);






CREATE TABLE `db239491684`.`dusk_mercos` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`compte_id` INT UNSIGNED ,
`date_gen` INT(11) UNSIGNED ,
`engage` BOOLEAN NOT NULL ,
`prix` INT UNSIGNED ,
`lieu_recrutement` VARCHAR(45),
`nom` VARCHAR( 255 ) NOT NULL ,
`brutalite` INT UNSIGNED NOT NULL ,
`finesse` INT UNSIGNED NOT NULL ,
`discipline` INT UNSIGNED NOT NULL ,
`constitution` INT UNSIGNED NOT NULL ,
`origine` ENUM( 'fed', 'log', 'mec', 'mag', 'maw', 'lev', 'fle', 'kut' ),
`salaire` INT UNSIGNED NOT NULL ,
`moral` INT UNSIGNED NOT NULL ,
`sante` INT UNSIGNED NOT NULL ,
`avatar` VARCHAR( 20 ) NOT NULL ,
PRIMARY KEY(`id`),
INDEX(`compte_id`),
FOREIGN KEY(`compte_id`) REFERENCES dusk_comptes(`id`) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_competences` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`nom` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
`script` TEXT NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_competences_merco` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`merco_id` INT UNSIGNED NOT NULL,
`competence_id` INT UNSIGNED NOT NULL,
PRIMARY KEY(`id`),
INDEX(`merco_id`),
INDEX(`competence_id`),
FOREIGN KEY(`merco_id`) REFERENCES dusk_mercos(`id`) ON DELETE CASCADE,
FOREIGN KEY(`competence_id`) REFERENCES dusk_competences(`id`) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_equipement` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`nom` VARCHAR( 255 ) NOT NULL ,
`partie` VARCHAR( 20 ) NOT NULL,
`description` TEXT NOT NULL ,
`script` TEXT NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_equipement_merco` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`merco_id` INT UNSIGNED NOT NULL,
`equipement_id` INT UNSIGNED NOT NULL,
PRIMARY KEY(`id`),
INDEX(`merco_id`),
INDEX(`equipement_id`),
FOREIGN KEY(`merco_id`) REFERENCES dusk_mercos(`id`) ON DELETE CASCADE,
FOREIGN KEY(`equipement_id`) REFERENCES dusk_equipement(`id`) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_joueurs` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`compte_id` INT UNSIGNED NOT NULL ,
`nom` VARCHAR( 255 ) NOT NULL ,
`origine` ENUM( 'fed', 'log', 'mec', 'mag', 'maw', 'lev', 'fle', 'kut' ),
`allegeance` ENUM( 'fed', 'log', 'mec', 'mag', 'maw', 'lev', 'fle', 'kut' ),
`experience` VARCHAR(50) NOT NULL ,
`argent` VARCHAR(50) NOT NULL ,
`reputation_federation` INT UNSIGNED,
`reputation_leviathan` INT UNSIGNED,
`reputation_logres` INT UNSIGNED,
PRIMARY KEY(`id`),
UNIQUE(`nom`),
INDEX(`compte_id`),
FOREIGN KEY(`compte_id`) REFERENCES dusk_comptes(`id`) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_equipement_joueur` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`joueur_id` INT UNSIGNED NOT NULL,
`equipement_id` INT UNSIGNED NOT NULL,
PRIMARY KEY(`id`),
INDEX(`joueur_id`),
INDEX(`equipement_id`),
FOREIGN KEY(`joueur_id`) REFERENCES dusk_joueurs(`id`) ON DELETE CASCADE,
FOREIGN KEY(`equipement_id`) REFERENCES dusk_equipement(`id`) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_atouts` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`precedent_id` INT UNSIGNED ,
`nom` VARCHAR( 255 ) NOT NULL ,
`charge` INT UNSIGNED ,
`duree` INT UNSIGNED NOT NULL ,
`description` TEXT NOT NULL ,
`script` TEXT NOT NULL ,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_atout_joueur` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`joueur_id` INT UNSIGNED NOT NULL,
`atout_id` INT UNSIGNED NOT NULL,
PRIMARY KEY(`id`),
INDEX(`joueur_id`),
INDEX(`atout_id`),
FOREIGN KEY(`joueur_id`) REFERENCES dusk_joueurs(`id`) ON DELETE CASCADE,
FOREIGN KEY(`atout_id`) REFERENCES dusk_atouts(`id`) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `db239491684`.`dusk_mission` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`compte_id` INT UNSIGNED NOT NULL,
`type` INT UNSIGNED NOT NULL,
`difficulte` INT UNSIGNED NOT NULL,
`xp` INT UNSIGNED NOT NULL,
`letalite` INT UNSIGNED NOT NULL,
PRIMARY KEY(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE OR REPLACE ALGORITHM=UNDEFINED VIEW `dusk_acl_vue` AS
SELECT p.nom AS profil, c.code AS controleur, a.code AS `action`
FROM dusk_acl_profils p
JOIN dusk_acl_profils_actions pa ON pa.profil_id = p.id
JOIN dusk_acl_actions a ON a.id = pa.action_id
JOIN dusk_acl_controleurs c ON c.id = a.controleur_id;





INSERT INTO dusk_comptes(nom,pass)
VALUES ('Water',''),('Thane','');

INSERT INTO dusk_joueurs (compte_id,nom,origine,allegeance)
VALUES (1,'Waterminotaure Bobson','Magomiquets','Magomiquets');

INSERT INTO dusk_atouts(precedent_id,nom,charge,duree,description,script)
VALUES (0,'Engeance niv.1',1440,240,'Crée un démon Magomiquet pour aider votre équipe.',
'add merco (brutalite=1,finesse=1,discipline=1,constitution=1)');

INSERT INTO dusk_mercos(compte_id,nom,origine,brutalite,finesse,discipline,constitution,moral)
VALUES (1,'Kenny McKormick','Léviathan',37,41,45,23,500);

INSERT INTO dusk_equipement(nom,partie,description,script)
VALUES ('Épée de Schtroumpf','Main 1','Une épée courte.','brutalite+1');

INSERT INTO dusk_equipement_merco(merco_id,equipement_id)
VALUES (1,1);

INSERT INTO dusk_equipement(nom,partie,description,script)
VALUES ('Épée de Lumière Révélatrice','Main 1','Une épée phosphorescente.','brutalite+2,finesse-1');

INSERT INTO dusk_equipement_merco(merco_id,equipement_id)
VALUES (1,2);

INSERT INTO dusk_competences (nom,description,script)
VALUES ('Déboîtage du Pouce','Le mercenaire peut briller en société grâce à ce don de la nature.','finesse+1');

INSERT INTO dusk_competences_merco(merco_id,competence_id)
VALUES (1,1);

INSERT INTO dusk_competences (nom,description,script)
VALUES ('Amateur de Tartines','Le mercenaire est un cuisinier émérite.','finesse+1');

INSERT INTO dusk_competences_merco(merco_id,competence_id)
VALUES (1,2);