<?php
include_once("utils.php");
$name = "";
$email = "";
$blankCheck = "";
$validInput = "";

if(empty($_POST['name'])) {
    $blankName = TRUE;
} else {
    $blankName = FALSE;
    $name = test_input_data($_POST['name']);
}
if(empty($_POST['email'])) {
    $blankEmail = TRUE;
} else {
    $blankEmail = FALSE;
    $email = test_input_data($_POST['email']);
}
if(empty($_POST['message'])) {
    $blankMessage = TRUE;
} else {
    $blankMessage = FALSE;
    $message = test_input_data($_POST['message']);
}
if( $blankName || $blankEmail || $blankMessage ) {$blankCheck = "missing";} 
if (!preg_match("/^[a-zA-Z ]*$/",$name)) {$validInput = "invalid";}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {$validInput = "invalid";}
if($blankCheck == "missing") {
    echo $blankCheck;
} elseif ($validInput == "invalid") {
    echo $validInput;
} else {
    $headers = 'From: webmaster@guestweddingphoto.com' . "\r\n" . 'Reply-To: ' . $email . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    $msg = wordwrap($message, 70, "\r\n");
    mail('info@guestweddingphoto.com', 'Message from Website Form', $msg, $headers);
    echo "sent";
}
?>