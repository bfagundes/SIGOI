/* Cria a tabela situacao e insere nela os valores padrão */

CREATE TABLE funcao (
	id serial NOT NULL,
	nome character varying(50) NOT NULL,
	CONSTRAINT funcao_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE funcao OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE funcao;

/* reseta o auto_increment */
ALTER SEQUENCE funcao_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO funcao (nome) VALUES ('Tec Informatica');
INSERT INTO funcao (nome) VALUES ('Assistente Administrativo');

/* busca os dados */
SELECT * FROM funcao ORDER BY nome;