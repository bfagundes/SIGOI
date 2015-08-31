CREATE TABLE setor (
	id serial NOT NULL,
	nome character varying(50) NOT NULL,
	idLocal integer REFERENCES local (id),
	CONSTRAINT setor_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE setor OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE setor;

/* reseta o auto_increment */
ALTER SEQUENCE setor_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO setor (nome, idLocal) VALUES ('Informática', 1);
INSERT INTO setor (nome, idLocal) VALUES ('UGP Controle de Ponto', 1);
INSERT INTO setor (nome, idLocal) VALUES ('UGP Folha de Pagamento', 2);
INSERT INTO setor (nome, idLocal) VALUES ('Contabilidade', 2);
INSERT INTO setor (nome, idLocal) VALUES ('Coordenação SPA', 3);
INSERT INTO setor (nome, idLocal) VALUES ('Recepção SPA', 3);

/* busca os dados */
SELECT * FROM setor ORDER BY LOWER(nome);