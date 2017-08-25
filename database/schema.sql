
---------------------------
---------------------------
---- HELPER FUNCTIONS -----
---------------------------
---------------------------

/**
 * Generate a good enough random string for stub data
 * Do not use for any security purpose
 * @see http://www.simononsoftware.com/random-string-in-postgresql/
 * @param int Size of the desired string
 * @return string A "random" string
 */
CREATE OR REPLACE FUNCTION random_string(int)
RETURNS text
AS $$ 
  SELECT array_to_string(
    ARRAY (
      SELECT substring(
        '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' FROM (random() *26)::int FOR 1)
      FROM generate_series(1, $1) ), '' ) 
$$ LANGUAGE sql;


---------------------------
---------------------------
------- APP SCHEMA --------
---------------------------
---------------------------


/**
create table test(
    id serial primary key,
    whatever varchar not null
);
*/
CREATE TABLE IF NOT EXISTS users
(
  username VARCHAR(20) NOT NULL PRIMARY KEY,
  passphrase VARCHAR(100) NOT NULL,
  name VARCHAR(40) NOT NULL ,
  firstname VARCHAR(40) NOT NULL,
  gender VARCHAR(1),
  email VARCHAR(100) NOT NULL,
  birth DATE,
  tel_num VARCHAR(200),
  description VARCHAR(1000),
  tel_visible BOOL NOT NULL
);

CREATE TABLE IF NOT EXISTS object
(
  objectkey VARCHAR(60) NOT NULL PRIMARY KEY,
  path VARCHAR(30),
  departure VARCHAR(40) NOT NULL,
  arrival VARCHAR(40) NOT NULL,
  username VARCHAR(20) NOT NULL,
  name VARCHAR(40) NOT NULL,
  weight FLOAT NOT NULL,
  size_x INT NOT NULL,
  size_y INT NOT NULL,
  size_z INT NOT NULL,
  description VARCHAR(1000),
  price INT,
  CONSTRAINT FK_userobj FOREIGN KEY (username) REFERENCES users(username)
);


CREATE TABLE IF NOT EXISTS path
(
  pathkey VARCHAR(60) NOT NULL PRIMARY KEY,
  username VARCHAR(20) NOT NULL,
  departure VARCHAR(40) NOT NULL,
  arrival VARCHAR(40) NOT NULL,
  date DATE,
  regular BOOL NOT NULL,
  frequency INT,
  description VARCHAR(1000),
  price INT,
  CONSTRAINT FK_userpath FOREIGN KEY (username) REFERENCES users(username)
  -- CONSTRAINT Check_freq CHECK ((regular='t') OR (frequency IS NOT NULL)),
  -- CONSTRAINT Check_freq2 CHECK ((regular='f') OR (frequency IS NULL))
);

CREATE TABLE IF NOT EXISTS appreciation (
  fstuser VARCHAR(20) NOT NULL,
  snduser VARCHAR(20) NOT NULL,
  note INT NOT NULL, --CHECK (VALUE IN (0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5)),
  day DATE NOT NULL,
  titlecomm VARCHAR(40),
  commentary VARCHAR(400),
  CONSTRAINT PK_star PRIMARY KEY (fstuser, day, snduser),
  CONSTRAINT Check_star CHECK (note >= 0 AND note <= 5),
  CONSTRAINT Check_users CHECK (fstuser != snduser),
  CONSTRAINT FK_usr1 FOREIGN KEY (fstuser) REFERENCES users(username),
  CONSTRAINT FK_usr2 FOREIGN KEY (snduser) REFERENCES users(username)
);


CREATE TABLE IF NOT EXISTS star (
  username VARCHAR(20) NOT NULL PRIMARY KEY,
  star FLOAT,
  num INT NOT NULL,
  CONSTRAINT Check_star CHECK (star >= 0 AND star <= 5),
  CONSTRAINT Check_null CHECK (((num=0) AND (star IS NULL)) OR ((num<>0) AND (star IS NOT NULL))) ,
  CONSTRAINT FK_usr1 FOREIGN KEY (username) REFERENCES users(username)
);

---------------------------
---------------------------
-------- APP DATA ---------
---------------------------
---------------------------



