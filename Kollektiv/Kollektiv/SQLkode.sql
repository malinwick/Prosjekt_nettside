-- Tabeller 
CREATE TABLE bruker(
    bruker_id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    bruker_brukernavn varchar(256) not null,
    bruker_epost varchar(256) not null, 
    bruker_passord varchar(256) not null 
); 


CREATE TABLE kollektiv(
    kollektiv_id int(11) not null PRIMARY KEY AUTO_INCREMENT, 
    kollektiv_navn varchar(256) not null
); 


CREATE TABLE medlem(
    bruker_id int not null,
    kollektiv_id int not null,
    FOREIGN KEY (bruker_id) REFERENCES bruker(bruker_id),
    FOREIGN KEY (kollektiv_id) REFERENCES kollektiv(kollektiv_id)
); 


CREATE TABLE vask(
    vask_dato date not null PRIMARY KEY, 
    bruker_id int not null,
    kollektiv_id int not null,
    FOREIGN KEY (bruker_id) REFERENCES bruker(bruker_id),
    FOREIGN KEY (kollektiv_id) REFERENCES kollektiv(kollektiv_id)
); 

CREATE TABLE rombooking(
    tidspunkt_start datetime not null PRIMARY KEY,
    tidspunkt_slutt datetime not null,
    rom varchar(256) not null, 
    bruker_id int not null,
    kollektiv_id int not null,
    FOREIGN KEY (bruker_id) REFERENCES bruker(bruker_id),
    FOREIGN KEY (kollektiv_id) REFERENCES kollektiv(kollektiv_id)
);


CREATE TABLE oppgjor(
    produkt varchar(256) not null,
    pris float not null, 
    bruker_id int not null,
    kollektiv_id int not null,
    FOREIGN KEY (bruker_id) REFERENCES bruker(bruker_id),
    FOREIGN KEY (kollektiv_id) REFERENCES kollektiv(kollektiv_id)
);


CREATE TABLE produkt(
    produkt_navn varchar(256) not null PRIMARY KEY,
    produkt_antall varchar(256) not null, 
    bruker_id int not null,
    kollektiv_id int not null,
    FOREIGN KEY (bruker_id) REFERENCES bruker(bruker_id),
    FOREIGN KEY (kollektiv_id) REFERENCES kollektiv(kollektiv_id)
);



-- Eksempel på innsetting i tabeller 
INSERT INTO bruker (bruker_fornavn, bruker_etternavn, bruker_brukernavn, bruker_passord)
VALUES ('Magne', 'Buraas', 'mbu028', 'padffej');
INSERT INTO bruker (bruker_fornavn, bruker_etternavn, bruker_brukernavn, bruker_passord)
VALUES ('Caroline', 'Nykrem', 'CarNyk', '123455');
INSERT INTO bruker (bruker_fornavn, bruker_etternavn, bruker_brukernavn, bruker_passord)
VALUES ('Malin', 'Wick', 'malW', 'passord');


INSERT INTO kollektiv (kollektiv_navn)
VALUES ('Kollektiv1');
INSERT INTO kollektiv (kollektiv_navn)
VALUES ('Kollektiv2');


INSERT INTO medlem (bruker_id, kollektiv_id)
VALUES (1, 1); 
INSERT INTO medlem (bruker_id, kollektiv_id)
VALUES (2, 2); 
INSERT INTO medlem (bruker_id, kollektiv_id)
VALUES (3, 2); 


INSERT INTO vask (vask_dato, bruker_id, kollektiv_id)
VALUES ('2019-09-31', 1, 1); 
INSERT INTO vask (vask_dato, bruker_id, kollektiv_id)
VALUES ('2019-10-03', 2, 2); 
INSERT INTO vask (vask_dato, bruker_id, kollektiv_id)
VALUES ('2019-10-05', 3, 2); 


-- Sletting av tabeller 
DROP TABLE medlem; 
DROP TABLE vask;
DROP TABLE rombooking;
DROP TABLE oppgjor;
DROP TABLE produkt;
DROP TABLE bruker;
DROP TABLE kollektiv;