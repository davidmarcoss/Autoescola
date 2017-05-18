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

create table administradors(
    nif varchar(9),
    nom varchar(20) not null,
    cognoms varchar(20) not null,
    correu varchar(30) unique not null,
    password varchar(32) not null,
    rol varchar(10) not null check(tipus in("admin", "professor")),

    primary key(nif)
);

create table alumnes(
    nif varchar(9),
    nom varchar(20) not null,
    cognoms varchar(20) not null,
    correu varchar(30) unique not null,
    password varchar(32) not null,
    poblacio varchar(20) not null,
    adreca varchar(20) not null,
    telefon varchar(9) not null,
    professor_nif varchar(9),

    primary key(nif),
    foreign key(professor_nif) references administradors(nif)
);

create table carnets(
    codi varchar(4),

    primary key(codi)
);

create table alumne_carnets(
    alumne_nif varchar(9),
    carnet_codi varchar(4),
    data_alta timestamp,

    primary key(alumne_nif, carnet_codi),
    foreign key(alumne_nif) references alumnes(nif),
    foreign key(carnet_codi) references carnets(codi)
);

create table tests(
    codi varchar(10), -- TEST01, TEST02, ...
    nom varchar(10), -- TEST 01, TEST 02, ....
    tipus varchar(10) check(tipus in("basico", "avanzado", "examen")),
    carnet_codi varchar(4),

    primary key(codi),
    foreign key(carnet_codi) references carnets(codi)
);

create table preguntes(
    codi varchar(10), -- P01, P02, ...
    pregunta varchar(300) not null,
    opcio_correcta varchar(255) not null,
    opcio_2 varchar(255) not null,
    opcio_3 varchar(255),
    imatge varchar(50),
    test_codi varchar(10),

    primary key(codi),
    foreign key(test_codi) references tests(codi)
);

create table alumne_tests(
    id int not null,
    data_fi timestamp,
    alumne_nif varchar(9),
    test_codi varchar(10),
    nota varchar(10) check(nota in ('suspendido', 'aprobado', 'excelente')),

    primary key(id),
    foreign key(alumne_nif) references alumnes(nif),
    foreign key(test_codi) references tests(codi)
);

create table alumne_preguntes_respostes(
    id int not null,
    pregunta_codi varchar(300) not null,
    resposta_alumne varchar(255) not null,
    isCorrecta varchar(1) check(isCorrecta in("S", "N")),
    alumne_test int,

    primary key(id),
    foreign key(alumne_test) references alumne_tests(id),
    foreign key(pregunta_codi) references preguntes(codi)
);

create table cotxes(
    matricula varchar(8),
    marca varchar(30),
    model varchar(30),
    combustible varchar(10) check(combustible in("benzina","gasoil")),

    primary key(matricula)
);

create table alumne_practiques(
    id int not null,
    data_inici timestamp,
    duracio int,
    cotxe varchar(8),

    primary key(id),
    foreign key(cotxe) references cotxes(matricula)
);

create table index_taules(
    taula_nom varchar(50),
    last_id int,

    primary key(taula_nom)
);

insert into administradors values('11111111A', 'Admin', 'Gotera', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin');
insert into administradors values('11111111B', 'Professor', 'Gotera', 'professor@gmail.com', '3f9cd3c7b11eb1bae99dddb3d05da3c5', 'professor');

insert into alumnes values('11111111C', 'Alumne', 'Los Palotes', 'alumne@gmail.com', 'c98a0d7fe575cc92f0cc931db5e31552', 'Masquefa', 'Major 28', '937725050', '11111111B');

insert into carnets values('A');
insert into carnets values('A2');
insert into carnets values('B');

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


insert into alumne_tests values(1, '2017-05-15 15:00:00', '11111111C', 'TEST0001', 'excelente');

insert into alumne_preguntes_respostes values(1, 'P000001', 'Respuesta 1 Pregunta 1', 'S', 1);

insert into cotxes values('1010-ABC', 'Honda', 'Civic', 'gasoil');
insert into cotxes values('2020-ABC', 'Renault', 'Clio', 'benzina');

insert into alumne_practiques values(1, '2017-05-15 15:00:00', 1, '1010-ABC');

insert into index_taules values('alumne_tests', 1);
insert into index_taules values('alumne_preguntes_respostes', 2);
insert into index_taules values('alumne_practiques', 1);
insert into index_taules values('alumne_carnets', 1);