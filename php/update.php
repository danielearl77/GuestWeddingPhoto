<?php
include_once("auth.php");
include_once("utils.php");

if( is_logged_in() ) {

    if( !isset($_SESSION) ){session_start();}

    $name = test_input_data($_POST['updateName']);
    $email = test_input_data($_POST['updateEmail']);
    $weddingDate = test_input_data($_POST['updateDate']);
    $user = $_SESSION['LogInPIN'];
    $fName = strstr($name, ' ', true);
    $lName = strstr($name, ' ');
    $qUpdate = "
            SELECT
                *
            FROM
                `f62zmi_226sk1`.`users`
            WHERE
                `users`.`uID` = '$user'
        ";
    
    $CheckUpdateRes = mysqli_query($link, $qUpdate);
    
    if( mysqli_num_rows($CheckUpdateRes) == 1 ){    
        $qUpdate = "
                UPDATE
                    `f62zmi_226sk1`.`users`
                SET
                    `users`.`uFirstName` = '$fName',
                    `users`.`uLastName` = '$lName',
                    `users`.`uEmail` = '$email',
                    `users`.`uWeddingDate` = '$weddingDate'
                WHERE
                    `users`.`uID` = '$user'
                    ";
        
        $uUpdate = mysqli_query($link, $qUpdate);
        if( mysqli_affected_rows($link) == 1 ){
            $changeUpdateMessage = "Details Updated.";
        } else {
            $changeUpdateMessage = "ERROR: Database Error.";
        }    
    } else {
        $changeUpdateMessage = "ERROR: Invalid User.";
    }
    echo $changeUpdateMessage;    
} else {
      header("Location: ../error.html");
}
?>