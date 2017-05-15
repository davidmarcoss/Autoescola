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
insert into administradors values('11111111A', 'Admin', 'Gotera', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin');
insert into administradors values('11111111B', 'Professor', 'Gotera', 'professor@gmail.com', '3f9cd3c7b11eb1bae99dddb3d05da3c5', 'professor');

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
insert into alumnes values('11111111C', 'Alumne', 'Los Palotes', 'alumne@gmail.com', 'c98a0d7fe575cc92f0cc931db5e31552', 'Masquefa', 'Major 28', '937725050', '11111111A');

create table carnets(
    codi varchar(4),

    primary key(codi)
);
insert into carnets values('A');
insert into carnets values('A1');
insert into carnets values('B');

create table alumne_carnets(
    alumne_nif varchar(9),
    carnet_codi varchar(4),
    data_alta date,

    primary key(alumne_nif, carnet_codi),
    foreign key(alumne_nif) references alumnes(nif),
    foreign key(carnet_codi) references carnets(codi)
);
insert into alumne_carnets values('11111111C', 'B', '2017-05-15');

create table tests(
    codi varchar(10), -- TEST01, TEST02, ...
    nom varchar(10), -- TEST 01, TEST 02, ....
    tipus varchar(10) check(tipus in("basic", "avancat", "examen")),
    carnet_codi varchar(4),

    primary key(codi),
    foreign key(carnet_codi) references carnets(codi)
);
insert into tests values('TEST0001', 'TEST 0001', 'basic', 'B');
insert into tests values('TEST0002', 'TEST 0002', 'basic', 'B');

create table preguntes(
    codi varchar(10), -- P01, P02, ...
    pregunta varchar(300) not null,
    opcio_correcta varchar(255) not null,
    opcio_2 varchar(255) not null,
    opcio_3 varchar(255),
    tematica varchar(20),
    imatge varchar(50),
    test_codi varchar(10),

    primary key(codi),
    foreign key(test_codi) references tests(codi)
);
insert into preguntes values('P000001', '¿Cómo comprobaremos la presión de los neumáticos?', 'Con los neumáticos fríos.', 'Con los neumáticos calientes.', 'Los neumáticos modernos no requieren mantenimiento.', NULL, 'Mantenimiento', 'TEST0001');
insert into preguntes values('P000002', '¿Las bicicletas pueden llevar remolque?', 'Sí.', 'No.', NULL, NULL, 'Remolques', 'TEST0001');
insert into preguntes values('P000003', '¿Qué le indica esta señal?', 'Principio de autovía.', 'Principio de autopista o autovía.', 'Principio de autopista.', 'P000003.jpg', 'Señales', 'TEST0001');

create table alumne_tests(
    id int,
    data_inici date,
    hora_inici int,
    alumne_nif varchar(9),
    test_codi varchar(10),
    nota varchar(10) check(nota in ('suspes', 'aprobat', 'excelent')),

    primary key(id),
    foreign key(alumne_nif) references alumnes(nif),
    foreign key(test_codi) references tests(codi)
);
insert into alumne_tests values(1, '2017-05-15', '340000', '11111111C', 'TEST0001', 'excelent');

create table alumne_preguntes_respostes(
    id int,
    pregunta varchar(255) not null,
    resposta_alumne varchar(255) not null,
    isCorrecta varchar(1) check(isCorrecta in("S", "N")),
    alumne_test int,

    primary key(id),
    foreign key(alumne_test) references alumne_tests(id)
);
insert into alumne_preguntes_respostes values(1, '¿Cómo comprobaremos la presión de los neumáticos?', 'Con los neumáticos fríos.', 'N', 1);
insert into alumne_preguntes_respostes values(2, '¿Las bicicletas pueden llevar remolque?', 'No.', 'S', 1);

create table cotxes(
    matricula varchar(8),
    marca varchar(30),
    model varchar(30),
    combustible varchar(10) check(combustible in("benzina","gasoil")),

    primary key(matricula)
);
insert into cotxes values('1010-ABC', 'Honda', 'Civic', 'gasoil');
insert into cotxes values('2020-ABC', 'Renault', 'Clio', 'benzina');

create table alumne_practiques(
    id int,
    data_inici date,
    hora_inici int,
    duracio int,
    cotxe varchar(8),

    primary key(id),
    foreign key(cotxe) references cotxes(matricula)
);
insert into alumne_practiques values(1, '2017-05-15', '54000000', 1, '1010-ABC');

create table index_taules(
    taula_nom varchar(50),
    last_id int,

    primary key(taula_nom)
);
insert into index_taules values('alumne_tests', 1);
insert into index_taules values('alumne_preguntes_respostes', 2);
insert into index_taules values('alumne_practiques', 1);