<?php

/** Autentica um uasuario a uma sessao */
function session_login($username){
	session_regenerate_id ();
	$_SESSION['valid'] = 1;
	$_SESSION['username'] = $username;
}

/** Destroi todas as variaveies e, em seguida, a sessao em si */
function session_logout(){
    $_SESSION = array();
    session_destroy();
}

/** Verifica se um usuario tem uma sessao ativa */
function session_isValid(){
    if(isset($_SESSION['valid']) && $_SESSION['valid'])
        return true;
    return false;
}

?>