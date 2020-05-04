# ------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Users
#------------------------------------------------------------

CREATE TABLE Users(
	id_user INT AUTO_INCREMENT NOT NULL,
	nom VARCHAR(70) NOT NULL,
	prenom VARCHAR(70) NOT NULL,
	email VARCHAR(70) UNIQUE NOT NULL,
	pseudo VARCHAR(70) UNIQUE NOT NULL,
	password VARCHAR(70) NOT NULL,
	CONSTRAINT users_pk PRIMARY KEY (id_user)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Tasks
#------------------------------------------------------------

CREATE TABLE Tasks(
        id_task INT Auto_increment NOT NULL,
        description VARCHAR (255) NOT NULL,
        deadline DATETIME NOT NULL,
        id_user INT NOT NULL,
        CONSTRAINT tasks_pk PRIMARY KEY (id_task),
        CONSTRAINT tasks_users_fk FOREIGN KEY (id_user) REFERENCES Users(id_user)
)ENGINE=InnoDB;