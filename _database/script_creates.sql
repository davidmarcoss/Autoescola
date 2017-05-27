CREATE TABLE administradors(
    admin_nif VARCHAR(9),
    admin_nom VARCHAR(20) NOT NULL,
    admin_cognoms VARCHAR(20) NOT NULL,
    admin_correu VARCHAR(30) UNIQUE NOT NULL,
    admin_password VARCHAR(32) NOT NULL,
    admin_rol VARCHAR(10) NOT NULL,

    CONSTRAINT administradors_pk PRIMARY KEY(admin_nif),
    CONSTRAINT admin_rol_check CHECK(admin_rol in('admin', 'professor'))
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
    alu_desactivat INT NOT NULL,
    alu_token VARCHAR(32),

    CONSTRAINT alumnes_pk PRIMARY KEY(alu_nif),
    CONSTRAINT alumnes_fk_professor FOREIGN KEY(alu_professor_nif) REFERENCES administradors(admin_nif),
    CONSTRAINT alumnes_desactivat_check CHECK(alu_desactivat IN(0, 1))
);

CREATE TABLE carnets(
    carnet_codi VARCHAR(4),
    carnet_desactivat INT NOT NULL,

    CONSTRAINT carnets_pk PRIMARY KEY(carnet_codi),
    CONSTRAINT carnets_check CHECK(carnet_desactivat IN(0, 1))
);

CREATE TABLE alumne_carnets(
    alu_carn_alumne_nif VARCHAR(9),
    alu_carn_carnet_codi VARCHAR(4),
    alu_carn_data_alta TIMESTAMP,

    CONSTRAINT alumne_carnets_pk PRIMARY KEY(alu_carn_alumne_nif, alu_carn_carnet_codi),
    CONSTRAINT alumne_carnets_fk_alumne FOREIGN KEY(alu_carn_alumne_nif) REFERENCES alumnes(alu_nif),
    CONSTRAINT alumne_carnets_fk_carnet FOREIGN KEY(alu_carn_carnet_codi) REFERENCES carnets(carnet_codi)
);

CREATE TABLE tests(
    test_codi VARCHAR(10), -- TEST01, TEST02, ...
    test_nom VARCHAR(10) UNIQUE NOT NULL, -- TEST 01, TEST 02, ....
    test_tipus VARCHAR(10) NOT NULL ,
    test_carnet_codi VARCHAR(4) NOT NULL,

    CONSTRAINT tests_pk PRIMARY KEY(test_codi),
    CONSTRAINT tests_fk_carnet FOREIGN KEY(test_carnet_codi) REFERENCES carnets(carnet_codi) ON DELETE CASCADE,
    CONSTRAINT test_tipus_check CHECK(test_tipus IN('basico', 'avanzado', 'examen'))
);

CREATE TABLE preguntes(
    preg_codi VARCHAR(10), -- P01, P02, ...
    preg_pregunta VARCHAR(300) NOT NULL,
    preg_opcio_correcta VARCHAR(255) NOT NULL,
    preg_opcio_2 VARCHAR(255) NOT NULL,
    preg_opcio_3 VARCHAR(255),
    preg_imatge VARCHAR(50),
    preg_test_codi VARCHAR(10) NOT NULL,

    CONSTRAINT preguntes_pk PRIMARY KEY(preg_codi),
    CONSTRAINT preguntes_fk_test FOREIGN KEY(preg_test_codi) REFERENCES tests(test_codi) ON DELETE CASCADE
);

CREATE TABLE alumne_tests(
    alu_test_id INT,
    alu_test_data_fi TIMESTAMP NOT NULL,
    alu_test_alumne_nif VARCHAR(9) NOT NULL,
    alu_test_test_codi VARCHAR(10) NOT NULL,
    alu_test_nota VARCHAR(10) NOT NULL ,

    CONSTRAINT alumne_tests_pk PRIMARY KEY(alu_test_id),
    CONSTRAINT alumne_tests_fk_alumne FOREIGN KEY(alu_test_alumne_nif) REFERENCES alumnes(alu_nif),
    CONSTRAINT alumne_tests_fk_test FOREIGN KEY(alu_test_test_codi) REFERENCES tests(test_codi) ON DELETE CASCADE,
    CONSTRAINT alumne_tests_nota_check CHECK(alu_test_nota IN('suspendido', 'aprobado', 'excelente'))
);

CREATE TABLE alumne_respostes(
    alu_resp_id INT NOT NULL,
    alu_resp_pregunta_codi VARCHAR(10) NOT NULL,
    alu_resp_resposta_alumne VARCHAR(255) NOT NULL,
    alu_resp_isCorrecta VARCHAR(1),
    alu_resp_alumne_test INT,

    CONSTRAINT alumne_respostes_pk PRIMARY KEY(alu_resp_id),
    CONSTRAINT alumne_respostes_fk_alumne FOREIGN KEY(alu_resp_alumne_test) REFERENCES alumne_tests(alu_test_id),
    CONSTRAINT alumne_respostes_fk_pregunta FOREIGN KEY(alu_resp_pregunta_codi) REFERENCES preguntes(preg_codi) ON DELETE CASCADE,
    CONSTRAINT alumne_respostes_check CHECK(alu_resp_isCorrecta IN('S', 'N'))
);

CREATE TABLE alumne_practiques(
    alu_prac_id INT NOT NULL,
    alu_prac_data_inici TIMESTAMP NOT NULL,
    alu_prac_duracio INT,
    alu_prac_alumne_nif VARCHAR(9) NOT NULL,
    alu_prac_observacions VARCHAR(255),

    CONSTRAINT alumne_practiques_pk PRIMARY KEY(alu_prac_id),
    CONSTRAINT alumne_practiques_fk_alumne FOREIGN KEY(alu_prac_alumne_nif) REFERENCES alumnes(alu_nif)
);

CREATE TABLE index_taules(
    taula_nom VARCHAR(50),
    last_id INT,

    CONSTRAINT index_taules_pk PRIMARY KEY(taula_nom)
);