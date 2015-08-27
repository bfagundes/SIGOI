/* Cria a tabela teste e insere nela os valores padrão */

CREATE TABLE teste (
	id serial NOT NULL,
	nome character varying(50) NOT NULL,
	CONSTRAINT teste_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE teste OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE teste;

/* reseta o auto_increment */
ALTER SEQUENCE teste_id_seq RESTART WITH 1;

/* busca os dados */
SELECT * FROM teste ORDER BY id;