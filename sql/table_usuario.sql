CREATE TABLE usuario (
	id serial NOT NULL,
	/* Cadastro da Pessoa */
	nome character varying(50) NOT NULL,
	idSetor integer REFERENCES setor (id) NOT NULL,
	idFuncao integer REFERENCES funcao (id) NOT NULL,
	/* Cadastro do Usuario */
	login character varying(50) UNIQUE,
	senha character varying(128),
	ativo boolean,
	admin boolean,
	resetarSenha boolean,
	ultimoLogin date,
	CONSTRAINT usuario_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE usuario OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE usuario;

/* reseta o auto_increment */
ALTER SEQUENCE usuario_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO usuario (nome, idSetor, idFuncao, login, senha, ativo, admin, resetarSenha, ultimoLogin) VALUES ('Bruno Fagundes', 8, 6, 'bruno.ti', '', true, true, false, null);
INSERT INTO usuario (nome, idSetor, idFuncao, login, senha, ativo, admin, resetarSenha, ultimoLogin) VALUES ('Matteus Barragan', 8, 6, 'matteus.ti', '', true, true, false, null);
INSERT INTO usuario (nome, idSetor, idFuncao, login, senha, ativo, admin, resetarSenha, ultimoLogin) VALUES ('Elisa Penteado', 8, 6, 'elisa.p', '', true, true, false, null);

/* busca os dados */
SELECT * FROM usuario ORDER BY LOWER(nome);