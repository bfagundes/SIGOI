CREATE TABLE chamado (
	id serial NOT NULL,
	nrofo integer NOT NULL,
	idSolicitante integer REFERENCES usuario (id) NOT NULL,
	idSetor integer REFERENCES setor (id) NOT NULL,
	idLocal integer REFERENCES local (id) NOT NULL,
	dataAbertura timestamp NOT NULL,
	dataVencimento timestamp,
	dataFechamento timestamp,
	idTecnico integer REFERENCES usuario (id),
	idTipo integer REFERENCES tipo (id),
	idPrioridade integer REFERENCES prioridade (id),
	idSituacao integer REFERENCES situacao (id),
	assunto varchar(140) NOT NULL,
	descricao varchar (500) NOT NULL,
	CONSTRAINT chamado_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE chamado OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE chamado;

/* reseta o auto_increment */
ALTER SEQUENCE chamado_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO chamado (nrofo, idSolicitante, idSetor, idLocal, dataAbertura, datavencimento, dataFechamento, idTecnico, idTipo, idPrioridade, idSituacao, assunto, descricao) 
	VALUES (0, 1, 12, 1, now(), null, null, 1, 1, 2, 1, 'A pasta da farmacia sumiu do desktop', 'Sumiu a pasta da farmacia do desktop, estava aqui a 2 minutos atrás!');

INSERT INTO chamado (nrofo, idSolicitante, idSetor, idLocal, dataAbertura, datavencimento, dataFechamento, idTecnico, idTipo, idPrioridade, idSituacao, assunto, descricao) 
	VALUES (0, 1, 14, 1, now(), null, null, 1, 1, 2, 1, 'Quebrar contas', 'Quebrar a conta do paciente X, com os dados Y, bla bla bla');

INSERT INTO chamado (nrofo, idSolicitante, idSetor, idLocal, dataAbertura, datavencimento, dataFechamento, idTecnico, idTipo, idPrioridade, idSituacao, assunto, descricao) 
	VALUES (0, 1, 13, 2, now(), null, null, 1, 1, 2, 1, 'Hackearam meu BOL', 'Eu acho que terroristas sírios hackearam meu email do BOL. Já tinham feito isso antes com minha conta no Mercado Livre');
	
INSERT INTO chamado (nrofo, idSolicitante, idSetor, idLocal, dataAbertura, datavencimento, dataFechamento, idTecnico, idTipo, idPrioridade, idSituacao, assunto, descricao) 
	VALUES (0, 1, 15, 2, now(), null, null, 1, 1, 2, 1, 'Mudar mesas de lugar', 'Precisamos mudar as mesas de lugar, vamos fazer uma ilha (e um luau depois)');

/* busca os dados */
SELECT * FROM chamado ORDER BY id;