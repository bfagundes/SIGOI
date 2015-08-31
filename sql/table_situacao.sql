CREATE TABLE situacao (
	id serial NOT NULL,
	nome character varying(50) NOT NULL,
	CONSTRAINT situacao_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE situacao OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE situacao;

/* reseta o auto_increment */
ALTER SEQUENCE situacao_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO situacao (nome) VALUES ('Aberto');
INSERT INTO situacao (nome) VALUES ('Pendente');
INSERT INTO situacao (nome) VALUES ('Fechado');
INSERT INTO situacao (nome) VALUES ('');
INSERT INTO situacao (nome) VALUES ('');

/* busca os dados */
SELECT * FROM situacao ORDER BY id;