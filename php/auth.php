<?php

if( !isset($_SESSION) ){
	session_start();
}

function is_logged_in(){
	if( isset($_SESSION['loggedIn']) ){
		return TRUE;
	} else {
		return FALSE;
	}
}



if( isset($_GET['log']) && $_GET['log'] == 'out' ){
	session_destroy();
	header('location: ../index.html');
}



?>