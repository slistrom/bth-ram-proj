--
-- Creating tables part of the forum.
--


--
-- Table question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "title" TEXT NOT NULL,
    "text" TEXT,
    "userId" INTEGER,
    "answered" TEXT,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);

--
-- Table answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "text" TEXT NOT NULL,
    "questId" INTEGER,
    "userId" INTEGER,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);

--
-- Table question comments
--
DROP TABLE IF EXISTS Qcomment;
CREATE TABLE Qcomment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "text" TEXT NOT NULL,
    "questId" INTEGER,
    "userId" INTEGER,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);

--
-- Table answer comments
--
DROP TABLE IF EXISTS Acomment;
CREATE TABLE Acomment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "text" TEXT NOT NULL,
    "answId" INTEGER,
    "userId" INTEGER,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);

--
-- Table tags
--
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "text" TEXT NOT NULL,
    "questId" INTEGER,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME
);
