<?php
include_once("auth.php");
include_once("utils.php");
// load session vars into local vars
if( !isset($_SESSION) ){session_start();}

$isNewUser = $_SESSION['isNewUsr'];


if ($isNewUser == 'yes') {
    
    $newUserId = $_SESSION['userID'];
    
    
    
    $qIn = "
            SELECT
                *
            FROM
                `f62zmi_226sk1`.`users`
            WHERE
                `users`.`uID` = '$newUserId'
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
                
        $name = $logInName;
        $email = $logInEmail;
        $PIN = $logInPIN;
             
    } 
}else {
        $name = $_SESSION['LogInName'];
        $email = $_SESSION['LogInEmail'];
        $PIN = $_SESSION['LogInPIN'];
        $date = $_SESSION['LogInDate'];
}





$uploadDirectory = '../uploads/' . $PIN . '/*.*';
$files = (glob($uploadDirectory));
if ($files){
	$photoCount = count($files);
} else {
	$photoCount = 0;
}

?>

<?php if( is_logged_in() ) { ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta lang="en">
		<meta name="viewport" content="width=device-width">
        <link rel="icon" type="image/png" href="../images/favicon.png">
		<link rel="stylesheet" type="text/css" href="../css/gwp-reset.min.css">
        <link rel="stylesheet" type="text/css" href="../css/gwp-resp.css">
		<link rel="stylesheet" type="text/css" href="../css/gwp-style.css">
        <script src="../js/jquery-1.11.3.min.js"></script>

		<title>Guest Wedding Photo | User Area</title>   
        
        <script>
            
                // temp store vars for cancelled edits of user details
                var globalUser = "";
                var globalEmail = "";
                var globalDate = "";
            
                $(document).ready(function(){
                    $("#change-details-button").click(function(){
                        var BtnState = $("#change-details-button").text();
                        if (BtnState === "Update Details") {
                            var changeDetailBtn = document.getElementById("change-details-button");
                            changeDetailBtn.innerHTML = 'Save Changes';
                            $("#cancel-changes-button").show();
                            globalUser = $("#userName").val();
                            globalEmail = $("#emailAddr").val();
                            globalDate = $("#weddingDate").val();
                            $("#userName").attr("readonly", false);
                            $("#emailAddr").attr("readonly", false);
                            $("#weddingDate").attr("readonly", false);
                            $("#change-details-button").removeClass("sign-button");
                            $("#change-details-button").addClass("warn-button");
                        }

                        if (BtnState === "Save Changes") {
                            var changeName = $("#userName").val();
                            var changeEmail = $("#emailAddr").val();
                            var changeWeddingDate = $("#weddingDate").val();
                            
                            var changedDataPost = '&updateName=' + changeName + '&updateEmail=' + changeEmail + '&updateDate=' + changeWeddingDate;

                            $.ajax({
                                type: "POST",
                                url: "update.php",
                                data: changedDataPost,
                                cache: false,
                                success: function(changeResult) {
                                    var changeDetailBtn = document.getElementById("change-details-button");
                                    changeDetailBtn.innerHTML = 'Update Details'; 
                                    $("#cancel-changes-button").hide();
                                    $("#userName").attr("readonly", true);
                                    $("#emailAddr").attr("readonly", true);
                                    $("#weddingDate").attr("readonly", true);
                                    $("#change-details-button").removeClass("warn-button");
                                    $("#change-details-button").addClass("sign-button");
                                    $("#action-message").text(changeResult);
                                    console.log(changeResult);
                                }
                            });  
                        }; 
                    });
                });
            
            $(document).ready(function(){
                $("#cancel-changes-button").click(function(){
                    var changeDetailBtn = document.getElementById("change-details-button");
                    changeDetailBtn.innerHTML = 'Update Details';
                    $("#userName").val(globalUser);
                    $("#emailAddr").val(globalEmail);
                    $("#weddingDate").val(globalDate);
                    $("#cancel-changes-button").hide();
                    $("#userName").attr("readonly", true);
                    $("#emailAddr").attr("readonly", true);
                    $("#weddingDate").attr("readonly", true);
                    $("#change-details-button").removeClass("warn-button");
                    $("#change-details-button").addClass("sign-button");
               }); 
            });
            
            $(document).ready(function(){
                $("#cancel-new-pwd").click(function(){
                    $("#pwd-change-box").fadeOut(); 
                    $("#old-pwd").attr("placeholder", "Current Password").val("");
                    $("#new-pwd").attr("placeholder", "New Password").val("");
                });
            });
            
            $(document).ready(function(){
                $("#change-pwd-button").click(function(){
                    $("#user").hide();
                    $("#pwd-change-box").fadeIn();    
                });    
            });
            
            $(document).ready(function(){
                $("#cancel-close-btn").click(function(){
                    $("#close-account-box").fadeOut();  
                    $("#close-error-msg").text("");
                    $("#close-pwd").attr("placeholder", "Please Enter Password").val("");
                });
            });
            
            $(document).ready(function(){
                $("#close-account-button").click(function(){
                    $("#close-account-box").fadeIn();    
                });    
            });
            
            
            $(document).ready(function(){
                // Change Password
                $("#set-new-pwd").click(function(){
                    var oldPwd = $("#old-pwd").val();
                    var newPwd = $("#new-pwd").val();
                    var id = $("#user").val();
                    var passPwd = '&old=' + oldPwd + '&new=' + newPwd + '&id=' + id;
                    $.ajax({
                        type: "POST",
                        url: "change-pwd.php",
                        data: passPwd,
                        cache: false,
                        success: function(pwdChanged) {
                            $("#old-pwd").val("");
                            $("#new-pwd").val("");
                            if(pwdChanged === "y") {
                                $("#action-message").text("Password Changed");
                            } else {
                                $("#action-message").text(pwdChanged);
                            }
                            $("#pwd-change-box").fadeOut();
                        }
                    });   
                });
            });
                        
            $(document).ready(function(){
                //  Close Account
                $("#close-account-btn").click(function(){
                    var pwd = '&closepwd=' + $("#close-pwd").val();
                    $.ajax({
                        type: "POST",
                        url: "close-account.php",
                        data: pwd,
                        cache: false,
                        success: function(accountClosed) {
                            if(accountClosed === "1") {
                                window.location.assign('../index.html');    
                            } else {
                                $("#close-error-msg").text(accountClosed);
                                //console.log(accountClosed);
                            }
                        }
                    });
                });
            });
            
            $(document).ready(function(){
                $("#menu-burger").click(function(){
                    $("nav").toggle();    
                });   
            });
        </script>
        
        
        
    </head>
    <body>
        <header id="top">
            <div class="row">
                <div class="column-12">
                    <div class="ad-bar">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- guestweddingphoto -->
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-1798485712270431"
                             data-ad-slot="3825578107"
                             data-ad-format="auto"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script> 
                    </div>
                </div>
            </div>
            <div class="row nav-bar">
               <div class="column-3"><a href="../index.html"><img src="../images/logo.png" alt="logo"></a><img id="menu-burger" alt="Menu" src="../images/burger-menu-icon.png"></div>
                <div class="column-6">
                    <nav>
                        <a href="?log=out">Log Out</a>
                    </nav>
                </div>
            </div>
        </header>
    
        <section id="guest-image-thumbs"> <!-- selection of uploaded images -->
            <div id="uploaded-photos" class="card">
                <h3>Some of your guests photos</h3>
                <p>Your guests have uploaded <?php echo $photoCount;?> photos so far.</p>
                <div>                    
                    <?php 
					$fileList = glob($uploadDirectory);
					$fileListLength = count($fileList);
                    if ($fileListLength == 0) { $length = 0;?>
                        <div class="no-img"></div>
                    <?php } elseif ($fileListLength < 4) {
						$length = $fileListLength;
					} else {
						$length = 4;
					}
					for($x = 0; $x < $length; $x++) {
						$imgFile = $fileList[$x]; ?>
			    		<img class="photo-thumb" src="<?php echo $imgFile; ?>">
			    		<?php if ($x == 3) { ?> <br> <?php } 
			    	} ?>
                </div>
                <?php if ($fileListLength != 0) { ?>
                    <div id="download-photos-button"><a href="../download.php"><button id="download-button" class="sign-button" >Download Now</button></a></div>
                <?php } ?>
                
                <script>
                $(document).ready(function(){
                    $("#download-button").click(function(){
                        var btn = document.getElementById('download-button');
                        btn.innerHTML = 'Downloading...';
                        setTimeout(btnTimer, 8000);
                            function btnTimer() {
                                btn.innerHTML = 'Download Now';
                            } 
                    });    
                });
                </script>
            </div>    
        </section>
        
        <section id="user-management"> <!-- User management -->
            <div class="row">
                <div class="column-6"> <!-- User Details Card -->
                    <div id="user-details" class="card">
                        <!-- Name, Email, New Password, Wedding Date, Wedding PIN, Delete Account Button -->
                        <h3>Your Details</h3>
                        <label>Name:</label><input id="userName" value="<?php echo $name;?>" readonly><br>
                        <label>Email:</label><input id="emailAddr" value="<?php echo $email;?>" readonly><br>
                        <label>Wedding PIN:</label><input id="weddingPin" value="<?php echo $PIN;?>" readonly><br>
                        <label>Wedding Date:</label><input id="weddingDate" <?php if(isset($_SESSION['LogInDate'])) { ?> value="<?php echo $date;?>" <?php } ?> readonly><br>
                        
                        
                        <button id="change-pwd-button" class="sign-button">Change Password</button>
                        <button id="change-details-button" class="sign-button">Update Details</button>
                        <button id="close-account-button" class="sign-button">Close Account</button>
                        <button id="cancel-changes-button" class="warn-button">Cancel Changes</button>
                        <p id="action-message"></p>
                        
                        <div id="pwd-change-box">
                            <h3>Change Password</h3>
                            <input type="password" id="old-pwd" placeholder="Current Password">
                            <input type="password" id="new-pwd" placeholder="New Password">
                            <input type="text" id="user" value="<?php echo $PIN;?>">
                            <button id="set-new-pwd" class="warn-button">Change Password</button>
                            <button id="cancel-new-pwd" class="sign-button">Cancel</button>
                        </div>
                        
                        <div id="close-account-box">
                            <h3>Close Account</h3>
                            <p>This will delete all uploaded photos, and remove all your details from our systems.</p>
                            <p>Are You Sure?</p>
                            <input type="password" id="close-pwd" placeholder="Please Enter Password">
                            <button id="close-account-btn" class="warn-button">Close Account</button>
                            <button id="cancel-close-btn" class="sign-button">Cancel</button>
                            <p id="close-error-msg"></p>
                        </div>
                    </div>
                </div>
                
                <div class="column-6"> <!-- User Info / Help Card -->
                    <div id="user-actions" class="card">
                        <h3>How it Works</h3>
                        <p>Your wedding PIN is <?php echo $PIN ?> and you need to provide your guests with this on the day. Cards as part of your table decoration usually work well.</p>
                        <p>Your guests use the PIN and this site to upload their photos. When photos have been uploaded a selection of thumbnail images will appear at the top of this page along with a count indicating the total number of photos uploaded.</p>
                        <p>To download your images click the download button.  A zip file containing all of your images uploaded to the site will be downloaded to your computer.  Please note you must do this on a Windows / Mac based computer and not a tablet or phone.</p>
                        <p>If you have any questions please contact us using the contact form.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <footer>
            <div class="row">
                <div class="column-4">
                    <a href="#top">Back to Top</a>
                    <a href="https://www.twitter.com/GuestWedding" target="_blank"><img id="twitter-link" src="../images/TwitterLogo.png" alt="twitter"></a>
                </div>
                <div class="column-8">
                    <p>Guest Wedding Photo &copy;2015 - 2018</p>
                </div>
            </div>
        </footer>
        
    </body>
</html>

<?php } else { ?>
    <script>window.location.assign("../error.html");</script>
<?php  }  ?>