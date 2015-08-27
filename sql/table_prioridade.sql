/* Cria a tabela prioridade e insere nela os valores padrão */

CREATE TABLE prioridade (
	id serial NOT NULL,
	nome character varying(50) NOT NULL,
	CONSTRAINT prioridade_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE prioridade OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE prioridade;

/* reseta o auto_increment */
ALTER SEQUENCE prioridade_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO prioridade (nome) VALUES ('Urgente');
INSERT INTO prioridade (nome) VALUES ('Alta');
INSERT INTO prioridade (nome) VALUES ('Media');
INSERT INTO prioridade (nome) VALUES ('Baixa');
INSERT INTO prioridade (nome) VALUES ('');

/* busca os dados */
SELECT * FROM prioridade ORDER BY id;