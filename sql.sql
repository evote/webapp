CREATE TABLE users(
	id INT NOT NULL AUTO_INCREMENT ,
	username VARCHAR(64) NOT NULL UNIQUE,
	password VARCHAR(128) NOT NULL ,
	email VARCHAR (64) NOT NULL ,
	PRIMARY KEY(id)
);

CREATE TABLE votes(
	id VARCHAR(32) NOT NULL,
	name VARCHAR(64),
	id_user INT NOT NULL,
	voters TEXT NOT NULL,
	options TEXT NOT NULL,
	p TEXT NOT NULL,
	g TEXT NOT NULL,
	k TEXT,
	PRIMARY KEY(id),
	FOREIGN KEY(id_user) REFERENCES users(id)
);
	
CREATE TABLE options(
	id INT NOT NULL AUTO_INCREMENT,
	id_option INT NOT NULL,
	id_votes VARCHAR(32) NOT NULL,
	name VARCHAR(64) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(id_votes) REFERENCES votes(id)
);

CREATE TABLE card(
	id INT NOT NULL AUTO_INCREMENT,
	id_votes VARCHAR(32) NOT NULL,
	id_option INT NOT NULL, 
	gtv TEXT,
	Pog TEXT,
	gyv TEXT,
	sig TEXT,
	PRIMARY KEY(id),
	FOREIGN KEY(id_votes) REFERENCES votes(id)
);

CREATE TABLE result(
	id_vote VARCHAR(32) NOT NULL,
	product_first TEXT,
	product_second TEXT,
	PRIMARY KEY(id_vote),
	FOREIGN KEY(id_vote) REFERENCES votes(id)
);

CREATE TABLE xxx(
	id INT NOT NULL AUTO_INCREMENT,
	id_voter VARCHAR(128),
	id_card TEXT,
	val INT,
	PRIMARY KEY(id)
);