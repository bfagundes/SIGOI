/* Cria a tabela tipo e insere nela os valores padrão */

CREATE TABLE tipo (
	id serial NOT NULL,
	nome character varying(50) NOT NULL,
	CONSTRAINT tipo_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE tipo OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE tipo;

/* reseta o auto_increment */
ALTER SEQUENCE tipo_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO tipo (nome) VALUES ('Problema');
INSERT INTO tipo (nome) VALUES ('Incidente');
INSERT INTO tipo (nome) VALUES ('Acidente');
INSERT INTO tipo (nome) VALUES ('Solicitação');
INSERT INTO tipo (nome) VALUES ('Pergunta');

/* busca os dados */
SELECT * FROM tipo;