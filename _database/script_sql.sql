drop database if exists autoescola;
create database autoescola;
use autoescola;

drop table if exists administradors;
drop table if exists alumnes;
drop table if exists carnets;
drop table if exists alumne_carnets;
drop table if exists tests;
drop table if exists preguntes;
drop table if exists alumne_tests;
drop table if exists alumne_preguntes_respostes;
drop table if exists cotxes;
drop table if exists alumne_practiques;
drop table if exists index_taules;

CREATE TABLE administradors(
    admin_nif VARCHAR(9),
    admin_nom VARCHAR(20) NOT NULL,
    admin_cognoms VARCHAR(20) NOT NULL,
    admin_correu VARCHAR(30) unique NOT NULL,
    admin_password VARCHAR(32) NOT NULL,
    admin_rol VARCHAR(10) NOT NULL CHECK(admin_rol in("admin", "professor")),

    PRIMARY KEY(admin_nif)
);

CREATE TABLE alumnes(
    alu_nif VARCHAR(9),
    alu_nom VARCHAR(20) NOT NULL,
    alu_cognoms VARCHAR(20) NOT NULL,
    alu_correu VARCHAR(30) unique NOT NULL,
    alu_password VARCHAR(32) NOT NULL,
    alu_poblacio VARCHAR(20) NOT NULL,
    alu_adreca VARCHAR(20) NOT NULL,
    alu_telefon VARCHAR(9) NOT NULL,
    alu_professor_nif VARCHAR(9),
    alu_desactivat INT(1) NOT NULL CHECK(desactivat IN(0, 1)),

    PRIMARY KEY(alu_nif),
    FOREIGN KEY(alu_professor_nif) REFERENCES administradors(admin_nif)
);

CREATE TABLE carnets(
    carnet_codi VARCHAR(4),
    carnet_desactivat INT(1) NOT NULL CHECK(carnet_desactivat IN(0, 1)),

    PRIMARY KEY(carnet_codi)
);

CREATE TABLE alumne_carnets(
    alu_carn_alumne_nif VARCHAR(9),
    alu_carn_carnet_codi VARCHAR(4),
    alu_carn_data_alta TIMESTAMP,

    PRIMARY KEY(alu_carn_alumne_nif, alu_carn_carnet_codi),
    FOREIGN KEY(alu_carn_alumne_nif) REFERENCES alumnes(alu_nif),
    FOREIGN KEY(alu_carn_carnet_codi) REFERENCES carnets(carnet_codi)
);

CREATE TABLE tests(
    test_codi VARCHAR(10), -- TEST01, TEST02, ...
    test_nom VARCHAR(10), -- TEST 01, TEST 02, ....
    test_tipus VARCHAR(10) CHECK(test_tipus IN("basico", "avanzado", "examen")),
    test_carnet_codi VARCHAR(4),

    PRIMARY KEY(test_codi),
    FOREIGN KEY(test_carnet_codi) REFERENCES carnets(carnet_codi) ON DELETE CASCADE
);

CREATE TABLE preguntes(
    preg_codi VARCHAR(10), -- P01, P02, ...
    preg_pregunta VARCHAR(300) NOT NULL,
    preg_opcio_correcta VARCHAR(255) NOT NULL,
    preg_opcio_2 VARCHAR(255) NOT NULL,
    preg_opcio_3 VARCHAR(255),
    preg_imatge VARCHAR(50),
    preg_test_codi VARCHAR(10),

    PRIMARY KEY(preg_codi),
    FOREIGN KEY(preg_test_codi) REFERENCES tests(test_codi) ON DELETE CASCADE
);

CREATE TABLE alumne_tests(
    alu_test_id INT NOT NULL,
    alu_test_data_fi TIMESTAMP,
    alu_test_alumne_nif VARCHAR(9),
    alu_test_test_codi VARCHAR(10),
    alu_test_nota VARCHAR(10) CHECK(al_test_nota IN('suspendido', 'aprobado', 'excelente')),

    PRIMARY KEY(alu_test_id),
    FOREIGN KEY(alu_test_alumne_nif) REFERENCES alumnes(alu_nif),
    FOREIGN KEY(alu_test_test_codi) REFERENCES tests(test_codi) ON DELETE CASCADE
);

CREATE TABLE alumne_respostes(
    alu_resp_id INT NOT NULL,
    alu_resp_pregunta_codi VARCHAR(300) NOT NULL,
    alu_resp_resposta_alumne VARCHAR(255) NOT NULL,
    alu_resp_isCorrecta VARCHAR(1) CHECK(alu_resp_isCorrecta IN("S", "N")),
    alu_resp_alumne_test INT,

    PRIMARY KEY(alu_resp_id),
    FOREIGN KEY(alu_resp_alumne_test) REFERENCES alumne_tests(alu_test_id),
    FOREIGN KEY(alu_resp_pregunta_codi) REFERENCES preguntes(preg_codi) ON DELETE CASCADE
);

