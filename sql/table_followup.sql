CREATE TABLE followup (
	id serial NOT NULL,
	idChamado integer REFERENCES chamado (id) NOT NULL,
	idUsuario integer REFERENCES usuario (id) NOT NULL,
	data timestamp NOT NULL,
	texto VARCHAR (1000) NOT NULL,
	observacoes VARCHAR (150),
	CONSTRAINT followup_pkey PRIMARY KEY (id)
) WITH (OIDS=FALSE);
ALTER TABLE followup OWNER TO postgres;

/* Reseta a tabela */
TRUNCATE TABLE followup;

/* reseta o auto_increment */
ALTER SEQUENCE followup_id_seq RESTART WITH 1;

/* insere os valores padrao */
INSERT INTO followup (idChamado, idUsuario, data, texto, observacoes) VALUES (1, 1, '2015/09/28 10:28', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id ante eleifend, varius sem a, accumsan lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla bibendum tortor eget nunc iaculis, id tristique ligula interdum. Curabitur maximus, est et gravida euismod, eros neque venenatis nisl, non ultrices mi magna viverra mi. In pulvinar aliquam lobortis. Maecenas nec dignissim mauris, non condimentum augue. Suspendisse porta lectus sit amet elit ornare mattis. Donec facilisis nibh vitae elit dapibus, at varius nisi ullamcorper. Duis nibh est, posuere id molestie ac, pretium vitae quam. Maecenas laoreet dolor odio, at fermentum dui interdum vel. Quisque non ullamcorper diam. Ut et vestibulum lacus, ac sodales est. Integer tempus euismod rhoncus.', 'Status: Aberto > Pendente');
INSERT INTO followup (idChamado, idUsuario, data, texto, observacoes) VALUES (1, 1, '2015/09/28 13:12', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id ante eleifend, varius sem a, accumsan lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla bibendum tortor eget nunc iaculis, id tristique ligula interdum. Curabitur maximus, est et gravida euismod, eros neque venenatis nisl, non ultrices mi magna viverra mi. In pulvinar aliquam lobortis. Maecenas nec dignissim mauris, non condimentum augue. Suspendisse porta lectus sit amet elit ornare mattis. Donec facilisis nibh vitae elit dapibus, at varius nisi ullamcorper. Duis nibh est, posuere id molestie ac, pretium vitae quam. Maecenas laoreet dolor odio, at fermentum dui interdum vel. Quisque non ullamcorper diam. Ut et vestibulum lacus, ac sodales est. Integer tempus euismod rhoncus.', 'Status: Pendente > Solucionado');
INSERT INTO followup (idChamado, idUsuario, data, texto, observacoes) VALUES (1, 1, '2015/09/28 13:33', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id ante eleifend, varius sem a, accumsan lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla bibendum tortor eget nunc iaculis, id tristique ligula interdum. Curabitur maximus, est et gravida euismod, eros neque venenatis nisl, non ultrices mi magna viverra mi. In pulvinar aliquam lobortis. Maecenas nec dignissim mauris, non condimentum augue. Suspendisse porta lectus sit amet elit ornare mattis. Donec facilisis nibh vitae elit dapibus, at varius nisi ullamcorper. Duis nibh est, posuere id molestie ac, pretium vitae quam. Maecenas laoreet dolor odio, at fermentum dui interdum vel. Quisque non ullamcorper diam. Ut et vestibulum lacus, ac sodales est. Integer tempus euismod rhoncus.', '');

/* busca os dados */
SELECT * FROM followup ORDER BY LOWER(nome);