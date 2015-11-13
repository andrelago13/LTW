PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Users;
CREATE TABLE Users
(
  id INTEGER PRIMARY KEY, 
  name VARCHAR, 
  email VARCHAR
);

DROP TABLE IF EXISTS EventTypes;
CREATE TABLE EventTypes
(
  id INTEGER PRIMARY KEY,
  name VARCHAR
);

DROP TABLE IF EXISTS Events;
CREATE TABLE Events
(
  id INTEGER PRIMARY KEY,
  type INTEGER REFERENCES EventTypes(id),
  name VARCHAR NOT NULL,
  description VARCHAR NOT NULL,
  date DATETIME,
  owner INTEGER REFERENCES Users(id),
  image BLOB
);