<?php
include_once("utils.php");
include_once("auth.php");


if( !isset($_SESSION) ){
	session_start();
}


if(empty($_POST['user'])) {
    $blankUser = TRUE;
} else {
    $usernameRaw = $_POST['user'];
    $blankUser = FALSE;
    $validEmail = filter_var($usernameRaw, FILTER_VALIDATE_EMAIL);
}
  
if(empty($_POST['pwd'])) {
    $blankPwd = TRUE;
} else {
    $blankPwd = FALSE;
}
   
if ($blankUser || $blankPwd) {
    echo "ERROR: No Username or Password Entered.";
} elseif (!$validEmail) {
    echo "ERROR: No Valid Username Entered.";
} else {
    
    $passwordRaw = $_POST['pwd'];

    $username = test_input_data($usernameRaw);
    $passwordUn = test_input_data($passwordRaw);
    $password = sha1($passwordUn);
    $sUsername = mysqli_real_escape_string($link, $username);

    //========= Run SQL to find user
    $qIn = "
            SELECT
                *
            FROM
                `f62zmi_226sk1`.`users`
            WHERE
                `users`.`uEMail` = '$sUsername'
            AND
                `users`.`uPsw` = '$password' 
        ";

    //run query

    $LogInRes = mysqli_query($link, $qIn);

    if( mysqli_num_rows($LogInRes) == 1 ){

        $_SESSION['loggedIn'] = 'yes';
        $isLoggedIn = "valid";
        $logIn = mysqli_fetch_assoc($LogInRes);
        
        $logInName = $logIn['uFirstName'];
        $logInName .= " ";
        $logInName .= $logIn['uLastName'];
        $logInEmail = $logIn['uEMail'];
        $logInPIN = $logIn['uID'];
        $logInWeddingDate = $logIn['uWeddingDate'];
        
        $_SESSION['LogInName'] = $logInName;
        $_SESSION['LogInEmail'] = $logInEmail;
        $_SESSION['LogInPIN'] = $logInPIN;
        $_SESSION['LogInDate'] = $logInWeddingDate;

        } else {
            $isLoggedIn = "no";
        }
        $_SESSION['isNewUsr'] = "no";
        echo $isLoggedIn;
        //echo "valid";
}

   


   


 

?>