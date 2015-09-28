<?php

/** Autentica um usuario a uma sessao */
function session_login($username, $userid){
	session_regenerate_id ();
	$_SESSION['valid'] = 1;
	$_SESSION['username'] = $username;
	$_SESSION['userid'] = $userid;
	$_SESSION['last_activity'] = time();
}

/** encerra uma sessao */
function session_logout(){
    session_unset();
    session_destroy();
}

/** Verifica se um usuario tem uma sessao ativa */
function session_isValid(){
	$return = false;

	// verifica se a sessao é m_validateidentifier(conn, tf)
	if(isset($_SESSION['valid']) && $_SESSION['valid']){
		$return = true;
	}

	// verifica se a ultima atividade ocorreu nos ultimos 30 minutos
	if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] < 1800)){
		$return = true;
	}
	return $return;
}

?>