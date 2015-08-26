<?php
	
	/** Faz a conexão com o banco */
	function db_connect() {
		static $connection;

		// Pega os dados do arquivo de configuração
		$config = parse_ini_file('config.ini'); 

		// tenta conectar
  		$db_handle = pg_pconnect("host=".$config['host']." dbname=".$config['db']." user=".$config['username']." password=".$config['password']);

  		// Tratamento de erros
	    if (!$db_handle) {   
    		echo (pg_last_error($connection));
		}
	}

	function db_query($query) {
	    // conecta no banco
	    $connection = db_connect();
	    // executa a query
	    $result = pg_query($query);
	    // retorna o resultado
	    return $result;
	}

	function db_error() {
    	$connection = db_connect();
    	return pg_last_error($connection);
	}

	// Tentando inserir dados na tabela teste
	$result = db_query("INSERT INTO teste (nome) VALUES ('Nome_Teste')");
	if($result === false) {
		$error = pg_result_error($result);
	}
	echo "Tudo Ok. Pode ficar tranquilo!";

?>
