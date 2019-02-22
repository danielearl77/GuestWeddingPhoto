<?php
/// If poss make this file html and use AJAX.
/// AJAX Call to get PIN out of PHP file and update wedding pin <span>.
/// AJAX function to send files from 'form' to upload php script.
/// AJAX to update html with invalid PIN error after checking DB.
/// AJAX to update html with 'y' or 'n' on file upload.
/// If not poss then all in php.....

/// Keep as php
/// AJAX Call to run photo upload
/// AJAX Call to show message panel
/// Spinner while waiting for script to return
/// AJAX to update message panel


/////////////////////////////////////////////////////////
if(!isset($_SESSION)){session_start();}
$PIN = $_SESSION['guestWeddingPIN'];
?>

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

		<title>Guest Wedding Photo | Upload Wedding Photos</title>
        
        
        <script src="../js/jquery-1.11.3.min.js">
        
        
        </script>
        <script>$(document).ready(function(){
                $("#menu-burger").click(function(){
                    $("nav").toggle();    
                });   
            });
            </script>
        
    </head>
    
    <body>
        <header>
            <div class="row nav-bar">
                <div class="column-3"><a href="../index.html"><img src="../images/logo.png" alt="logo"></a><img id="menu-burger" alt="Menu" src="../images/burger-menu-icon.png"></div>
                <div class="column-6">
                    <nav>
                        <a href="../index.html">Home</a>
                        <a href="../index.html#contact">Contact Us</a>
                        <a href="#help">Help</a>
                    </nav>
                </div>
            </div>
        </header>
        <section id="upload">
            <div class="column-3"></div>
                
            <div class="column-6">
                <div id="upload-photos-form" class="card">
                    
        
                    
                    
                        <h3>Upload Photos</h3>
                        <p>You are uploading pictures for wedding PIN <span id="wedding-pin"><?php echo $PIN;?></span></p>
                        <p>If this is correct click 'Choose Files' to select the photos you want to share</p>
                        
                        <form id="file-form" action="upload-photo.php" method="POST" enctype="multipart/form-data">
                            <input type="file" id="file" name="file[]" multiple/>
                            <button class="sign-button" type="submit" id="upload-button">Upload</button>
                        </form>            
            </div>
                <script>
                    //script to change button text to uploading...
                   $("#upload-button").click(function() {
                       var uploadButton = document.getElementById('upload-button');
                       uploadButton.innerHTML = 'Uploading...';                       
                       //console.log("clicked");
                    });
                </script>
            </div>
                
            <div class="column-3"></div>
        </section>
        
        <section id="help">            
            <h3>Help Uploading Photos</h3>
            <p>Your photos should be in one of the following formats <span class="code">.png .jpeg .jpg</span> or <span class="code">.gif</span>.  The file size of the photos must not exceed 10mb per photo.</p> 

            <p>If you have taken your photos using a digital camera or mobile phone they should meet these requirements without you having to do anything else.  If your internet connection is slow or unreliable that can also cause problems uploading photos.</p>  

            <p>Please also check that you are using the correct wedding PIN, as provided at the wedding.</p>

            <p>If your photos are the correct size and format, your internet connection is good, and the PIN is correct but your photos still won’t upload then please contact us using the contact form and we will look into it for you.</p>	
        </section>
        
        <footer>
            <div class="row">
                <div class="column-4">
                    <a href="../index.html">Back to Top</a>
                    <a href="../legal.html">Terms and Conditions</a>
                    <img id="twitter-link" src="../images/TwitterLogo.png" alt="twitter">
                    <img id="facebook-link" src="../images/FBLogo.png" alt="Facebook" hidden>
                </div>
                <div class="column-8">
                    <p>Guest Wedding Photo &copy;2015 - 2018</p>
                </div>
            </div>
        </footer>
    
    </body>
</html>