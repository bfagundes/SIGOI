<?php
	/** Faz a conexão com o banco */
	function db_connect() {
		static $connection;

		// Pega os dados do arquivo de configuração
		$config = parse_ini_file('dbconf.ini'); 

		// tenta conectar
  		$db_handle = pg_pconnect("host=".$config['host']." dbname=".$config['db']." user=".$config['username']." password=".$config['password']);

  		// Tratamento de erros
	    if (!$db_handle) {   
    		echo (pg_last_error($connection));
		}
	}

	/** Faz Queries no banco */
	function db_query($query) {
		// conecta no banco
	    $connection = db_connect();
	    // executa a query
	    $result = pg_query($query);
	    // retorna o resultado
	    return $result;				
	}

	/** Exibe erros */
	function db_error() {
    	$connection = db_connect();
    	return pg_last_error($connection);
	}

	/** Faz SELECT Queries, retorna um array com as linhas retornadas */
	function db_select($query) {
	    $rows = array();
	    $result = db_query($query);

	    // returna falso se deu erro
	    if($result === false) {
	        return false;
	    }

	    // se deu certo, coloca as linhas em um array e o retorna
	    while ($row = pg_fetch_assoc($result)) {
	        $rows[] = $row;
	    }
	    return $rows;
	}

	/** limpa as strings antes de fazer a query */
	function db_quote($value) {
    	$connection = db_connect();
    	return "'" . pg_escape_string($value) . "'";
	}
?>