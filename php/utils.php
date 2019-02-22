<?php 

//ini_set('display_errors','on');
//error_reporting(E_ALL);


//===========  DATABASE LOGIC:
//defining useful constants

//define('HST','localhost');
//define('USR','root');
//define('PSW','root');//default value: root
//define('DBN','gwp_test');

 define('HST','norwichcitynewscouk.fatcowmysql.com');
 define('USR','n1m6a_w2ti3ht');
 define('PSW','l2wkvweecsji');
 define('DBN','f62zmi_226sk1');

//connect to server and store connection details
$link = mysqli_connect(HST, USR, PSW) or $failMsg = "Could not connect to server.";
// selecting the DB
mysqli_select_db($link, DBN) or $failMsg = "Could not connect to DB.";

function test_input_data($inputData) {
	$inputData = trim($inputData);
	$inputData = addslashes($inputData);
	$inputData = htmlspecialchars($inputData);
	return $inputData;
}


?>
