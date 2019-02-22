<?php
// Take entered wedding PIN and add to a $SESSION var to be used by the upload.php script.
// return echo true if set and echo false if not set.
$weddingpin = $_POST['pin'];

if(!isset($_SESSION)){session_start();}

$_SESSION['guestWeddingPIN'] = $weddingpin;

if( isset($_SESSION['guestWeddingPIN']) ){
		echo "TRUE";
	} else {
		echo "FALSE";
	}
?>