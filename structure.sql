# script créé le : Tue Feb 04 20:31:59 CET 2014 -   syntaxe MySQL ;

# use  VOTRE_BASE_DE_DONNEE ;

DROP TABLE IF EXISTS Utilisateur ;
CREATE TABLE Utilisateur (id BIGINT(20) NOT NULL AUTO_INCREMENT,
login VARCHAR(60),
password VARCHAR(64),
nom VARCHAR(60),
prenom VARCHAR(60),
level tinyint(2),
classe_id BIGINT(20),
PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Document ;
CREATE TABLE Document (id BIGINT(20) NOT NULL AUTO_INCREMENT,
nom VARCHAR(255),
date_creation DATE,
contenu TEXT,
type_id int(20) NOT NULL,
PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Classe ;
CREATE TABLE Classe (id BIGINT(20) NOT NULL AUTO_INCREMENT,
nom VARCHAR(100),
PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Type ;
CREATE TABLE Type (id int(20) NOT NULL AUTO_INCREMENT,
nom VARCHAR(100),
affichable BOOL,
PRIMARY KEY (id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Ecrit ;
CREATE TABLE Ecrit (utilisateur_id BIGINT(20) NOT NULL,
document_id BIGINT(20) NOT NULL,
date_modification DATE,
PRIMARY KEY (utilisateur_id,
 document_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS Autorise ;
CREATE TABLE Autorise (classe_id BIGINT(20) NOT NULL,
document_id BIGINT(20) NOT NULL,
date_autorisation DATE,
PRIMARY KEY (classe_id,
 document_id) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE Utilisateur ADD CONSTRAINT FK_Utilisateur_classe_id FOREIGN KEY (classe_id) REFERENCES Classe (id);
ALTER TABLE Document ADD CONSTRAINT FK_Document_type_id FOREIGN KEY (type_id) REFERENCES Type (id);
ALTER TABLE Ecrit ADD CONSTRAINT FK_Ecrit_utilisateur_id FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur (id);
ALTER TABLE Ecrit ADD CONSTRAINT FK_Ecrit_document_id FOREIGN KEY (document_id) REFERENCES Document (id);
ALTER TABLE Autorise ADD CONSTRAINT FK_Autorise_classe_id FOREIGN KEY (classe_id) REFERENCES Classe (id);
ALTER TABLE Autorise ADD CONSTRAINT FK_Autorise_document_id FOREIGN KEY (document_id) REFERENCES Document (id);
