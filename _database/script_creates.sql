CREATE TABLE administradors(
    admin_nif VARCHAR(9),
    admin_nom VARCHAR(20) NOT NULL,
    admin_cognoms VARCHAR(20) NOT NULL,
    admin_correu VARCHAR(30) UNIQUE NOT NULL,
    admin_password VARCHAR(32) NOT NULL,
    admin_rol VARCHAR(10) NOT NULL CHECK(admin_rol in("admin", "professor")),

    PRIMARY KEY(admin_nif)
);

CREATE TABLE alumnes(
    alu_nif VARCHAR(9),
    alu_nom VARCHAR(20) NOT NULL,
    alu_cognoms VARCHAR(20) NOT NULL,
    alu_correu VARCHAR(30) UNIQUE NOT NULL,
    alu_password VARCHAR(32) NOT NULL,
    alu_poblacio VARCHAR(20) NOT NULL,
    alu_adreca VARCHAR(20) NOT NULL,
    alu_telefon VARCHAR(9) NULL,
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
    test_nom VARCHAR(10) UNIQUE NOT NULL, -- TEST 01, TEST 02, ....
    test_tipus VARCHAR(10) NOT NULL CHECK(test_tipus IN("basico", "avanzado", "examen")),
    test_carnet_codi VARCHAR(4) NOT NULL,

    PRIMARY KEY(test_codi),
    FOREIGN KEY(test_carnet_codi) REFERENCES carnets(carnet_codi) ON DELETE CASCADE
);

CREATE TABLE preguntes(
    preg_codi VARCHAR(10), -- P01, P02, ...
    preg_pregunta VARCHAR(300) NOT NULL,
    preg_opcio_correcta VARCHAR(255) NOT NULL,
    preg_opcio_2 VARCHAR(255) NOT NULL,
    preg_opcio_3 VARCHAR(255),
    preg_imatge VARCHAR(50) UNIQUE,
    preg_test_codi VARCHAR(10) NOT NULL,

    PRIMARY KEY(preg_codi),
    FOREIGN KEY(preg_test_codi) REFERENCES tests(test_codi) ON DELETE CASCADE
);

CREATE TABLE alumne_tests(
    alu_test_id INT,
    alu_test_data_fi TIMESTAMP NOT NULL,
    alu_test_alumne_nif VARCHAR(9) NOT NULL,
    alu_test_test_codi VARCHAR(10) NOT NULL,
    alu_test_nota VARCHAR(10) NOT NULL CHECK(al_test_nota IN('suspendido', 'aprobado', 'excelente')),

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
    cotxe_marca VARCHAR(30) NOT NULL,
    cotxe_model VARCHAR(30) NOT NULL,
    cotxe_combustible VARCHAR(10) NOT NULL CHECK(cotxe_combustible IN("benzina","gasoil")),

    PRIMARY KEY(cotxe_matricula)
);

CREATE TABLE alumne_practiques(
    alu_prac_id INT NOT NULL,
    alu_prac_data_inici TIMESTAMP NOT NULL,
    alu_prac_duracio INT,
    alu_prac_alumne_nif VARCHAR(9) NOT NULL,
    alu_prac_cotxe VARCHAR(8) NOT NULL,

    PRIMARY KEY(alu_prac_id),
    FOREIGN KEY(alu_prac_alumne_nif) REFERENCES alumnes(alu_nif),
    FOREIGN KEY(alu_prac_cotxe) REFERENCES cotxes(cotxe_matricula)
);

CREATE TABLE index_taules(
    taula_nom VARCHAR(50),
    last_id INT,

    PRIMARY KEY(taula_nom)
);