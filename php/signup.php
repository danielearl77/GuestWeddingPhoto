<?php
include_once("utils.php");
include_once("auth.php");
if( !isset($_SESSION) ){session_start();}
// Get data from form

$terms = $_POST['terms'];

if($terms == "true") {
    if(empty($_POST['firstName'])) {
        $output = "fail";
    } else {
        $firstName = test_input_data($_POST['firstName']);   
        if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
            $output = "fail";
            //not real name
        } 
    }
    if(empty($_POST['lastName'])) {
        $output = "fail";
    } else {
        $lastName = test_input_data($_POST['lastName']);
        if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
            $output = "fail";
            //not real name
        } 
    }
    if(empty($_POST['email'])) {
        $output = "fail";
    } else {
        $email = test_input_data($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $output = "fail"; 
            //not real email
        } 
    }
    if(empty($_POST['pwd'])) {
        $output = "fail";
    } else {
        $password = test_input_data($_POST['pwd']);
        $encyPwd = sha1($password);
    } 
} else {
    $output = "fail";
}

$sanEmail = mysqli_real_escape_string($link, $email);
$checkEmail = " SELECT * FROM `f62zmi_226sk1`.`users` WHERE `users`.`uEMail` = '$sanEmail' ";
$checkEmailResult = mysqli_query($link, $checkEmail);
if( mysqli_affected_rows($link) == 1 ) {
	$output = "Old-Email";	
} 

if($output == "fail" || $output == "Old-Email") {
    echo $output;
    
} else {
    // Drop data into DB
    $sanFirstName = mysqli_real_escape_string($link, $firstName);
	$sanLastName = mysqli_real_escape_string($link, $lastName);
	$sanPwd = mysqli_real_escape_string($link, $encyPwd);
    //store vars into database
    $userq =    "
                    INSERT INTO `f62zmi_226sk1`.`users`
                        (
                        `users`.`uFirstName`,
                        `users`.`uLastName`,
                        `users`.`uEMail`,
                        `users`.`uPsw`
                         )
				    VALUES
                        (
                        '$sanFirstName',
                        '$sanLastName',
                        '$sanEmail',
                        '$sanPwd'
                        )
                ";		
    $Res = mysqli_query($link, $userq);

    if( mysqli_affected_rows($link) == 1  ){
        $successMsg = "User account successfully created.<br><br>Please choose a menu option above to continue.";		
        // Take uID and create photo directory
        $dirq = mysqli_insert_id($link);
        $dir = '../uploads/' . $dirq;
        $zipDir = '../downloads/' . $dirq;
        mkdir($dir);
        mkdir($zipDir);
        $output = $dirq;
    } else {
        $output = "error";
        echo $output;
    }//end check query
    
    
    // Compose and send welcome email [should be html email]   
    // Welcome Text including users name, email address used [username], wedding PIN
    // Instructions on what to do next and how the site works
    // Link to the site
    $welcomeMailPIN = $dirq;
    $welcomeMailTo = $sanEmail;
    $welcomeMailSubject = "Welcome to Guest Wedding Photo";
    $welcomeMailMessage = '
    <html>
    <head><title>Welcome to Guest Wedding Photo</title></head>
    <body>
        <h2>Welcome to Guest Wedding Photo</h2>
        <h3>Thank you for signing up</h3>
        <p>Your username is the email address you used to register, use this and your chosen password to log in to the site.  The first think you need to do when you log in is enter your wedding date.  We will remove all uploaded photos 6 months after your wedding.</p>
        <p>Your wedding PIN is ' . $welcomeMailPIN . ' and should be given to your guests on or before your wedding day.  Your guests use this PIN to upload their photos to the website.</p>
        <p>If you have any questions email us at info@guestweddingphoto.com or use the contact us form on the website.</p>
        <p>Thanks again for signing up, and we wish you all the best for your big day.</p>
    </body></html>
    ';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    $headers[] = 'To: ' . $welcomeMailTo;
    $headers[] = 'From: no-reply@guestweddingphoto.com';
    mail($welcomeMailTo, $welcomeMailSubject, $welcomeMailMessage, implode("\r\n", $headers));
    
    // Set new user SESSION var to true
    // Set user session var to the new uID
    // return back non fail msg in output to index.html forcing signin page to load.
    $_SESSION['isNewUsr'] = "yes";
    $_SESSION['userID'] = $output;
    $_SESSION['loggedIn'] = "yes";
    //echo "success";
    echo $output;
}






//if ($terms == "true") {
//    echo "14";
//} else {
//    echo "fail";
//}



// Load signin page
//$output = "fail";
//$output .= $terms;
//echo $output;
//echo "fail";

?>