-- insert 100 random strings of length 20
/**
insert into test (whatever) 
    select random_string(20)
    from generate_series(1, 100)
;
*/
INSERT INTO users VALUES ('Ghorhahm','8fd428551006740e9afdb3015789579bdaf95977' , 'BASTIEN', 'QUENTIN', 'M','qbastien544@gmail.com','1996-12-13','0648224724','Chapo Chapo',FALSE); /*passphrased*/
INSERT INTO users VALUES ('Ilée', '85ae2544a865d567ad246d9b23460029b30ee4b6' , 'LE GAL', 'Mathieu', 'A','mlegal1996@gmail.com','1996-08-30','0643014651', NULL,TRUE);/*ilée*/
INSERT INTO users VALUES ('Raeya', 'a9fd3382a9848a9155d16933060a97e7fc18f896' , 'LE GAL', 'Elise', 'F','elise.legal@gmail.com','1992-04-28','0625351726','A but strictement professionnel',TRUE);/*8==3*/
INSERT INTO users VALUES ('Phoko','9c6490cbdb79c4717392153e001a27af2acd212c' , 'BARBIER', 'Anthony', 'M','phoko.ensiie@gmail.com','1996-06-06','0606483537','Ahaha génial',TRUE);

INSERT INTO path VALUES ('pathkey1', 'Ghorhahm' , 'TOULOUSE', 'EVRY', '2017-08-20', FALSE, NULL, 'en voiture', 75);
INSERT INTO path VALUES ('pathkey2', 'Raeya' , 'EVRY', 'METZ', NULL, TRUE, 5, 'Voyage tout les dimanche entre metz et evry', 50);
INSERT INTO path VALUES ('pathkey3', 'Ilée' , 'TOULOUSE', 'EVRY', '2017-07-14', FALSE, NULL, 'en toyota 4 places', 25);
INSERT INTO path VALUES ('pathkey4', 'Phoko' , 'EVRY', 'EVRY', '2017-08-30', FALSE, NULL, 'plus vite', 30);

INSERT INTO object VALUES ('objectkey1', NULL , 'EVRY', 'METZ', 'Ghorhahm', 'un chapeau', 100, 20, 1, 1, NULL,100);
INSERT INTO object VALUES ('objectkey2', NULL , 'TOULOUSE', 'EVRY', 'Phoko', 'un pain au chocolat', 0.5, 10, 5, 2, 'avec supplément chocolat',0.15);
INSERT INTO object VALUES ('objectkey3', NULL , 'ROUEN', 'METZ', 'Raeya', 'Intégral de la saison 2 de GoT', 1, 10, 10, 50, NULL,20);
INSERT INTO object VALUES ('objectkey4', NULL , 'TOULOUSE', 'METZ', 'Ilée', 'un réveil', 5, 20, 42, 15, 'pour réussir à se lever le matin',50);

INSERT INTO star VALUES ('Ghorhahm',5,2);
INSERT INTO star VALUES ('Ilée',1,3);
INSERT INTO star VALUES ('Raeya',5,3);
INSERT INTO star VALUES ('Phoko',NULL,0);

INSERT INTO appreciation VALUES ('Ghorhahm','Phoko',5,'2017-07-24','Niquel','Simplement parfait, aimable, ponctuel, tout était réuni');
INSERT INTO appreciation VALUES ('Ghorhahm','Raeya',5,'2017-07-12','',NULL);
INSERT INTO appreciation VALUES ('Ilée','Ghorhahm',3,'2017-07-25','Retard !','Beaucoup de retard, Dommage');
INSERT INTO appreciation VALUES ('Ilée','Raeya',0,'2017-07-22','','');
INSERT INTO appreciation VALUES ('Ilée','Ghorhahm',0,'2017-07-21','','Voilà');
INSERT INTO appreciation VALUES ('Raeya','Ghorhahm',5,'2017-07-21','Parfait','Rien à redire');
INSERT INTO appreciation VALUES ('Raeya','Phoko',5,'2017-07-21','',NULL);
INSERT INTO appreciation VALUES ('Raeya','Ilée',5,'2017-07-21','Bien','Bon service');