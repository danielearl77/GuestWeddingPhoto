<?php
include_once("auth.php");
include_once("utils.php");

if( is_logged_in() ) {

    $old = test_input_data($_POST['old']);
    $new = test_input_data($_POST['new']);
    $user = test_input_data($_POST['id']);
    $encOld = sha1($old);
    $encNew = sha1($new);
    $qPwdCh = "
            SELECT
                *
            FROM
                `f62zmi_226sk1`.`users`
            WHERE
                `users`.`uID` = '$user'
        ";
    
    $CheckPwdRes = mysqli_query($link, $qPwdCh);

    if( mysqli_num_rows($CheckPwdRes) == 1 ){
        $res = mysqli_fetch_assoc($CheckPwdRes);
        $current = $res['uPsw'];
        if($current == $encOld) {
            
            $qUpdatePwd = "
                UPDATE
                    `f62zmi_226sk1`.`users`
                SET
                    `users`.`uPsw` = '$encNew'
                WHERE
                    `users`.`uID` = '$user'
                    ";
            $uPIN = mysqli_query($link, $qUpdatePwd);
            if( mysqli_affected_rows($link) == 1 ){
                $changePasswordMessage = "Password Updated.";
            } else {
                $changePasswordMessage = "ERROR: Database Error.";
            }   
        } else {
            $changePasswordMessage = "ERROR: Password Incorrect.";    
        }
    } else {
        $changePasswordMessage = "ERROR: Invalid User.";
    }
    echo $changePasswordMessage;
} else {
    header("Location: ../error.html");
}
?>