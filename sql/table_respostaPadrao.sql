/* Cria a tabela prioridade e insere nela os valores padrão */

CREATE TABLE respostaPadrao (
	id serial NOT NULL,
	titulo character varying(50) NOT NULL,
	texto character varying(140) NOT NULL,
	idSituacao integer REFERENCES situacao (id),
	CONSTRAINT respostaPadrao_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE respostaPadrao OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE respostaPadrao;

/* reseta o auto_increment */
ALTER SEQUENCE respostaPadrao_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO respostaPadrao (titulo, texto, idSituacao) VALUES ('Solicitacao Atendida', 'A solicitacao foi atendida conforme solicitado', 3);
INSERT INTO respostaPadrao (titulo, texto, idSituacao) VALUES ('Solicitacoes Atendidas', 'As Solicitações foram atendidas conforme solicitado.', 3);
INSERT INTO respostaPadrao (titulo, texto, idSituacao) VALUES ('Alteração Realizada', 'Realizadas as devidas alterações conforme solicitado.', 3);
INSERT INTO respostaPadrao (titulo, texto, idSituacao) VALUES ('', '');
INSERT INTO respostaPadrao (titulo, texto, idSituacao) VALUES ('', '');

/* busca os dados */
SELECT * FROM respostaPadrao;