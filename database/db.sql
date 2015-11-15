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
  image BLOB
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

DROP TABLE IF EXISTS Thread;
CREATE TABLE Thread
(
  id INTEGER PRIMARY KEY,
  idEvent INTEGER REFERENCES Event(id),
  name VARCHAR NOT NULL
);

DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment
(
  id INTEGER PRIMARY KEY,
  idThread INTEGER REFERENCES Thread(id),
  author INTEGER REFERENCES User(id),
  comment TEXT NOT NULL
);

DROP TABLE IF EXISTS Album;
CREATE TABLE Album
(
  id INTEGER PRIMARY KEY,
  idEvent INTEGER REFERENCES Event(id),
  name VARCHAR NOT NULL
);

DROP TABLE IF EXISTS Photo;
CREATE TABLE Photo
(
  id INTEGER PRIMARY KEY,
  image BLOB NOT NULL
);

INSERT INTO EventType (id, name) VALUES (1, 'Party');
INSERT INTO EventType (id, name) VALUES (2, 'Concert');
INSERT INTO EventType (id, name) VALUES (3, 'Conference');

INSERT INTO User (id, name, username, email, hash) VALUES (1, 'Gustavo Silva', 'gtugablue', 'silva95gustavo@gmail.com', 'abchashxyz');

INSERT INTO Event (type, name, description, date, public, owner)
	VALUES (1, 'Churrasco do Reis', 'O Reis passou a todas as cadeiras, therefore churrasco!', '2015-12-12 19:00:00', 0, 1);

INSERT INTO EventRegistration (idEvent, idUser) VALUES (1, 1);