PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS User;
CREATE TABLE User
(
  id INTEGER PRIMARY KEY, 
  name VARCHAR NOT NULL,
  username CHAR(25) NOT NULL,
  email VARCHAR NOT NULL,
  hash VARCHAR NOT NULL
);

DROP TABLE IF EXISTS EventType;
CREATE TABLE EventType
(
  id INTEGER PRIMARY KEY,
  name VARCHAR NOT NULL
);

DROP TABLE IF EXISTS Event;
CREATE TABLE Event
(
  id INTEGER PRIMARY KEY,
  type INTEGER REFERENCES EventType(id),
  name VARCHAR NOT NULL,
  description VARCHAR NOT NULL,
  date DATETIME NOT NULL,
  public BOOLEAN NOT NULL,
  owner INTEGER REFERENCES User(id),
  imagePath VARCHAR
);

DROP TABLE IF EXISTS EventRegistration;
CREATE TABLE EventRegistration
(
  idEvent INTEGER REFERENCES Event(id),
  idUser INTEGER REFERENCES User(id),
  PRIMARY KEY(idEvent, idUser)
);

DROP TABLE IF EXISTS EventInvite;
CREATE TABLE EventInvite
(
  idEvent INTEGER REFERENCES Event(id),
  idInvited INTEGER REFERENCES User(id),
  idInviter INTEGER REFERENCES User(id),
  PRIMARY KEY(idEvent, idInvited)
);

DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment
(
  id INTEGER PRIMARY KEY,
  idEvent INTEGER REFERENCES Thread(id),
  author INTEGER REFERENCES User(id),
  text TEXT NOT NULL,
  date DATE NOT NULL DEFAULT (datetime('now','localtime'))
);

DROP TABLE IF EXISTS EventSearch;
CREATE VIRTUAL TABLE EventSearch USING fts4(id, name, description);

DROP TRIGGER IF EXISTS EventUpdate;
CREATE TRIGGER EventUpdate
	AFTER Update ON Event
	FOR EACH ROW
	BEGIN
		UPDATE EventSearch SET name = NEW.name, description = NEW.description WHERE id = NEW.id;
	END;

DROP TRIGGER IF EXISTS EventInsert;
CREATE TRIGGER EventInsert
	AFTER INSERT ON Event
	FOR EACH ROW
	BEGIN
		INSERT INTO EventSearch (id, name, description) VALUES (NEW.id, NEW.name, NEW.description);
	END;
	
DROP TRIGGER IF EXISTS EventDelete;
CREATE TRIGGER EventDelete
	AFTER DELETE ON Event
	FOR EACH ROW
	BEGIN
		DELETE FROM EventRegistration WHERE idEvent = OLD.id;
		DELETE FROM EventInvite WHERE idEvent = OLD.id;
		DELETE FROM EventSearch WHERE id = OLD.id;
	END;

INSERT INTO EventType (id, name) VALUES (1, 'Party');
INSERT INTO EventType (id, name) VALUES (2, 'Concert');
INSERT INTO EventType (id, name) VALUES (3, 'Conference');

INSERT INTO User (id, name, username, email, hash) VALUES (1, 'Gustavo Silva', 'gtugablue', 'silva95gustavo@gmail.com', '$2y$10$gu7d2oO1Gb/1IWu16bIZt.8Vaai./rYTbE6zkrArxqeYj8QBUPzEa');
INSERT INTO User (id, name, username, email, hash) VALUES (2, 'André Lago', 'andrelago', 'aslmbc13@gmail.com', '$2y$10$gu7d2oO1Gb/1IWu16bIZt.8Vaai./rYTbE6zkrArxqeYj8QBUPzEa');

INSERT INTO Event (type, name, description, date, public, owner)
	VALUES (1, 'Churrasco do Reis', 'O Reis passou a todas as cadeiras, therefore churrasco!', '2015-12-12 19:00:00', 0, 1);

INSERT INTO EventRegistration (idEvent, idUser) VALUES (1, 1);
INSERT INTO EventInvite (idEvent, idInvited, idInviter) VALUES (1, 2, 1);