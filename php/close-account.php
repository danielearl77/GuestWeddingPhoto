<?php 
// User Close Account
include_once("auth.php");
include_once("utils.php");


//ini_set('display_errors','on');
//error_reporting(E_ALL);

if( is_logged_in() ) {

    if( !isset($_SESSION) ){session_start();}

    // Get User ID from $_SESSION
    $user = $_SESSION['LogInPIN'];
    // Get password from form
    $pwd = test_input_data($_POST['closepwd']);
    $cryptPwd = sha1($pwd);
    // get DB Record
    // check password against record
    $qIn = "
            SELECT
                *
            FROM
                `f62zmi_226sk1`.`users`
            WHERE
                `users`.`uID` = '$user'
            AND
                `users`.`uPsw` = '$cryptPwd' 
        ";
    $LogInRes = mysqli_query($link, $qIn);

    if( mysqli_num_rows($LogInRes) == 1 ){
        $newEmail = "-********-";
        $newPwd = "--********--";
        $qClose =   "
                    UPDATE 
                        `f62zmi_226sk1`.`users`
                    SET
                        `users`.`uEmail` = '$newEmail',
                        `users`.`uPsw` = '$newPwd'
                    WHERE
                        `users`.`uID` = '$user'
                    ";
        $uPIN = mysqli_query($link, $qClose);
        // email user to confirm account removal and BCC admin@GWP
        $closeMailTo = $_SESSION['LogInEmail'];
        $closeMailSubject = "Goodbye from Guest Wedding Photo";
        $closeMailMessage = '
        <html>
        <head><title>Guest Wedding Photo Account Closure</title></head>
        <body>
            <h2>Goodbye from Guest Wedding Photo</h2>
            <h3>Thank you for using our service</h3>
            <p>This email is to confirm that your account with us is now closed, and all of your data will be deleted fully in 10 days</p>
            <p>We hope you had a great day, and were sent loads of great photos</p>
            <p>If you have closed your account in error please email us at info@guestweddingphoto.com within 10 days, including your name and wedding PIN, and we will re-activate your account.</p>
            <p>Thanks again for using our service, and we wish you all the best for the future.</p>
        </body></html>
        ';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'To: ' . $closeMailTo;
        $headers[] = 'Bcc: close@guestweddingphoto.com';
        $headers[] = 'From: no-reply@guestweddingphoto.com';
        mail($closeMailTo, $closeMailSubject, $closeMailMessage, implode("\r\n", $headers));
        // log user out and return to home page
        session_destroy();
        echo "1";
    } else {
        echo "ERROR: Incorrect Password Entered";
    }  
} else {
    header("Location: ../error.html");
}


?>