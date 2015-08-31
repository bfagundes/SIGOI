CREATE TABLE local (
	id serial NOT NULL,
	nome character varying(50) NOT NULL UNIQUE,
	CONSTRAINT local_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE local OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE local;

/* reseta o auto_increment */
ALTER SEQUENCE local_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO local (nome) VALUES ('Hospital HMGV');
INSERT INTO local (nome) VALUES ('Sede da FHGV');
INSERT INTO local (nome) VALUES ('SPA');
INSERT INTO local (nome) VALUES ('UCE');

/* busca os dados */
SELECT * FROM local ORDER BY LOWER(nome);