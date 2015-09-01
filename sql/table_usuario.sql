CREATE TABLE usuario (
	id serial NOT NULL,
	/* Cadastro da Pessoa */
	nome character varying(50),
	idSetor integer REFERENCES setor (id),
	idFuncao integer REFERENCES funcao (id),
	idPrioridade integer REFERENCES prioridade (id),
	/* Cadastro do Usuario */
	usuario character varying(50),
	senha character varying(150),
	ativo boolean,
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
INSERT INTO usuario (nome, idLocal) VALUES ('Informática', 1);
INSERT INTO usuario (nome, idLocal) VALUES ('UGP Controle de Ponto', 1);
INSERT INTO usuario (nome, idLocal) VALUES ('UGP Folha de Pagamento', 2);
INSERT INTO usuario (nome, idLocal) VALUES ('Contabilidade', 2);
INSERT INTO usuario (nome, idLocal) VALUES ('Coordenação SPA', 3);
INSERT INTO usuario (nome, idLocal) VALUES ('Recepção SPA', 3);

/* busca os dados */
SELECT * FROM usuario ORDER BY LOWER(nome);