CREATE TABLE cotxes(
    cotxe_matricula VARCHAR(8),
    cotxe_marca VARCHAR(30),
    cotxe_model VARCHAR(30),
    cotxe_combustible VARCHAR(10) CHECK(cotxe_combustible IN("benzina","gasoil")),

    PRIMARY KEY(cotxe_matricula)
);

CREATE TABLE alumne_practiques(
    alu_prac_id INT NOT NULL,
    alu_prac_data_inici TIMESTAMP,
    alu_prac_duracio INT,
    alu_prac_cotxe VARCHAR(8),

    PRIMARY KEY(alu_prac_id),
    FOREIGN KEY(alu_prac_cotxe) REFERENCES cotxes(cotxe_matricula)
);

CREATE TABLE index_taules(
    taula_nom VARCHAR(50),
    last_id INT,

    PRIMARY KEY(taula_nom)
);

insert into administradors values('11111111A', 'Admin', 'Gotera', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin');
insert into administradors values('11111111B', 'Professor', 'Gotera', 'professor@gmail.com', '3f9cd3c7b11eb1bae99dddb3d05da3c5', 'professor');

insert into alumnes values('11111111C', 'Alumne', 'Los Palotes', 'alumne@gmail.com', 'c98a0d7fe575cc92f0cc931db5e31552', 'Masquefa', 'Major 28', '937725050', '11111111B', 0);

insert into carnets values('A', 0);
insert into carnets values('A2', 0);
insert into carnets values('B', 0);

insert into alumne_carnets values('11111111C', 'A2', '2016-05-15');
insert into alumne_carnets values('11111111C', 'B', '2017-05-15');

insert into tests values('TEST0001', 'TEST 0001', 'basico', 'B');

insert into preguntes values('P000001', 'Pregunta 1', 'Respuesta 1 Pregunta 1', 'Respuesta 2 Pregunta 1', 'Respuesta 3 Pregunta 1', NULL, 'TEST0001');
insert into preguntes values('P000002', 'Pregunta 2', 'Respuesta 1 Pregunta 2', 'Respuesta 2 Pregunta 2', 'Respuesta 3 Pregunta 2', NULL, 'TEST0001');
insert into preguntes values('P000003', 'Pregunta 3', 'Respuesta 1 Pregunta 3', 'Respuesta 2 Pregunta 3', 'Respuesta 3 Pregunta 3', NULL, 'TEST0001');
insert into preguntes values('P000004', 'Pregunta 4', 'Respuesta 1 Pregunta 4', 'Respuesta 2 Pregunta 4', 'Respuesta 3 Pregunta 4', NULL, 'TEST0001');
insert into preguntes values('P000005', 'Pregunta 5', 'Respuesta 1 Pregunta 5', 'Respuesta 2 Pregunta 5', 'Respuesta 3 Pregunta 5', NULL, 'TEST0001');
insert into preguntes values('P000006', 'Pregunta 6', 'Respuesta 1 Pregunta 6', 'Respuesta 2 Pregunta 6', 'Respuesta 3 Pregunta 6', NULL, 'TEST0001');
insert into preguntes values('P000007', 'Pregunta 7', 'Respuesta 1 Pregunta 7', 'Respuesta 2 Pregunta 7', 'Respuesta 3 Pregunta 7', NULL, 'TEST0001');
insert into preguntes values('P000008', 'Pregunta 8', 'Respuesta 1 Pregunta 8', 'Respuesta 2 Pregunta 8', 'Respuesta 3 Pregunta 8', NULL, 'TEST0001');
insert into preguntes values('P000009', 'Pregunta 9', 'Respuesta 1 Pregunta 9', 'Respuesta 2 Pregunta 9', 'Respuesta 3 Pregunta 9', NULL, 'TEST0001');
insert into preguntes values('P000010', 'Pregunta 10', 'Respuesta 1 Pregunta 10', 'Respuesta 2 Pregunta 10', 'Respuesta 3 Pregunta 10', NULL, 'TEST0001');
insert into preguntes values('P000011', 'Pregunta 11', 'Respuesta 1 Pregunta 11', 'Respuesta 2 Pregunta 11', 'Respuesta 3 Pregunta 11', NULL, 'TEST0001');
insert into preguntes values('P000012', 'Pregunta 12', 'Respuesta 1 Pregunta 12', 'Respuesta 2 Pregunta 12', 'Respuesta 3 Pregunta 12', NULL, 'TEST0001');
insert into preguntes values('P000013', 'Pregunta 13', 'Respuesta 1 Pregunta 13', 'Respuesta 2 Pregunta 13', 'Respuesta 3 Pregunta 13', NULL, 'TEST0001');
insert into preguntes values('P000014', 'Pregunta 14', 'Respuesta 1 Pregunta 14', 'Respuesta 2 Pregunta 14', 'Respuesta 3 Pregunta 14', NULL, 'TEST0001');
insert into preguntes values('P000015', 'Pregunta 15', 'Respuesta 1 Pregunta 15', 'Respuesta 2 Pregunta 15', 'Respuesta 3 Pregunta 15', NULL, 'TEST0001');
insert into preguntes values('P000016', 'Pregunta 16', 'Respuesta 1 Pregunta 16', 'Respuesta 2 Pregunta 16', 'Respuesta 3 Pregunta 16', NULL, 'TEST0001');
insert into preguntes values('P000017', 'Pregunta 17', 'Respuesta 1 Pregunta 17', 'Respuesta 2 Pregunta 17', 'Respuesta 3 Pregunta 17', NULL, 'TEST0001');
insert into preguntes values('P000018', 'Pregunta 18', 'Respuesta 1 Pregunta 18', 'Respuesta 2 Pregunta 18', 'Respuesta 3 Pregunta 18', NULL, 'TEST0001');
insert into preguntes values('P000019', 'Pregunta 19', 'Respuesta 1 Pregunta 19', 'Respuesta 2 Pregunta 19', 'Respuesta 3 Pregunta 19', NULL, 'TEST0001');
insert into preguntes values('P000020', 'Pregunta 20', 'Respuesta 1 Pregunta 20', 'Respuesta 2 Pregunta 20', 'Respuesta 3 Pregunta 20', NULL, 'TEST0001');
insert into preguntes values('P000021', 'Pregunta 21', 'Respuesta 1 Pregunta 21', 'Respuesta 2 Pregunta 21', 'Respuesta 3 Pregunta 21', NULL, 'TEST0001');
insert into preguntes values('P000022', 'Pregunta 22', 'Respuesta 1 Pregunta 22', 'Respuesta 2 Pregunta 22', 'Respuesta 3 Pregunta 22', NULL, 'TEST0001');
insert into preguntes values('P000023', 'Pregunta 23', 'Respuesta 1 Pregunta 23', 'Respuesta 2 Pregunta 23', 'Respuesta 3 Pregunta 23', NULL, 'TEST0001');
insert into preguntes values('P000024', 'Pregunta 24', 'Respuesta 1 Pregunta 24', 'Respuesta 2 Pregunta 24', 'Respuesta 3 Pregunta 24', NULL, 'TEST0001');
insert into preguntes values('P000025', 'Pregunta 25', 'Respuesta 1 Pregunta 25', 'Respuesta 2 Pregunta 25', 'Respuesta 3 Pregunta 25', NULL, 'TEST0001');
insert into preguntes values('P000026', 'Pregunta 26', 'Respuesta 1 Pregunta 26', 'Respuesta 2 Pregunta 26', 'Respuesta 3 Pregunta 26', NULL, 'TEST0001');
insert into preguntes values('P000027', 'Pregunta 27', 'Respuesta 1 Pregunta 27', 'Respuesta 2 Pregunta 27', 'Respuesta 3 Pregunta 27', NULL, 'TEST0001');
insert into preguntes values('P000028', 'Pregunta 28', 'Respuesta 1 Pregunta 28', 'Respuesta 2 Pregunta 28', 'Respuesta 3 Pregunta 28', NULL, 'TEST0001');
insert into preguntes values('P000029', 'Pregunta 29', 'Respuesta 1 Pregunta 29', 'Respuesta 2 Pregunta 29', 'Respuesta 3 Pregunta 29', NULL, 'TEST0001');
insert into preguntes values('P000030', 'Pregunta 30', 'Respuesta 1 Pregunta 30', 'Respuesta 2 Pregunta 30', 'Respuesta 3 Pregunta 30', NULL, 'TEST0001');

insert into cotxes values('1010-ABC', 'Honda', 'Civic', 'gasoil');
insert into cotxes values('2020-ABC', 'Renault', 'Clio', 'benzina');

insert into alumne_practiques values(1, '2017-05-15 15:00:00', 1, '1010-ABC');

insert into index_taules values('alumne_tests', 1);
insert into index_taules values('alumne_respostes', 2);
insert into index_taules values('alumne_practiques', 1);
insert into index_taules values('alumne_carnets', 1);