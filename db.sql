PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS User;
CREATE TABLE User
(
  id INTEGER PRIMARY KEY, 
  name VARCHAR, 
  email VARCHAR
);

DROP TABLE IF EXISTS EventType;
CREATE TABLE EventType
(
  id INTEGER PRIMARY KEY,
  name VARCHAR
);

DROP TABLE IF EXISTS Event;
CREATE TABLE Event
(
  id INTEGER PRIMARY KEY,
  type INTEGER REFERENCES EventType(id),
  name VARCHAR NOT NULL,
  description VARCHAR NOT NULL,
  date DATETIME,
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

DROP TABLE IF EXISTS EventThread;
CREATE TABLE EventThread
(
  id INTEGER PRIMARY KEY,
  idEvent INTEGER REFERENCES Event(id),
  name VARCHAR NOT NULL
);

DROP TABLE IF EXISTS ThreadComment;
CREATE TABLE ThreadComment
(
  id INTEGER PRIMARY KEY,
  idThread INTEGER REFERENCES Thread(id),
  author INTEGER REFERENCES User(id),
  comment TEXT NOT NULL
);